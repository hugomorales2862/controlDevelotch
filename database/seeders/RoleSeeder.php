<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // Prospects
            'view prospects',
            'create prospects',
            'edit prospects',
            'delete prospects',
            // Clients
            'view clients',
            'create clients',
            'edit clients',
            'delete clients',
            // Services
            'view services',
            'create services',
            'edit services',
            'delete services',
            // Quotes
            'view quotes',
            'create quotes',
            'edit quotes',
            'delete quotes',
            // Projects
            'view projects',
            'create projects',
            'edit projects',
            'delete projects',
            // Tasks
            'view tasks',
            'create tasks',
            'edit tasks',
            'delete tasks',
            // Invoices
            'view invoices',
            'create invoices',
            'edit invoices',
            'delete invoices',
            // Payments
            'view payments',
            'create payments',
            'edit payments',
            'delete payments',
            // Users & Roles
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            // Audit Logs
            'view audit logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $staffRole = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);

        // Assign all permissions to admin
        $adminRole->syncPermissions(Permission::all());

        // Assign some permissions to staff
        $staffPermissions = [
            'view prospects', 'create prospects', 'edit prospects',
            'view clients', 'create clients', 'edit clients',
            'view services', 'create services', 'edit services',
            'view quotes', 'create quotes', 'edit quotes',
            'view projects', 'create projects', 'edit projects',
            'view tasks', 'create tasks', 'edit tasks',
            'view invoices', 'create invoices', 'edit invoices',
            'view payments', 'create payments', 'edit payments',
            'view users', 'view roles',
            'view audit logs',
        ];
        $staffRole->syncPermissions($staffPermissions);

        // Assign limited permissions to client
        $clientPermissions = [
            'view quotes',
            'view invoices',
            'view payments',
        ];
        $clientRole->syncPermissions($clientPermissions);
    }
}
