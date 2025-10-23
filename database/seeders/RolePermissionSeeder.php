<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\CashBalance;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view_dashboard',
            'view_transactions',
            'create_transactions',
            'edit_transactions',
            'delete_transactions',
            'approve_transactions',
            'view_payment_proofs',
            'create_payment_proofs',
            'edit_payment_proofs',
            'delete_payment_proofs',
            'approve_payment_proofs',
            'reject_payment_proofs',
            'view_users',
            'create_users',
            'edit_users',
            'delete_users',
            'view_reports',
            'manage_cash_balance',
            'manage_settings',
            'view_settings',
            'view_weekly_payments',
            'manage_weekly_payments',
            'view_audit_logs'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $bendaharaRole = Role::create(['name' => 'bendahara']);
        $anggotaRole = Role::create(['name' => 'anggota']);

        // Assign all permissions to bendahara
        $bendaharaRole->givePermissionTo(Permission::all());

        // Assign limited permissions to anggota
        $anggotaRole->givePermissionTo([
            'view_dashboard',
            'view_transactions',
            'create_payment_proofs',
            'edit_payment_proofs',
            'delete_payment_proofs',
            'view_payment_proofs',
            'view_settings',
            'view_weekly_payments'
        ]);

        // Create default users
        $bendahara = User::create([
            'name' => 'Bendahara',
            'email' => 'bendahara@example.com',
            'password' => bcrypt('password'),
        ]);
        $bendahara->assignRole('bendahara');

        $anggota = User::create([
            'name' => 'Anggota',
            'email' => 'anggota@example.com',
            'password' => bcrypt('password'),
        ]);
        $anggota->assignRole('anggota');

        // Initialize cash balance
        CashBalance::create([
            'total_income' => 0,
            'total_expense' => 0,
            'current_balance' => 0,
            'approved_income' => 0,
            'manual_income' => 0,
            'member_payments' => 0,
            'last_updated_at' => now(),
        ]);
    }
}
