<?php

namespace App\Models;

use CodeIgniter\Model;

class MProduk extends Model
{
    protected $table            = 'produk';
    protected $primaryKey       = 'id_produk';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_produk','kode_produk','nama_produk','harga_beli','harga_jual','id_satuan','id_kategori','stok'];

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

    public function getAllProduk(){
        $produk= NEW MProduk;
        $queryproduk=$produk->query("CALL lihat_produk()")->getResult();
        return $queryproduk;
    }
    public function getCetak(){
        $produk= NEW MProduk;
        $queryproduk=$produk->query("CALL cetak_produk()")->getResult();
        return $queryproduk;
    }
    public function getProduk(){
        $produk= NEW MProduk;
        $queryproduk=$produk->query("CALL lihat_produk2()")->getResult();
        return $queryproduk;
    }
    public function getData(){
        $produk= NEW MProduk;
        $queryproduk=$produk->query("CALL data_produk()")->getResult();
        return $queryproduk;
    }
    public function tambahProduk($data){
        $produk = NEW MProduk;
        $kodeNya = $data['kode_produk'];
        $namaNya = $data['nama_produk'];
        $SatuanNya = $data['id_satuan'];
        $kategoriNya = $data['id_kategori'];
        $hargaBeliNya = $data['harga_beli'];
        $hargaJualNya = $data['harga_jual'];
        $stokNya = $data['stok'];

        $produk->query("CALL tambah_produk('$kodeNya','$namaNya','$SatuanNya','$kategoriNya','$hargaBeliNya','$hargaJualNya','$stokNya')");
    }
    public function hapusProduk($idNya){
        $produk = NEW MProduk;
        $produk->query("CALL hapus_produk('".$idNya."')");
    }
    public function updateStok($data)
    {          
            $produk = new MProduk;
            $idNya = $data['id_produk'];
            $hargaBeliNya = $data['harga_beli'];
            $hargaJualNya = $data['harga_jual'];
            $stokNya = $data['stok'];

    $produk->query("CALL update_stok('$idNya','$hargaBeliNya','$hargaJualNya','$stokNya')");
    }
    public function updateProduk($data)
    {          
            $produk = new MProduk;
            $idNya = $data['id_produk'];
            $kodeNya = $data['kode_produk'];
            $namaNya = $data['nama_produk'];
            $SatuanNya = $data['id_satuan'];
            $kategoriNya= $data['id_kategori'];

    $produk->query("CALL update_produk('$idNya','$kodeNya','$namaNya','$SatuanNya','$kategoriNya')");
    }

    public function getInfo($productCode)
    {
        return $this->where('kode_produk', $productCode)->first();
    }
    
    public function jumlahStokHabis(){
        $produk= NEW MProduk;
        $queryproduk=$produk->query("CALL StokBarang()")->getResult();
        return $queryproduk;
    }
}
