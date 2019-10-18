<!-- Page -->
<div class="page">

    <div class="page-content container-fluid">
        <!-- Panel Tabs -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Add Inventor Non Pegawai</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-xl-6">
                        <form method="post" action="<?= base_url('paten/save_inventor');  ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <?= $this->session->flashdata('message'); ?>
                            NIK
                            <input type="text" class="form-control" name="nik" id="nik" placeholder="NIK">
                            <small class="form-text text-danger"><?= form_error('nik'); ?></small>
                            Nama Inventor
                            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Inventor">
                            <small class="form-text text-danger"><?= form_error('nama'); ?></small>

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