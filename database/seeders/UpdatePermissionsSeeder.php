<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UpdatePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add missing permissions - safe for production
        $newPermissions = [
            'edit_payment_proofs',
            'delete_payment_proofs',
            'manage_settings',
            'view_audit_logs',
            'view_weekly_payments',
            'manage_weekly_payments',
            'view_settings'
        ];

        $this->command->info('Checking and adding missing permissions...');

        foreach ($newPermissions as $permission) {
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
                $this->command->info("✓ Added permission: {$permission}");
            } else {
                $this->command->info("✓ Permission already exists: {$permission}");
            }
        }

        // Update anggota role permissions
        $anggotaRole = Role::where('name', 'anggota')->first();
        if ($anggotaRole) {
            $anggotaPermissions = [
                'edit_payment_proofs',
                'delete_payment_proofs',
                'view_weekly_payments',
                'view_settings'
            ];

            foreach ($anggotaPermissions as $permission) {
                if (!$anggotaRole->hasPermissionTo($permission)) {
                    $anggotaRole->givePermissionTo($permission);
                    $this->command->info("✓ Added {$permission} to anggota role");
                }
            }
        }

        // Update bendahara role permissions
        $bendaharaRole = Role::where('name', 'bendahara')->first();
        if ($bendaharaRole) {
            $bendaharaPermissions = [
                'manage_settings',
                'view_audit_logs',
                'manage_weekly_payments',
                'view_weekly_payments',
                'view_settings'
            ];

            foreach ($bendaharaPermissions as $permission) {
                if (!$bendaharaRole->hasPermissionTo($permission)) {
                    $bendaharaRole->givePermissionTo($permission);
                    $this->command->info("✓ Added {$permission} to bendahara role");
                }
            }
        }

        $this->command->info('✅ All permissions updated successfully!');
        $this->command->info('🔒 Production-safe: Only adds missing permissions, no duplicates created.');
    }
}
