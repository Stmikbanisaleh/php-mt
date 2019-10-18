  <!-- Page -->
  <div class="page">

      <div class="page-content container-fluid">
          <!-- Panel Tabs -->
          <div class="panel">
              <div class="panel-heading">
                  <h3 class="panel-title">Manajemen Pengajuan Paten</h3>
              </div>
              <div class="panel-body container-fluid">
                  <div class="row row-lg">
                      <div class="col-xl">
                          <!-- Example Tabs Line Top -->
                          <div class="example-wrap">
                              <div class="nav-tabs-horizontal" data-plugin="tabs">
                                  <ul class="nav nav-tabs nav-tabs-line tabs-line-top" role="tablist">
                                      <li class="nav-item" role="presentation"><a class="nav-link active" data-toggle="tab" href="#TabsDraft" aria-controls="TabsDraft" role="tab">DRAFT</a></li>
                                      <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDiajukan" aria-controls="TabsDiajukan" role="tab">DIAJUKAN</a></li>
                                      <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDisetujui" aria-controls="TabsDisetujui" role="tab">DISETUJUI</a></li>
                                      <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDitolak" aria-controls="TabsDitolak" role="tab">DITOLAK</a></li>
                                      <li class="nav-item" role="presentation"><a class="nav-link" data-toggle="tab" href="#TabsDitarik" aria-controls="TabsDitarik" role="tab">DITARIK KEMBALI</a></li>
                                  </ul>
                                  <div class="tab-content pt-20">
                                      <div class="tab-pane active" id="TabsDraft" role="tabpanel">
                                          <!-- Draft Table -->
                                          <div class="panel">

                                              <?= $this->session->flashdata('message'); ?>
                                              <a href="<?= base_url('paten/input'); ?>" class="btn btn-info my-10">
                                                  <i class="fa fa-plus"> Input</i>
                                              </a>
                                              <a href="<?= base_url('paten/timeline'); ?>" target="_blank" class="btn btn-success my-10 ml-5">
                                                  <i class="fa fa-arrows-h"> Timeline</i>
                                              </a>
                                              <div class="">
                                                  <table class="table dataTable table-striped table-bordered w-full" data-plugin="dataTable">
                                                      <thead>
                                                          <tr class="table-info">
                                                              <th>No.</th>
                                                              <th>Judul</th>
                                                              <th>Unit Kerja</th>
                                                              <th>Nama Inventor</th>
                                                              <th>Keterangan</th>
                                                              <th>Dokumen Valid</th>
                                                              <th>Tanggal Update</th>
                                                              <th class="text-nowrap">Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDraft as $p0) : ?>
                                                          <tr>
                                                              <td><?= $i ?></td>
                                                              <td><?= $p0['JUDUL']; ?></td>
                                                              <td><?= $p0['NAMA_REV'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getInventor as $inv) { ?>
                                                                  <?php if ($inv['ID_PATEN'] == $p0['ID']) { ?>
                                                                  <?= $inv['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getInventorNon as $invn) { ?>
                                                                  <?php if ($invn['ID_PATEN'] == $p0['ID']) { ?>
                                                                  <?= $invn['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td><?= $p0['KETERANGAN'] ?></td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($p0['TGL_INPUT'])) ?></td>
                                                              <td>
                                                                  <?php
                                                                        $role_id = $this->session->userdata('role_id');
                                                                        if ($role_id == 14 || $role_id == 15 || $role_id == 18) {
                                                                            ?>
                                                                  <a href="<?= base_url() ?>paten/edit/<?= $p0['ID']; ?>" class="text-warning" value="<?= $p0['ID'] ?>;"><i class="fa fa-pencil"> Edit</i></a>
                                                                  <a href="<?= base_url() ?>paten/ajukan/<?= $p0['ID']; ?>" class="text-info" value="<?= $p0['ID'] ?>;" onclick="return confirm('Anda yakin ingin mengajukan paten?');"><i class="fa fa-send"> Ajukan</i></a>
                                                                  <?php if ($p0['PERNAH_DIAJUKAN'] != 1) { ?>
                                                                  <a href="<?= base_url() ?>paten/hapusdraft/<?= $p0['ID']; ?>" class="text-danger" value="<?= $p0['ID'] ?>;" onclick="return confirm('Anda yakin ingin menghapus paten?');"><i class="fa fa-trash"> Hapus</i></a>
                                                                  <?php } ?>
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
                                                              <td><?= $i ?></td>
                                                              <td><?= $p1['JUDUL']; ?></td>
                                                              <td><?= $p1['NAMA_REV']; ?></td>
                                                              <td>
                                                                  <?php foreach ($getInventor as $inv) { ?>
                                                                  <?php if ($inv['ID_PATEN'] == $p1['ID']) { ?>
                                                                  <?= $inv['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td><?= $p1['KETERANGAN']; ?></td>
                                                              <td><?= date('d-m-Y', strtotime($p1['TGL_INPUT'])) ?></td>
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
                                          <!-- Disetujui Table -->
                                          <div class="panel">
                                              <div class="table-responsive">
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
                                                              <th class="text-nowrap">Aksi</th>
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
                                                              <td><?= $i ?></td>
                                                              <td><?= $p2['JUDUL']; ?></td>
                                                              <td><?= $p2['NAMA_REV'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getInventor as $inv) { ?>
                                                                  <?php if ($inv['ID_PATEN'] == $p2['ID']) { ?>
                                                                  <?= $inv['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
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
                                          <!-- End Disetujui Table -->
                                      </div>
                                      <div class="tab-pane" id="TabsDitolak" role="tabpanel">
                                          <div class="panel">
                                              <div class="table-responsive">
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
                                                              <td><?= $i ?></td>
                                                              <td><?= $p3['JUDUL']; ?></td>
                                                              <td><?= $p3['NAMA_REV'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getInventor as $inv) { ?>
                                                                  <?php if ($inv['ID_PATEN'] == $p3['ID']) { ?>
                                                                  <?= $inv['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
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
                                                  <table class="table table-hover table-bordered dataTable table-striped w-full" data-plugin="dataTable">
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
                                                              <td><?= $i ?></td>
                                                              <td><?= $p4['JUDUL']; ?></td>
                                                              <td><?= $p4['NAMA_REV'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getInventor as $inv) { ?>
                                                                  <?php if ($inv['ID_PATEN'] == $p4['ID']) { ?>
                                                                  <?= $inv['NAMA']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td><?= $p4['KETERANGAN']; ?></td>
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