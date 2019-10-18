  <!-- Page -->
  <div class="page">
    
    <div class="page-content container-fluid">
      <!-- Panel Tabs -->
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Manajemen Verifikator Hak Cipta</h3>
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
                      aria-controls="TabsDitangguhkan" role="tab">DITANGGUHKAN</a></li>
                  </ul>
                  <div class="tab-content pt-20">
                    <div class="tab-pane active" id="TabsDiusulkan" role="tabpanel">
                      <!-- Diajukan Table -->
                      <div class="panel">
                        <div class="text-right my-5">
                            <a href="<?= base_url('hakcipta/export') ?>" class="btn btn-sm btn-success my-5 text-right"><i class="fa fa-file-excel-o"></i> Export</a>      
                        </div>
                            <div class="table-responsive">
                                <table class="table dataTable table-bordered table-striped w-full" data-plugin="dataTable">
                                    <thead>
                                    <tr class="table-info">
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Unit Kerja</th>
                                        <th>Nama Pencipta</th>
                                        <th>Keterangan</th>
                                        <th>Dokumen</th>
                                        <th>Tanggal Ajuan</th>
                                        <th class="text-nowrap">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($getDiajukan as $h1) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $h1['JUDUL']; ?></td> 
                                        <td><?= $h1['NAMA_REV']; ?></td> 
                                        <td>
                                             <!-- Pencipta Pegawai -->
                                            <?php foreach ($getPencipta as $cip) { ?>
                                            <?php if ($cip['ID_HAKCIPTA'] == $h1['ID']) { ?>
                                            <?= $cip['NAMA']; ?>;<br>
                                            <?php } ?>
                                            <?php } ?>

                                            <!-- Pencipta Non Pegawai -->
                                            <?php foreach ($getPenciptaNon as $cipnon) { ?>
                                            <?php if ($cipnon['ID_HAKCIPTA'] == $h1['ID']) { ?>
                                            <?= $cipnon['NAMA']; ?>;<br>
                                            <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td><?= date('d-m-Y', strtotime($h1['TGL_INPUT']))?></td>
                                        <td>
                                            <?php 
                                                $role_id = $this->session->userdata('role_id'); 
                                                if ($role_id == 15 || $role_id == 17 ) {
                                            ?>
                                                <a href="<?= base_url()?>hakcipta/verifikasi/<?=$h1['ID'];?>" class="text-info" ><i class="fa fa-check-square-o"> Verifikasi</i></a>
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
                            <table class="table table-hover table-bordered dataTable table-striped w-full" data-plugin="dataTable">
                                <thead>
                                    <tr class="table-info">
                                        <th>No.</th>
                                        <th>Judul</th>
                                        <th>Unit Kerja</th>
                                        <th>Nama Pendesain</th>
                                        <th>Nomor Pendaftaran</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal Ajuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($getDisetujui as $h2) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $h2['JUDUL']; ?></td> 
                                    <td><?= $h2['NAMA_REV']; ?></td> 
                                    <td>
                                        <!-- Pencipta Pegawai -->
                                        <?php foreach ($getPencipta as $cip) { ?>
                                        <?php if ($cip['ID_HAKCIPTA'] == $h2['ID']) { ?>
                                        <?= $cip['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>

                                        <!-- Pencipta Non Pegawai -->
                                        <?php foreach ($getPenciptaNon as $cipnon) { ?>
                                        <?php if ($cipnon['ID_HAKCIPTA'] == $h2['ID']) { ?>
                                        <?= $cipnon['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><?= date('d-m-Y', strtotime($h2['TGL_INPUT']))?></td>
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
                                <table class="table table-hover table-bordered dataTable table-striped w-full" data-plugin="dataTable">
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
                                        <?php foreach ($getDitolak as $h3) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $h3['JUDUL']; ?></td> 
                                        <td><?= $h3['NAMA_REV']; ?></td> 
                                        <td>
                                            <!-- Pencipta Pegawai -->
                                            <?php foreach ($getPencipta as $cip) { ?>
                                            <?php if ($cip['ID_HAKCIPTA'] == $h3['ID']) { ?>
                                            <?= $cip['NAMA']; ?>;<br>
                                            <?php } ?>
                                            <?php } ?>

                                            <!-- Pencipta Non Pegawai -->
                                            <?php foreach ($getPenciptaNon as $cipnon) { ?>
                                            <?php if ($cipnon['ID_HAKCIPTA'] == $h3['ID']) { ?>
                                            <?= $cipnon['NAMA']; ?>;<br>
                                            <?php } ?>
                                            <?php } ?>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td><?= date('d-m-Y', strtotime($h3['TGL_INPUT']))?></td>
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
                            <table class="table table-hover table-bordered dataTable table-striped w-full" data-plugin="dataTable">
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
                                    <?php foreach ($getDitangguhkan as $h4) : ?>
                                <tr>
                                    <td><?= $i; ?></td>
                                    <td><?= $h4['JUDUL']; ?></td> 
                                    <td><?= $h4['NAMA_REV']; ?></td> 
                                    <td>
                                        <!-- Pencipta Pegawai -->
                                        <?php foreach ($getPencipta as $cip) { ?>
                                        <?php if ($cip['ID_HAKCIPTA'] == $h4['ID']) { ?>
                                        <?= $cip['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>

                                        <!-- Pencipta Non Pegawai -->
                                        <?php foreach ($getPenciptaNon as $cipnon) { ?>
                                        <?php if ($cipnon['ID_HAKCIPTA'] == $h4['ID']) { ?>
                                        <?= $cipnon['NAMA']; ?>;<br>
                                        <?php } ?>
                                        <?php } ?>
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td><?= date('d-m-Y', strtotime($h4['TGL_INPUT']))?></td>
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