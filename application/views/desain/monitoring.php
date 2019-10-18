  <!-- Page -->
  <div class="page">

      <div class="page-content container-fluid">
          <!-- Panel Tabs -->
          <div class="panel" id="panel">
              <div class="panel-heading">
                  <h3 class="panel-title">Manajemen Pengajuan Desain Industri</h3>
              </div>
              <div class="panel-body container-fluid">
                  <div class="row row-lg">
                      <div class="col-xl">
                          <!-- Example Tabs Line Top -->
                          <div class="example-wrap">
                              <div class="nav-tabs-horizontal" data-plugin="tabs">
                                  <ul class="nav nav-tabs nav-tabs-line tabs-line-top" role="tablist">
                                      <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#TabsDraft" oncl aria-controls="TabsDraft" role="tab">DRAFT</a></li>
                                      <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDiajukan" aria-controls="TabsDiajukan" role="tab">DIAJUKAN</a></li>
                                      <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDisetujui" aria-controls="TabsDisetujui" role="tab">DISETUJUI</a></li>
                                      <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDitolak" aria-controls="TabsDitolak" role="tab">DITOLAK</a></li>
                                      <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDitangguhkan" aria-controls="TabsDitangguhkan" role="tab">DITANGGUHKAN</a></li>
                                  </ul>
                                  <div class="tab-content pt-20">
                                      <div class="tab-pane active" id="TabsDraft" role="tabpanel">
                                          <!-- Draft Table -->
                                          <div class="panel">
                                              <div class="table-responsive">
                                                  <?= $this->session->flashdata('message'); ?>
                                                  <a href="<?= base_url('desain/input'); ?>" class="btn btn-info my-10">
                                                      <i class="fa fa-plus"> Input</i>
                                                  </a>
                                                  <table class="table dataTable table-striped w-full" data-plugin="dataTable">
                                                      <thead>
                                                          <tr class="table-info">
                                                              <th>No.</th>
                                                              <th>Judul</th>
                                                              <th>Unit Kerja</th>
                                                              <th>Nama Pendesain</th>
                                                              <th>Keterangan</th>
                                                              <th>Dokumen Valid</th>
                                                              <th>Tanggal Update</th>
                                                              <th class="text-nowrap">Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDraft as $d0) : ?>
                                                          <tr>
                                                              <td><?= $i ?></td>
                                                              <td><?= $d0['JUDUL']; ?></td>
                                                              <td><?= $d0['NAMA_REV'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPendesain as $des) { ?>
                                                                  <?php if ($des['ID_DESAIN_INDUSTRI'] == $d0['ID']) { ?>
                                                                  <?= $des['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPendesainNon as $desn) { ?>
                                                                  <?php if ($desn['ID_DESAIN_INDUSTRI'] == $d0['ID']) { ?>
                                                                  <?= $desn['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($d0['TGL_INPUT'])) ?></td>
                                                              <td>
                                                                  <?php
                                                                        $role_id = $this->session->userdata('role_id');
                                                                        if ($role_id == 14 || $role_id == 15 || $role_id == 18) {
                                                                            ?>
                                                                  <a href="<?= base_url() ?>desain/edit/<?= $d0['ID']; ?>" class="text-warning" value="<?= $d0['ID'] ?>;"><i class="fa fa-pencil"> Edit</i></a>
                                                                  <a href="<?= base_url() ?>desain/ajukan/<?= $d0['ID']; ?>" class="text-info" value="<?= $d0['ID'] ?>;" onclick="return confirm('Anda yakin ingin mengajukan Desain Industri?');"><i class="fa fa-send"> Ajukan</i></a>
                                                                  <a href="<?= base_url() ?>desain/hapusdraft/<?= $d0['ID']; ?>" class="text-danger" value="<?= $d0['ID'] ?>;" onclick="return confirm('Anda yakin ingin menghapus Desain Industri?');"><i class="fa fa-trash"> Hapus</i></a>
                                                                  <?php } ?>
                                                              </td>
                                                          </tr>
                                                          <?php $i++; ?>
                                                          <?php endforeach; ?>
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                          <!-- End Draft Table -->
                                      </div>
                                      <div class="tab-pane" id="TabsDiajukan" role="tabpanel">
                                          <!-- Diajukan Table -->
                                          <div class="panel">
                                              <div class="table-responsive">
                                                  <table class="table dataTable table-striped w-full" data-plugin="dataTable">
                                                      <thead>
                                                          <tr class="table-info">
                                                              <th>No.</th>
                                                              <th>Judul</th>
                                                              <th>Unit Kerja</th>
                                                              <th>Nama Pendesain</th>
                                                              <th>Keterangan</th>
                                                              <th>Tanggal Ajuan</th>
                                                              <th>Bulan Ke</th>
                                                              <th class="text-nowrap">Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDiajukan as $d1) : ?>
                                                          <?php
                                                                $waktuinput  = date_create($d1['TGL_INPUT']);
                                                                $waktusekarang = date_create();
                                                                $diff  = date_diff($waktuinput, $waktusekarang);

                                                                if ($diff->m <= 1) {
                                                                    $diff->m = 1;
                                                                }
                                                                ?>
                                                          <tr>
                                                              <td><?= $i ?></td>
                                                              <td><?= $d1['JUDUL']; ?></td>
                                                              <td><?= $d1['NAMA_REV'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPendesain as $des) { ?>
                                                                  <?php if ($des['ID_DESAIN_INDUSTRI'] == $d1['ID']) { ?>
                                                                  <?= $des['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPendesainNon as $desn) { ?>
                                                                  <?php if ($desn['ID_DESAIN_INDUSTRI'] == $d1['ID']) { ?>
                                                                  <?= $desn['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($d1['TGL_INPUT'])) ?></td>
                                                              <td><?= $diff->m; ?></td>
                                                              <td></td>
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
                                                  <table class="table dataTable table-striped w-full" data-plugin="dataTable">
                                                      <thead>
                                                          <tr class="table-info">
                                                              <th>No.</th>
                                                              <th>Judul</th>
                                                              <th>Unit Kerja</th>
                                                              <th>Nama Pendesain</th>
                                                              <th>Nomor Pendaftaran</th>
                                                              <th>Keterangan</th>
                                                              <th>Tanggal Ajuan</th>
                                                              <th>Bulan Ke</th>
                                                              <th>Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDisetujui as $d2) : ?>
                                                          <?php
                                                                $waktuinput  = date_create($d2['TGL_INPUT']);
                                                                $waktusekarang = date_create();
                                                                $diff  = date_diff($waktuinput, $waktusekarang);

                                                                if ($diff->m <= 1) {
                                                                    $diff->m = 1;
                                                                }
                                                                ?>
                                                          <tr>
                                                              <td><?= $i; ?></td>
                                                              <td><?= $d2['JUDUL']; ?></td>
                                                              <td><?= $d2['NAMA_REV'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPendesain as $des) { ?>
                                                                  <?php if ($des['ID_DESAIN_INDUSTRI'] == $d2['ID']) { ?>
                                                                  <?= $des['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPendesainNon as $desn) { ?>
                                                                  <?php if ($desn['ID_DESAIN_INDUSTRI'] == $d2['ID']) { ?>
                                                                  <?= $desn['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($d2['TGL_INPUT'])) ?></td>
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
                                                  <table class="table dataTable table-striped w-full" data-plugin="dataTable">
                                                      <thead>
                                                          <tr class="table-info">
                                                              <th>No.</th>
                                                              <th>Judul</th>
                                                              <th>Unit Kerja</th>
                                                              <th>Nama Pendesain</th>
                                                              <th>Keterangan</th>
                                                              <th>Tanggal Ajuan</th>
                                                              <th>Bulan Ke</th>
                                                              <th>Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDitolak as $d3) : ?>
                                                          <?php
                                                                $waktuinput  = date_create($d3['TGL_INPUT']);
                                                                $waktusekarang = date_create();
                                                                $diff  = date_diff($waktuinput, $waktusekarang);

                                                                if ($diff->m <= 1) {
                                                                    $diff->m = 1;
                                                                }
                                                                ?>
                                                          <tr>
                                                              <td><?= $i ?></td>
                                                              <td><?= $d3['JUDUL']; ?></td>
                                                              <td><?= $d3['NAMA_REV'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPendesain as $des) { ?>
                                                                  <?php if ($des['ID_DESAIN_INDUSTRI'] == $d3['ID']) { ?>
                                                                  <?= $des['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPendesainNon as $desn) { ?>
                                                                  <?php if ($desn['ID_DESAIN_INDUSTRI'] == $d3['ID']) { ?>
                                                                  <?= $desn['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($d1['TGL_INPUT'])) ?></td>
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
                                                  <table class="table dataTable table-striped w-full" data-plugin="dataTable">
                                                      <thead>
                                                          <tr class="table-info">
                                                              <th>No.</th>
                                                              <th>Judul</th>
                                                              <th>Unit Kerja</th>
                                                              <th>Nama Pendesain</th>
                                                              <th>Keterangan</th>
                                                              <th>Tanggal Ajuan</th>
                                                              <th>Bulan Ke</th>
                                                              <th>Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDitangguhkan as $d4) : ?>
                                                          <?php
                                                                $waktuinput  = date_create($d4['TGL_INPUT']);
                                                                $waktusekarang = date_create();
                                                                $diff  = date_diff($waktuinput, $waktusekarang);

                                                                if ($diff->m <= 1) {
                                                                    $diff->m = 1;
                                                                }
                                                                ?>
                                                          <tr>
                                                              <td><?= $i ?></td>
                                                              <td><?= $d4['JUDUL']; ?></td>
                                                              <td><?= $d4['NAMA_REV'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPendesain as $des) { ?>
                                                                  <?php if ($des['ID_DESAIN_INDUSTRI'] == $d4['ID']) { ?>
                                                                  <?= $des['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPendesainNon as $desn) { ?>
                                                                  <?php if ($desn['ID_DESAIN_INDUSTRI'] == $d4['ID']) { ?>
                                                                  <?= $desn['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($d1['TGL_INPUT'])) ?></td>
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