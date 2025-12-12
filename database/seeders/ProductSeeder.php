<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Store;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure Categories Exist
        $categories = [
            1 => ['name' => 'Lip Products', 'icon' => 'categories/lips.png'],
            2 => ['name' => 'Complexion', 'icon' => 'categories/foundation.png'],
            3 => ['name' => 'Skincare', 'icon' => 'categories/skincare.png'],
            4 => ['name' => 'Masks', 'icon' => 'categories/mask.png'],
            5 => ['name' => 'Fragrance', 'icon' => 'categories/perfume.png'],
            6 => ['name' => 'Cheek', 'icon' => 'categories/blush.png'],
            7 => ['name' => 'Eye', 'icon' => 'categories/eye.png'],
        ];

        $catMap = [];
        foreach ($categories as $key => $cat) {
            $c = ProductCategory::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'icon' => $cat['icon'],
                    'description' => 'Best ' . $cat['name'] . ' collection'
                ]
            );
            $catMap[$key] = $c->id;
        }

        // 2. Get a Store
        $store = Store::first() ?? Store::create([
            'user_id' => 1,
            'name' => 'Sillia Official Store',
            'logo' => 'stores/default.png',
            'about' => 'Official Sillia Beauty Store',
            'phone' => '08123456789',
            'city' => 'Jakarta',
            'address' => 'Sillia HQ',
            'is_verified' => true,
        ]);

        // 3. Products with Local Images in database/seeders/
        $products = [
            // Lips
            [
                'name' => 'MAKE OVER Powerstay Transferproof Matte Lip Cream',
                'slug' => 'make-over-powerstay-transferproof-matte-lip-cream',
                'product_category_id' => 1,
                'price' => 143000,
                'description' => 'Lip pigment bertekstur ringan dengan hasil glazy-plump yang tahan hingga 24 jam.',
                'image' => 'lip1.jpg',
            ],
            [
                'name' => 'Holika Heart Crush Bare Glaze Tint' ,
                'slug' => 'holika-heart-crush-bare-glaze-tint',
                'product_category_id' => 1,
                'price' => 105000,
                'description' => 'Lip tint dengan tekstur super ringan, hasil transparan glossy.',
                'image' => 'lip2.webp',
            ],
            [
                'name' => 'Barenbliss Peach Makes Perfect Lip Tint',
                'slug' => 'barenbliss-peach-makes-perfect-lip-tint',
                'product_category_id' => 1,
                'price' => 115000,
                'description' => 'Lip tint beraroma peach manis dengan tekstur milky light gel.',
                'image' => 'lip3.webp',
            ],
            
            // Complexion
            [
                'name' => 'Maybelline Fit Me Matte and Poreless Liquid Foundation',
                'slug' => 'maybelline-fit-me-matte-and-poreless-liquid-foundation',
                'product_category_id' => 2,
                'price' => 146000,
                'description' => 'Foundation cair full coverage dengan hasil matte natural.',
                'image' => 'fondi1.png',
            ],
            [
                'name' => 'Makeover Powerstay 24H Weightless Liquid Foundation',
                'slug' => 'makeover-powerstay-24-weightless-liquid-foundation',
                'product_category_id' => 2,
                'price' => 201000,
                'description' => 'Liquid foundation bertekstur ringan dengan hasil matte yang smooth.',
                'image' => 'fondi 2.png',
            ], 
            [
                'name' => 'Skintific All Day Perfect Serum Foundation',
                'slug' => 'skintific-all-day-perfect-serum-foundation',
                'product_category_id' => 2,
                'price' => 181000,
                'description' => 'Serum foundation dengan medium to full coverage dan soft matte finish.',
                'image' => 'fondi3.png',
            ],

            // Skincare
            [
                'name' => 'Skintific 10% Niacinamide Serum',
                'slug' => 'skintific-10-niacinamide-serum',
                'product_category_id' => 3,
                'price' => 126000,
                'description' => 'Serum pencerah dengan Royal DSM Niacinamide berkemurnian tinggi.',
                'image' => 'serum1.png',
            ],
            [
                'name' => 'd Alba White Truffle First Spray Serum',
                'slug' => 'dalba-white-truffle-first-spray-serum',
                'product_category_id' => 3,
                'price' => 201000,
                'description' => 'Mist serum dengan kandungan White Truffle, Chia Seed extract.',
                'image' => 'serum2.png',
            ],
            [
                'name' => 'Avoskin YSB Serum Alpha Arbutin 3% + Grapeseed',
                'slug' => 'avoskin-ysb-serum-alpha-arbutin-3-grapeseed',
                'product_category_id' => 3,
                'price' => 128000,
                'description' => 'Serum yang memadukan active ingredients Alpha Arbutin 3%.',
                'image' => 'serum3.png',
            ],

            // Masks
            [
                'name' => 'Missha Airy Fit Sheet Mask Rice',
                'slug' => 'missha-airy-fit-sheet-mask-rice',
                'product_category_id' => 4,
                'price' => 20000,
                'description' => 'Sheet mask ringan yang nyaman menempel di wajah.',
                'image' => 'mask3.jpg',
            ],
            [
                'name' => 'Mediheal THE H.P.A Glowing Ampoule Mask',
                'slug' => 'mediheal-glowing-ampoule-mask',
                'product_category_id' => 4,
                'price' => 31000,
                'description' => 'Ampoule mask dengan 6x Biome Complex, LHA, dan PHA.',
                'image' => 'mask2.png',
            ],
            [
                'name' => 'Breylee Rose Facial Mask',
                'slug' => 'breylee-rose-facial-mask',
                'product_category_id' => 4,
                'price' => 8750,
                'description' => 'Sheet mask ringan dengan ekstrak mawar.',
                'image' => 'maask1.png', // Fallback as no 3rd mask image found
            ],

            // Fragrance
            [
                'name' => 'HMNS Orgsm',
                'slug' => 'hmns-orgsm',
                'product_category_id' => 5,
                'price' => 323000,
                'description' => 'Parfum dengan aroma red apple yang segar.',
                'image' => 'parfum1.png',
            ],
            [
                'name' => 'SAFF & CO Coco - Extrait De Parfum',
                'slug' => 'coco-edp',
                'product_category_id' => 5,
                'price' => 160000,
                'description' => 'Parfum dengan kesegaran bergamot, mandarin, dan neroli.',
                'image' => 'parfum2.png',
            ],
            [
                'name' => 'Speaks To Me Slow Sunset',
                'slug' => 'slow-sunset',
                'product_category_id' => 5,
                'price' => 299000,
                'description' => 'Parfum dengan nuansa hangat dan menenangkan.',
                'image' => 'parfum3.png',
            ],

            // Cheek (Blush On)
            [
                'name' => 'ESQA Powder Blush',
                'slug' => 'powder-blush',
                'product_category_id' => 6,
                'price' => 95000,
                'description' => 'Blush on berwarna pink lembut dengan kilau natural.',
                'image' => 'on1.png',
            ],
            [
                'name' => 'Emina Cheeklit Pressed Blush',
                'slug' => 'cheeklit-pressed-blush',
                'product_category_id' => 6,
                'price' => 45000,
                'description' => 'Blush on pressed yang memberikan rona segar natural.',
                'image' => 'on2.png',
            ],
            [
                'name' => 'ROSE ALL DAY Cheeky Flush Liquid Blush',
                'slug' => 'cheeky-flush-liquid-blush',
                'product_category_id' => 6,
                'price' => 73000,
                'description' => 'Blush on warna pink cerah natural.',
                'image' => 'on3.png',
            ],

            // Eye
            [
                'name' => 'Azarine Sweet Treats Eyeshadow',
                'slug' => 'sweet-treats-eyeshadow',
                'product_category_id' => 7,
                'price' => 62000,
                'description' => 'Eyeshadow quad dengan kombinasi 2 matte dan 2 shimmer.',
                'image' => 'eye1.png',
            ],
            [
                'name' => 'Holika Piece Matching Shadow Palette',
                'slug' => 'holika-piece-matching-shadow-palette',
                'product_category_id' => 7,
                'price' => 195000,
                'description' => 'Eyeshadow palette dengan kombinasi tekstur matte, shimmer, dan glitter.',
                'image' => 'eye2.png',
            ],
            [
                'name' => 'CLIO Pro Eye Palette',
                'slug' => 'clio-pro-eye-palette',
                'product_category_id' => 7,
                'price' => 315000,
                'description' => 'Eye palette dengan kombinasi warna sehari-hari.',
                'image' => 'eye3.png',
            ],
        ];

        // Ensure directory exists
        Storage::disk('public')->makeDirectory('products');

        foreach ($products as $p) {
             // Use mapped category ID, valid store ID, and default stock
             $prod = Product::create([
                'store_id' => $store->id,
                'product_category_id' => $catMap[$p['product_category_id']] ?? $catMap[1], // Fallback to 1 if missing
                'name' => $p['name'],
                'slug' => $p['slug'] . '-' . time(), // Unique slug
                'price' => $p['price'],
                'description' => $p['description'],
                'stock' => 100, // Default stock
                'condition' => 'new',
                'weight' => 500,
                'is_active' => true,
            ]);

            // Handle Image Assignment
            try {
                $sourcePath = database_path('seeders/' . $p['image']);
                $targetFile = null;

                // 1. Priority: Use the specific image defined in the seeder array
                if (File::exists($sourcePath)) {
                    $filename = $p['slug'] . '-' . Str::random(6) . '.' . pathinfo($sourcePath, PATHINFO_EXTENSION);
                    Storage::disk('public')->put('products/' . $filename, File::get($sourcePath));
                    $targetFile = 'products/' . $filename;
                } 
                // 2. Fallback: Check if there's an existing file in storage that matches closely
                else {
                    $existingFiles = Storage::disk('public')->files('products');
                    foreach ($existingFiles as $file) {
                        if (str_contains($file, $p['slug'])) {
                            $targetFile = $file;
                            break;
                        }
                    }
                    
                    // 3. Last Resort: Random image if strictly necessary (prevents broken images)
                    if (!$targetFile && count($existingFiles) > 0) {
                        $targetFile = $existingFiles[array_rand($existingFiles)];
                    }
                }

                if ($targetFile) {
                    ProductImage::create([
                        'product_id' => $prod->id,
                        'image' => $targetFile,
                        'is_thumbnail' => true,
                    ]);
                }
            } catch (\Exception $e) {
                // Log or ignore
            }
        }
    }
}
