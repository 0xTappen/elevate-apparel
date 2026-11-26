# Struktur database

| Tabel | Isi | Hubungan |
| --- | --- | --- |
| users | Akun dengan password hash dan penanda `is_admin` | Independen |
| categories | Nama, slug unik, deskripsi, gambar | `hasMany(Product)` |
| products | Kategori, spesifikasi, harga awal, gambar, status | `belongsTo(Category)`, `hasMany(Inquiry)` |
| inquiries | Kontak, kebutuhan, jumlah, status | `belongsTo(Product)` opsional |
| business_settings | Nama PT, brand, deskripsi, kontak | Satu baris konfigurasi |

Foreign key `products.category_id` memakai `restrictOnDelete`, sehingga kategori berisi produk tidak dapat dihapus. `inquiries.product_id` memakai `nullOnDelete` agar konsultasi tetap tersimpan setelah produk dihapus. Slug kategori dan produk unik. Index mendukung filter produk aktif, kategori/harga, dan status inquiry.

Migration dibuat dan dijalankan dengan `php artisan migrate`; seeder idempotent dengan `php artisan db:seed`.

Panel admin memakai gate `access-admin`. Hanya pengguna dengan `is_admin = true` yang dapat masuk dan mengelola data.
