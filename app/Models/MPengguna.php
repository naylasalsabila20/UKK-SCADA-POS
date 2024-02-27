<?php

namespace App\Models;

use CodeIgniter\Model;

class MPengguna extends Model
{
    protected $table            = 'pengguna';
    protected $primaryKey       = 'email';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['email','nama','password','level'];

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

    public function hapusPengguna($email){
        $pengguna = NEW MPengguna;
        $pengguna->query("CALL hapus_pengguna('".$email."')");
    }
        
    public function tambahPengguna($data){
        $pengguna = NEW MPengguna;
        $emailNya = $data['email'];
        $namaNya = $data['nama'];
        $passwordNya = $data['password'];
        $levelNya = $data['level'];

        $pengguna->query("CALL tambah_pengguna('$emailNya','$namaNya','$passwordNya', '$levelNya')");
    }


    public function updatePengguna($data)
    {          
            $pengguna = new MPengguna;
            $email = $data['email'];
            $nama = $data['nama'];
            $level = $data['level'];

    $pengguna->query("CALL update_pengguna('$email','$nama','$level')");
    }

    public function getAllPengguna(){
    $pengguna= NEW MPengguna;
    $queryPengguna = $pengguna->query("CALL list_pengguna()")->getResult();
    
    return $queryPengguna;
    }

  
    public function cariPengguna($email){
        $pengguna= NEW MPengguna;
        $queryPengguna = $pengguna->query("CALL cari_kategori('".$email."')")->getResult();
        return $queryPengguna;
        }
        public function updatePassword($data)
        {          
                $pengguna = new MPengguna;
                $email = $data['email'];
                $password = $data['password'];
        $pengguna->query("CALL update_password  ('$email','$password')");
        }
        
}