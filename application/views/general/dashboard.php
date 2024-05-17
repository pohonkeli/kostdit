<?php
// Initialize total_jumlah_bayar
$total_jumlah_bayar = 0;
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Include jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <!-- Include Chart.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>

</head>

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


    <!-- Laporan Grafik Pemasukan Per Periode -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Laporan Keuangan Tahun <?php echo date("Y"); ?></b></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="chart-responsive">
              <canvas id="barChart" style="height: 300px;"></canvas>
            </div>

            <?php
            // Assuming $daftar_keuangan_per_periode contains the aggregated data
            $chart_labels = [];
            $chart_data = [];

            foreach ($daftar_keuangan_per_periode as $row) {
              $chart_labels[] = $row['bulan'] . ' ' . $row['tahun'];
              // Remove commas from total_pemasukan and cast it to integer
              $total_pemasukan = (int) str_replace(',', '', $row['total_pemasukan']);
              $chart_data[] = $total_pemasukan;
            }
            ?>
          </div>

        </div>
      </div>
    </div>

    <!-- Laporan Pemasukan Bulan Ini -->
    <div class="row">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Laporan Keuangan Bulan <?php echo date("M"); ?></b></h3>
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



<script>
  $(document).ready(function () {
    'use strict';

    var ticksStyle = {
      fontColor: '#495057',
      fontStyle: 'bold'
    };

    var mode = 'index';
    var intersect = true;

    var barData = {
      labels: <?php echo json_encode($chart_labels); ?>,
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: <?php echo json_encode($chart_data); ?>
        }
      ]
    };

    var barOptions = {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            }
          }, ticksStyle)
        }]
      }
    };

    var barChartCanvas = $('#barChart').get(0).getContext('2d');
    var barChartData = $.extend(true, {}, barData);
    var temp0 = barData.datasets[0];
    barChartData.datasets[0] = temp0;

    var barChartOptions = $.extend(true, {}, barOptions);
    barChartOptions.datasetFill = false;

    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    });
  });
</script>