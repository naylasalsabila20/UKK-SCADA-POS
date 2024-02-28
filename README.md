# APLIKASI KASIR CI-4
Aplikasi ini merupakan contoh project uji kompetensi program keahlian Rekayasa Perangkat Lunak tahun 2023/2024.
Dilengkapi dengan fitur:
1. LOGIN
2. CRUD PENGGUNA, SATUAN, KATEGORI, PRODUK
3. TRANSAKSI
4. CETAK LAPORAN STOK
## Download dan Instalasi
1. Jalankan CMD / Terminal
2. Masuk ke drive D: atau yang lain jika di linux silahkan masuk direktori mana saja
3. Jalankan perintah :
   <code> git clone https://github.com/naylasalsabila20/UKK-SCADA-POS.git</code>
4. Lakukan update dengan perintah composer update
5. Ganti file env dengan .env
6. Seting :
   <code> CI_ENVIRONMENT = development atau production
   app.baseURL = 'http://localhost:8080'
   database.default.hostname = localhost
   database.default.database = scada_pos
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
## Menjalankan Aplikasi
1. Buka terminal
2. Jalankan perintah php spark serve
3. Buka browser, akses URL http://localhost:8080
## DEMO
Home
![Teks Alternatif](https://github.com/naylasalsabila20/UKK-SCADA-POS/blob/main/demohome.png)

Master data
![Teks Alternatif](https://github.com/naylasalsabila20/UKK-SCADA-POS/blob/main/demomasterdata.png)

Transaksi
![Teks Alternatif](https://github.com/naylasalsabila20/UKK-SCADA-POS/blob/main/demotransaksi.png)

CETAK LAPORAN STOK
![Teks Alternatif](https://github.com/naylasalsabila20/UKK-SCADA-POS/blob/main/demolaporanstok.png)

