<?php

namespace App\Models;

use CodeIgniter\Model;

class MSatuan extends Model
{
    protected $table            = 'satuan';
    protected $primaryKey       = 'id_satuan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_satuan','nama_satuan'];

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

    public function getAllSatuan(){
        $satuan= NEW MSatuan;
        $querysatuan=$satuan->query("CALL list_satuan()")->getResult();
        return $querysatuan;
    }
    public function hapusSatuan($idsatuan){
        $satuan = NEW MSatuan;
        $satuan->query("CALL hapus_satuan('".$idsatuan."')");
    }
    public function tambahSatuan($data){
        $satuan = NEW MSatuan;
        $nama = $data['nama_satuan'];
        $satuan->query("CALL tambah_satuan('$nama')");  
    }
    public function updateSatuan($data){
        $satuan=NEW MSatuan;
        $idsatuan = $data['id_satuan'];
        $nama = $data['nama_satuan'];
        $satuan->query("CALL update_satuan('$idsatuan','$nama')");
    }

    public function cariSatuan($idsatuan){
    $satuan= NEW MSatuan;
    $querysatuan = $satuan->query("CALL cari_satuan('".$idsatuan."')")->getResult();
    return $querysatuan;
    }
     
    public function cekKetergantungan($idNya)
    {
        $query = "SELECT COUNT(*) AS total FROM produk WHERE id_satuan = ?";
        $result = $this->db->query($query, [$idNya])->getRow();
        return $result->total > 0;
    }
}
