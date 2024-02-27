<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Produk extends BaseController
{
    public function index()
    {
        $data=[
            'listProduk'=>$this->produk->getAllProduk(),
            'listSatuan'=>$this->satuan->getAllSatuan(),
            'listKategori'=>$this->kategori->getAllKategori(),
            'DataProduk'=>$this->produk->getData()
            
        ];
        return view('master-data/produk/list-produk',$data);
    }
    public function tambah(){
        $validation = \Config\Services::validation();
               $validation->setRule('kode_produk', 'Kode produk', 'required', [
                   'required'=>'{field} tidak boleh kosong',
                ]);
               $validation->setRule('nama_produk', 'Nama produk', 'required', [
                'required'=>'{field} tidak boleh kosong',
                ]);
                $validation->setRule('id_satuan', 'Nama Satuan', 'required', [
                    'required'=>'{field} tidak boleh kosong',
                ]);
                $validation->setRule('id_kategori', 'Nama kategori', 'required', [
                    'required'=>'{field} tidak boleh kosong',
                ]);
                $validation->setRule('harga_beli', 'Harga beli', 'required', [
                    'required'=>'{field} tidak boleh kosong',
                ]);
                $validation->setRule('harga_jual', 'Harga jual', 'required', [
                    'required'=>'{field} tidak boleh kosong',
                ]);
                $validation->setRule('stok', 'Stok', 'required|numeric|greater_than[0]', [
                    'required'=>'{field} tidak boleh kosong',
                    'numeric'=>'{field} harus berupa angka',
                    'greater_than' => '{field} harus lebih besar dari 0'
                    ]);

                    $datavalid = [
                        'kode_produk'=>$this->request->getPost('txtkodeproduk'),
                        'nama_produk'=>$this->request->getPost('txtnamaproduk'),
                        'id_satuan'=>$this->request->getPost('id_satuan'),
                        'id_kategori'=>$this->request->getPost('id_kategori'),
                        'harga_beli'=>$this->request->getPost('txthargabeli'),
                        'harga_jual'=>$this->request->getPost('txthargajual'),
                        'stok'=>$this->request->getPost('txtstok')
                      ];
                 if (!$validation->run($datavalid)) {
                    // Custom error messages will be used if validation fails
                    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
                }
                $data=[
                    'kode_produk'=>$this->request->getPost('txtkodeproduk'),
                    'nama_produk'=>$this->request->getPost('txtnamaproduk'),
                    'id_satuan'=>$this->request->getPost('id_satuan'),
                    'id_kategori'=>$this->request->getPost('id_kategori'),
                    'harga_beli'=> str_replace('.', '', $this->request->getPost('txthargabeli')),
                    'harga_jual'=> str_replace('.', '', $this->request->getPost('txthargajual')),
                    'stok'=>$this->request->getPost('txtstok')
                           ];
                          
                                           $this->produk->tambahProduk($data);
                                           session()->setFlashdata('pesan','Data berhasil ditambahkan');
                                       
                                   return redirect()->to('/master-data-produk');
       
       }
       public function hapus($idNya){
        $this->produk->hapusProduk($idNya);
        session()->setFlashdata('hapus','Data berhasil dihapus');
        return redirect()->to('/master-data-produk');
       }
       public function updateStok(){
        var_dump($_POST);
        $idNya = $this->request->getPost('id_produk');
        $hargaBeliNya = str_replace('.','',$this->request->getPost('txthargabeli'));
        $hargaJualnya = str_replace('.','',$this->request->getPost('txthargajual'));
        $Stoknya = $this->request->getPost('txtstok');
        error_log('id_produk: ' . $idNya); 
        error_log('harga_beli: ' . $hargaBeliNya);
        error_log('harga_jual: ' . $hargaJualnya);
        error_log('stok: ' . $Stoknya);
        $data = [
            'id_produk' => $idNya,
            'harga_beli' => $hargaBeliNya,
            'harga_jual'=> $hargaJualnya,
            'stok'=> $Stoknya,
        ];
        $this->produk->updateStok($data);
        session()->setFlashdata('edit','Data berhasil diupdate');
        return redirect()->to('/master-data-produk') ;
    }
    public function update(){
        var_dump($_POST);
        $idNya = $this->request->getPost('id_produk');
        $kodeNya =$this->request->getPost('txtkodeproduk');
        $namaNya =$this->request->getPost('txtnamaproduk');
        $satuanNya =$this->request->getPost('id_satuan');
        $kategoriNya =$this->request->getPost('id_kategori');
        error_log('id_produk: ' . $idNya); 
        error_log('kode_produk: ' . $kodeNya);
        error_log('nama_produk: ' . $namaNya);
        error_log('id_satuan: ' . $satuanNya);
        error_log('id_kategori: ' . $kategoriNya);
        $data = [
            'id_produk' => $idNya,
            'kode_produk'=> $kodeNya,
            'nama_produk'=> $namaNya,
            'id_satuan'=> $satuanNya,
            'id_kategori'=>$kategoriNya
        ];
        $this->produk->updateProduk($data);
        session()->setFlashdata('edit','Data berhasil diupdate');
        return redirect()->to('/master-data-produk') ;
    }
    public function listStok()
    {
        $data=[
            'listProduk'=>$this->produk->getAllProduk(),     
        ];
        return view('laporan/list-stok-produk',$data);
    }
    
    public function laporanStok(){
        $data =[
            'listProduk'=>$this->produk->getCetak(),
            ] ;
        
            return view('laporan/laporanstok',$data); 
    }

  
}
