<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Kategori extends BaseController
{
    public function index()
    {
        $data=[
            'listKategori'=> $this->kategori->getAllKategori()
        ];
        return view('master-data/kategori/list-kategori',$data);
    }
    public function tambah(){
        $validation = \Config\Services::validation();
               $validation->setRule('nama_kategori', 'Nama kategori', 'required|is_unique[kategori.nama_kategori]', [
                   'is_unique' => '{field} sudah digunakan!',
                   'required'=>'{field} tidak boleh kosong!',
               ]);
               $datavalid = [
                   'nama_kategori'=>$this->request->getPost('txtnamakategori')
                 ];
                 if (!$validation->run($datavalid)) {
                    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
                }
                $data=[
                               'nama_kategori' =>$this->request->getPost('txtnamakategori')
                           ];
                           $cekRecord=$this->kategori->cariKategori($data['nama_kategori']);
                                       if(isset($cekRecord[0]->id_kategori)){
                                           $this->kategori->updateKategori($data);
                                       } else {
                                           $this->kategori->tambahKategori($data);
                                           session()->setFlashdata('pesan','Data berhasil ditambahkan');
                                       }
                                   return redirect()->to('/master-data-kategori');
       
       }
       public function hapus($idNya){
       
            // Lakukan validasi di sini sebelum menghapus data
            if($this->validasiHapus($idNya)) {
                // Data bisa dihapus, panggil metode untuk menghapus data
                $this->kategori->hapusKategori($idNya);
                session()->setFlashdata('hapus','Data berhasil dihapus');
            } else {
                // Data tidak dapat dihapus karena telah digunakan di tabel lain
                session()->setFlashdata('error','Data tidak dapat dihapus karena masih digunakan di tabel lain');
            }
            return redirect()->to('/master-data-kategori');
        
    }
 
    private function validasiHapus($idNya) {
        $dataTerpakai = $this->kategori->cekKetergantungan($idNya);
          return !$dataTerpakai;
    }
    
    public function update(){
        var_dump($_POST);
        $idNya = $this->request->getPost('id_kategori');
        $namaNya = $this->request->getPost('txtnamakategori');
        error_log('id_kategori: ' . $idNya); // Log ID kategori
        error_log('nama_kategori: ' . $namaNya); // Log Nama Divisi
        $validation = \Config\Services::validation();
        $validation->setRule('nama_kategori', 'Nama kategori', 'required|is_unique[kategori.nama_kategori]', [
            'is_unique' => '{field} sudah digunakan!',
            'required'=>'{field} tidak boleh kosong!',
        ]);
        $datavalid = [
            'nama_kategori'=>$this->request->getPost('txtnamakategori')
          ];
          if (!$validation->run($datavalid)) {
             // Custom error messages will be used if validation fails
             return redirect()->back()->withInput()->with('errors', $validation->getErrors());
         }
        $data = [
            'id_kategori' => $idNya,
            'nama_kategori' => $namaNya
        ];
    
        $this->kategori->updateKategori($data);
        session()->setFlashdata('edit','Data berhasil diupdate');
        return redirect()->to('/master-data-kategori') ;
    }
}
