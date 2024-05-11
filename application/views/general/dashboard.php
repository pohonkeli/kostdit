<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard
      <small>Control panel</small>
    </h1>
  </section>

  <section class="content">
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
                    No
                  </td>
                  <td>
                    Peringatan
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
                    No
                  </td>
                  <td>
                    Property Kosong
                  </td>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($daftar_property_kosong as $item): ?>
                  <tr>
                    <td><?php echo $item['nomor']; ?></td>
                    <td><?php echo $item['property_kosong']; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </section>


</div>