<?= $this->extend('template.php');?>
<?= $this->section('konten');?>
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
                Laporan Penjualan
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-auto ms-auto d-print-none">
              </div>
            </div>
          </div>
        </div>
</div>
<div class="page-body">
<div class="container-xl">
                        <div class="col-12">
                <div class="row row-cards">
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg>
                            </span>
                          </div>
                          <div class="col">
                          <?php
                          if(isset($DailySell)) :
                          foreach($DailySell as $baris) :  
                          ?>
                            <div class="font-weight-medium">
                           <b> Rp. <?= number_format($baris->total_harian) ?></b>
                            </div>
                            <?php
                        endforeach;
                        endif;
                        ?>
                            <div class="text-muted">
                              Total Penjualan Hari ini
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-green text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/shopping-cart -->
                            <i class="bi bi-cash-coin"></i>
                          </span>
                          </div>
                          <div class="col">
                          <?php
                          if(isset($laba)) :
                          foreach($laba as $baris) :  
                          ?>
                            <div class="font-weight-medium">
                            <b>Rp. <?= number_format($baris->total_keuntungan)?></b>
                            </div>
                            <?php
                        endforeach;
                        endif;
                        ?>
                            <div class="text-muted">
                              Total Keuntungan Hari ini
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                        <div class="col-auto">
<div class="text-white avatar" style="background-color: red; display: inline-block; padding: 10px;">
                        <i class="bi bi-graph-down-arrow"></i>
                      </div>
                      </div>
                          <div class="col">
                          <?php
                          if(isset($stokLow)) :
                          foreach($stokLow as $baris) :  
                          ?>
                            <div class="font-weight-medium">
                            <b>Rp. <?= $baris->total_low_stock ?></b>
                            </div>
                            <div class="text-muted">
                              Total kerugian bulan ini
                            </div>
                            <?php
                        endforeach;
                        endif;
                        ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6 col-lg-3">
                    <div class="card card-sm">
                      <div class="card-body">
                        <div class="row align-items-center">
                          <div class="col-auto">
                            <span class="bg-facebook text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                            <i class="bi bi-cash-coin"></i>
                          </span>
                          </div>
                          <?php
                          if(isset($laba)) :
                          foreach($laba as $baris) :  
                          ?>
                          <div class="col">
                            <div class="font-weight-medium">
                            <b>Rp. <?= number_format($baris->total_keuntungan)?></b>
                            </div>
                            <div class="text-muted">
                              Total Keuntungan Hari ini
                            </div>
                            <?php
                        endforeach;
                        endif;
                        ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="p-2"></div>
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Detail Penjualan Hari Ini</h3>
                  </div>
                  <div class="card-body border-bottom py-3">
                  
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
          
                  </div>
                </div>
              </div>
            </div>
          </div>
         </div>
          <?= $this->endSection();?>