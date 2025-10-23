<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ProductionPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Production-safe seeder for audit log permissions only
     */
    public function run(): void
    {
        $this->command->info('🚀 Adding audit log permissions to production...');

        // Add audit log permission if it doesn't exist
        $permission = Permission::firstOrCreate(['name' => 'view_audit_logs']);
        $this->command->info("✓ Permission 'view_audit_logs' ready");

        // Assign to bendahara role if not already assigned
        $bendaharaRole = Role::where('name', 'bendahara')->first();
        if ($bendaharaRole && !$bendaharaRole->hasPermissionTo('view_audit_logs')) {
            $bendaharaRole->givePermissionTo('view_audit_logs');
            $this->command->info("✓ Added 'view_audit_logs' to bendahara role");
        } else {
            $this->command->info("✓ Bendahara role already has 'view_audit_logs' permission");
        }

        $this->command->info('✅ Audit log permissions added successfully!');
        $this->command->info('🔒 Production-safe: Only adds missing permissions.');
    }
}
