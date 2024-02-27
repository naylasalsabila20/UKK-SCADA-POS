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
                Master Data Pengguna
                </h2>
              </div>
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="<?=site_url('list-pengguna');?>" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
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
        </div>
        <div class="page-body">
          <div class="container px-4">
                <div class="card">
                <div class="p-3">
                <?php if (session()->getFlashData('passerror')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= esc(session('passerror')) ?>
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close" style="float:right;"></button>
    </div>
<?php endif; ?>     
                
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
                <th>Nama</th>
                <th>Email</th>
                <th>Level</th>
                <th>Aksi</th>
                </tr>
                </thead>
                <?php
                  if(isset($listPengguna)) :
                  $html =null;
                  $no = 0;
                  foreach($listPengguna as $baris) :
                  $no++;
                   $html .='<tr>';
                   $html .='<td>'. $no.'</td>';
                   $html .='<td>'. $baris->nama.'</td>';
                   $html .='<td>'. $baris->email.'</td>';
                   $html .='<td>'. $baris->level.'</td>';
                   $html .='<td>
                   <a href="'.site_url('list-pengguna').'"  data-bs-toggle="modal" data-bs-target="#editmodal'.$baris->email.'" title="edit">
                   <i class="bi bi-pencil-square"></i></a>
                   <a href="'.site_url('list-pengguna').'"  data-bs-toggle="modal" data-bs-target="#editpassmodal'.$baris->email.'" title="edit password">
                   <i class="bi bi-shield-lock-fill"></i></a>
                   <a href="javascript:void(0);" onclick="confirmDelete(\''.site_url('hapus-pengguna/'.$baris->email).'\')" title="hapus"><i class="bi bi-trash-fill"></i></a>
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
            <h5 class="modal-title">Form Tambah Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="txtnama" placeholder="Silahkan masukkan nama">
            </div>
            </div>
          <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="txtemail" placeholder="Silahkan masukkan email">
            </div>
            </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Password</label>
             <input type="password" class="form-control" name="txtpassword" placeholder="Silahkan masukkan password">
            </div>
            </div>
            <div class="col-lg-6">
            <div class="mb-3">
                            <div class="form-label">Level</div>
                            <div>
                              <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="admin" name="txtlevel">
                                <span class="form-check-label">admin</span>
                              </label>
                              <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="kasir" name="txtlevel">
                                <span class="form-check-label">kasir</span>
                              </label>
                            </div>
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
                  if(isset($listPengguna)) :
                  foreach($listPengguna as $baris) :
    ?>
<div class="modal modal-blur fade" id="editmodal<?=$baris->email?>" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Form Update Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="edit-pengguna" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="txtemail" placeholder="Silahkan masukkan email" value="<?=$baris->email?>" readonly>
            </div>
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="txtnama" placeholder="Silahkan masukkan nama" value="<?=$baris->nama?>">
            </div>
            <div class="mb-3">
                            <div class="form-label">Level</div>
                            <div>
                              <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="admin" <?=$baris->level== 'admin' ? 'checked' : ''?> name="txtlevel">
                                <span class="form-check-label">admin</span>
                              </label>
                              <label class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" value="kasir" <?=$baris->level== 'kasir' ? 'checked' : '' ?> name="txtlevel">
                                <span class="form-check-label">kasir</span>
                              </label>
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
                  if(isset($listPengguna)) :
                  foreach($listPengguna as $baris) :
    ?>
<div class="modal modal-blur fade" id="editpassmodal<?=$baris->email?>" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Form Update Password Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" action="edit-password" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="row">
              <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" name="txtemail" placeholder="Silahkan masukkan email" value="<?=$baris->email?>" readonly>
            </div>
            </div>
            <div class="col-lg-6">
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" class="form-control" name="txtnama" placeholder="Silahkan masukkan nama" value="<?=$baris->nama?>" readonly>
            </div>
            </div>
            </div>
            <div class="row">
              <div class="col-lg-6">
            <div class="mb-3">
            <label class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="passwordbaru" width="20"  placeholder="Masukkan password" required/>  
              </div>
              </div>
              <div class="col-lg-6">
              <div class="mb-3">
              <label class="form-label">Repeat Password</label>
                            <input type="password" class="form-control" name="repeat" width="20" placeholder="Masukkan kembali password" required/>       </div>
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