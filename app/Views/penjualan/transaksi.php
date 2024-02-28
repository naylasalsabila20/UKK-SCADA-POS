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
             
                </div>
                <h2 class="page-title">
            
                </h2>
              </div>
              <div class="col-auto ms-auto d-print-none">
               
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container px-4">
                <div class="card">
             <div class="row">
                <div class="col">
              <div class="row row-cards">
                <div class="col">
                  <div class="card">
                    <form action="<?=site_url('transaksi-penjualan')?>" method="POST">
                    <div class="card-header">
                      <h3 class="card-title">NO TRANSAKSI :    <?php if(isset($detailPenjualan) && !empty($detailPenjualan)) : ?>
                      <?= $detailPenjualan[0]['no_transaksi']; ?>
                      <?php endif; ?>
                      </h3>
                    </div>
                    <div class="card-body">
                      <div class="mb-3">
                        <label class="form-label">KODE PRODUK</label>
                        <input type="hidden" value="<?=$no_transaksi;?>" name="no_transaksi" class="form-control" >
                        <select class="js-example-basic-multiple form-select" name="id_produk" multiple="multiple">
                        <?php if(isset($produkList)) :
                          foreach ($produkList as $row) : ?> 
                        <option value="<?=$row->id_produk;?>"><?=$row->kode_produk;?> | <?=$row->nama_produk;?> | <?=$row->stok;?> | <?=number_format($row->harga_jual,0,',','.');?></option>
                        <?php 
                        endforeach;
                      endif;?>
                      </select>
                      <?php if(session()->has('errors') && isset(session('errors')['id_produk'])): ?>
                       <p style="color: red;"><?php echo session('errors')['id_produk']; ?></p>
                       <?php endif; ?>
                    </div>
               
                      <div class="mb-3">
                        <label class="form-label">JUMLAH</label>
                        <input type="text" name="txtqty" class="form-control">
                        <?php if(session()->has('errors') && isset(session('errors')['txtqty'])): ?>
        <p style="color: red;"><?php echo session('errors')['txtqty']; ?></p>
    <?php endif; ?>
    <?php if (session()->has('error')) : ?>
           <p style="color: red;"><?= session('error') ?></p>
        <?php endif; ?>
                      </div>
        
                      <div class="card-footer text-end">
                      <button type="submit" class="btn sm btn-success"> <i class="bi bi-cart-fill"></i></button>
                    </div>
                    </div>
                </form>
                  </div>
                </div>
                <div class="col">
                    <table  class="table table-sm table-striped">
                <thead>
                 <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                </tr>
                </thead>
                <tbody>
                <?php if(isset($detailPenjualan) && !empty($detailPenjualan)) :
    $no = 1;
    foreach ($detailPenjualan as $detail) : ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= $detail['nama_produk']; ?></td>
        <td  style="text-align: center;">X<?= $detail['qty']; ?></td>
        <td><?= $detail['nama_satuan']; ?></td>
        <td><?= number_format($detail['total_harga'], 0, ',', '.'); ?></td>
    </tr>
<?php endforeach;
else: ?>
    <tr>
        <td colspan="4">Tidak ada produk</td>
    </tr>
<?php endif; ?>
              </tbody>
                 </table>
                  </div>


             
                <div class="col">
                  <div class="card">
                    <div class="card-header">
                      <h1 >TOTAL : RP <?= number_format($totalHarga, 0, ',', '.'); ?></h1>
                    </div>
                    <div class="card-body">
                    <div class="mb-3">
                                        <label class="form-label">BAYAR</label>
                                        <input type="text" name="txtbayar" class="form-control" id="txtbayar">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">KEMBALI</label>
                                        <input type="text" name="kembali" class="form-control" id="kembali" readonly>
                                    </div>
                      <div class="card-footer text-end">
                      <button id="btnBayar" class="btn btn-primary" onclick="redirectToRoute()">Bayar</button>
                   
            
                    </div>
                  </div>
                </div>
                </div>
 

          </div>
        </div>
        <script>
    function redirectToRoute() {
        window.location.href = '<?= site_url('pembayaran') ?>';
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen-elemen yang diperlukan
        var txtBayar = document.getElementById('txtbayar');
        var btnBayar = document.getElementById('btnBayar'); // Tombol untuk melakukan pembayaran
        var kembali = document.getElementById('kembali');
        var totalHarga = <?= $totalHarga ?>; // Ambil total harga dari controller dan diteruskan ke view

        // Nonaktifkan tombol pembayaran dari awal
        btnBayar.disabled = true;

        // Tambahkan event listener untuk memantau perubahan pada input bayar
        txtBayar.addEventListener('input', function() {
            // Ambil nilai yang dibayarkan
            var bayar = parseFloat(txtBayar.value);

            // Hitung kembaliannya
            var kembalian = bayar - totalHarga;

            // Tampilkan kembaliannya pada input kembali
            if (kembalian >= 0) {
                kembali.value = kembalian.toFixed(2).replace(/(\.00)+$/, ''); // Menampilkan hingga 2 digit desimal
                // Aktifkan tombol pembayaran jika bayar cukup
                btnBayar.disabled = false;
            } else {
                kembali.value = '0'; // Jika kembalian negatif, tampilkan '0.00'
                // Nonaktifkan tombol pembayaran jika bayar kurang
                btnBayar.disabled = true;
            }
        });
    });
</script>


<?= $this->endSection();?>