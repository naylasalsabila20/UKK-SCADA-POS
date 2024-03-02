<?php

namespace App\Models;

use CodeIgniter\Model;

class MPenjualan extends Model
{
    protected $table            = 'penjualan';
    protected $primaryKey       = 'id_penjualan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['no_transaksi','tgl_penjualan','email','total'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function generateTransactionNumber()
{
    // Dapatkan tahun dua angka terakhir
    $tahun = date('y');

    // Dapatkan nomor urut terakhir dari database
    $lastTransaction = $this->orderBy('id_penjualan', 'DESC')->first();

    // Ambil nomor urut terakhir atau setel ke 0 jika belum ada transaksi sebelumnya
    $lastNumber = ($lastTransaction) ? intval(substr($lastTransaction['no_transaksi'], -4)) : 0;

    // Increment nomor urut
    $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

    // Hasilkan nomor transaksi dengan format SCDPSYYMMDDXXXX
    $no_transaksi = 'SCD' . $tahun . date('md') . $nextNumber;

    // Simpan nomor transaksi dalam sesi
    session()->set('GeneratedTransactionNumber', $no_transaksi);

    return $no_transaksi;
}

public function getTotalHargaById($idPenjualan)
{
    $query = $this->select('total')->where('id_penjualan', $idPenjualan)->first();
    
    // Periksa apakah hasil kueri tidak kosong sebelum mengakses indeks 'total'
    if ($query) {
        return $query['total'];
    } else {
        // Jika hasil kueri kosong, kembalikan nilai default, misalnya 0
        return 0;
    }
}
public function getDailySell(){
    $penjualan= NEW MPenjualan;
    $queryPenjualan=$penjualan->query("CALL getDailySel()")->getResult();
    return $queryPenjualan;
}
public function getDailyPenjualan(){
    $penjualan= NEW MPenjualan;
    $queryPenjualan=$penjualan->query("CALL TotalTransaksi()")->getResult();
    return $queryPenjualan;
}
public function laba(){
    $penjualan= NEW MPenjualan;
    $queryPenjualan=$penjualan->query("CALL hitung_keuntungan()")->getResult();
    return $queryPenjualan;
}
public function cariLaporan($bulan, $tahun){
    $penjualan = new MPenjualan;
    $queryPenjualan = $penjualan->query("CALL tampilkan_data_penjualan_per_hari('" . $bulan . "', '" . $tahun . "')")->getResult();
    return $queryPenjualan; 
}
public function hitungLaporan($bulan, $tahun){
    $penjualan = new MPenjualan;
    $queryPenjualan = $penjualan->query("CALL hitung_total_penjualan_keuntungan('" . $bulan . "', '" . $tahun . "')")->getResult();
    return $queryPenjualan; 
}
public function totalperbulan(){
    $penjualan= NEW MPenjualan;
    $queryPenjualan=$penjualan->query("CALL hitung_total_penjualan_bulan_ini()")->getResult();
    return $queryPenjualan;
}
public function keuntunganperbulan(){
    $penjualan= NEW MPenjualan;
    $queryPenjualan=$penjualan->query("CALL hitung_total_keuntungan_bulan_ini()")->getResult();
    return $queryPenjualan;
}
}
