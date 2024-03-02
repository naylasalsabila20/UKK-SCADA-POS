<!doctype html>
<html lang="en">
  <head>
    <title>SCADA POS</title>
    <link rel="icon" type="image/x-icon" href="/dist/img/favicon.ico" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
	<link href="<?=base_url('dist/select2/css/select2.min.css');?>" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<!-- jQuery -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<!-- Bootstrap JS -->
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<!-- CSS files -->
    <link href="<?=base_url('dist/css/tabler.min.css?1684106062');?>" rel="stylesheet"/>
    <link href="<?=base_url('dist/css/tabler-flags.min.css?1684106062');?>" rel="stylesheet"/>
    <link href="<?=base_url('dist/css/tabler-payments.min.css?1684106062');?>" rel="stylesheet"/>
    <link href="<?=base_url('dist/css/tabler-vendors.min.css?1684106062');?>" rel="stylesheet"/>
    <link href="<?=base_url('dist/css/demo.min.css?1684106062');?>" rel="stylesheet"/>
   	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
    <script src="https://kit.fontawesome.com/e6c5675fff.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h3 class="text-center">LAPORAN PENJUALAN HARI INI</h3>
<div class="row">
    <div class="col">
        Toko : SCADAMART
    </div>
    <div class="col-3 text-left">
        Tanggal :                             <?php
// Array nama-nama hari dalam bahasa Indonesia
$nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");

// Array nama-nama bulan dalam bahasa Indonesia
$nama_bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

// Mendapatkan tanggal hari ini
$tanggal_hari_ini = date("Y-m-d");

// Mendapatkan nama hari berdasarkan tanggal hari ini
$nama_hari_ini = date("w", strtotime($tanggal_hari_ini));

// Mendapatkan nama bulan berdasarkan tanggal hari ini
$bulan_hari_ini = date("n", strtotime($tanggal_hari_ini)) - 1;

// Mendapatkan tahun berdasarkan tanggal hari ini
$tahun_hari_ini = date("Y", strtotime($tanggal_hari_ini));

// Mencetak tanggal hari ini dengan nama hari dan bulan dalam bahasa Indonesia
echo $nama_hari[$nama_hari_ini] . " " . date("d", strtotime($tanggal_hari_ini)) . " " . $nama_bulan[$bulan_hari_ini] . " " . $tahun_hari_ini;
?>

    </div>
</div>
<div class="row">
    <div class="col"><b>Total Keuntungan :   <?php
                          if(isset($laba)) :
                          foreach($laba as $baris) :  
                          ?>
                            <b>Rp. <?= number_format($baris->total_keuntungan)?></b>
                            <?php
                        endforeach;
                        endif;
                        ?></b>
                        </div>
                        <div class="col-3 text-left">
                            <b>Total Penjualan :
                        <?php
                          if(isset($DailySell)) :
                          foreach($DailySell as $baris) :  
                          ?>
                           <b> Rp. <?= number_format($baris->total_harian) ?></b>
                            <?php
                        endforeach;
                        endif;
                        ?></b>
                    </div>
</div>
<div class="p-2"></div>
<table id="myTable" class="table table-sm table-striped table-bordered text-center">
                <thead>
                 <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                </tr>
                </thead>
                <?php
                  if(isset($listDetailPenjualan)) :
                  $html =null;
                  $no = 0;
                  foreach($listDetailPenjualan as $baris) :
                  $no++;
                   $html .='<tr>';
                   $html .='<td>'. $no.'</td>';
                   $html .='<td>'. $baris->no_transaksi.'</td>';
                   $html .='<td>'. $baris->nama_produk.'</td>';
                   $html .='<td>'. $baris->qty.'</td>';
                   $html .='<td>'.number_format($baris->total_harga,0,',','.').'</td>';
                   $html .='</tr>';
                    endforeach;
                    echo $html;
                    endif;
                   ?> 
                 </table>
                 <script type="text/javascript">
        window.print();
    </script>
</body>
</html>