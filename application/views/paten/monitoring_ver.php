<!-- Page -->
<div class="page">

    <div class="page-content container-fluid">
        <!-- Panel Tabs -->
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Manajemen Verifikator Paten</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-xl">
                        <!-- Example Tabs Line Top -->
                        <div class="example-wrap">
                            <div class="nav-tabs-horizontal" data-plugin="tabs">
                                <ul class="nav nav-tabs nav-tabs-line tabs-line-top" role="tablist">
                                    <li class="nav-item " role="presentation"><a class="nav-link active" data-toggle="tab" href="#TabsDiusulkan" aria-controls="TabsDiusulkan" role="tab">DIUSULKAN</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDisetujui" aria-controls="TabsDisetujui" role="tab">DISETUJUI</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDitolak" aria-controls="TabsDitolak" role="tab">DITOLAK</a></li>
                                    <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDitangguhkan" aria-controls="TabsDitangguhkan" role="tab">DITARIK KEMBALI</a></li>
                                </ul>
                                <div class="tab-content pt-20">
                                    <div class="tab-pane active" id="TabsDiusulkan" role="tabpanel">
                                        <!-- Diajukan Table -->
                                        <div class="panel">

                                            <div class="text-right my-5">
                                                <a href="<?= base_url('paten/export') ?>" class="btn btn-sm btn-success my-5 text-right"><i class="fa fa-file-excel-o"></i> Export</a>
                                            </div>

                                            <div class="table-responsive">
                                                <table id="mytable" class="table dataTable table-bordered table-striped w-full" data-plugin="dataTable">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th>No.</th>
                                                            <th>Judul</th>
                                                            <th>Unit Kerja</th>
                                                            <th>Nama Inventor</th>
                                                            <th>Keterangan</th>
                                                            <th>Dokumen</th>
                                                            <th>Filling Date</th>
                                                            <th>Bulan Ke</th>
                                                            <th class="text-nowrap">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($getDiajukan as $p1) : ?>
                                                        <?php
                                                            $waktuinput  = date_create($p1['TGL_INPUT']);
                                                            $waktusekarang = date_create();
                                                            $diff  = date_diff($waktuinput, $waktusekarang);

                                                            if ($diff->m <= 1) {
                                                                $diff->m = 1;
                                                            }
                                                            ?>
                                                        <tr>
                                                            <td><?= $i; ?></td>
                                                            <td><?= $p1['JUDUL']; ?></td>
                                                            <td><?= $p1['NAMA_REV']; ?></td>
                                                            <td>
                                                                <!-- Inventor Pegawai -->
                                                                <?php foreach ($getInventor as $inv) { ?>
                                                                <?php if ($inv['ID_PATEN'] == $p1['ID']) { ?>
                                                                <?= $inv['NAMA']; ?>;<br>
                                                                <?php } ?>
                                                                <?php } ?>

                                                                <!-- Inventor Non Pegawai -->
                                                                <?php foreach ($getInventorNon as $invnon) { ?>
                                                                <?php if ($invnon['ID_PATEN'] == $p1['ID']) { ?>
                                                                <?= $invnon['NAMA']; ?>;<br>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td><?= $p1['KETERANGAN']; ?></td>
                                                            <td></td>
                                                            <td><?= date('d-m-Y', strtotime($p1['TGL_INPUT'])); ?></td>
                                                            <td><?= $diff->m; ?></td>
                                                            <td>
                                                                <?php
                                                                    $role_id = $this->session->userdata('role_id');
                                                                    if ($role_id == 15 || $role_id == 17) {
                                                                        ?>
                                                                <a href="<?= base_url() ?>paten/verifikasi/<?= $p1['ID']; ?>" class="text-info"><i class="fa fa-check-square-o"> Verifikasi</i></a>
                                                                <?php } ?>
                                                            </td>

                                                        </tr>
                                                        <?php $i++; ?>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End Diajukan Table -->
                                    </div>
                                    <div class="tab-pane" id="TabsDisetujui" role="tabpanel">
                                        <!-- Panel Basic -->
                                        <div class="panel">
                                            <div class="table-responsive">
                                                <!-- Disetujui Table -->
                                                <table class="table dataTable table-bordered table-striped w-full" data-plugin="dataTable">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th>No.</th>
                                                            <th>Judul</th>
                                                            <th>Unit Kerja</th>
                                                            <th>Nama Inventor</th>
                                                            <th>Nomor Pendaftaran</th>
                                                            <th>Keterangan</th>
                                                            <th>Tanggal Ajuan</th>
                                                            <th>Bulan Ke</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($getDisetujui as $p2) : ?>
                                                        <?php
                                                            $waktuinput  = date_create($p2['TGL_INPUT']);
                                                            $waktusekarang = date_create();
                                                            $diff  = date_diff($waktuinput, $waktusekarang);

                                                            if ($diff->m <= 1) {
                                                                $diff->m = 1;
                                                            }
                                                            ?>
                                                        <tr>
                                                            <td><?= $i; ?></td>
                                                            <td><?= $p2['JUDUL']; ?></td>
                                                            <td><?= $p2['NAMA_REV']; ?></td>
                                                            <td>
                                                                <!-- Inventor Pegawai -->
                                                                <?php foreach ($getInventor as $inv) { ?>
                                                                <?php if ($inv['ID_PATEN'] == $p2['ID']) { ?>
                                                                <?= $inv['NAMA']; ?>;<br>
                                                                <?php } ?>
                                                                <?php } ?>

                                                                <!-- Inventor Non Pegawai -->
                                                                <?php foreach ($getInventorNon as $invnon) { ?>
                                                                <?php if ($invnon['ID_PATEN'] == $p2['ID']) { ?>
                                                                <?= $invnon['NAMA']; ?>;<br>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td></td>
                                                            <td><?= $p2['KETERANGAN']; ?></td>
                                                            <td><?= date('d-m-Y', strtotime($p2['TGL_INPUT'])) ?></td>
                                                            <td><?= $diff->m; ?></td>
                                                            <td></td>

                                                        </tr>
                                                        <?php $i++; ?>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End Panel Basic -->
                                    </div>
                                    <div class="tab-pane" id="TabsDitolak" role="tabpanel">
                                        <div class="panel">
                                            <div class="table-responsive">
                                                <!-- Ditolak Table -->
                                                <table class="table dataTable table-bordered table-striped w-full" data-plugin="dataTable">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th>No.</th>
                                                            <th>Judul</th>
                                                            <th>Unit Kerja</th>
                                                            <th>Nama Inventor</th>
                                                            <th>Keterangan</th>
                                                            <th>Tanggal Ajuan</th>
                                                            <th>Bulan Ke</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($getDitolak as $p3) : ?>
                                                        <?php
                                                            $waktuinput  = date_create($p3['TGL_INPUT']);
                                                            $waktusekarang = date_create();
                                                            $diff  = date_diff($waktuinput, $waktusekarang);

                                                            if ($diff->m <= 1) {
                                                                $diff->m = 1;
                                                            }
                                                            ?>
                                                        <tr>
                                                            <td><?= $i; ?></td>
                                                            <td><?= $p3['JUDUL']; ?></td>
                                                            <td><?= $p3['NAMA_REV']; ?></td>
                                                            <td>
                                                                <!-- Inventor Pegawai -->
                                                                <?php foreach ($getInventor as $inv) { ?>
                                                                <?php if ($inv['ID_PATEN'] == $p3['ID']) { ?>
                                                                <?= $inv['NAMA']; ?>;<br>
                                                                <?php } ?>
                                                                <?php } ?>

                                                                <!-- Inventor Non Pegawai -->
                                                                <?php foreach ($getInventorNon as $invnon) { ?>
                                                                <?php if ($invnon['ID_PATEN'] == $p3['ID']) { ?>
                                                                <?= $invnon['NAMA']; ?>;<br>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td></td>
                                                            <td><?= $p3['KETERANGAN']; ?></td>
                                                            <td><?= date('d-m-Y', strtotime($p3['TGL_INPUT'])) ?></td>
                                                            <td><?= $diff->m; ?></td>
                                                            <td></td>

                                                        </tr>
                                                        <?php $i++; ?>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="TabsDitangguhkan" role="tabpanel">
                                        <div class="panel">
                                            <div class="table-responsive">
                                                <!-- Ditangguhkan Table -->
                                                <table class="table dataTable table-bordered table-striped w-full" data-plugin="dataTable">
                                                    <thead>
                                                        <tr class="table-info">
                                                            <th>No.</th>
                                                            <th>Judul</th>
                                                            <th>Unit Kerja</th>
                                                            <th>Nama Inventor</th>
                                                            <th>Keterangan</th>
                                                            <th>Tanggal Ajuan</th>
                                                            <th>Bulan Ke</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1; ?>
                                                        <?php foreach ($getDitangguhkan as $p4) : ?>
                                                        <?php
                                                            $waktuinput  = date_create($p4['TGL_INPUT']);
                                                            $waktusekarang = date_create();
                                                            $diff  = date_diff($waktuinput, $waktusekarang);

                                                            if ($diff->m <= 1) {
                                                                $diff->m = 1;
                                                            }
                                                            ?>
                                                        <tr>
                                                            <td><?= $i; ?></td>
                                                            <td><?= $p4['JUDUL']; ?></td>
                                                            <td><?= $p4['NAMA_REV']; ?></td>
                                                            <td>
                                                                <!-- Inventor Pegawai -->
                                                                <?php foreach ($getInventor as $inv) { ?>
                                                                <?php if ($inv['ID_PATEN'] == $p4['ID']) { ?>
                                                                <?= $inv['NAMA']; ?>;<br>
                                                                <?php } ?>
                                                                <?php } ?>

                                                                <!-- Inventor Non Pegawai -->
                                                                <?php foreach ($getInventorNon as $invnon) { ?>
                                                                <?php if ($invnon['ID_PATEN'] == $p4['ID']) { ?>
                                                                <?= $invnon['NAMA']; ?>;<br>
                                                                <?php } ?>
                                                                <?php } ?>
                                                            </td>
                                                            <td></td>
                                                            <td></td>
                                                            <td><?= date('d-m-Y', strtotime($p4['TGL_INPUT'])) ?></td>
                                                            <td><?= $diff->m; ?></td>
                                                            <td></td>

                                                        </tr>
                                                        <?php $i++; ?>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Example Tabs Line Top -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Panel Tabs -->
    </div>
</div>
</div>
</div>
</div>
<!-- End Page -->
<script src="<?= base_url('assets/') ?>global/vendor/jquery/jquery.js"></script>
<script>
    $(document).ready(function() {
        //$('#mytable').DataTable({
        // dom: 'Bfrtip',
        // buttons: [
        //      'copy', 'csv', 'excel',
        //   ]
        // });
    });
</script>