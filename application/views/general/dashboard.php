<?php
// Initialize total_jumlah_bayar
$total_jumlah_bayar = 0;
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
      <small>Control panel</small>
    </h1>
  </section>

  <section class="content">

    <!-- Peringatan Jatuh Tempo -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Peringatan Jatuh Tempo</b></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <table style="width:100%; table-layout:fixed" class="table table-striped">
              <thead>
                <tr>
                  <td style="width:50px;">
                    <b>No</b>
                  </td>
                  <td>
                    <b>Peringatan</b>
                  </td>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($daftar_peringatan as $item): ?>
                  <tr>
                    <td><?php echo $item['nomor']; ?></td>
                    <td><?php echo $item['peringatan']; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

    <!-- Peringatan Property Kosong -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Peringatan Property Kosong</b></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <table style="width:100%; table-layout:fixed" class="table table-striped">
              <thead>
                <tr>
                  <td style="width:50px;">
                    <b>No</b>
                  </td>
                  <td>
                    <b>Property Kosong</b>
                  </td>
                  <td class="text-center">
                    <b>Iklan</b>
                  </td>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($daftar_property_kosong as $item): ?>
                  <tr>
                    <td><?php echo $item['nomor']; ?></td>
                    <td><?php echo $item['property_kosong']; ?></td>
                    <td class="text-center">
                      <a href="https://mamikos.com/" title="MamiKos" target="_blank">
                        <img src="https://mamikos.com/assets/logo/svg/logo_mamikos_green_v2.svg" alt="MamiKos Logo"
                          style="width: 100px; height: auto;">
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Laporan Keuangan Bulan ini -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Laporan Keuangan Bulan Ini</b></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <table style="width:100%; table-layout:fixed" class="table table-striped">
              <thead>
                <tr>
                  <td style="width:50px;">
                    <b>No</b>
                  </td>
                  <td>
                    <b>Nama Penghuni</b>
                  </td>
                  <td>
                    <b>Tanggal Bayar</b>
                  </td>
                  <td>
                    <b>Jumlah Bayar</b>
                  </td>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($daftar_keuangan_bulan_ini as $item): ?>
                  <tr>
                    <td><?php echo $item['nomor']; ?></td>
                    <td><b><?php echo $item['customer_name']; ?></b></td>
                    <td><?php echo $item['tanggal_bayar']; ?></td>
                    <td><?php echo 'Rp ' . number_format($item['jumlah_bayar'], 0, ',', '.'); ?></td>
                  </tr>
                  <?php
                  // Add each jumlah_bayar to the total
                  $total_jumlah_bayar += $item['jumlah_bayar'];
                  ?>
                <?php endforeach; ?>
              </tbody>

              <tfoot>
                <tr>
                  <td colspan="3" style="text-align:right;"><b>Total:</b></td>
                  <td><b><?php echo 'Rp ' . number_format($total_jumlah_bayar, 0, ',', '.'); ?></b></td>
                </tr>
              </tfoot>

            </table>
          </div>
        </div>
      </div>
    </div>

  </section>


</div>