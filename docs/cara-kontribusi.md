> Sebelumnya diharapkan anda paham lebih dahulu bagaimana cara membuat pull request :D.

## 1. Membuat Aplikasi Demo
Buat aplikasi yang ingin anda demokan. Pastikan bisa jalan dengan benar. Ada 2 jenis aplikasi yang bisa anda buat.

### &nbsp; 1A. Halaman Statis
Jika demo yang anda buat hanya hanya terdiri dari satu halaman saja dan tidak terdiri dari beberapa proses seperti demo
untuk `widget`. Maka anda bisa membuatnya sebagai halaman statis. Caranya, buat file php untuk demo tersebut 
di folder `protected/views/pages`. Nama file harus huruf kecil semua. Jika terdiri dari beberapa kata, pisahkan dengan
`-`. Misal nama file-nya `contoh-fullcalendar.php`.

Untuk mengakses file yang sudah dibuat dari browser adalah dengan alamat `localhost/your-app/index.php/pages/nama-file`.
Misal nama filenya `contoh-fullcalendar.php`, maka urlnya `localhost/your-app/index.php/pages/contoh-fullcalendar`.
`Route` untuk demo tersebut adalah `['site/page', 'view' => 'contoh-fullcalendar']`. Contoh untuk demo jenis ini 
adalah `hello-world`. Filenya ada di `protected/views/pages/hello-world.php`.

### &nbsp; 1B. Aplikasi Lengkap
Jenis demo yang kedua adalah berupa aplikasi lengkap yaitu terdiri dari controller dan view (dan model). Buat aplikasinya
secara lengkap terus pastikan bisa dijalankan. Jika demo tersebut memerlukan tabel tertentu, buat juga file migrationnya.
Untuk controllernya, set `layout`nya menjadi 'playground'. Contoh untuk demo jenis ini adalah `chat` dan `easyui`.

## 2. Mendaftarkan Menu
Berikutnya mendaftarkan demo tersebut ke sidebar menu. Caranya, edit file `protected/routes/routes.php`. 
Tambahkan demo yang dibuat ke dalam `array`. Bisa ke dalam salah satu `key` yang ada atau membuat baru. Misal
```php
return [
    ...
    'Full Calendar' => [
        'Contoh 1' => 'calendar/contoh1.php',
    ],
];
```
Selanjutnya adalah membuat file `protected/routes/calendar/contoh1.php`. File ini berisi konfigurasi untuk demo tersebut.
Formatnya
```php
return [
    'url' => ['site/page', 'view' => 'contoh-fullcalendar'], // wajib
    'author' => 'Nama Anda', // optional
    'text' => "Keterangan singkat untuk demo anda. Optional. Bisa
menyertakan *markdown* `syntax` di sini.
",
    'sources' => [ // source yang akan ditampilakan
        [
            'source' => '@app/views/pages/contoh-fullcalendar.php',
            'lang' => 'html', // opsional. defaultnya baca ext file
            'text' => 'Keterangan source', // opsional
        ],
        '@app/views/pages/js/fullcalendar.js',
        // Sintak lain yg disuport adalah 'app\controllers\NamaController'
        // atau bisa juga 'app\models\MyModel::rules' untuk menampilkan hanya 1 method
    ],
    'urls' => [ 
        // jika ada url lain yang terkait. Url yang dilist di sini akan 
        // dianggap sebagai satu thread untuk komentar/disqus
        // opsional
       ['site/page', 'view' => 'page-lain'],
       ['site/page', 'view' => 'page-lain-lagi'],
    ]
];
```
Setelah itu silakan melakukan pull request. Kami akan mereview kode anda :D.
Kami nantikan partisipasi anda untuk perkembangan Yii Indonesia.
