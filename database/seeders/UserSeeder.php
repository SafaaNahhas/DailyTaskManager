<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = ['create tasks', 'edit tasks', 'delete tasks','view trashed tasks'];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        $userRole = Role::firstOrCreate(['name' => 'user']);

        $user1 = User::firstOrCreate(
            ['email' => 'safaa@gmail.com'],
            [
                'name' => 'Safaa',
                'password' => Hash::make('12345678')
            ]
        );
        $user1->assignRole($adminRole);

        $user2 = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'password' => Hash::make('12345678')
            ]
        );
        $user2->assignRole($userRole);
        $user3 = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'password' => Hash::make('12345678')
            ]
        );
        $user3->assignRole($userRole);
        $user4 = User::firstOrCreate(
            ['email' => 'melia@gmail.com'],
            [
                'name' => 'Melia',
                'password' => Hash::make('12345678')
            ]
        );
        $user4->assignRole($userRole);
        $user5 = User::firstOrCreate(
            ['email' => 'naya@gmail.com'],
            [
                'name' => 'Naya',
                'password' => Hash::make('12345678')
            ]
        );
        $user5->assignRole($userRole);
        $user6 = User::firstOrCreate(
            ['email' => 'lolia@gmail.com'],
            [
                'name' => 'Lolia',
                'password' => Hash::make('12345678')
            ]
        );
        $user6->assignRole($userRole);
}
}
