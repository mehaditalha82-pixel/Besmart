<?php

namespace Database\Seeders;

use App\Models\B2bPricing;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\Product;
use App\Models\SalesHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles & Permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $b2bRole = Role::firstOrCreate(['name' => 'b2b-merchant']);
        $customerRole = Role::firstOrCreate(['name' => 'customer']);

        $manageProducts = Permission::firstOrCreate(['name' => 'manage-products']);
        $manageOrders = Permission::firstOrCreate(['name' => 'manage-orders']);
        $viewWholesale = Permission::firstOrCreate(['name' => 'view-wholesale-pricing']);

        $adminRole->givePermissionTo([$manageProducts, $manageOrders, $viewWholesale]);
        $b2bRole->givePermissionTo([$viewWholesale]);

        // 2. Users
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@taobao-enterprise.com',
            'phone_number' => '+1 800 555 0199',
            'active_mode' => 'b2b',
        ]);
        $adminUser->assignRole($adminRole);

        $customerUser = User::factory()->create([
            'name' => 'Consumer User',
            'email' => 'customer@example.com',
            'phone_number' => '+1 800 555 0122',
            'active_mode' => 'b2c',
        ]);
        $customerUser->assignRole($customerRole);

        // 3. Hierarchical Categories
        $taxonomies = [
            [
                'name' => 'Car Parts',
                'slug' => 'car-parts',
                'icon' => 'Car',
                'description' => 'Automotive components, engine parts, and accessories',
                'children' => ['Engine Components', 'Brake Systems', 'Exterior Accessories'],
            ],
            [
                'name' => 'Cosmetics',
                'slug' => 'cosmetics',
                'icon' => 'Sparkles',
                'description' => 'Skincare, botanical serums, and beauty essentials',
                'children' => ['Skincare', 'Makeup', 'Fragrance'],
            ],
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'icon' => 'Cpu',
                'description' => 'Microprocessors, smart IoT hardware, and EV electronics',
                'children' => ['Microcontrollers', 'Smart Sensors', 'Power Electronics'],
            ],
            [
                'name' => 'Green Energy',
                'slug' => 'green-energy',
                'icon' => 'Zap',
                'description' => 'Solar inverters, battery storage, and EV chargers',
                'children' => ['Solar Panels', 'Inverters', 'EV Chargers'],
            ],
        ];

        foreach ($taxonomies as $item) {
            $parentCat = Category::create([
                'name' => $item['name'],
                'slug' => $item['slug'],
                'icon' => $item['icon'],
                'description' => $item['description'],
                'is_active' => true,
            ]);

            foreach ($item['children'] as $childName) {
                Category::create([
                    'parent_id' => $parentCat->id,
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'icon' => $item['icon'],
                    'is_active' => true,
                ]);
            }

            // 4. Products under Parent Category
            $products = Product::factory()->count(4)->create([
                'category_id' => $parentCat->id,
                'is_featured' => true,
            ]);

            foreach ($products as $product) {
                // B2B Pricing Tiers
                B2bPricing::create([
                    'product_id' => $product->id,
                    'min_qty' => 10,
                    'max_qty' => 49,
                    'unit_price' => round($product->retail_price * 0.85, 2),
                ]);

                B2bPricing::create([
                    'product_id' => $product->id,
                    'min_qty' => 50,
                    'max_qty' => null,
                    'unit_price' => round($product->retail_price * 0.70, 2),
                ]);

                // Active Flash Deal for first 2 products
                if (rand(0, 1) === 1) {
                    FlashDeal::create([
                        'product_id' => $product->id,
                        'discount_price' => round($product->retail_price * 0.75, 2),
                        'start_time' => now()->subHours(2),
                        'end_time' => now()->addHours(24),
                        'allocated_stock' => 100,
                        'sold_stock' => rand(10, 60),
                    ]);
                }

                // 10-Year Historical Sales Data
                for ($year = 2017; $year <= 2026; $year++) {
                    SalesHistory::create([
                        'product_id' => $product->id,
                        'units_sold' => rand(500, 5000),
                        'revenue' => round(rand(10000, 100000), 2),
                        'sale_date' => "$year-06-15",
                    ]);
                }
            }
        }
    }
}
