<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Pengguna extends BaseController
{
    public function index()
    {
        $data=[
            'listPengguna'=> $this->pengguna->getAllpengguna()
        ];
        return view('master-data/pengguna/list-pengguna',$data);
    }
    public function tambah(){
        $validation = \Config\Services::validation();
               $validation->setRule('email', 'email pengguna', 'required|is_unique[pengguna.email]', [
                   'is_unique' => '{field} sudah digunakan!',
                   'required'=> '{field} tidak boleh kosong'
               ]);
               $validation->setRule('nama', 'nama pengguna', 'required', [
                'required' => '{field} tidak boleh kosong'
               ]);
               $validation->setRule('password', 'password', 'required', [
                'required' => '{field} tidak boleh kosong'
               ]);
               $validation->setRule('level', 'level', 'required', [
                'required' => '{field} tidak boleh kosong'
               ]);
               $datavalid = [
                   'email'=>$this->request->getPost('txtemail'),
                   'nama'=>$this->request->getPost('txtnama'),
                   'password'=>$this->request->getPost('txtpassword'),
                   'level'=>$this->request->getPost('txtlevel')
                 ];
                 if (!$validation->run($datavalid)) {
                    // Custom error messages will be used if validation fails
                    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
                }
                $data=[
                               'email' =>$this->request->getPost('txtemail'),
                               'nama' =>$this->request->getPost('txtnama'),
                               'password' =>$this->request->getPost('txtpassword'),
                               'level' =>$this->request->getPost('txtlevel')
                           ];
                           $cekRecord=$this->pengguna->cariPengguna($data['email']);
                                       if(isset($cekRecord[0]->email)){
                                           $this->pengguna->updatePengguna($data);
                                       } else {
                                           $this->pengguna->tambahPengguna($data);
                                           session()->setFlashdata('pesan','Data berhasil ditambahkan');
                                       }
                                   return redirect()->to('/master-data-pengguna');
       
       }
       public function hapus($emailNya){
        $this->pengguna->hapusPengguna($emailNya);
        session()->setFlashdata('hapus','Data berhasil dihapus');
        return redirect()->to('/master-data-pengguna');
       }
 
    public function update(){
        var_dump($_POST);
        $emailNya = $this->request->getPost('txtemail');
        $levelNya = $this->request->getPost('txtlevel');
        $namaNya = $this->request->getPost('txtnama');
        error_log('email: ' . $emailNya); 
        error_log('level: ' . $levelNya);
        error_log('nama: ' . $namaNya);

        $data = [
            'email' => $emailNya,
            'level' => $levelNya,
            'nama'=> $namaNya,
        ];
        $this->pengguna->updatePengguna($data);
        session()->setFlashdata('edit','Data berhasil diupdate');
        return redirect()->to('/master-data-pengguna') ;
    }
    public function updatepassPengguna(){
    
        var_dump($_POST);
                  $validation = [
                      'passwordbaru'=>'required',
                      'repeat'=>'required|matches[passwordbaru]'
                  ];
                  if(!$this->validate($validation)){
                      return redirect()->back()->with('passerror', 'Password tidak sinkron!');			
                  }
                  $data=[
                      'email'=>$this->request->getVar('txtemail'),
                      'password' => $this->request->getVar('passwordbaru')
                      
                  ];
      
                  $this->pengguna->updatePassword($data);
                  session()->setFlashdata('edit','Data berhasil diupdate');
  
              return redirect()->to('/master-data-pengguna');
          }
}
