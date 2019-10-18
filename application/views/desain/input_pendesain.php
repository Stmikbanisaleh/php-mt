<!-- Page -->
<div class="page">

    <div class="page-content container-fluid">
        <!-- Panel Tabs -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Add Pendesain Non Pegawai</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-xl-6">
                        <form method="post" action="<?= base_url('desain/save_pendesain');  ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <?= $this->session->flashdata('message'); ?>
                            NIK
                            <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK">
                            Nama Pendesain
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Pendesain">

                            <div class="text-right my-20">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Panel Tabs -->

    </div>
</div>