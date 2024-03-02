<?= $this->extend('template');?>
<?= $this->section('konten');?>
<?php
if (session()->has('pesan')) {
    echo flash_swal('success', 'Berhasil', session('pesan'));
}
if (session()->has('edit')) {
  // Panggil fungsi helper untuk menampilkan SweetAlert
  echo flash_swal('success', 'Berhasil', session('edit'));
}
if (session()->has('hapus')) {
  // Panggil fungsi helper untuk menampilkan SweetAlert
  echo flash_swal('success', 'Berhasil', session('hapus'));
}
?>
 <!-- Page header -->
 <div class="page-header d-print-none text-white">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                Laporan Stok Produk
                </h2>
              </div>
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="<?=site_url('catak-laporan-stok');?>" class="btn btn-success d-none d-sm-inline-block">
                  <i class="bi bi-printer-fill"></i> CETAK
                  </a>
                </div>
            </div>
              </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container px-4">
                <div class="card">
                <div class="p-3">

                <table id="myTable" class="table table-sm table-striped table-bordered text-center">
                <thead>
                 <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Kategori</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Stok</th>
                </tr>
                </thead>
                <?php
                  if(isset($listProduk)) :
                  $html =null;
                  $no = 0;
                  foreach($listProduk as $baris) :
                  $no++;
                   $html .='<tr>';
                   $html .='<td>'. $no.'</td>';
                   $html .='<td>'. $baris->kode_produk.'</td>';
                   $html .='<td>'. $baris->nama_produk.'</td>';
                   $html .='<td>'. $baris->nama_satuan.'</td>';
                   $html .='<td>'. $baris->nama_kategori.'</td>';
                   $html .='<td>'.number_format($baris->harga_beli,0,',','.').'</td>';
                   $html .='<td>'.number_format($baris->harga_jual,0,',','.').'</td>';
                   $html .='<td>'. $baris->stok.'</td>';
                   $html .='</tr>';
                    endforeach;
                    echo $html;
                    endif;
                   ?> 
                 </table>
                </div>
             

  
        <?= $this->endSection();?>