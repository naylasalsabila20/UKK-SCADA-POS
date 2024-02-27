<?php

namespace App\Models;

use CodeIgniter\Model;

class MKategori extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_kategori','nama_kategori'];

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

    public function getAllKategori(){
        $kategori= NEW MKategori;
        $queryKategori=$kategori->query("CALL list_kategori()")->getResult();
        return $queryKategori;
    }
    public function hapusKategori($idKategori){
        $kategori = NEW MKategori;
        $kategori->query("CALL hapus_kategori('".$idKategori."')");
    }
    public function tambahKategori($data){
        $kategori = NEW MKategori;
        $nama = $data['nama_kategori'];
        $kategori->query("CALL tambah_kategori('$nama')");  
    }
    public function updateKategori($data){
        $kategori=NEW MKategori;
        $idKategori = $data['id_kategori'];
        $nama = $data['nama_kategori'];
        $kategori->query("CALL update_kategori('$idKategori','$nama')");
    }

    public function cariKategori($idKategori){
    $kategori= NEW MKategori;
    $queryKategori = $kategori->query("CALL cari_kategori('".$idKategori."')")->getResult();
    return $queryKategori;
    }

    public function cekKetergantungan($idNya)
    {
        $query = "SELECT COUNT(*) AS total FROM produk WHERE id_kategori = ?";
        $result = $this->db->query($query, [$idNya])->getRow();
        return $result->total > 0;
    }
}
