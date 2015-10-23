Welcome to QuotaTool!
===================

QuotaTool merupakan aplikasi sederhana untuk mengelola quota pengguna pada sistem Linux, Mac OS X, FreeBSD, OpenBSD, NetBSD, Solaris, dan AIX. Repository resminya berada di https://github.com/ekenberg/quotatool.

Pada package ini hanya sebuah wrapper untuk digunakan pada Laravel.

----------
Instalasi
-------------

#### Install dengan Composer

Cukup sederhana, jalankan perintah berikut.

    composer require nurmanhabib/quotatool


#### Tambahkan Service Provider

Tambahkan `Nurmanhabib\QuotaTool\QuotaToolServiceProvider` ke dalam file di `config/app.php` pada array `providers`.

    'providers' = [
        ...,
        ...,
        
        'Nurmanhabib\QuotaTool\QuotaToolServiceProvider',
    ];


#### Install quota

Pastikan sistem Anda sudah terinstall `quota` dan `quotatool`.

    apt-get install quota quotatool

Untuk konfigurasinya, bagi yang menggunakan Linux Ubuntu dapat mengikuti tutorial https://www.digitalocean.com/community/tutorials/how-to-enable-user-and-group-quotas


#### Berikan Hak Akses quotatool

Package ini menggunakan perintah shell script untuk mengakses `quotatool` dengan sudo. Untuk itu modifikasi dengan perintah berikut.

    sudo visudo

Tambahkan baris berikut pada baris dimana saja tidak masalah.

    ...
    %www-data   ALL=(ALL) NOPASSWD: /usr/sbin/quotatool
    ...

Baris tersebut mengijinkan group `www-data` mengeksekusi `sudo /usr/sbin/quotatool` tanpa password.

----------
Penggunaan
-------------
#### Contoh Penggunaan
Set 50Gb soft and hard disk usage limits for user `nurmanhabib` on filesystem `/home`

    QuotaTool::uid('nurmanhabib')->limit('50G', '50G');

setelah dilakukan output dengan `QuotaTool::raw()` akan menghasilkan sebagai berikut.

    quotatool -u nurmanhabib -b -q 50G -l 50G /home


#### Group ID
Untuk memberikan quota pada group dapat menggunakan method `gid()` 

    QuotaTool::gid('1001');
    QuotaTool::gid('www-data');

#### Filesystem
Secara default, quotatool berada pada filesystem `/home`. Jika quotatool berada pada filesystem lain, Anda dapat menambahkan method `filesystem()`. 

    QuotaTool::uid('nurmanhabib')->limit('50G', '50G')->filesystem('/');
    
setelah dilakukan output dengan `QuotaTool::raw()` akan menghasilkan sebagai berikut.

    quotatool -u nurmanhabib -b -q 50G -l 50G /

#### Limit Block
Untuk menambahkan limit block dengan 10000 soft dan 10240 hard

    QuotaTool::uid('nurmanhabib')->limit(10000, 10240);
    
atau

    QuotaTool::uid('nurmanhabib')->limit(10000, 10240, 'block');
    
#### Limit Inode
Untuk menambahkan limit inode dengan 10000 soft dan 10240 hard

    QuotaTool::uid('nurmanhabib')->limit(10000, 10240, 'inode');
    
#### Grace Period
Belum tersedia :)