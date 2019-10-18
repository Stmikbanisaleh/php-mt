  <!-- Page -->
  <div class="page">
    
    <div class="page-content container-fluid">
      <!-- Panel Tabs -->
      <div class="panel">
        <div class="panel-heading">
          <h3 class="panel-title">Manajemen Monitoring Pembayaran</h3>
        </div>
        <div class="panel-body container-fluid">
          <div class="row row-lg">
            <div class="col-xl">
              <!-- Example Tabs Line Top -->
              <div class="example-wrap">
                  <div class="tab-content pt-20">
                    <div class="tab-pane active" id="TabsDraft" role="tabpanel">
                        <!-- Draft Table -->
                        <div class="panel">
                            <div class="table-responsive">
                                <table class="table dataTable table-striped w-full" data-plugin="dataTable">
                                    <thead>
                                    <tr class="table-info">
                                        <th>No.</th>
                                        <th>Nomor Pendaftaran</th>
                                        <th>Unit Kerja</th>
                                        <th>Nama Kepegawaian</th>
                                        <th>Tahun</th>
                                        <th>Jenis Pembayaran</th>
                                        <th>Tarif</th>
                                        <th>Bayar</th>
                                        <th>Tunggakan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                       <?php foreach ($pembayaran  as $b ) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $b['NOMOR_PENDAFTAR']?></td>
                                        <td><?= $b['UNIT']?></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                        <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- End Draft Table -->
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