<?php

return [
    'required' => ':attribute wajib diisi.',
    'string' => ':attribute harus berupa teks.',
    'numeric' => ':attribute harus berupa angka.',
    'integer' => ':attribute harus berupa bilangan bulat.',
    'email' => ':attribute harus berupa alamat email yang valid.',
    'exists' => ':attribute tidak valid.',
    'image' => ':attribute harus berupa gambar.',
    'mimes' => ':attribute harus berformat JPG, PNG, atau WebP.',
    'extensions' => ':attribute memiliki ekstensi yang tidak valid.',
    'boolean' => ':attribute tidak valid.',
    'in' => ':attribute tidak valid.',
    'min' => ['numeric' => ':attribute minimal :min.', 'string' => ':attribute minimal :min karakter.'],
    'max' => ['numeric' => ':attribute maksimal :max.', 'string' => ':attribute maksimal :max karakter.', 'file' => ':attribute maksimal :max kilobita.'],
    'regex' => ':attribute memiliki format yang tidak valid.',
    'url' => ':attribute harus berupa URL yang valid.',
    'starts_with' => ':attribute harus menggunakan alamat Instagram resmi.',
    'attributes' => [
        'name' => 'Nama', 'email' => 'Email', 'phone' => 'Nomor WhatsApp', 'organization' => 'Organisasi',
        'product_id' => 'Produk', 'quantity' => 'Jumlah', 'message' => 'Pesan', 'category_id' => 'Kategori',
        'description' => 'Deskripsi', 'price' => 'Harga', 'material' => 'Material', 'min_order' => 'Minimum order',
        'production_days' => 'Estimasi produksi', 'image' => 'Gambar', 'password' => 'Kata sandi',
    ],
];
