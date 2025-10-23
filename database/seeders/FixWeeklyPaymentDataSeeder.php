<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WeeklyPayment;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FixWeeklyPaymentDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure permissions exist
        $permissions = [
            'view_weekly_payments',
            'manage_weekly_payments'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Get or create roles
        $bendaharaRole = Role::firstOrCreate(['name' => 'bendahara']);
        $anggotaRole = Role::firstOrCreate(['name' => 'anggota']);

        // Assign permissions to roles
        $bendaharaRole->syncPermissions(Permission::all());
        $anggotaRole->givePermissionTo('view_weekly_payments');

        // Get all users with anggota role
        $anggotaUsers = User::role('anggota')->get();

        $this->command->info('Found ' . $anggotaUsers->count() . ' anggota users');

        // Create weekly payments for current month
        $currentMonth = now()->format('Y-m');

        for ($week = 1; $week <= 4; $week++) {
            $weekPeriod = $currentMonth . '-W' . $week;

            foreach ($anggotaUsers as $user) {
                WeeklyPayment::updateOrCreate(
                    [
                        'week_period' => $weekPeriod,
                        'user_id' => $user->id
                    ],
                    [
                        'amount' => 50000,
                        'is_paid' => rand(0, 1) == 1, // Random payment status
                        'paid_at' => rand(0, 1) == 1 ? now()->subDays(rand(1, 7)) : null,
                        'notes' => rand(0, 1) == 1 ? 'Pembayaran via transfer' : null
                    ]
                );
            }
        }

        // Create weekly payments for previous month
        $previousMonth = now()->subMonth()->format('Y-m');

        for ($week = 1; $week <= 4; $week++) {
            $weekPeriod = $previousMonth . '-W' . $week;

            foreach ($anggotaUsers as $user) {
                WeeklyPayment::updateOrCreate(
                    [
                        'week_period' => $weekPeriod,
                        'user_id' => $user->id
                    ],
                    [
                        'amount' => 50000,
                        'is_paid' => true, // Previous month mostly paid
                        'paid_at' => now()->subMonth()->subDays(rand(1, 28)),
                        'notes' => 'Pembayaran bulan lalu'
                    ]
                );
            }
        }

        $this->command->info('Weekly payment data fixed successfully!');
        $this->command->info('Total weekly payments created: ' . WeeklyPayment::count());
    }
}
