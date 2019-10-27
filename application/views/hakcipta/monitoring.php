  <!-- Page -->
  <div class="page">

      <div class="page-content container-fluid">
          <!-- Panel Tabs -->
          <div class="panel">
              <div class="panel-heading">
                  <h3 class="panel-title">Manajemen Pengajuan Hak Cipta</h3>
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
                                                  <a href="<?= base_url('hakcipta/input'); ?>" class="btn btn-info my-10">
                                                      <i class="fa fa-plus"> Input</i>
                                                  </a>
                                                  <table class="table dataTable table-striped w-full" data-plugin="dataTable">
                                                      <thead>


                                                          <tr class="table-info">
                                                              <th>No.</th>
                                                              <th>Judul</th>
                                                              <th>Unit Kerja</th>
                                                              <th>Nama Pencipta</th>
                                                              <th>Keterangan</th>
                                                              <th>Dokumen Valid</th>
                                                              <th>Tanggal Update</th>
                                                              <th class="text-nowrap">Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDraft as $h0) : ?>
                                                          <tr>
                                                              <td><?= $i ?></td>
                                                              <td><?= $h0['judul']; ?></td>
                                                              <td><?= $h0['nama_rev'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPencipta as $cip) { ?>
                                                                  <?php if ($cip['id_hakcipta'] == $h0['id']) { ?>
                                                                  <?= $cip['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPenciptaNon as $cipn) { ?>
                                                                  <?php if ($cipn['id_hakcipta'] == $h0['id']) { ?>
                                                                  <?= $cipn['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td></td>
                                                              <td></td>
                                                              <td>
                                                                  <?php
                                                                        $role_id = $this->session->userdata('role_id');
                                                                        if ($role_id == 14 || $role_id == 15 || $role_id == 18) {
                                                                            ?>
                                                                  <a href="<?= base_url() ?>hakcipta/edit/<?= $h0['id']; ?>" class="text-warning" value="<?= $h0['id'] ?>;"><i class="fa fa-pencil"> Edit</i></a>
                                                                  <a href="<?= base_url() ?>hakcipta/ajukan/<?= $h0['id']; ?>" class="text-info" value="<?= $h0['id'] ?>;" onclick="return confirm('Anda yakin ingin mengajukan Hak Cipta?');"><i class="fa fa-send"> Ajukan</i></a>
                                                                  <a href="<?= base_url() ?>hakcipta/hapusdraft/<?= $h0['id']; ?>" class="text-danger" value="<?= $h0['id'] ?>;" onclick="return confirm('Anda yakin ingin menghapus Hak Cipta?');"><i class="fa fa-trash"> Hapus</i></a>
                                                                  <?php  } ?>
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
                                                              <th>Nama Pencipta</th>
                                                              <th>Keterangan</th>
                                                              <th>Tanggal Ajuan</th>
                                                              <th>Bulan Ke</th>
                                                              <th class="text-nowrap">Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDiajukan as $h1) : ?>
                                                          <?php
                                                                $waktuinput  = date_create($h1['createdAt']);
                                                                $waktusekarang = date_create();
                                                                $diff  = date_diff($waktuinput, $waktusekarang);

                                                                if ($diff->m <= 1) {
                                                                    $diff->m = 1;
                                                                }
                                                                ?>
                                                          <tr>
                                                              <td><?= $i ?></td>
                                                              <td><?= $h1['judul']; ?></td>
                                                              <td><?= $h1['nama_rev'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPencipta as $cip) { ?>
                                                                  <?php if ($cip['id_hakcipta'] == $h1['id']) { ?>
                                                                  <?= $cip['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPenciptaNon as $cipn) { ?>
                                                                  <?php if ($cipn['id_hakcipta'] == $h1['id']) { ?>
                                                                  <?= $cipn['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($h1['createdAt'])) ?></td>
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
                                          <!-- Panel Disetuj -->
                                          <div class="panel">
                                              <div class="table-responsive">
                                                  <!-- Disetujui Table -->
                                                  <table class="table dataTable table-striped w-full" data-plugin="dataTable">
                                                      <thead>
                                                          <tr class="table-info">
                                                              <th>No.</th>
                                                              <th>Judul</th>
                                                              <th>Unit Kerja</th>
                                                              <th>Nama Pencipta</th>
                                                              <th>Nomor Pencatatan</th>
                                                              <th>Tanggal Permohonan</th>
                                                              <th>Tanggal Ajuan</th>
                                                              <th>Bulan Ke</th>
                                                              <th>Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDisetujui as $h2) : ?>
                                                          <?php
                                                                $waktuinput  = date_create($h2['createdAt']);
                                                                $waktusekarang = date_create();
                                                                $diff  = date_diff($waktuinput, $waktusekarang);

                                                                if ($diff->m <= 1) {
                                                                    $diff->m = 1;
                                                                }
                                                                ?>
                                                          <tr>
                                                              <td><?= $i; ?></td>
                                                              <td><?= $h2['judul']; ?></td>
                                                              <td><?= $h2['nama_rev'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPencipta as $cip) { ?>
                                                                  <?php if ($cip['id_hakcipta'] == $h2['id']) { ?>
                                                                  <?= $cip['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPenciptaNon as $cipn) { ?>
                                                                  <?php if ($cipn['id_hakcipta'] == $h2['id']) { ?>
                                                                  <?= $cipn['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($h2['createdAt'])) ?></td>
                                                              <td><?= $diff->m; ?></td>
                                                              <td></td>
                                                          </tr>
                                                          <?php $i++; ?>
                                                          <?php endforeach; ?>
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                          <!-- End Panel Disetuj -->
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
                                                              <th>Nama Pencipta</th>
                                                              <th>Keterangan</th>
                                                              <th>Tanggal Ajuan</th>
                                                              <th>Bulan Ke</th>
                                                              <th>Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDitolak as $h3) : ?>
                                                          <?php
                                                                $waktuinput  = date_create($h3['createdAt']);
                                                                $waktusekarang = date_create();
                                                                $diff  = date_diff($waktuinput, $waktusekarang);

                                                                if ($diff->m <= 1) {
                                                                    $diff->m = 1;
                                                                }
                                                                ?>
                                                          <tr>
                                                              <td><?= $i ?></td>
                                                              <td><?= $h3['judul']; ?></td>
                                                              <td><?= $h3['nama_rev'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPencipta as $cip) { ?>
                                                                  <?php if ($cip['id_hakcipta'] == $h3['id']) { ?>
                                                                  <?= $cip['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPenciptaNon as $cipn) { ?>
                                                                  <?php if ($cipn['id_hakcipta'] == $h3['id']) { ?>
                                                                  <?= $cipn['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($h3['createdAt'])) ?></td>
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
                                                              <th>Nama Pencipta</th>
                                                              <th>Keterangan</th>
                                                              <th>Tanggal Ajuan</th>
                                                              <th>Aksi</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                          <?php $i = 1; ?>
                                                          <?php foreach ($getDitangguhkan as $h4) : ?>
                                                          <?php
                                                                $waktuinput  = date_create($h4['createdAt']);
                                                                $waktusekarang = date_create();
                                                                $diff  = date_diff($waktuinput, $waktusekarang);

                                                                if ($diff->m <= 1) {
                                                                    $diff->m = 1;
                                                                }
                                                                ?>
                                                          <tr>
                                                              <td><?= $i ?></td>
                                                              <td><?= $h4['judul']; ?></td>
                                                              <td><?= $h4['nama_rev'] ?></td>
                                                              <td>
                                                                  <?php foreach ($getPencipta as $cip) { ?>
                                                                  <?php if ($cip['id_hakcipta'] == $h4['id']) { ?>
                                                                  <?= $cip['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>

                                                                  <?php foreach ($getPenciptaNon as $cipn) { ?>
                                                                  <?php if ($cipn['id_hakcipta'] == $h4['id']) { ?>
                                                                  <?= $cipn['nama']; ?>;<br>
                                                                  <?php } ?>
                                                                  <?php } ?>
                                                              </td>
                                                              <td></td>
                                                              <td><?= date('d-m-Y', strtotime($h4['createdAt'])) ?></td>
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