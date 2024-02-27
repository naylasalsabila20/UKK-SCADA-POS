<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Satuan extends BaseController
{
    public function index()
    {
        $data=[
            'listSatuan'=> $this->satuan->getAllSatuan()
        ];
        return view('master-data/satuan/list-satuan',$data);
    }
    public function tambah(){
        $validation = \Config\Services::validation();
               $validation->setRule('nama_satuan', 'Nama satuan', 'required|is_unique[satuan.nama_satuan]', [
                   'is_unique' => '{field} sudah digunakan!',
                   'required'=>'{field} tidak boleh kosong',
         
               ]);
               $datavalid = [
                   'nama_satuan'=>$this->request->getPost('txtnamasatuan')
                 ];
                 if (!$validation->run($datavalid)) {
                    // Custom error messages will be used if validation fails
                    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
                }
                $data=[
                               'nama_satuan' =>$this->request->getPost('txtnamasatuan')
                           ];
                           $cekRecord=$this->satuan->cariSatuan($data['nama_satuan']);
                                       if(isset($cekRecord[0]->id_satuan)){
                                           $this->satuan->updateSatuan($data);
                                       } else {
                                           $this->satuan->tambahSatuan($data);
                                           session()->setFlashdata('pesan','Data berhasil ditambahkan');
                                       }
                                   return redirect()->to('/master-data-satuan');
       
       }
       public function hapus($idNya){
        if($this->validasiHapus($idNya)) {
            // Data bisa dihapus, panggil metode untuk menghapus data
            $this->satuan->hapusSatuan($idNya);
            session()->setFlashdata('hapus','Data berhasil dihapus');
        } else {
            // Data tidak dapat dihapus karena telah digunakan di tabel lain
            session()->setFlashdata('error','Data tidak dapat dihapus karena masih digunakan di tabel lain');
        }
        return redirect()->to('/master-data-satuan');
    }
    private function validasiHapus($idNya) {
        $dataTerpakai = $this->satuan->cekKetergantungan($idNya);
          return !$dataTerpakai;
    }
 
    public function update(){
        var_dump($_POST);
        $idNya = $this->request->getPost('id_satuan');
        $namaNya = $this->request->getPost('txtnamasatuan');
        error_log('id_satuan: ' . $idNya); // Log ID satuan
        error_log('nama_satuan: ' . $namaNya); // Log Nama Divisi
        $validation = \Config\Services::validation();
        $validation->setRule('nama_satuan', 'Nama satuan', 'required|is_unique[satuan.nama_satuan]', [
            'is_unique' => '{field} sudah digunakan!',
        ]);
        $datavalid = [
            'nama_satuan'=>$this->request->getPost('txtnamasatuan')
          ];
          if (!$validation->run($datavalid)) {
             // Custom error messages will be used if validation fails
             return redirect()->back()->withInput()->with('errors', $validation->getErrors());
         }
        $data = [
            'id_satuan' => $idNya,
            'nama_satuan' => $namaNya
        ];
    
        $this->satuan->updateSatuan($data);
        session()->setFlashdata('edit','Data berhasil diupdate');
        return redirect()->to('/master-data-satuan') ;
    }
}
