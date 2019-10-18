  <!-- Page -->
  <div class="page">

      <div class="page-content container-fluid">
          <!-- Panel Tabs -->
          <div class="panel">
              <div class="panel-heading">
                  <h3 class="panel-title">Manajemen Pengajuan Merek</h3>
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
                                                  <a href="<?= base_url('merek/input'); ?>" class="btn btn-info my-10">
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
                                                          <?php foreach ($getDraft as $m0) : ?>
                                                              <tr>
                                                                  <td><?= $i ?></td>
                                                                  <td><?= $m0['JUDUL']; ?></td>
                                                                  <td><?= $m0['NAMA_REV'] ?></td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td>
                                                                      <?php
                                                                            $role_id = $this->session->userdata('role_id');
                                                                            if ($role_id == 14 || $role_id == 15 || $role_id == 18) {
                                                                                ?>
                                                                          <a href="<?= base_url() ?>merek/edit/<?= $m0['ID']; ?>" class="text-warning" value="<?= $m0['ID'] ?>;"><i class="fa fa-pencil"> Edit</i></a>
                                                                          <a href="<?= base_url() ?>merek/ajukan/<?= $m0['ID']; ?>" class="text-info" value="<?= $m0['ID'] ?>;" onclick="return confirm('Anda yakin ingin mengajukan Merek?');"><i class="fa fa-send"> Ajukan</i></a>
                                                                          <a href="<?= base_url() ?>merek/hapusdraft/<?= $m0['ID']; ?>" class="text-danger" value="<?= $m0['ID'] ?>;" onclick="return confirm('Anda yakin ingin menghapus Merek?');"><i class="fa fa-trash"> Hapus</i></a>
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
                                          <!-- Draft Table -->
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
                                                              <th>Dokumen Valid</th>
                                                              <th>Tanggal Update</th>
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

                                                                    if ($diff->m <= 1) {
                                                                        $diff->m = 1;
                                                                    }
                                                                    ?>
                                                              <tr>
                                                                  <td><?= $i; ?></td>
                                                                  <td><?= $m1['JUDUL']; ?></td>
                                                                  <td><?= $m1['NAMA_REV'] ?></td>
                                                                  <td>
                                                                      <a data-toggle="modal" href="#modal_<?= $m1['ID'] ?>" class="text-info"><i class="fa fa-user"> Lihat</i></a>
                                                                  </td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td><?= date('d-m-Y', strtotime($m1['TGL_INPUT'])) ?></td>
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
                                                  <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
                                                      <thead>
                                                          <tr class="table-info">
                                                              <th>No.</th>
                                                              <th>Judul</th>
                                                              <th>Unit Kerja</th>
                                                              <th>Nama Pendesain</th>
                                                              <th>Nama Pendaftaran</th>
                                                              <th>Keterangan</th>
                                                              <th>Tanggal Ajuan</th>
                                                              <th>Bulan Ke</th>
                                                              <th>Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDisetujui as $m2) : ?>
                                                              <?php
                                                                    $waktuinput  = date_create($m2['TGL_INPUT']);
                                                                    $waktusekarang = date_create();
                                                                    $diff  = date_diff($waktuinput, $waktusekarang);

                                                                    if ($diff->m <= 1) {
                                                                        $diff->m = 1;
                                                                    }
                                                                    ?>
                                                              <tr>
                                                                  <td><?= $i; ?></td>
                                                                  <td><?= $m2['JUDUL']; ?></td>
                                                                  <td><?= $m2['NAMA_REV'] ?></td>
                                                                  <td>
                                                                      <a data-toggle="modal" href="#modal_<?= $m2['ID'] ?>" class="text-info"><i class="fa fa-user"> Lihat</i></a>
                                                                  </td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td><?= date('d-m-Y', strtotime($m2['TGL_INPUT'])) ?></td>
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
                                                  <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
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
                                                          <?php foreach ($getDitolak as $m3) : ?>
                                                              <?php
                                                                    $waktuinput  = date_create($m3['TGL_INPUT']);
                                                                    $waktusekarang = date_create();
                                                                    $diff  = date_diff($waktuinput, $waktusekarang);

                                                                    if ($diff->m <= 1) {
                                                                        $diff->m = 1;
                                                                    }
                                                                    ?>
                                                              <tr>
                                                                  <td><?= $i ?></td>
                                                                  <td><?= $m3['JUDUL']; ?></td>
                                                                  <td><?= $m3['NAMA_REV'] ?></td>
                                                                  <td>
                                                                      <a data-toggle="modal" href="#modal_<?= $m3['ID'] ?>" class="text-info"><i class="fa fa-user"> Lihat</i></a>
                                                                  </td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td><?= date('d-m-Y', strtotime($m3['TGL_INPUT'])) ?></td>
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
                                                  <table class="table table-hover dataTable table-striped w-full" data-plugin="dataTable">
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
                                                          <?php foreach ($getDitangguhkan as $m4) : ?>
                                                              <?php
                                                                    $waktuinput  = date_create($m4['TGL_INPUT']);
                                                                    $waktusekarang = date_create();
                                                                    $diff  = date_diff($waktuinput, $waktusekarang);

                                                                    if ($diff->m <= 1) {
                                                                        $diff->m = 1;
                                                                    }
                                                                    ?>
                                                              <tr>
                                                                  <td><?= $i ?></td>
                                                                  <td><?= $m4['JUDUL']; ?></td>
                                                                  <td><?= $m4['NAMA_REV'] ?></td>
                                                                  <td>
                                                                      <a data-toggle="modal" href="#modal_<?= $m4['ID'] ?>" class="text-info"><i class="fa fa-user"> Lihat</i></a>
                                                                  </td>
                                                                  <td></td>
                                                                  <td></td>
                                                                  <td><?= date('d-m-Y', strtotime($m4['TGL_INPUT'])) ?></td>
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