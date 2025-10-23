<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AddWeeklyPaymentPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create new permissions if they don't exist
        $permissions = [
            'view_weekly_payments',
            'manage_weekly_payments'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Get roles
        $bendaharaRole = Role::where('name', 'bendahara')->first();
        $anggotaRole = Role::where('name', 'anggota')->first();

        if ($bendaharaRole) {
            // Give all permissions to bendahara
            $bendaharaRole->givePermissionTo($permissions);
        }

        if ($anggotaRole) {
            // Give view permission to anggota
            $anggotaRole->givePermissionTo('view_weekly_payments');
        }

        $this->command->info('Weekly payment permissions added successfully!');
    }
}
