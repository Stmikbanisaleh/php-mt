<!-- Page -->
<div class="page">

<div class="page-content container-fluid">
    <!-- Panel Tabs -->
    <div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">Manajemen Verifikator Merek</h3>
    </div>
    <div class="panel-body container-fluid">
        <div class="row row-lg">
        <div class="col-xl">
            <!-- Example Tabs Line Top -->
            <div class="example-wrap">
            <div class="nav-tabs-horizontal" data-plugin="tabs">
                <ul class="nav nav-tabs nav-tabs-line tabs-line-top" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#TabsDiusulkan"
                    aria-controls="TabsDiusulkan" role="tab">DIUSULKAN</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDisetujui"
                    aria-controls="TabsDisetujui" role="tab">DISETUJUI</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDitolak"
                    aria-controls="TabsDitolak" role="tab">DITOLAK</a></li>
                <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDitangguhkan"
                    aria-controls="TabsDitangguhkan" role="tab">DITARIK KEMBALI</a></li>
                </ul>
                <div class="tab-content pt-20">
                <div class="tab-pane active" id="TabsDiusulkan" role="tabpanel">
                    <!-- Diajukan Table -->
                    <div class="panel">
                    <div class="text-right my-5">
                        <a href="<?= base_url('merek/export') ?>" class="btn btn-sm btn-success my-5 text-right"><i class="fa fa-file-excel-o"></i> Export</a>      
                    </div>
                        <div class="table-responsive">
                            <table class="table dataTable table-bordered table-striped w-full" data-plugin="dataTable">
                                <thead>
                                <tr class="table-info">
                                    <th>No.</th>
                                    <th>Judul</th>
                                    <th>Unit Kerja</th>
                                    <th>Nama Pendesain</th>
                                    <th>Keterangan</th>
                                    <th>Dokumen</th>
                                    <th>Tanggal Ajuan</th>
                                    <th>Bulan Ke</th>
                                    <th class="text-nowrap">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($getDiajukan as $m1) : ?>
                                    <?php 
                                        $waktuinput  = date_create($m1['TGL_INPUT']); 
                                        $waktusekarang = date_create(); 
                                        $diff  = date_diff($waktuinput, $waktusekarang);
                                            
                                        if ($diff->m <= 1){
                                            $diff->m = 1;
                                        }
                                    ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $m1['JUDUL']; ?></td> 
                                    <td><?= $m1['NAMA_REV']; ?></td>
                                    <td>
                                        <!-- Pendesain Pegawai -->
                                        <?php foreach ($getPendesain as $des) { ?>
                                        <?php if ($des['ID_MEREK'] == $m1['ID']) { ?>
                                        <?= $des['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>

                                        <!-- Pendesain Non Pegawai -->
                                        <?php foreach ($getPendesainNon as $desnon) { ?>
                                        <?php if ($desnon['ID_MEREK'] == $m1['ID']) { ?>
                                        <?= $desnon['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><?= date('d-m-Y', strtotime($m1['TGL_INPUT']))?></td>
                                    <td><?=$diff->m;?></td>
                                    <td>
                                        <?php 
                                            $role_id = $this->session->userdata('role_id'); 
                                            if ($role_id == 15 || $role_id == 17 ) {
                                        ?>
                                            <a href="<?= base_url()?>merek/verifikasi/<?=$m1['ID'];?>" class="text-info" ><i class="fa fa-check-square-o"> Verifikasi</i></a>
                                            <?php } ?>
                                    </td>
                                    
                                </tr>
                                    <?php $i++;; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Diajukan Table -->
                </div>
                <div class="tab-pane" id="TabsDisetujui" role="tabpanel">
                    <!-- Disetujui Table -->
                    <div class="panel">
                        <div class="table-responsive">
                            <table class="table dataTable table-bordered table-striped w-full" data-plugin="dataTable">
                                <thead>
                                <tr class="table-info">
                                    <th>No.</th>
                                    <th>Judul</th>
                                    <th>Unit Kerja</th>
                                    <th>Nama Pendesain</th>
                                    <th>Keterangan</th>
                                    <th>Dokumen</th>
                                    <th>Tanggal Ajuan</th>
                                    <th>Bulan Ke</th>
                                    <th class="text-nowrap">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($getDisetujui as $m2) : ?>
                                    <?php 
                                        $waktuinput  = date_create($m2['TGL_INPUT']); 
                                        $waktusekarang = date_create(); 
                                        $diff  = date_diff($waktuinput, $waktusekarang);
                                            
                                        if ($diff->m <= 1){
                                            $diff->m = 1;
                                        }
                                    ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $m2['JUDUL']; ?></td> 
                                    <td><?= $m2['NAMA_REV']; ?></td>
                                    <td>
                                        <!-- Pendesain Pegawai -->
                                        <?php foreach ($getPendesain as $des) { ?>
                                        <?php if ($des['ID_MEREK'] == $m2['ID']) { ?>
                                        <?= $des['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>

                                        <!-- Pendesain Non Pegawai -->
                                        <?php foreach ($getPendesainNon as $desnon) { ?>
                                        <?php if ($desnon['ID_MEREK'] == $m2['ID']) { ?>
                                        <?= $desnon['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><?= date('d-m-Y', strtotime($m2['TGL_INPUT']))?></td>
                                    <td><?=$diff->m;?></td>
                                    <td></td>
                                    
                                </tr>
                                    <?php $i++;; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- End Disetujui Table -->
                </div>
                <div class="tab-pane" id="TabsDitolak" role="tabpanel">
                        <div class="panel">
                            <div class="table-responsive">
                                <!-- Ditolak Table -->
                            <table class="table table-hover dataTable table-bordered table-striped w-full" data-plugin="dataTable">
                                <thead>
                                    <tr class="table-info">
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Unit Kerja</th>
                                        <th>Nama Pendesain</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Ajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($getDitolak as $m3) : ?>
                                    <?php 
                                        $waktuinput  = date_create($m3['TGL_INPUT']); 
                                        $waktusekarang = date_create(); 
                                        $diff  = date_diff($waktuinput, $waktusekarang);
                                            
                                        if ($diff->m <= 1){
                                            $diff->m = 1;
                                        }
                                    ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $m3['JUDUL']; ?></td> 
                                    <td><?= $m3['NAMA_REV']; ?></td>
                                    <td>
                                    <!-- Pendesain Pegawai -->
                                    <?php foreach ($getPendesain as $des) { ?>
                                        <?php if ($des['ID_MEREK'] == $m3['ID']) { ?>
                                        <?= $des['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>

                                        <!-- Pendesain Non Pegawai -->
                                        <?php foreach ($getPendesainNon as $desnon) { ?>
                                        <?php if ($desnon['ID_MEREK'] == $m3['ID']) { ?>
                                        <?= $desnon['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><?= date('d-m-Y', strtotime($m3['TGL_INPUT']))?></td>
                                    <td><?=$diff->m;?></td>
                                    <td></td>
                                    
                                </tr>
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
                            <table class="table table-hover dataTable table-bordered table-striped w-full" data-plugin="dataTable">
                                <thead>
                                    <tr class="table-info">
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Unit Kerja</th>
                                        <th>Nama Pendesain</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Ajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($getDitangguhkan as $m4) : ?>
                                    <?php 
                                        $waktuinput  = date_create($m4['TGL_INPUT']); 
                                        $waktusekarang = date_create(); 
                                        $diff  = date_diff($waktuinput, $waktusekarang);
                                            
                                        if ($diff->m <= 1){
                                            $diff->m = 1;
                                        }
                                    ?>
                                    
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $m4['JUDUL']; ?></td> 
                                    <td><?= $m4['NAMA_REV']; ?></td> 
                                    <td>
                                        <!-- Pendesain Pegawai -->
                                        <?php foreach ($getPendesain as $des) { ?>
                                        <?php if ($des['ID_MEREK'] == $m4['ID']) { ?>
                                        <?= $des['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>

                                        <!-- Pendesain Non Pegawai -->
                                        <?php foreach ($getPendesainNon as $desnon) { ?>
                                        <?php if ($desnon['ID_MEREK'] == $m4['ID']) { ?>
                                        <?= $desnon['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><?= date('d-m-Y', strtotime($m4['TGL_INPUT']))?></td>
                                    <td><?=$diff->m;?></td>
                                    <td></td>
                                    
                                </tr>
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