<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Penjualan extends BaseController
{
    public function index()
    {
        $no_transaksi = $this->penjualan->generateTransactionNumber();
       

        $data=[
            'no_transaksi'=>$no_transaksi,
            'produkList'=> $this->produk->getProduk(),
            'detailPenjualan' => $this->detail->getDetailPenjualan(session()->get('IdPenjualan')),
            'totalHarga' =>$this->penjualan->getTotalHargaById(session()->get('IdPenjualan')),
        ];
        return view('penjualan/transaksi',$data);
    }
   
    public function simpanPenjualan(){
        $validation = \Config\Services::validation();
        $validation->setRule('id_produk', 'ID Produk', 'required',['required'=>'Inputan wajib diisi']);
        $validation->setRule('txtqty', 'Qty', 'required|numeric',['required'=>'Inputan wajib diisi','numeric'=>'Inputan harus berupa angka']);
    
        // Jalankan validasi
        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }
        $id_produk = $this->request->getPost('id_produk');
        $qty = $this->request->getPost('txtqty');
        $cekBarang = $this->produk->find($id_produk);
        $stok_produk = $cekBarang['stok'];
    
        // Periksa apakah qty melebihi stok
        if ($qty > $stok_produk) {
            return redirect()->back()->withInput()->with('error', 'Qty tidak boleh melebihi stok.');
        }

        // ambil detail barang yang dijual
        $where=['id_produk'=>$this->request->getPost('id_produk')];
        $cekBarang=$this->produk->where($where)->findAll(); 
        $hargaJual=$cekBarang[0]['harga_jual'];
    
        if(session()->get('IdPenjualan') == null){            
            // 1. Menyiapkan data penjualan
            date_default_timezone_set('Asia/Jakarta');
            // Mendapatkan waktu saat ini dalam zona waktu yang telah diatur
            $tanggal_sekarang = date('Y-m-d H:i:s');

            $dataPenjualan=[
                'no_transaksi'=>$this->request->getPost('no_transaksi'),
                'tgl_penjualan'=>$tanggal_sekarang, // Perbaiki format tanggal
                'email'=> session()->get('email'),
                'total'=>0
            ];
            
            // 2. Menyimpan data ke dalam tabel penjualan
            $this->penjualan->insert($dataPenjualan);
    
            // 3. Menyiapkan data untuk menyimpan detail penjualan
            $idPenjualanBaru = $this->penjualan->insertID(); // Mendapatkan ID penjualan baru
            $dataDetailPenjualan=[
                'id_penjualan'=>$idPenjualanBaru,
                'id_produk'=>$this->request->getPost('id_produk'),
                'qty'=> $this->request->getPost('txtqty'),
                'total_harga'=>$hargaJual*$this->request->getPost('txtqty')
            ];
    
            // 4. Menyimpan data ke dalam tabel detail penjualan
            $this->detail->insert($dataDetailPenjualan);
    
            // 5. Membuat session untuk penjualan baru
            session()->set('IdPenjualan', $idPenjualanBaru);
        } else {
            // Jika ada ID penjualan yang sudah tersimpan di sesi, gunakan ID itu untuk menyimpan detail penjualan
            $idPenjualanSaatIni = session()->get('IdPenjualan');
            $dataDetailPenjualan=[
                'id_penjualan'=>$idPenjualanSaatIni,
                'id_produk'=>$this->request->getPost('id_produk'),
                'qty'=> $this->request->getPost('txtqty'),
                'total_harga'=>$hargaJual*$this->request->getPost('txtqty')
            ];
    
            // Simpan data ke dalam tabel detail penjualan
            $this->detail->insert($dataDetailPenjualan);
        }
    
        // Mengarahkan pengguna kembali ke halaman transaksi penjualan
        return redirect()->to('transaksi-penjualan');
    }
    public function simpanPembayaran(){
        // Mendapatkan ID penjualan yang selesai
        $idPenjualanSelesai = session()->get('IdPenjualan');
        
        // Menghapus ID penjualan dari sesi
        session()->remove('IdPenjualan');
        
        // Mengarahkan pengguna kembali ke halaman transaksi penjualan
        return redirect()->to('transaksi-penjualan');
    }
        
    public function listPenjualan()
    {
    
            $data=[
                'DailySell'=>$this->penjualan->getDailySell(),   
                'DailyPenjualan'=>$this->penjualan->getDailyPenjualan(),  
                'listDetailPenjualan'=>$this->detail->getDailyDetailPenjualan(),
                'stokLow'=>$this->produk->jumlahStokHabis(), 
                'laba'=>$this->penjualan->laba(), 
                'total'=>$this->penjualan->totalperbulan(),
                'untung'=>$this->penjualan->keuntunganperbulan()
            ];
  
        return view('laporan/list-penjualan',$data);
    }
    public function carilaporan()
    {
        // Aturan validasi
        $rules = [
            'bulan' => 'required',
            'tahun' => 'required'
        ];
    
        // Lakukan validasi
        if ($this->validate($rules)) {
            // Jika validasi berhasil, ambil bulan dan tahun dari inputan pengguna
            $bulan = $this->request->getPost('bulan');
            $tahun = $this->request->getPost('tahun');
    
            // Ambil data yang diperlukan
            $data = [
                'DailySell'=>$this->penjualan->getDailySell(),   
                'DailyPenjualan'=>$this->penjualan->getDailyPenjualan(),  
                'listDetailPenjualan'=>$this->detail->getDailyDetailPenjualan(),
                'stokLow'=>$this->produk->jumlahStokHabis(), 
                'laba'=>$this->penjualan->laba(), 
                'carilaporan' => $this->penjualan->cariLaporan($bulan, $tahun),
                'hitunglaporan' => $this->penjualan->hitungLaporan($bulan, $tahun)
            ];
   
            // Tampilkan view dengan data yang diperoleh
            return view('laporan/cari-laporan', $data);
        } else {
            // Jika validasi gagal, tampilkan halaman dengan pesan kesalahan
            return view('laporan/cari-laporan', ['validation' => $this->validator]);
        }
    }
    public function cetakHariini(){
        $data=[
            'DailySell'=>$this->penjualan->getDailySell(),   
            'DailyPenjualan'=>$this->penjualan->getDailyPenjualan(),  
            'listDetailPenjualan'=>$this->detail->getDailyDetailPenjualan(),
            'stokLow'=>$this->produk->jumlahStokHabis(), 
            'laba'=>$this->penjualan->laba(), 
            'total'=>$this->penjualan->totalperbulan(),
            'untung'=>$this->penjualan->keuntunganperbulan()
        ];
        return view('laporan/cetak-laporan-hari-ini',$data);
    }
    
}
