<head>
    <!-- Load jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Load jQuery UI -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Transaksi Rental
            <small>Edit</small>
        </h1>
    </section>
    <!-- Tombol Back -->
    <section class="content-header">
        <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url('rentals/rentalListing'); ?>" class="btn btn-default">
                    <i class="fa fa-chevron-left"></i> Back to Rental List
                </a>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Transaksi Rental</h3>
                    </div>
                    <div class="panel-body">
                        <form action="<?php echo base_url('rentals/edit'); ?>" method="post">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rental_code">Rental Code:</label>
                                        <input type="text" class="form-control" id="rental_code" name="rental_code"
                                            value="<?php echo $rental_header['rental_code']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rental_code">Tanggal Pembuatan Dokumen:</label>
                                        <input type="text" class="form-control" id="rental_code" name="rental_code"
                                            value="<?php echo $rental_header['tanggal_transaksi']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="a">Tanggal Awal Rental:</label>
                                        <input type="text" class="form-control" id="a" name="a"
                                            value="<?php echo $rental_header['tanggal_awal_rental']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="a">Tanggal Akhir Rental:</label>
                                        <input type="text" class="form-control" id="a" name="a"
                                            value="<?php echo $rental_header['tanggal_akhir_rental']; ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="a">Customer Code:</label>
                                        <input type="text" class="form-control" id="a" name="a"
                                            value="<?php echo $rental_header['customer_code']; ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="a">Customer Name:</label>
                                        <input type="text" class="form-control" id="a" name="a"
                                            value="<?php echo $rental_header['customer_name']; ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="a">Property Code:</label>
                                        <input type="text" class="form-control" id="a" name="a"
                                            value="<?php echo $rental_header['property_code']; ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="a">Property Name:</label>
                                        <input type="text" class="form-control" id="a" name="a"
                                            value="<?php echo $rental_header['property_name']; ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="a">Letak:</label>
                                        <input type="text" class="form-control" id="a" name="a"
                                            value="<?php echo $rental_header['keterangan']; ?>" disabled>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="a">Type:</label>
                                        <input type="text" class="form-control" id="a" name="a"
                                            value="<?php echo $rental_header['type_name']; ?>" disabled>
                                    </div>
                                </div>

                            </div>

                            <!-- <div class="row">
                                <div class="col-md-12 text-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>
                                        Save</button>
                                </div>
                            </div> -->
                        </form>
                    </div>
                </div>


                <!--  batas Detail Pembayaran -->

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Transaksi Detail Pembayaran</h3>
                    </div>
                    <div class="panel-body">
                        <div class="box-body table-responsive no-padding">

                            <?php
                            if (
                                $is_admin == 1 ||
                                (array_key_exists('RentalsButtonAddRow', $access_info)
                                    && ($access_info['RentalsButtonAddRow']['list'] == 1 || $access_info['RentalsButtonAddRow']['total_access'] == 1))
                            ) {
                                ?>
                                <div class="text-right mb-10">
                                    <?php if ($rental_header['status_rental'] === 'LUNAS'): ?>
                                        <button type="button" class="btn btn-primary" onclick="addRow()" disabled><i
                                                class="fa fa-plus"></i> Add Row</button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-primary" onclick="addRow()"><i
                                                class="fa fa-plus"></i> Add Row</button>
                                    <?php endif; ?>
                                </div>
                                <?php
                            }
                            ?>

                            <table class="table table-hover" id="paymentTable">
                                <thead>
                                    <tr>
                                        <th>Payment Code</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Jumlah Bayar</th>
                                        <th>Keterangan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rental_payment as $item): ?>
                                        <tr>
                                            <td><?php echo $item['payment_code']; ?></td>
                                            <td><?php echo $item['tanggal_transaksi']; ?></td>
                                            <td><?php echo $item['jumlah_bayar']; ?></td>
                                            <td><?php echo $item['keterangan']; ?></td>
                                            <td>
                                                <?php if (isset($item['additional_row']) && $item['additional_row'] === true): ?>
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="deleteRow(this)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div><!-- /.box-body -->
                    </div>

                    <?php
                    if (
                        $is_admin == 1 ||
                        (array_key_exists('RentalsButtonSave', $access_info)
                            && ($access_info['RentalsButtonSave']['list'] == 1 || $access_info['RentalsButtonSave']['total_access'] == 1))
                    ) {
                        ?>
                        <div class="panel-footer">
                            <button type="button" class="btn btn-success" id="btnSave"><i class="fa fa-save"></i> Save
                                Data</button>
                        </div>
                        <?php
                    }
                    ?>
                </div>




                <!-- batas Total Rincian -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Rincian Total</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 col-md-offset-6">
                                <div class="row">
                                    <div class="col-md-6 text-right">
                                        <label for="rental_code">Total Harga Sewa:</label>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <input type="text" class="form-control" id="total_harga_sewa"
                                            name="total_harga_sewa"
                                            value="<?php echo $rental_header['total_harga_sewa']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 text-right">
                                        <label for="rental_code">Total Sudah Bayar:</label>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <input type="text" class="form-control" id="total_sudah_bayar"
                                            name="total_sudah_bayar"
                                            value="<?php echo $rental_header['total_sudah_bayar']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 text-right">
                                        <label for="rental_code">Total Kurang Bayar:</label>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <input type="text" class="form-control" id="total_kurang_bayar"
                                            name="total_kurang_bayar"
                                            value="<?php echo $rental_header['total_kurang_bayar']; ?>" disabled>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 text-right">
                                        <label for="rental_code">STATUS PEMBAYARAN:</label>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <input type="text" class="form-control" id="status_rental" name="status_rental"
                                            value="<?php echo $rental_header['status_rental']; ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </section>
</div>



<script>
    function addRow() {
        var table = document.getElementById("paymentTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);

        cell1.innerHTML = "<input type='text' class='form-control' name='payment_code[]' disabled value='PAY_XXXXXX'>";
        cell2.innerHTML = "<input type='text' placeholder='Tanggal Bayar' class='form-control datepicker' name='tanggal_transaksi[]'>";
        cell3.innerHTML = "<input type='text' placeholder='Jumlah Bayar' class='form-control' name='jumlah_bayar[]'>";
        cell4.innerHTML = "<input type='text' placeholder='Keterangan' class='form-control' name='keterangan[]'>";
        cell5.innerHTML = "<button type='button' class='btn btn-danger btn-sm' onclick='deleteRow(this)'><i class='fa fa-trash'></i></button>";

        // Initialize datepicker for the new row
        $(".datepicker").datepicker({
            dateFormat: "yy-mm-dd"
        });
    }

    function deleteRow(button) {
        var row = button.closest('tr');
        row.remove();

        calculatePayments();
    }

    function calculatePayments() {
        var totalHargaSewa = parseFloat($('#total_harga_sewa').val());
        var totalSudahBayar = 0;


        // Loop through each row in the payment table and sum up the total payments
        $('#paymentTable tbody tr').each(function () {
            var jumlahBayarOld = parseFloat($(this).find('td:nth-child(3)').text());

            var jumlahBayarNewRow = parseFloat($(this).find('input[name="jumlah_bayar[]"]').val());


            if (!isNaN(jumlahBayarOld)) {
                totalSudahBayar += jumlahBayarOld;
            }

            if (!isNaN(jumlahBayarNewRow)) {
                totalSudahBayar += jumlahBayarNewRow;
            }

        });

        var totalKurangBayar = totalHargaSewa - totalSudahBayar;
        var statusPembayaran = (totalKurangBayar === 0) ? 'LUNAS' : 'BELUM LUNAS';

        // Update the input fields with the calculated values
        $('#total_sudah_bayar').val(totalSudahBayar.toFixed(2));
        $('#total_kurang_bayar').val(totalKurangBayar.toFixed(2));
        $('#status_rental').val(statusPembayaran);
    }

    // Call the function initially and whenever there's a change in payment
    $(document).ready(function () {
        calculatePayments();

        $('#paymentTable').on('change', 'input[name="jumlah_bayar[]"]', function () {
            calculatePayments();
        });

        $('#paymentTable').on('click', '.btn-danger', function () {
            calculatePayments();
        });
    });

    //Button click event to create rental
    $('#btnSave').click(function () {
        // Konfirmasi sebelum menyimpan data
        var confirmSave = confirm("Apakah Anda yakin ingin menyimpan data?");

        // Jika pengguna menekan tombol "OK"
        if (confirmSave) {
            var rental_code = $('#rental_code').val();
            var total_harga_sewa = $('#total_harga_sewa').val();
            var total_sudah_bayar = $('#total_sudah_bayar').val();
            var total_kurang_bayar = $('#total_kurang_bayar').val();
            var status_rental = $('#status_rental').val();

            var details_payment = [];

            // Loop through each row in the table
            $('#paymentTable tbody tr').each(function () {
                var payment_code = $(this).find('input[name="payment_code[]"]').val();
                var tanggal_transaksi = $(this).find('input[name="tanggal_transaksi[]"]').val();
                var jumlah_bayar = $(this).find('input[name="jumlah_bayar[]"]').val();
                var keterangan = $(this).find('input[name="keterangan[]"]').val();

                if (payment_code === undefined) {
                    payment_code = $(this).find('td:nth-child(1)').text();
                }

                if (tanggal_transaksi === undefined) {
                    tanggal_transaksi = $(this).find('td:nth-child(2)').text();
                }

                if (jumlah_bayar === undefined) {
                    jumlah_bayar = $(this).find('td:nth-child(3)').text();
                }

                if (keterangan === undefined) {
                    keterangan = $(this).find('td:nth-child(4)').text();
                }

                // Add data from each row to the details_payment array
                details_payment.push({
                    "payment_code": payment_code,
                    "tanggal_transaksi": tanggal_transaksi,
                    "jumlah_bayar": jumlah_bayar,
                    "keterangan": keterangan
                });
            });

            // Create the data object
            var data = {
                "rental_code": rental_code,
                "total_harga_sewa": total_harga_sewa,
                "total_sudah_bayar": total_sudah_bayar,
                "total_kurang_bayar": total_kurang_bayar,
                "status_rental": status_rental,
                "details_payment": details_payment
            };

            // Kirim data ke controller menggunakan AJAX
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("rentals/PostUpdateRental"); ?>',
                data: data,
                success: function (response) {
                    alert("Data berhasil disimpan");

                    window.location.href = '<?php echo base_url("rentals/rentalListing"); ?>';
                }
            });
        }
    });


</script>