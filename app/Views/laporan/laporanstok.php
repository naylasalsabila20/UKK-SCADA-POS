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
    <h3 class="text-center">LAPORAN STOK BARANG</h3>
<div class="row">
    <div class="col">
        Toko : SCADAMART
    </div>
    <div class="col-3 text-left">
        Tanggal : <?php  echo  date("F Y"); ?>

    </div>
    
</div>
<div class="p-2"></div>
<table  class="table table-sm table-striped table-bordered text-center">
                <thead>
                 <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Kategori</th>
                <th>Harga Jual</th>
                <th>Harga Beli</th>
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
                 <script type="text/javascript">
        window.print();
    </script>
</body>
</html>