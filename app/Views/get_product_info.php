<?php
// Koneksi ke database (sesuaikan dengan detail koneksi Anda)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'scada_pos';

// Membuat koneksi ke database
$connection = mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (!$connection) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengambil kode produk dari permintaan POST
$productCode = $_POST['productCode'];

// Membuat query untuk mengambil informasi produk berdasarkan kode produk
$query = "SELECT id_produk, nama_produk, harga_jual FROM produk WHERE kode_produk = '$productCode'";
$result = mysqli_query($connection, $query);

$response = array();

// Jika data produk ditemukan
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $response['success'] = true;
    $response['product'] = array(
        'id' => $row['id_produk'],
        'name' => $row['nama_produk'],
        'price' => $row['harga_jual']
    );
} else {
    $response['success'] = false;
}

// Mengirim respons dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);

// Menutup koneksi ke database
mysqli_close($connection);
?>
