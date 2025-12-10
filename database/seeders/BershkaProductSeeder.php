<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BershkaProductSeeder extends Seeder
{
    public function run()
    {
        // 1. Setup Store
        $user = User::firstOrCreate(
            ['email' => 'bershka@example.com'],
            [
                'name' => 'Bershka Official',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]
        );

        $store = Store::firstOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Bershka Collection',
                'slug' => 'bershka-collection',
                'about' => 'Latest trends in fashion for men and women.',
                'phone' => '081234567899',
                'city' => 'Jakarta',
                'postal_code' => '12190',
                'address' => 'Grand Indonesia Mall',
                'is_verified' => true
            ]
        );

        // 2. Setup Categories
        // Ensure Main Categories exist
        $menCategory = ProductCategory::firstOrCreate(
            ['slug' => 'men'],
            ['name' => 'Men', 'description' => 'Men\'s Fashion']
        );

        $womenCategory = ProductCategory::firstOrCreate(
            ['slug' => 'women'],
            ['name' => 'Women', 'description' => 'Women\'s Fashion']
        );

        // Helper to get or create subcategory
        $getSubCategory = function ($parent, $name, $slugSuffix) {
            return ProductCategory::firstOrCreate(
                ['slug' => $parent->slug . '-' . $slugSuffix],
                [
                    'name' => $name,
                    'parent_id' => $parent->id,
                    'description' => $name . ' for ' . $parent->name
                ]
            );
        };

        // Men Subcategories
        $menPants = $getSubCategory($menCategory, 'Pants', 'pants');
        $menShirts = $getSubCategory($menCategory, 'Shirts', 'shirts'); // Assuming T-shirts go here or create T-Shirts
        $menShoes = $getSubCategory($menCategory, 'Shoes', 'shoes');
        $menAcc = $getSubCategory($menCategory, 'Accessories', 'accessories');

        // Women Subcategories
        $womenTops = $getSubCategory($womenCategory, 'Tops', 'tops');
        $womenPants = $getSubCategory($womenCategory, 'Pants', 'pants');
        $womenShoes = $getSubCategory($womenCategory, 'Shoes', 'shoes');
        $womenAcc = $getSubCategory($womenCategory, 'Accessories', 'accessories');


        // 3. Define Products
        $products = [
            // Men
            [
                'name' => 'Baggy Jeans - Light Blue',
                'category_id' => $menPants->id,
                'description' => 'Relaxed fit baggy jeans in light blue wash. 100% cotton denim for everyday comfort.',
                'price' => 459000,
                'image' => 'products/bershka/men-pants-1.jpg'
            ],
            [
                'name' => 'Cargo Trousers - Black',
                'category_id' => $menPants->id,
                'description' => 'Utility cargo trousers with multiple functional pockets. Comfortable fit ensuring maximum mobility.',
                'price' => 499000,
                'image' => 'products/bershka/men-pants-2.jpg'
            ],
            [
                'name' => 'Graphic Print Tee - White',
                'category_id' => $menShirts->id,
                'description' => 'Oversized t-shirt with front graphic print. Made from soft cotton jersey.',
                'price' => 229000,
                'image' => 'products/bershka/men-shirt-1.jpg'
            ],
            [
                'name' => 'Basic Long Sleeve - Grey',
                'category_id' => $menShirts->id,
                'description' => 'Essential long sleeve top in soft cotton blend. Regular fit, perfect for layering.',
                'price' => 199000,
                'image' => 'products/bershka/men-shirt-2.jpg'
            ],
            [
                'name' => 'Chunky Sneakers - White',
                'category_id' => $menShoes->id,
                'description' => 'Trendy chunky sneakers with mixed material upper. Comfortable thick sole.',
                'price' => 699000,
                'image' => 'products/bershka/men-shoes-1.jpg'
            ],
            [
                'name' => 'High Top Trainers - Black',
                'category_id' => $menShoes->id,
                'description' => 'Classic high top trainers in black canvas. Features a durable rubber toe cap.',
                'price' => 599000,
                'image' => 'products/bershka/men-shoes-2.jpg'
            ],
            [
                'name' => 'Silver Chain Necklace',
                'category_id' => $menAcc->id,
                'description' => 'Minimalist silver chain necklace. Made from durable stainless steel.',
                'price' => 149000,
                'image' => 'products/bershka/men-acc-1.jpg'
            ],

            // Women
            [
                'name' => 'Ribbed Knit Top - White',
                'category_id' => $womenTops->id,
                'description' => 'Fitted ribbed knit top with long sleeves. Soft and stretchy fabric that accentuates the silhouette.',
                'price' => 249000,
                'image' => 'products/bershka/women-top-1.jpg'
            ],
            [
                'name' => 'Asymmetric Hem Top - Black',
                'category_id' => $womenTops->id,
                'description' => 'Trendy top with a unique asymmetric hemline. Modern silhouette for a stylish look.',
                'price' => 299000,
                'image' => 'products/bershka/women-top-2.jpg'
            ],
            [
                'name' => 'Wide Leg Jeans - Blue',
                'category_id' => $womenPants->id,
                'description' => 'High-waisted wide leg jeans in a vintage blue wash. A staple piece for any wardrobe.',
                'price' => 499000,
                'image' => 'products/bershka/women-pants-1.jpg'
            ],
            [
                'name' => 'Platform Sandals - Beige',
                'category_id' => $womenShoes->id,
                'description' => 'Chunky platform sandals perfect for summer. Features a comfortable cushioned footbed.',
                'price' => 459000,
                'image' => 'products/bershka/women-shoes-1.jpg'
            ],
            [
                'name' => 'Ankle Boots - Black',
                'category_id' => $womenShoes->id,
                'description' => 'Sleek black ankle boots with a stable block heel. Made from high-quality faux leather.',
                'price' => 599000,
                'image' => 'products/bershka/women-shoes-2.jpg'
            ],
            [
                'name' => 'Strappy Heels - Silver',
                'category_id' => $womenShoes->id,
                'description' => 'Elegant strappy heels suitable for evening wear. Eye-catching metallic finish.',
                'price' => 549000,
                'image' => 'products/bershka/women-shoes-3.jpg'
            ],
            [
                'name' => 'Hoop Earrings Set',
                'category_id' => $womenAcc->id,
                'description' => 'Set of 3 gold-tone hoop earrings in varied sizes. Versatile for different styles.',
                'price' => 129000,
                'image' => 'products/bershka/women-acc-1.jpg'
            ],
            [
                'name' => 'Shoulder Bag - Black',
                'category_id' => $womenAcc->id,
                'description' => 'Classic shoulder bag with a stylish chain strap. Made from smooth faux leather.',
                'price' => 399000,
                'image' => 'products/bershka/women-acc-2.jpg'
            ],
        ];

        foreach ($products as $item) {
            $product = Product::firstOrCreate(
                [
                    'name' => $item['name'],
                    'store_id' => $store->id,
                ],
                [
                    'product_category_id' => $item['category_id'],
                    'slug' => Str::slug($item['name']) . '-' . Str::random(5),
                    'description' => $item['description'],
                    'condition' => 'new',
                    'price' => $item['price'],
                    'weight' => rand(300, 800),
                    'stock' => rand(15, 50),
                ]
            );

            // Add Image if not exists
            if (!$product->productImages()->exists()) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $item['image'],
                    'is_thumbnail' => true,
                ]);
            }
        }
    }
}
