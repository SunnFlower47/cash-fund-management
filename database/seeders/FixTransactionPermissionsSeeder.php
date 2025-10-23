<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FixTransactionPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure view_transactions permission exists
        Permission::firstOrCreate(['name' => 'view_transactions']);

        // Get anggota role
        $anggotaRole = Role::where('name', 'anggota')->first();

        if ($anggotaRole) {
            // Give view_transactions permission to anggota if not already assigned
            if (!$anggotaRole->hasPermissionTo('view_transactions')) {
                $anggotaRole->givePermissionTo('view_transactions');
                $this->command->info('Added view_transactions permission to anggota role');
            } else {
                $this->command->info('Anggota role already has view_transactions permission');
            }
        } else {
            $this->command->error('Anggota role not found');
        }
    }
}
