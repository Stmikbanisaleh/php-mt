<!-- Page -->
<div class="page">

    <div class="page-content container-fluid">
        <!-- Panel Tabs -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Pegawai</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-xl-6">
                        <form method="post" action="<?= base_url('pegawai/update_pegawai');  ?>">
                            <?= $this->session->flashdata('message'); ?>
                            <input type="hidden" name="id" value="<?= $peg['ID'] ?>">
                            KODE KEPEGAWAIAN
                            <input type="text" class="form-control" name="kode_kepegawaian" id="kode_kepegawaian" value="<?= $peg['KODE_KEPEGAWAIAN'] ?>">
                            <small class="form-text text-danger"><?= form_error('kode_kepegawaian'); ?></small>
                            NIK
                            <input type="text" class="form-control" name="nik" id="nik" value="<?= $peg['NIK'] ?>">
                            <small class="form-text text-danger"><?= form_error('nik'); ?></small>
                            Nama
                            <input type="text" class="form-control" name="nama" id="nama" value="<?= $peg['NAMA'] ?>">
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