<?php

namespace App\Models;

use CodeIgniter\Model;

class MMember extends Model
{
    protected $table            = 'member';
    protected $primaryKey       = 'id_member';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_member','nama','no_telp','alamat','poin'];

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

    public function getAllMember(){
        $member= NEW MMember;
        $querymember=$member->query("CALL list_member()")->getResult();
        return $querymember;
    }
    public function getdata(){
        $member= NEW MMember;
        $querymember=$member->query("CALL  GetMemberList()")->getResult();
        return $querymember;
    }
    public function hapusMember($idmember){
        $member = NEW MMember;
        $member->query("CALL hapus_member('".$idmember."')");
    }
    public function tambahMember($data){
        $member = NEW MMember;
        $nama = $data['nama'];
        $noNya = $data['no_telp'];
        $alamatNya = $data['alamat'];
        $member->query("CALL tambah_member('$nama','$noNya','$alamatNya')");  
    }
    public function updateMember($data){
        $member=NEW MMember;
        $idmember = $data['id_member'];
        $noNya = $data['no_telp'];
        $alamatNya = $data['alamat'];
        $member->query("CALL update_member('$idmember','$noNya','$alamatNya')");
    }

    public function cariMember($idmember){
    $member= NEW MMember;
    $querymember = $member->query("CALL cari_member('".$idmember."')")->getResult();
    return $querymember;
    }
}
