<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Toko Filkom</title>
    <link rel="stylesheet" href="homepage.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    </head>
<body>

    <?php
    // --- DATA PRODUK DENGAN MULTIPLE IMAGES ---
    // Pastikan Anda memiliki file gambar ini di folder yang sama
    $products = [
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp50.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            // Gunakan placeholder atau nama file gambar yang sesuai
            'images' => ['sensi-vivo.jpg', 'sensi-vivo-2.jpg', 'sensi-vivo-3.jpg']
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp700.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['Produk1.jpeg'] // Hanya satu gambar
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp25.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['sutra.jpg', 'sutra-2.jpg']
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp50.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['sensi-vivo.jpg', 'sensi-vivo-4.jpg']
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp700.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['braidy.jpg']
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp25.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['sutra.jpg', 'sutra-3.jpg', 'sutra-4.jpg']
        ],
        // Ulangi produk untuk baris kedua sesuai desain
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp50.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['sensi-vivo.jpg', 'sensi-vivo-5.jpg']
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp700.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['braidy.jpg']
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp25.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['sutra.jpg', 'sutra-5.jpg']
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp50.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['sensi-vivo.jpg', 'sensi-vivo-6.jpg', 'sensi-vivo-7.jpg']
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp700.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['braidy.jpg']
        ],
        [
            'name' => '[PRODUK BAGUS GEYS]',
            'price' => 'Rp25.000',
            'rating' => '5.0',
            'sold' => '1+ terjual',
            'store' => 'TokcengDodoI',
            'images' => ['sutra.jpg']
        ],
    ];
    ?>

    <header class="navbar">
        <div class="logo">
            <img src="filkom-logo.png" alt="FILKOM Logo" class="logo-img">
            <span>FILKOM</span>
            <span class="tagline">Fakultas Ilmu Komputer</span>
        </div>

        <nav class="nav-links">
            <a href="#" class="kategori-btn">Kategori</a>
            <div class="search-box">
                <i class="search-icon">🔍</i>
                <input type="text" placeholder="Cari Produk di Sini yee">
            </div>
            <a href="#" class="login-btn">Login</a>
            <a href="#" class="register-btn">Register</a>
        </nav>
    </header>

    <main class="product-grid-container">
        <div class="product-grid">

            <?php
            // Looping untuk menampilkan setiap produk
            foreach ($products as $product) {
                // Gambar utama selalu elemen pertama
                $main_image = $product['images'][0];
                // Hitung jumlah gambar tambahan
                $extra_image_count = count($product['images']) - 1;
            ?>

            <div class="product-card">
                <a href="#">
                    <img src="<?php echo $main_image; ?>" alt="<?php echo $product['name']; ?>">
                    
                    <?php
                    // Tampilkan indikator jika ada gambar tambahan
                    if ($extra_image_count > 0) {
                        echo '<div class="image-indicator">';
                        echo '+' . $extra_image_count . ' Foto Lain';
                        echo '</div>';
                    }
                    ?>
                    
                    <div class="product-info">
                        <h4 class="product-name"><?php echo $product['name']; ?></h4>
                        <p class="product-price"><?php echo $product['price']; ?></p>
                        <div class="product-meta">
                            <span class="rating">⭐ <?php echo $product['rating']; ?></span>
                            <span class="sold">| <?php echo $product['sold']; ?></span>
                        </div>
                        <p class="store-name"><span><i class="store-icon">🏠</i></span> <?php echo $product['store']; ?></p>
                    </div>
                </a>
            </div>

            <?php
            } // Akhir loop
            ?>

        </div>
    </main>

</body>
</html>