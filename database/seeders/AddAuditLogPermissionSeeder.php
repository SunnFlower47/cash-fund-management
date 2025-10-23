<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddAuditLogPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create audit log permission if it doesn't exist
        $permission = Permission::firstOrCreate(['name' => 'view_audit_logs']);

        // Assign to bendahara role
        $bendaharaRole = Role::where('name', 'bendahara')->first();
        if ($bendaharaRole && !$bendaharaRole->hasPermissionTo('view_audit_logs')) {
            $bendaharaRole->givePermissionTo('view_audit_logs');
        }
    }
}
