<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Create Roles
        $adminRole = Role::create([
            'name' => 'admin',
            'description' => 'Administrator'
        ]);
        $staffRole = Role::create([
            'name' => 'staff',
            'description' => 'Staff'
        ]);

        //Create Users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id
        ]);
        User::create([
            'name' => 'Staff User',
            'email' => 'staf@staff.com',
            'password' => bcrypt('password'),
            'role_id' => $staffRole->id
        ]);

        //Create Categories
        $categories = [
            ['name' => 'Electronics', 'description' => 'Electronic devices and components'],
            ['name' => 'Furniture', 'description' => 'Office and home furniture'],
            ['name' => 'Stationery', 'description' => 'Office supplies and stationery'],
        ];
        foreach ($categories as $category) {
            Category::create($category);
        }

        //Create Suppliers
        $suppliers = [
            [
                'name' => 'Tech Supply Co.',
                'email' => 'contact@techsupply.com',
                'phone' => '+1234567890',
                'address' => '123 Tech Street, Silicon Valley',
                'contact_person' => 'John Doe',
            ],
            [
                'name' => 'Office Furniture Ltd.',
                'email' => 'sales@officefurniture.com',
                'phone' => '+1234567891',
                'address' => '456 Furniture Ave, New York',
                'contact_person' => 'Jane Smith',
            ],
        ];
        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        //Create sample items
        Item::create([
            'sku' => 'ELEC-001',
            'name' => 'Wireless Mouse',
            'description' => 'Ergonomic wireless mouse with USB receiver',
            'category_id' => 1,
            'supplier_id' => 1,
            'quantity' => 50,
            'min_stock_level' => 10,
            'unit_price' => 25.99,
            'unit' => 'pcs',
        ]);

        Item::create([
            'sku' => 'FURN-001',
            'name' => 'Office Chair',
            'description' => 'Ergonomic office chair with lumbar support',
            'category_id' => 2,
            'supplier_id' => 2,
            'quantity' => 15,
            'min_stock_level' => 5,
            'unit_price' => 299.99,
            'unit' => 'pcs',
        ]);
    }
}
