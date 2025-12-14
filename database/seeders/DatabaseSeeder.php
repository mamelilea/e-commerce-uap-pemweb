<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $admin = User::firstOrCreate(
            ['email' => 'adminkore@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
        \App\Models\UserBalance::firstOrCreate(['user_id' => $admin->id], ['balance' => 0]);

        $member1 = User::firstOrCreate(
            ['email' => 'sellermerch@kore.com'],
            [
                'name' => 'Seller One',
                'password' => bcrypt('password'),
                'role' => 'member',
            ]
            
        );

        $member2 = User::firstOrCreate(
            ['email' => 'member2@kore.com'],
            [
                'name' => 'Member Two',
                'password' => bcrypt('password'),
                'role' => 'member',
            ]
        );

        \App\Models\UserBalance::firstOrCreate(
            ['user_id' => $member2->id],
            ['balance' => 500000]
        );

        \App\Models\Buyer::firstOrCreate(
            ['user_id' => $member2->id],
            ['phone_number' => '08987654321']
        );

        \App\Models\UserBalance::firstOrCreate(['user_id' => $member1->id], ['balance' => 1000000]);
        \App\Models\Buyer::firstOrCreate(['user_id' => $member1->id], ['phone_number' => '08123456789']);

        $member1->update(['role' => 'seller']);

        $store = \App\Models\Store::firstOrCreate(
            ['slug' => 'k-store-official'],
            [
                'user_id' => $member1->id,
                'name' => 'K-Store Official',
                'about' => 'The best Korean stuff.',
                'is_verified' => true,
            ]
        );
        \App\Models\StoreBalance::firstOrCreate(['store_id' => $store->id], ['balance' => 0]);

        $albumProducts = [
            ['name' => 'Stray Kids - MAXIDENT (Danger Love Edition)', 'about' => 'Album mini penuh energi yang memadukan konsep cinta obsesif dengan beat agresif khas Stray Kids. Dikemas dengan desain bold dan edgy, MAXIDENT menampilkan sisi liar sekaligus emosional dari Stray Kids, lengkap dengan photobook eksklusif, photocard acak, dan CD album. Cocok untuk STAY yang suka konsep kuat dan penuh attitude.
'],
            ['name' => 'SEVENTEEN - Attacca (Passion Version)', 'about' => 'Attacca menggambarkan emosi yang mengalir tanpa jeda—penuh gairah dan ketulusan. Album ini hadir dengan visual artistik bernuansa merah yang elegan, dilengkapi photobook premium, photocard member, dan merchandise eksklusif. Pilihan tepat untuk CARAT yang menyukai konsep dewasa dan emosional.
'],
            ['name' => 'SEVENTEEN - Seventeenth Heaven (Festival Edition)', 'about' => 'Album yang merayakan kebahagiaan, mimpi, dan kebersamaan. Dengan desain warna-warni seperti festival, Seventeenth Heaven memancarkan energi positif khas SEVENTEEN. Berisi photobook ceria, CD album, photocard acak, dan item koleksi spesial yang membuat pengalaman unboxing terasa fun dan hangat.

'],
            ['name' => 'NCT DREAM - DREAMSCAPE (Construct Version)', 'about' => 'Album dengan konsep futuristik dan imajinatif yang menggambarkan dunia mimpi NCT DREAM. Dikemas dengan desain hijau neon modern, album ini berisi photobook tebal, CD-R, folded poster, photocard, serta item kreatif unik. Cocok untuk NCTzen yang menyukai konsep eksperimental dan visual artsy.
'],
            ['name' => 'NCT DREAM - Ultimate Park (Go Back To The Future Edition)', 'about' => 'Album box spesial dengan konsep taman bermain futuristik yang playful dan penuh nostalgia. Dikemas dalam box besar kolektor, berisi set album, photobook, collectible items, dan desain visual cerah. Album ini menampilkan sisi ceria dan youthful khas NCT DREAM yang ikonik.
'],
            ['name' => 'ENHYPEN - Romance: UNTOLD (Inceptio Version)', 'about' => 'Album romantis dengan konsep surat cinta yang penuh makna. Desain minimalis dengan aksen amplop merah melambangkan perasaan yang belum terucap. Dilengkapi photobook elegan, CD album, photocard, dan inclusions eksklusif. Pilihan sempurna untuk ENGENE yang menyukai konsep emosional dan aesthetic.'],
            ['name' => 'BOYNEXTDOOR - Single Album WHO! (Version Set)', 'about' => 'Single album debut BOYNEXTDOOR yang menampilkan konsep fresh, youthful, dan penuh energi khas rookie K-pop. Hadir dalam beberapa versi cover dengan desain bold dan modern, berisi lagu-lagu yang catchy dan easy listening. Cocok untuk ONEDOOR yang ingin memulai atau melengkapi koleksi album BOYNEXTDOOR.'],
        ];

        $photocardProducts = [
            ['name' => 'PHOTOCARD WISH - Valentine Series', 'about' => 'Set photocard dengan konsep Valentine bernuansa merah dan motif kartu cinta. Menampilkan pose close-up dengan ekspresi manis dan stylish. Cocok untuk kolektor yang menyukai konsep romantic-cute. Kartu dicetak dengan kualitas premium dan warna tajam.
'],
            ['name' => 'PHOTOCARD NCT DREAM - Beat It Up (Set of 7)', 'about' => 'Satu set photocard NCT DREAM berisi 7 member dengan konsep hitam-putih yang bold dan edgy. Gaya street dan ekspresi karismatik membuat set ini terlihat eksklusif. Cocok untuk NCTzen yang ingin koleksi lengkap satu era.
'],
            ['name' => 'PHOTOCARD NCT DREAM - Selfie Collection', 'about' => 'Photocard selfie dengan konsep casual dan natural. Menampilkan ekspresi santai dan gaya sehari-hari para member, memberikan kesan dekat dan personal. Dicetak ukuran standar photocard, cocok untuk binder koleksi.
'],
            ['name' => 'PHOTOCARD CORTIS - Night Drive Series', 'about' => 'Photocard dengan konsep malam hari dan vibe urban. Diambil dengan gaya candid dan sudut unik, memberikan kesan cool dan modern. Tersedia beberapa pose dengan latar mobil dan city lights, cocok untuk kolektor aesthetic.
'],
            ['name' => 'PHOTOCARD CORTIS - Color Outside (Reg Scene Ver A)', 'about' => 'Photocard resmi ukuran 8,5 x 5,5 cm dengan konsep outdoor cerah dan natural. Menampilkan ekspresi fresh dan playful setiap member. Dilengkapi desain backside khas CORTIS, cocok untuk koleksi maupun trade-photocard.'],
        ];

        $apparelProducts = [
            ['name' => 'Hoodie SEVENTEEN Nana Tour Zip-Up', 'about' => 'Hoodie zip-up berwarna hitam dengan desain SEVENTEEN Nana Tour yang simpel dan clean. Nyaman dipakai untuk aktivitas harian maupun sebagai outfit santai.'],
            ['name' => 'Hoodie SEVENTEEN Nana Tour Graphic', 'about' => 'Hoodie eksklusif NANA Tour dengan detail grafis di bagian depan dan belakang. Cocok untuk penggemar yang ingin tampil casual namun tetap stylish.'],
            ['name' => 'Jersey Stray Kids 08 Still Gonna Rock', 'about' => 'Kaos jersey Stray Kids dengan desain konser bernuansa bold dan sporty. Cocok dipakai saat nonton konser atau untuk streetwear sehari-hari.'],
            ['name' => 'Jersey AESPA Street Series', 'about' => 'Jersey aespa dengan desain logo metal yang edgy dan modern. Memberikan tampilan standout untuk outfit kasual maupun event K-pop.'],
            ['name' => 'T-Shirt AESPA Series Graphic Tee', 'about' => 'Kaos aespa dengan desain grafis karakter yang stylish dan trendy. Nyaman dipakai dan cocok untuk koleksi maupun daily outfit.'],
            ['name' => 'T-Shirt NCT I Love My Boyfriend', 'about' => 'Kaos NCT dengan desain cute dan playful bertema “I Love My BF”. Cocok untuk tampilan santai dan gaya kasual sehari-hari.'],
            ['name' => 'T-Shirt NCT 127 ILYE Series', 'about' => 'Kaos NCT 127 dengan desain heart graphic yang simpel dan manis. Pas dipakai untuk daily wear maupun sebagai item koleksi.'],
        ];

        $dollProducts = [
            ['name' => 'DOLL Mini Teen Animal Figure - SEVENTEEN', 'about' => 'Boneka mini berbentuk karakter hewan dengan desain chibi lucu, terinspirasi dari SEVENTEEN. Ukuran kecil dan ringan, cocok untuk koleksi, pajangan meja, atau hadiah bagi CARAT. Detail ekspresi dibuat imut dengan warna lembut yang menarik.
'],
            ['name' => 'DOLL Forest Friends Plush - NCT DREAM', 'about' => 'Boneka plush karakter hewan bertema forest dengan desain lucu dan warna cerah, terinspirasi dari NCT DREAM. Tekstur lembut dan empuk, cocok untuk dipeluk maupun dijadikan dekorasi kamar. Pilihan tepat untuk koleksi NCTzen.
'],
            ['name' => 'DOLL Animal Keychain Plush - NCT WISH', 'about' => 'Boneka plush mini berbentuk karakter hewan dengan gantungan, terinspirasi dari NCT WISH. Cocok digunakan sebagai keychain tas, pouch, atau backpack. Praktis dibawa dan tampil menggemaskan untuk melengkapi koleksi fans.
'],
            ['name' => 'DOLL Animal Character Plush - ENHYPEN', 'about' => 'Boneka plush karakter hewan dengan desain imut dan ekspresi khas, terinspirasi dari ENHYPEN. Terbuat dari bahan lembut berkualitas, nyaman disentuh dan cocok untuk koleksi maupun hadiah bagi ENGENE.'],
        ];

        $lightstickProducts = [
            ['name' => 'LIGHTSTICK Stray Kids Official', 'about' => 'Lightstick resmi Stray Kids dengan desain kompas ikonik yang melambangkan perjalanan dan semangat STAY.'],
            ['name' => 'LIGHTSTICK SEVENTEEN Official', 'about' => 'Lightstick resmi SEVENTEEN dengan tampilan gradasi elegan, cocok untuk konser dan koleksi CARAT.'],
            ['name' => 'LIGHTSTICK EXO Official', 'about' => 'Lightstick EXO dengan logo hexagon khas dan cahaya terang untuk pengalaman konser yang maksimal.'],
            ['name' => 'LIGHTSTICK ENHYPEN Official', 'about' => 'Lightstick resmi ENHYPEN dengan desain minimalis modern, nyaman digenggam saat fan event.'],
            ['name' => 'LIGHTSTICK ASTRO Official', 'about' => 'Lightstick ASTRO dengan logo bintang ungu ikonik, hadir dengan desain simpel dan elegan.'],
            ['name' => 'LIGHTSTICK TWICE Official', 'about' => 'Candy Bong versi terbaru dengan desain manis dan warna cerah khas TWICE.'],
            ['name' => 'LIGHTSTICK ZEROBASEONE Official', 'about' => 'Lightstick resmi ZEROBASEONE dengan desain clean dan kemasan eksklusif untuk koleksi.'],
            ['name' => 'LIGHTSTICK AESPA Official', 'about' => 'Fanlight aespa dengan desain futuristik dan logo transparan, cocok untuk konser dan display.'],
            ['name' => 'LIGHTSTICK NCT Official', 'about' => 'Lightstick resmi NCT dengan desain modern berwarna hitam neon green yang ikonik. Cocok digunakan saat konser, fan meeting, atau sebagai koleksi NCTzen.'],
        ];

        $keychainStickerProducts = [
            ['name' => 'Keychain Berry Matcha Idol', 'about' => 'Gantungan kunci akrilik dengan desain idol bernuansa berry dan matcha yang fresh dan cute. Cocok dipakai di tas, pouch, atau sebagai koleksi dekoratif.'],
            ['name' => 'Keychain Heart Idol Forever', 'about' => 'Keychain akrilik berbentuk hati dengan foto idol favorit dan finishing glitter transparan. Desain dua sisi yang manis untuk daily accessory.'],
            ['name' => 'Keychain Idol Rockstar Series', 'about' => 'Set gantungan kunci dengan konsep rockstar yang bold dan edgy. Cocok untuk kamu yang suka aksesoris unik dan standout.'],
            ['name' => 'Sticker Sheet Idol Pastel', 'about' => 'Sticker sheet bertema pastel dengan berbagai foto idol dan elemen dekoratif. Cocok untuk journaling, laptop, phone case, atau binder.'],
            ['name' => 'Sticker Pack NCT DREAM Cute Series', 'about' => 'Set stiker berisi member NCT DREAM dengan desain colorful dan playful. Ideal untuk koleksi atau menghias barang pribadi.'],
            ['name' => 'Sticker Pack Green Aesthetic Idol', 'about' => 'Paket stiker campuran dengan berbagai desain grafis dan tema idol. Cocok untuk dekorasi bebas dan koleksi casual merch.'],
        ];


        $categoriesMap = [
            'Album' => ['album1.jpg','album2.jpg','album3.jpg','album4.jpg','album5.jpg','album6.jpg','album7.jpg'],
            'Lightstick' => ['lightstick1.jpg','lightstick2.jpg','lightstick3.jpg','lightstick4.jpg','lightstick5.jpg','lightstick6.jpg','lightstick7.jpg','lightstick8.jpg','lightstick9.jpg'],
            'Photocard' => ['photocard1.jpg','photocard2.jpg','photocard3.jpg','photocard4.jpg','photocard5.jpg'],
            'Apparel' => ['hoodie1.jpg','hoodie2.jpg','jersey1.jpg','jersey2.jpg','kaos1.jpg','kaos2.jpg','kaos3.jpg'],
            'Doll' => ['doll1.jpg','doll2.jpg','doll3.jpg','doll4.jpg'],
            'Keychains & Stickers' => ['keychain1.jpg','keychain2.jpg','keychain3.jpg','sticker1.jpg','sticker2.jpg','sticker3.jpg'],
        ];

        Storage::disk('public')->makeDirectory('products');

        foreach ($categoriesMap as $catName => $images) {
            $category = \App\Models\ProductCategory::firstOrCreate(
                ['slug' => Str::slug($catName)],
                [
                    'name' => $catName,
                    'image' => 'default-icon.png',
                    'description' => 'Category for ' . $catName . ' products',
                ]
            );

            foreach ($images as $index => $imageFile) {

                $data = match ($catName) {
                    'Album' => $albumProducts[$index] ?? null,
                    'Photocard' => $photocardProducts[$index] ?? null,
                    'Apparel' => $apparelProducts[$index] ?? null,
                    'Doll' => $dollProducts[$index] ?? null,
                    'Lightstick' => $lightstickProducts[$index] ?? null,
                    'Keychains & Stickers' => $keychainStickerProducts[$index] ?? null,
                    default => null,
                };

                if (!$data) {
                    $data = [
                        'name' => $catName . ' ' . ($index + 1),
                        'about' => 'Official K-Pop merchandise.',
                    ];
                }

                $product = \App\Models\Product::firstOrCreate(
                    ['store_id' => $store->id, 'name' => $data['name']],
                    [
                        'product_category_id' => $category->id,
                        'slug' => Str::slug($data['name'] . '-' . uniqid()),
                        'about' => $data['about'],
                        'condition' => 'new',
                        'price' => rand(20000, 650000),
                        'weight' => rand(50, 900),
                        'stock' => rand(10, 50),
                    ]
                );

                \App\Models\ProductImage::firstOrCreate([
                    'product_id' => $product->id,
                    'image' => 'products/' . $imageFile,
                ]);
            }
        }

        $this->call([
            AdminUserSeeder::class,
            TransactionSeeder::class,
            ProductReviewSeeder::class,
        ]);
    }
}
