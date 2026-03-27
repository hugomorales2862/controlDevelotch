<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $staffRole = Role::firstOrCreate(['name' => 'staff']);
        $clientRole = Role::firstOrCreate(['name' => 'client']);

        $admin = User::where('email', 'admin@admin.com')->first();
        if ($admin && !$admin->hasRole('admin')) {
            $admin->assignRole($adminRole);
        }
    }
}
