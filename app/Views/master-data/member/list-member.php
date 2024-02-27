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
                Master Data Member
                </h2>
              </div>
              <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                  <a href="<?=site_url('list-member');?>" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
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
                <th>Id Member</th>
                <th>Nama</th>
                <th>Nomor HP </th>
                <th>Alamat</th>
                <th>Poin</th>
                <th>Aksi</th>
                </tr>
                </thead>
                <?php
                  if(isset($listMember)) :
                  $html =null;
                  $no = 0;
                  foreach($listMember as $baris) :
                  $no++;
                   $html .='<tr>';
                   $html .='<td>'. $baris->id_member.'</td>';
                   $html .='<td>'. $baris->nama.'</td>';
                   $html .='<td>'. $baris->no_telp.'</td>';
                   $html .='<td>'. $baris->alamat.'</td>';
                   $html .='<td>'. $baris->poin.'</td>';
                   $html .='<td>
                   <a href="'.site_url('list-member').'"  data-bs-toggle="modal" data-bs-target="#editmodal'.$baris->id_member.'" title="edit">
                   <i class="bi bi-pencil-square"></i></a>
                   <a href="javascript:void(0);" onclick="confirmDelete(\''.site_url('hapus-member/'.$baris->id_member).'\')" title="hapus"><i class="bi bi-trash-fill"></i></a>
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
            <h5 class="modal-title">Form Tambah Member</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="POST" class="needs-validation" novalidate>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="hidden" class="form-control" name="id_member" value="<?=isset($detailMember[0]->id_member) ? $detailMember[0]->id_member : null;?>"/>
              <input type="text" class="form-control" name="txtnama" placeholder="Silahkan masukkan nama">
            </div>
         <div class="mb-3">
      <label class="form-label">Nomor Telepon</label>
      <div class="input-group">
        <div class="input-group-prepend">
        <button class="btn btn-success">+62</button>
        </div>
        <input type="text" class="form-control" name="txtnotelp" placeholder="Silahkan masukkan nomor telepon">
      </div>
    </div>
            <div class="mb-3">
              <label class="form-label">Alamat</label>
             <input type="txt" class="form-control" name="txtalamat" placeholder="Silahkan masukkan alamat">
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
   if(isset($dataMember)) :
        $html =null;
        $no = 0;
      foreach($dataMember as $baris) :
          $no++;
          $html .='<div class="modal modal-blur fade" id="editmodal'.$baris->id_member.'" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Form Update member</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <form method="POST" action="edit-member" class="needs-validation" novalidate>
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label">Nama</label>
                  <input type="hidden" class="form-control" name="id_member" value="'.$baris->id_member.'"/>
                  <input type="text" class="form-control" name="txtnamamember" value="'.$baris->nama.'" placeholder="Silahkan masukkan nama member produk" readonly>
                </div>
                <div class="mb-3">
                <label class="form-label">Nomor Telepon</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                  <button class="btn btn-success">+62</button>
                  </div>
                  <input type="text" class="form-control" name="txtnotelp" value="'.$baris->modified_no_telp.'" placeholder="Silahkan masukkan nomor telepon">
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label">Alamat</label>
               <input type="text" class="form-control" name="txtalamat" value="'.$baris->alamat.'" placeholder="Silahkan masukkan alamat">
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
        </div>';
      endforeach;
      echo $html;
    endif;
    ?>
<?= $this->endSection();?>