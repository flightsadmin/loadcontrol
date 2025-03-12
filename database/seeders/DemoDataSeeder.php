<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        // Create common product categories
        $categories = [
            'Electronics' => [
                'Smartphone' => ['price' => 499.99, 'stock' => 50],
                'Laptop' => ['price' => 999.99, 'stock' => 30],
                'Headphones' => ['price' => 79.99, 'stock' => 100],
            ],
            'Groceries' => [
                'Bread' => ['price' => 2.99, 'stock' => 100],
                'Milk' => ['price' => 3.99, 'stock' => 200],
                'Eggs' => ['price' => 4.99, 'stock' => 150],
            ],
            'Clothing' => [
                'T-Shirt' => ['price' => 19.99, 'stock' => 75],
                'Jeans' => ['price' => 49.99, 'stock' => 45],
                'Shoes' => ['price' => 89.99, 'stock' => 60],
            ],
        ];

        foreach ($categories as $categoryName => $products) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => \Str::slug($categoryName),
            ]);

            foreach ($products as $productName => $details) {
                Product::create([
                    'name' => $productName,
                    'sku' => strtoupper(substr($productName, 0, 3)) . rand(1000, 9999),
                    'description' => fake()->sentence(),
                    'price' => $details['price'],
                    'stock' => $details['stock'],
                    'alert_stock' => 10,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
