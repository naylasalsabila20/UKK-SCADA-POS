<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Member extends BaseController
{
    public function index()
    {
        $data=[
            'listMember'=>$this->member->getAllMember(),
            'dataMember'=>$this->member->getdata()
        ];
        return view ('master-data/member/list-member',$data);
    }
    public function tambah(){
        $validation = \Config\Services::validation();
               $validation->setRule('no_telp', 'Nomer telepon', 'required|is_unique[member.no_telp]|min_length[11]|numeric', [
                   'is_unique' => '{field} sudah digunakan!',
                   'required'=>'{field} tidak boleh kosong',
                   'min_length' => '{field} minimal harus terdiri dari 11 karakter',
                   'numeric' => '{field} hanya boleh berisi angka'

               ]);
               $validation->setRule('nama', 'Nama', 'required', [
                'required'=>'{field} tidak boleh kosong'
               ]);
               $validation->setRule('alamat', 'Alamat', 'required', [
                'required'=>'{field} tidak boleh kosong'
               ]);
               $datavalid = [
                   'nama'=>$this->request->getPost('txtnama'),
                   'no_telp'=>$this->request->getPost('txtnotelp'),
                   'alamat'=>$this->request->getPost('txtalamat')
                 ];
                 if (!$validation->run($datavalid)) {
                    // Custom error messages will be used if validation fails
                    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
                }
                $data=[
                    'id_member'=>$this->request->getPost('id_member'),
                    'nama'=>$this->request->getPost('txtnama'),
                    'no_telp'=>$this->request->getPost('txtnotelp'),
                    'alamat'=>$this->request->getPost('txtalamat')
                           ];
                           $cekRecord=$this->member->cariMember($data['id_member']);
                                       if(isset($cekRecord[0]->id_member)){
                                           $this->member->updateMember($data);
                                       } else {
                                           $this->member->tambahMember($data);
                                           session()->setFlashdata('pesan','Data berhasil ditambahkan');
                                       }
                                   return redirect()->to('/master-data-member');
       
       }
       public function hapus($idNya){
        $this->member->hapusMember($idNya);
        session()->setFlashdata('hapus','Data berhasil dihapus');
        return redirect()->to('/master-data-member');
    }
 
    public function update(){
        var_dump($_POST);
        $idNya = $this->request->getPost('id_member');
        $noNya = $this->request->getPost('txtnotelp');
        $alamatNya = $this->request->getPost('txtalamat');
        error_log('id_member: ' . $idNya); 
        error_log('no_telp: ' . $noNya); 
        error_log('alamat: ' . $alamatNya);
        $validation = \Config\Services::validation();
        $validation->setRule('no_telp', 'Nomer telepon', 'required|is_unique[member.no_telp]|min_length[11]|numeric', [
            'is_unique' => '{field} sudah digunakan!',
            'required'=>'{field} tidak boleh kosong',
            'min_length' => '{field} minimal harus terdiri dari 11 karakter',
            'numeric' => '{field} hanya boleh berisi angka'
        ]);
        $validation->setRule('alamat', 'Alamat', 'required', [
         'required'=>'{field} tidak boleh kosong'
        ]);
        $datavalid = [
            'no_telp'=>$this->request->getPost('txtnotelp'),
            'alamat'=>$this->request->getPost('txtalamat')
          ];
          if (!$validation->run($datavalid)) {
             // Custom error messages will be used if validation fails
             return redirect()->back()->withInput()->with('errors', $validation->getErrors());
         }
        $data = [
            'id_member' => $idNya,
            'no_telp'=>$noNya,
            'alamat'=>$alamatNya
        ];
    
        $this->member->updateMember($data);
        session()->setFlashdata('edit','Data berhasil diupdate');
        return redirect()->to('/master-data-member') ;
    }
}
