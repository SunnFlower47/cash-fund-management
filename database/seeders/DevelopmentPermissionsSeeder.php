<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DevelopmentPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Simple seeder for development/testing
     */
    public function run(): void
    {
        $this->command->info('🔧 Adding audit log permissions for development...');

        // Add audit log permission
        $permission = Permission::firstOrCreate(['name' => 'view_audit_logs']);
        $this->command->info("✓ Permission 'view_audit_logs' ready");

        // Assign to bendahara role
        $bendaharaRole = Role::where('name', 'bendahara')->first();
        if ($bendaharaRole && !$bendaharaRole->hasPermissionTo('view_audit_logs')) {
            $bendaharaRole->givePermissionTo('view_audit_logs');
            $this->command->info("✓ Added 'view_audit_logs' to bendahara role");
        }

        $this->command->info('✅ Development permissions updated!');
    }
}
