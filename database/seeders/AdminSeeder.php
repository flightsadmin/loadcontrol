<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $actions = ['create', 'edit', 'view', 'update', 'delete'];
        $models = ['user', 'role', 'permission'];

        foreach ($models as $model) {
            foreach ($actions as $action) {
                $methodName = $action.' '.$model;
                Permission::create(['name' => $methodName]);
            }
        }

        $roles = [
            [
                'name' => 'wab',
                'permissions' => ['view user'],
            ],
            [
                'name' => 'admin',
                'permissions' => ['view user', 'create user'],
            ],
            [
                'name' => 'super-admin',
                'permissions' => Permission::pluck('name')->toArray(),
            ],
        ];

        foreach ($roles as $key => $roleData) {
            $role = Role::create(['name' => $roleData['name']]);
            $role->givePermissionTo($roleData['permissions']);

            User::create([
                'name' => ucwords(explode('-', $roleData['name'])[0]).' User',
                'email' => $roleData['name'].'@flightadmin.info',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(30),
            ])->assignRole($role);
        }

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ])->assignRole('super-admin');
    }
}
