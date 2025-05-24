<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Role permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            
            // Category permissions
            'view categories',
            'create categories',
            'edit categories',
            'delete categories',
            
            // Product permissions
            'view products',
            'create products',
            'edit products',
            'delete products',
            
            // Review permissions
            'view reviews',
            'create reviews',
            'edit reviews',
            'delete reviews',
            
            // Audit permissions
            'view audits',
            'export audits',
        ];

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->setPermissions($permissions)->save();

        $managerRole = Role::firstOrCreate(['name' => 'manager']);
        $managerRole->setPermissions([
            'view users',
            'view roles',
            'view categories', 'create categories', 'edit categories',
            'view products', 'create products', 'edit products', 'delete products',
            'view reviews', 'edit reviews', 'delete reviews',
            'view audits', 'export audits',
        ])->save();

        $editorRole = Role::firstOrCreate(['name' => 'editor']);
        $editorRole->setPermissions([
            'view categories',
            'view products', 'create products', 'edit products',
            'view reviews', 'edit reviews',
            'view audits',
        ])->save();

        $customerRole = Role::firstOrCreate(['name' => 'customer']);
        $customerRole->setPermissions([
            'view categories',
            'view products',
            'view reviews', 'create reviews', 'edit reviews',
        ])->save();

        // Create admin user if it doesn't exist
        $admin = User::firstOrNew(['email' => 'admin@example.com']);
        if (!$admin->exists) {
            $admin->fill([
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'is_active' => true,
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
            ]);
            $admin->save();
        }

        // Create manager user if it doesn't exist
        $manager = User::firstOrNew(['email' => 'manager@example.com']);
        if (!$manager->exists) {
            $manager->fill([
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role_id' => $managerRole->id,
                'is_active' => true,
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
            ]);
            $manager->save();
        }

        // Create editor user if it doesn't exist
        $editor = User::firstOrNew(['email' => 'editor@example.com']);
        if (!$editor->exists) {
            $editor->fill([
                'name' => 'Editor User',
                'password' => Hash::make('password'),
                'role_id' => $editorRole->id,
                'is_active' => true,
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
            ]);
            $editor->save();
        }

        // Create customer user if it doesn't exist
        $customer = User::firstOrNew(['email' => 'customer@example.com']);
        if (!$customer->exists) {
            $customer->fill([
                'name' => 'Customer User',
                'password' => Hash::make('password'),
                'role_id' => $customerRole->id,
                'is_active' => true,
                'uuid' => (string) \Illuminate\Support\Str::uuid(),
            ]);
            $customer->save();
        }
    }
}
