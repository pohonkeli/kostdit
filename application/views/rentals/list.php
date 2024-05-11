<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-users"></i> Transaksi Rental
            <small>Edit</small>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <!-- <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>customers/addNew"><i
                            class="fa fa-plus"></i> Add
                        New</a>
                </div> -->
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Rental List</h3>
                        <div class="box-tools">
                            <form action="<?php echo base_url() ?>rentals/rentalListing" method="POST" id="searchList">
                                <div class="input-group">
                                    <input type="text" name="searchText" value="<?php echo $searchText; ?>"
                                        class="form-control input-sm pull-right" style="width: 150px;"
                                        placeholder="Search" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-default searchList"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Rental Code</th>
                                <th>Periode</th>
                                <th>Tanggal Awal</th>
                                <th>Tanggal Habis</th>
                                <th>Penghuni</th>
                                <th>Lokasi</th>
                                <th>Nama Property</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                            <?php
                            if (!empty($rentalRecords)) {
                                foreach ($rentalRecords as $record) {
                                    // Tentukan kelas CSS berdasarkan status_rental
                                    $rowClass = ($record->status_rental == 'LUNAS') ? 'success' : 'danger';
                                    ?>
                                    <tr class="<?php echo $rowClass; ?>">
                                        <td><?php echo $record->rental_code ?></td>
                                        <td><?php echo $record->periode ?></td>
                                        <td><?php echo date('d F Y', strtotime($record->tanggal_awal_rental)); ?></td>
                                        <td><?php echo date('d F Y', strtotime($record->tanggal_akhir_rental)); ?></td>
                                        <td><?php echo $record->customer_name ?></td>
                                        <td><?php echo $record->keterangan ?></td>
                                        <td><?php echo $record->property_name ?></td>
                                        <td><?php echo $record->type_name ?></td>
                                        <td><?php echo $record->status_rental ?></td>
                                        <td class="text-center">
                                            <a class="btn btn-sm btn-info"
                                                href="<?php echo base_url() . 'rentals/edit/' . $record->rental_code; ?>"
                                                title="Edit"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </table>

                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
</div>



<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/common.js" charset="utf-8"></script>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('ul.pagination li a').click(function (e) {
            e.preventDefault();
            var link = jQuery(this).get(0).href;
            var value = link.substring(link.lastIndexOf('/') + 1);
            jQuery("#searchList").attr("action", baseURL + "rentalListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>