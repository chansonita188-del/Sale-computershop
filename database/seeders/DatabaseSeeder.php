<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Categories
        Category::create(['name' => 'Laptops', 'slug' => 'laptops', 'icon' => 'fas fa-laptop', 'description' => 'Powerful laptops for work and gaming']);
        Category::create(['name' => 'Desktops', 'slug' => 'desktops', 'icon' => 'fas fa-desktop', 'description' => 'High-performance desktop computers']);
        Category::create(['name' => 'Gaming PCs', 'slug' => 'gaming', 'icon' => 'fas fa-gamepad', 'description' => 'Ultimate gaming rigs']);
        Category::create(['name' => 'Components', 'slug' => 'components', 'icon' => 'fas fa-microchip', 'description' => 'Computer components and accessories']);
        
        // Products
        Product::create([
            'category_id' => 2,
            'name' => 'Ultimate Gaming Desktop Xtreme',
            'brand' => 'Custom Build',
            'model' => 'Gamer Pro X9',
            'product_type' => 'gaming_desktop',
            'cpu_brand' => 'Intel',
            'cpu_model' => 'Core i9-13900K',
            'cpu_speed' => 5.8,
            'cpu_cores' => 24,
            'gpu_brand' => 'NVIDIA',
            'gpu_model' => 'RTX 4090 24GB',
            'ram_size' => '64GB',
            'ram_type' => 'DDR5',
            'storage' => '2TB',
            'storage_type' => 'NVMe SSD',
            'monitor_size' => '32"',
            'monitor_resolution' => '3840x2160',
            'monitor_refresh_rate' => '144',
            'details' => "Ultimate gaming desktop with RGB lighting\n- Liquid cooling system\n- Includes mechanical keyboard and gaming mouse\n- Pre-installed Windows 11 Pro\n- 3-year warranty\n- Free shipping",
            'specifications' => "Motherboard: ASUS ROG Maximus Z790\nPower Supply: 1200W Platinum Certified\nCooling: 360mm AIO Liquid Cooler\nConnectivity: WiFi 6E, Bluetooth 5.3\nCase: Tempered Glass RGB Case",
            'price' => 3499.99,
            'stock' => 8,
            'featured' => true,
            'image_url' => 'https://images.unsplash.com/photo-1587202372775-e229f172a166?w=400'
        ]);
        
        Product::create([
            'category_id' => 1,
            'name' => 'ASUS ROG Zephyrus G14',
            'brand' => 'ASUS',
            'model' => 'G14',
            'product_type' => 'laptop',
            'cpu_brand' => 'AMD',
            'cpu_model' => 'Ryzen 9 5900HS',
            'cpu_speed' => 3.3,
            'cpu_cores' => 8,
            'gpu_brand' => 'NVIDIA',
            'gpu_model' => 'RTX 3060',
            'ram_size' => '16GB',
            'ram_type' => 'DDR4',
            'storage' => '1TB',
            'storage_type' => 'SSD',
            'details' => "Powerful gaming laptop with AMD Ryzen 9 and RTX 3060. Perfect for gaming and content creation.",
            'specifications' => "Display: 14-inch QHD 120Hz\nBattery: 76WHrs\nWeight: 1.6kg",
            'price' => 1499.99,
            'stock' => 10,
            'featured' => true,
            'image_url' => 'https://images.unsplash.com/photo-1588872657578-7efd1f1555ed?w=400'
        ]);
        
        Product::create([
            'category_id' => 3,
            'name' => 'NVIDIA GeForce RTX 4090',
            'brand' => 'NVIDIA',
            'model' => 'RTX 4090',
            'product_type' => 'gpu',
            'gpu_model' => 'RTX 4090 24GB',
            'ram_size' => '24GB',
            'ram_type' => 'GDDR6X',
            'details' => 'Ultimate graphics card for 4K gaming and professional workloads.',
            'price' => 1599.99,
            'stock' => 15,
            'featured' => true,
            'image_url' => 'https://images.unsplash.com/photo-1587202372775-e229f172a166?w=400'
        ]);
        
        Product::create([
            'category_id' => 2,
            'name' => 'Intel Core i9-13900K',
            'brand' => 'Intel',
            'model' => 'i9-13900K',
            'product_type' => 'cpu',
            'cpu_brand' => 'Intel',
            'cpu_model' => 'Core i9-13900K',
            'cpu_speed' => 5.8,
            'cpu_cores' => 24,
            'details' => 'Top-tier desktop processor for gaming and content creation.',
            'price' => 589.99,
            'stock' => 25,
            'featured' => true,
            'image_url' => 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea?w=400'
        ]);
        
        Product::create([
            'category_id' => 1,
            'name' => 'MSI Stealth 15M',
            'brand' => 'MSI',
            'model' => 'Stealth 15M',
            'product_type' => 'laptop',
            'cpu_brand' => 'Intel',
            'cpu_model' => 'Core i7-11375H',
            'cpu_speed' => 5.0,
            'cpu_cores' => 4,
            'gpu_model' => 'RTX 3060',
            'ram_size' => '16GB',
            'ram_type' => 'DDR4',
            'storage' => '512GB',
            'storage_type' => 'SSD',
            'price' => 1299.99,
            'stock' => 12,
            'featured' => false
        ]);
        
        Product::create([
            'category_id' => 3,
            'name' => 'AMD Ryzen 7 7800X3D',
            'brand' => 'AMD',
            'model' => '7800X3D',
            'product_type' => 'cpu',
            'cpu_brand' => 'AMD',
            'cpu_model' => 'Ryzen 7 7800X3D',
            'cpu_speed' => 5.0,
            'cpu_cores' => 8,
            'details' => 'Gaming-focused processor with 3D V-Cache technology.',
            'price' => 449.99,
            'stock' => 30,
            'featured' => true,
            'image_url' => 'https://images.unsplash.com/photo-1611078489935-0cb964de46d6?w=400'
        ]);
        
        // Users
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@salecs.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);
        
        User::create([
            'name' => 'Demo Customer',
            'email' => 'customer@test.com',
            'password' => bcrypt('customer123'),
            'role' => 'customer',
        ]);
        
        User::create([
            'name' => 'Bunthorn SRIENG',
            'email' => 'sriengbunthorn@gmail.com',
            'password' => bcrypt('password123'),
            'role' => 'customer',
        ]);
        
        $this->command->info('Sale ComputerShop seeded successfully!');
        $this->command->info('Admin: admin@salecs.com / admin123');
        $this->command->info('Customer: customer@test.com / customer123');
    }
}