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
                Master Data Produk
                </h2>
              </div>
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="<?=site_url('list-produk');?>" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Produk Baru
                  </a>
                  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
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
                <?php if (session()->has('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php foreach (session('errors') as $error): ?>
            <?= esc($error) ?><br>
        <?php endforeach; ?>
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close" style="float:right;"></button>
    </div>
<?php endif; ?>

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
                <th>Aksi</th>
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
                   $html .='<td>
                   <a href="'.site_url('list-produk').'"  data-bs-toggle="modal" data-bs-target="#editstokmodal'.$baris->id_produk.'" title="kelola stok">
                   <i class="bi bi-cart-plus-fill"></i></a>
                   <a href="'.site_url('list-produk').'"  data-bs-toggle="modal" data-bs-target="#editprodukmodal'.$baris->id_produk.'" title="edit">
                   <i class="bi bi-pencil-square"></i></a>
                   <a href="javascript:void(0);" onclick="confirmDelete(\''.site_url('hapus-produk/'.$baris->id_produk).'\')" title="hapus"><i class="bi bi-trash-fill"></i></a>
                   </td>';
                   $html .='</tr>';
                    endforeach;
                    echo $html;
                    endif;
                   ?> 
                 </table>
                </div>
                <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Form Tambah Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Kode Produk</label>
              <input type="text" class="form-control" name="txtkodeproduk" placeholder="Silahkan masukkan kode produk">
            </div>
            </div>
          <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Nama Produk</label>
              <input type="text" class="form-control" name="txtnamaproduk" placeholder="Silahkan masukkan nama produk">
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Satuan Produk</label>
              <select class="form-control" name="id_satuan">
                    <option value="">Pilih Satuan</option>
                    <?php
            if (isset($listSatuan)) {
              foreach ($listSatuan as $satuan) {
                echo '<option value="' . $satuan->id_satuan . '">' . $satuan->nama_satuan . '</option>';
              }
            }
            ?>
                </select>
            
            </div>
            </div>
          <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Kategori Produk</label>
              <select class="form-control" name="id_kategori">
                    <option value="">Pilih Kategori</option>
                    <?php
            if (isset($listKategori)) {
              foreach ($listKategori as $kategori) {
                echo '<option value="' . $kategori->id_kategori . '">' . $kategori->nama_kategori . '</option>';
              }
            }
            ?>
                  
                </select>
            </div>
            </div>  
              </div>
              <div class="row">
            <div class="col-lg-4">
            <div class="mb-3">
              <label class="form-label">Harga Beli</label>
              <input type="text" class="form-control" name="txthargabeli" id="moneyInput"  placeholder="Masukkan harga beli">
            </div>
            </div>
          <div class="col-lg-4">
            <div class="mb-3">
              <label class="form-label">Harga Jual</label>
              <input type="text" class="form-control" name="txthargajual" id="moneyInput2"  placeholder="Masukkan harga jual">
            </div>
            </div>  
            <div class="col-lg-4">
            <div class="mb-3">
              <label class="form-label">Stok</label>
              <input type="text" class="form-control" name="txtstok" placeholder="Silahkan masukkan stok">
            </div>
            </div>
              </div>
        
              </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <button class="btn btn-primary ms-auto" type="submit">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <?php
                  if(isset($DataProduk)) :
                  foreach($DataProduk as $baris) :
    ?>
      <div class="modal modal-blur fade" id="editprodukmodal<?=$baris->id_produk?>" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Form Update Produk</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="edit-produk" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Kode Produk</label>
              <input type="hidden" class="form-control" name="id_produk" value="<?=$baris->id_produk?>"/>
              <input type="text" class="form-control" name="txtkodeproduk" placeholder="Silahkan masukkan kode produk" value="<?=$baris->kode_produk?>">
            </div>
            </div>
          <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Nama Produk</label>
              <input type="text" class="form-control" name="txtnamaproduk" placeholder="Silahkan masukkan nama produk" value="<?=$baris->nama_produk?>">
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Satuan Produk</label>
              <select class="form-control" name="id_satuan">
              <?php
            if (isset($listSatuan)) {
                foreach ($listSatuan as $satuan) {
                    $selected = ($satuan->id_satuan == $baris->id_satuan) ? 'selected' : '';
                    echo '<option value="' . $satuan->id_satuan . '" ' . $selected . '>' . $satuan->nama_satuan . '</option>';
                }
            }
            ?>
                </select>
            
            </div>
            </div>
          <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Kategori Produk</label>
              <select class="form-control" name="id_kategori">
              <?php
            if (isset($listKategori)) {
                foreach ($listKategori as $kategori) {
                    $selected = ($kategori->id_kategori == $baris->id_kategori) ? 'selected' : '';
                    echo '<option value="' . $kategori->id_kategori . '" ' . $selected . '>' . $kategori->nama_kategori . '</option>';
                }
            }
            ?>
                </select>
            </div>
            </div>  
              </div>
           
        
              </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <button class="btn btn-primary ms-auto" type="submit">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <?php
      endforeach;
    endif;
    ?>
        <?php
                  if(isset($listProduk)) :
                  foreach($listProduk as $baris) :
    ?>
       <div class="modal modal-blur fade" id="editstokmodal<?=$baris->id_produk?>" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Form Update Stok</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="update-stok" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Kode Produk</label>
              <input type="hidden" class="form-control" name="id_produk" value="<?=$baris->id_produk    ?>"/>
              <input type="text" class="form-control" name="txtkodeproduk" placeholder="Silahkan masukkan kode produk" value="<?=$baris->kode_produk?>" readonly>
            </div>
            </div>
          <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Nama Produk</label>
              <input type="text" class="form-control" name="txtnamaproduk" value="<?=$baris->nama_produk?>" placeholder="Silahkan masukkan nama produk" readonly>
            </div>
            </div>
            </div>
              <div class="row">
            <div class="col-lg-4">
            <div class="mb-3">
              <label class="form-label">Harga Beli</label>
              <input type="text" class="form-control" name="txthargabeli" id="moneyInput3" placeholder="Masukkan harga beli" value="<?=$baris->harga_beli?>">
            </div>
            </div>
          <div class="col-lg-4">
            <div class="mb-3">
              <label class="form-label">Harga Jual</label>
              <input type="text" class="form-control" name="txthargajual" id="moneyInput4" placeholder="Masukkan harga jual" value="<?=$baris->harga_jual?>">
            </div>
            </div>  
            <div class="col-lg-4">
            <div class="mb-3">
              <label class="form-label">Stok</label>
              <input type="text" class="form-control" name="txtstok" placeholder="Masukkan stok" value="<?=$baris->stok?>">
            </div>
            </div>
              </div>
        
              </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <button class="btn btn-primary ms-auto" type="submit">Simpan</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    <?php
      endforeach;
    endif;
    ?>
        <?= $this->endSection();?>