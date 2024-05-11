<!-- Content Wrapper -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Auto Create Rental
            <small>Auto Create Rental by Period</small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6"> <!-- Tengahkan form di tengah kolom -->
                <div class="box box-primary">
                    <div class="box-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="periode" class="col-sm-3 control-label">Periode</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="periode" name="periode">
                                        <!-- Dropdown options will be filled dynamically -->
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9"> <!-- Geser tombol ke kanan -->
                                    <button type="button" class="btn btn-primary" id="btnCreate">Create</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<script>
    $(document).ready(function () {
        // Get periods from controller using AJAX
        $.ajax({
            type: 'GET',
            url: '<?php echo base_url('automations/getPeriode'); ?>',
            success: function (response) {
                // Parse JSON response to array
                var periodes = JSON.parse(response);

                // Populate dropdown options
                $.each(periodes, function (index, value) {
                    $('#periode').append('<option value="' + value + '">' + value + '</option>');
                });
            }
        });


        //Button click event to create rental
        $('#btnCreate').click(function () {
            var cobaPeriode = $('#periode').val();

            // Konfirmasi pesan sebelum mengirim data
            var confirmation = confirm("Apakah Anda yakin ingin membuat data untuk periode '" + cobaPeriode + "'?");

            // Jika pengguna mengonfirmasi, kirim data ke controller menggunakan AJAX
            if (confirmation) {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url("automations/CreateRentalByPeriode"); ?>',
                    data: {
                        "periode": cobaPeriode // Kirim periode sebagai data
                    },
                    success: function (response) {
                        alert('Data berhasil di generate');
                    }
                });
            }
        });



    });
</script>