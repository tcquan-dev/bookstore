<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view users', 
            'create users', 
            'edit users', 
            'delete users', 
            'view books', 
            'create books', 
            'edit books', 
            'delete books'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }        
    }
}
