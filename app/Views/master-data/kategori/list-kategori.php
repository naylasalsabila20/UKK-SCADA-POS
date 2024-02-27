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
if (session()->has('error')) {
  // Panggil fungsi helper untuk menampilkan SweetAlert
  echo flash_swal('error', 'Peringatan!', session('error'));
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
                Master Data Kategori
                </h2>
              </div>
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="<?=site_url('list-kategori');?>" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Tambah
                  </a>
                  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                  </a>
                </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          <div class="container px-4">
                <div class="card">
                <div class="p-3">
                <?php if (session()->has('errors') && session('errors.nama_kategori')): ?>
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= esc(session('errors.nama_kategori')) ?>
                  <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close" style="float:right;">
                  </button>
                  </div>
            <?php endif; ?>
                <table id="myTable" class="table table-sm table-striped table-bordered text-center">
                <thead>
                 <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
                </tr>
                </thead>
                <?php
                  if(isset($listKategori)) :
                  $html =null;
                  $no = 0;
                  foreach($listKategori as $baris) :
                  $no++;
                   $html .='<tr>';
                   $html .='<td>'. $no.'</td>';
                   $html .='<td>'. $baris->nama_kategori.'</td>';
                   $html .='<td>
                   <a href="'.site_url('list-kategori').'"  data-bs-toggle="modal" data-bs-target="#editmodal'.$baris->id_kategori.'" title="edit">
                   <i class="bi bi-pencil-square"></i></a>
                   <a href="javascript:void(0);" onclick="confirmDelete(\''.site_url('hapus-kategori/'.$baris->id_kategori).'\')" title="hapus"><i class="bi bi-trash-fill"></i></a>
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
            <h5 class="modal-title">Form Tambah Kategori</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Nama Kategori</label>
              <input type="hidden" class="form-control" name="id_kategori" value="<?=isset($detailKategori[0]->id_kategori) ? $detailKategori[0]->id_kategori : null;?>"/>
              <input type="text" class="form-control" name="txtnamakategori" placeholder="Silahkan masukkan nama kategori produk">
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
if(isset($listKategori)) :
    foreach($listKategori as $baris) :  
?>
        <div class="modal modal-blur fade" id="editmodal<?= $baris->id_kategori ?>" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Update Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="<?= base_url('edit-kategori') ?>" class="needs-validation" novalidate>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Kategori</label>
                                <input type="hidden" class="form-control" name="id_kategori" value="<?= $baris->id_kategori ?>"/>
                                <input type="text" class="form-control" name="txtnamakategori" value="<?= $baris->nama_kategori ?>" placeholder="Silahkan masukkan nama kategori produk" >
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