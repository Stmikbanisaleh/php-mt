  <!-- Page -->
  <div class="page">

    <div class="page-content container-fluid">
      <!-- Panel Tabs -->
      <div class="panel panel-primary">
        <div class="panel-heading xl-lg-6 col-md-12 text-center my-10">
          <h3 class="text-white panel-title">Manajemen Pembayaran</h3>
        </div>
        <div class="panel-body container-fluid">
          <form enctype="multipart/form-data" method="post" action="<?= base_url('pembayaran/save');  ?>">
            <div class="row row-lg">
              <div class="col-xl-6">
                <div class="panel">
                  <div class="table-responsive">

                    <table class="table table-borderless">
                      <tr style="height: 70px">
                        <td colspan="2">
                          <div class="input-group mb-3">
                            <input type="text" class="form-control" name="no_paten" id="no_paten" placeholder="Nomor Paten" aria-describedby="button-addon2">
                            <div class="input-group-append ml-10">
                              <button type="button" class="btn btn-primary btn-search" name="Search" id="btn-search">Search</button>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Unit Kerja</td>
                        <td><input class="form-control" name="unit_kerja" id="unit_kerja"></td>
                      </tr>
                      <tr>
                        <td>Judul</td>
                        <td><input class="form-control" name="judul" id="judul"></td>
                      </tr>
                      <tr>
                        <td>Tahun</td>
                        <td><input class="form-control" name="tahun" id="tahun"></td>
                      </tr>

                    </table>
                  </div>
                </div>
              </div>
              <div class="col-xl-6">
                <div class="panel">
                  <div class="table-responsive">
                    <table class="table">
                      <!--
                    <tr style="height: 70px">
                      <td colspan="2">
                        <h4 class="text-primary">Tarif Pembayaran</h4>
                      </td>
                    </tr>
                    -->
                      <tr>
                        <td>Jenis Pembayaran</td>
                        <td>
                          <select class="form-control" name="jenis_pembayaran" id="jenis_pembayaran">
                            <option value="">Pilih Jenis Pembayaran</option>
                            <?php foreach ($jenispembayaran as $jp) { ?>
                              <option value="<?= $jp['NAMA_REV']; ?>"><?= $jp['NAMA_REV']; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>Nominal</td>
                        <td><input class="form-control" name="nominal" id="nominal"></input></td>
                      </tr>
                      <tr>
                        <td>Dibayar</td>
                        <td><input class="form-control" name="dibayar" id="dibayar"></input></td>
                      </tr>
                      <tr>
                        <td>Bukti Pembayaran</td>
                        <td><input type="file" id="bukti_pembayaran" name="bukti_pembayaran" data-plugin="dropify" data-height="75px" /></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="row row-lg">
              <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary col-lg-4">Simpan</button>
              </div>
            </div>
          </form>
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
  <script type="text/javascript">
    $(document).ready(function() {

      $('#btn-search').on('click', function() {
        var this_val = $('#no_paten').val();
        if (this_val == '') {
          return false;
        }
        reload_data(this_val);
      });

      reload_data = function(this_val, mode_edit) {
        $.ajax({
          url: "<?php echo site_url('pembayaran/reload_paten') ?>",
          dataType: 'json',
          type: 'post',
          contentType: 'application/x-www-form-urlencoded',
          data: 'no_paten=' + this_val,
          success: function(data) {
            $.each(data.header, function(v) {
              $('#unit_kerja').val(v.NAMA_REV);
              $('#judul').val(v.JUDUL);
              $('#tahun').val(v.TAHUN_GRANTED);
            });
          },
          error: function() {
            console.log('Faiure on Reload Enquiry');
          }
        });
      }

    });
  </script>