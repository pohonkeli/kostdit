<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <i class="fa fa-user-circle-o" aria-hidden="true"></i> Daftar Property
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12 text-right">
                <div class="form-group">
                    <a class="btn btn-primary" href="<?php echo base_url(); ?>roles/add"><i class="fa fa-plus"></i> Add
                        New Role</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php
                $this->load->helper('form');
                $error = $this->session->flashdata('error');
                if ($error) {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>
                <?php
                $success = $this->session->flashdata('success');
                if ($success) {
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-12">
                        <?php echo validation_errors('<div class="alert alert-danger alert-dismissable">', ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <?php foreach ($propertyRecords as $category) { ?>
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title"><?php echo $category['CategoryCode'] . ' - ' . $category['Keterangan']; ?>
                            </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->

                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Type</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                </tr>
                                <?php foreach ($category['Properties'] as $property) { ?>
                                    <tr <?php echo ($property['StatusName'] == 'KOSONG') ? 'class="success"' : (($property['StatusName'] == 'PENUH') ? 'class="danger"' : ''); ?>>
                                        <td><?php echo $property['PropertyCode']; ?></td> <!-- Kode Property -->
                                        <td><?php echo $property['PropertyName']; ?></td> <!-- Nama Property -->
                                        <td><?php echo $property['TypeName']; ?></td> <!-- Type Property -->
                                        <td><?php echo $property['Keterangan']; ?></td> <!-- Keterangan -->
                                        <td><?php echo $property['StatusName']; ?></td> <!-- Status Property -->
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div><!-- /.box -->
                </div>
            <?php } ?>
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
            jQuery("#searchList").attr("action", baseURL + "roleListing/" + value);
            jQuery("#searchList").submit();
        });
    });
</script>