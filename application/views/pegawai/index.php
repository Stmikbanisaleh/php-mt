  <!-- Page -->
  <div class="page">

      <div class="page-content container-fluid">
          <!-- Panel Tabs -->
          <div class="panel">
              <div class="panel-heading">
                  <h3 class="panel-title">Data Pegawai</h3>
              </div>
              <div class="panel-body container-fluid">
                  <div class="row row-lg">
                      <div class="col-xl">
                          <div class="panel">
                              <a href="<?= base_url('pegawai/input_pegawai') ?>" class="btn btn-primary mb-10"><i class="fa fa-plus"></i> Tambah Pegawai</a>
                              <div class="table-responsive">
                                  <table class="table dataTable table-striped table-bordered w-full" data-plugin="dataTable">
                                      <thead>
                                          <tr class="table-info">
                                              <th>No.</th>
                                              <th>Kode Kepegawaian</th>
                                              <th>NIK</th>
                                              <th>Nama</th>
                                              <th>Aksi</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <?php $i = 1; ?>
                                          <?php foreach ($getPegawai as $gp) : ?>
                                              <tr>
                                                  <td><?= $i ?></td>
                                                  <td><?= $gp['KODE_KEPEGAWAIAN']; ?></td>
                                                  <td><?= $gp['NIK']; ?></td>
                                                  <td><?= $gp['NAMA']; ?></td>
                                                  <td>
                                                      <a href="<?= base_url() ?>pegawai/edit_pegawai/<?= $gp['ID']; ?>" class="btn btn-xs btn-primary">
                                                          <li class="fa fa-pencil"></li>
                                                      </a>
                                                      <a href="<?= base_url() ?>pegawai/hapus_pegawai/<?= $gp['ID']; ?>" class="btn btn-xs btn-danger" onclick="return confirm('Anda yakin ingin menghapus pegawai?');">
                                                          <li class="fa fa-trash"></li>
                                                      </a>
                                                  </td>
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
      </div>



      <!-- End Panel Tabs -->

  </div>
  </div>
  </div>
  </div>
  </div>
  <!-- End Page -->