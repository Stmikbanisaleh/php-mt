    <style>
      body {
        background-color: #f1f1f1;
      }

      h1 {
        text-align: center;
      }

      input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa;
      }

      /* Mark input boxes that gets an error on validation: */
      input.invalid {
        background-color: #ffdddd;
      }

      /* Hide all steps by default: */
      .tab {
        display: none;
      }
    </style>

    <!-- Page -->
    <div class="page">

      <div class="page-content container-fluid">
        <!-- Panel Tabs -->
        <div class="panel">
          <div class="panel-heading">
            <h3 class="panel-title">Verifikasi Desain</h3>
          </div>
          <div class="panel-body container-fluid">
            <div class="row row-lg">
              <div class="col-xl-6">
                <form id="regForm" enctype="multipart/form-data" method="post" action="<?= base_url('desain/save_verifikasi') ?>">
                  <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                  <div class="tab">
                    <input type="hidden" name="id" value="<?= $diajukan['ID'] ?>">
                    Ip-Man Code
                    <input name="ipman_code" class="form-control" value="<?= $diajukan['IPMAN_CODE']; ?>" id="" readonly>
                    Judul
                    <textarea class="form-control" name="judul" id="judul" readonly><?= $diajukan['JUDUL'] ?> </textarea>
                    Unit Kerja
                    <input class="form-control" value="<?= $diajukan['NAMA_REV']; ?>" name="unit_kerja" id="unit_kerja" readonly>
                    <div class="progress my-10">
                      <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 20%" role="progressbar">
                      </div>
                    </div>
                  </div>
                  <div class="tab">
                    <table class="table">
                      <h5>Pendesain</h5>
                      <?php foreach ($pendesain as $des) { ?>
                        <?php foreach ($pegawai as $p) {
                            if ($des['NIK'] == $p['NIK']) {
                              ?>
                            <tr>
                              <td><?= $p['NAMA'] ?></td>
                            </tr>
                        <?php }
                          } ?>

                        <?php foreach ($nonpegawai as $np) {
                            if ($des['NIK'] == $np['NIK']) {
                              ?>
                            <tr>
                              <td><?= $np['NAMA'] ?></td>
                            </tr>
                        <?php }
                          } ?>
                      <?php } ?>
                    </table>
                    <div class="progress my-10">
                      <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 40%" role="progressbar">
                      </div>
                    </div>
                  </div>

                  <div class="tab">
                    Tanggal Sertifikasi
                    <?php
                    $sertifikasi =  $diajukan['SERTIFIKASI'];
                    if ($sertifikasi != "" && $sertifikasi != '1970-01-01') {
                      $tgl_sertifikasi = date("d-m-Y", strtotime($sertifikasi));
                    } else {
                      $tgl_sertifikasi = "";
                    }
                    ?>
                    <input type="text" name="tgl_sertifikasi" id="tgl_sertifikasi" value="<?= $tgl_sertifikasi; ?>" class="datepicker form-control">
                    Pemeriksa Desain
                    <input class="form-control" name="pemeriksa_desain" value="<?= $diajukan['PEMERIKSA_DESAIN']; ?>" id="pemeriksa_desain">
                    Kontak Pemeriksa
                    <input class="form-control" name="kontak_pemeriksa" value="<?= $diajukan['KONTAK_PEMERIKSA']; ?>" id="kontak_pemeriksa">
                    Email Pemeriksa
                    <input class="form-control" name="email_pemeriksa" value="<?= $diajukan['EMAIL_PEMERIKSA']; ?>" id="email_pemeriksa">
                    <div class="progress my-10">
                      <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 50%" role="progressbar">
                      </div>
                    </div>
                  </div>

                  <div class="tab">
                    <div class="row row-lg my-10">
                      <div class="col-md-12 text-center">
                        <table class="table table-bordered">
                          <tr>
                            <td colspan="3">
                              <h4>Dokumen Inventor</h4>
                            </td>
                          </tr>
                          <?php
                          $i = 1;
                          $d = 0;
                          foreach ($dokumen as $dok) {
                            ?>
                            <tr>
                              <td><?= $i; ?></td>
                              <td><?= $dok['JENIS_DOKUMEN'] ?></td>
                              <td>
                                <?php if ($dokumen[$d]['SIZE'] > 0) { ?>
                                  <a class="btn btn-xs btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_paten/') . $dokumen[$d]['NAME'] ?>"><i class="fa fa-download"></i></a>
                                <?php } else { ?>
                                  <span class="badge badge-lg badge-warning"> Dokumen Belum Lengkap!</span>
                                <?php } ?>
                              </td>
                            </tr>
                          <?php $i++;
                            $d++;
                          } ?>
                        </table>
                      </div>
                      <div class="col-md-12 text-center my-20">
                        <table class="table table-bordered">
                          <tr>
                            <td colspan="2">
                              <h4>Dokumen Verifikator</h4>
                            </td>
                          </tr>
                          <tr>
                            <?php if ($dokver) { ?>
                              <td>Dokumen 1</td>
                              <td>
                                <?php if ($dokver[0]['SIZE'] > 0) { ?>
                                  <?php $dokumen1 = $dokver[0]['NAME'] ?>
                                  <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen1 ?>"><i class="fa fa-download"></i></a>
                                  <input type="hidden" name="currentfile1" value="<?= $dokver[0]['NAME']; ?>">
                                <?php } else { ?>
                                  <input type="file" name="dokumen1" id="dokumen1" data-plugin="dropify" data-height="60">
                                <?php } ?>
                              </td>
                          </tr>
                          <tr>
                            <td>Dokumen 2</td>
                            <td>
                              <?php if ($dokver[1]['SIZE'] > 0) { ?>
                                <?php $dokumen2 = $dokver[1]['NAME'] ?>
                                <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen2 ?>"><i class="fa fa-download"></i></a>
                              <?php } else { ?>
                                <input type="file" name="dokumen2" id="2" data-plugin="dropify" data-height="60">
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                            <td>Dokumen 3</td>
                            <td>
                              <?php if ($dokver[2]['SIZE'] > 0) { ?>
                                <?php $dokumen3 = $dokver[2]['NAME'] ?>
                                <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen3 ?>"><i class="fa fa-download"></i></a>
                              <?php } else { ?>
                                <input type="file" name="dokumen3" id="dokumen3" data-plugin="dropify" data-height="60">
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                            <td>Dokumen 4</td>
                            <td>
                              <?php if ($dokver[3]['SIZE'] > 0) { ?>
                                <?php $dokumen4 = $dokver[3]['NAME'] ?>
                                <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen4 ?>"><i class="fa fa-download"></i></a>
                              <?php } else { ?>
                                <input type="file" name="dokumen4" id="dokumen4" data-plugin="dropify" data-height="60">
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                            <td>Dokumen 5</td>
                            <td>
                              <?php if ($dokver[4]['SIZE'] > 0) { ?>
                                <?php $dokumen5 = $dokver[4]['NAME'] ?>
                                <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen5 ?>"><i class="fa fa-download"></i></a>
                              <?php } else { ?>
                                <input type="file" name="dokumen5" id="dokumen5" data-plugin="dropify" data-height="60">
                              <?php } ?>
                            </td>
                          </tr>


                        <?php } else { ?>

                          <tr>
                            <td><?= $newdokver[0]['JENIS_DOKUMEN']; ?></td>
                            <td><input type="file" name="dokumen1" id="dokumen1" data-plugin="dropify" data-height="60"></td>
                          </tr>
                          <tr>
                            <td><?= $newdokver[1]['JENIS_DOKUMEN']; ?></td>
                            <td><input type="file" name="dokumen2" id="dokumen2" data-plugin="dropify" data-height="60"></td>
                          </tr>
                          <tr>
                            <td><?= $newdokver[2]['JENIS_DOKUMEN']; ?></td>
                            <td><input type="file" name="dokumen3" id="dokumen3" data-plugin="dropify" data-height="60"></td>
                          </tr>
                          <tr>
                            <td><?= $newdokver[3]['JENIS_DOKUMEN']; ?></td>
                            <td><input type="file" name="dokumen4" id="dokumen4" data-plugin="dropify" data-height="60"></td>
                          </tr>
                          <tr>
                            <td><?= $newdokver[4]['JENIS_DOKUMEN']; ?></td>
                            <td><input type="file" name="dokumen5" id="dokumen5" data-plugin="dropify" data-height="60"></td>
                          </tr>
                        <?php } ?>
                        </table>
                      </div>
                    </div>
                    <div class="progress my-10">
                      <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 60%" role="progressbar">
                      </div>
                    </div>
                  </div>
                  <div class="tab">
                    Nomor Pendaftaran
                    <input type="text" name="no_pendaftaran" value="<?= $diajukan['NOMOR_PENDAFTAR']; ?>" id="no_pendaftaran" class="form-control"></input>

                    <?php
                    if ($diajukan['TAHUN_PENDAFTAR'] == 0) {
                      $diajukan['TAHUN_PENDAFTAR'] = "";
                    }
                    ?>
                    Tahun Pendaftaran
                    <input type="text" name="thn_pendaftaran" value="<?= $diajukan['TAHUN_PENDAFTAR'] ?>" id="thn_pendaftaran" class="form-control"></input>

                    <?php
                    if ($diajukan['TAHUN_GRANTED'] == 0) {
                      $diajukan['TAHUN_GRANTED'] = "";
                    }
                    ?>
                    Tahun Granted
                    <input type="text" name="thn_granted" value="<?= $diajukan['TAHUN_GRANTED'] ?>" id="thn_granted" class="form-control"></input>

                    Nomor Desain Industri
                    <input type="text" name="no_desain" value="<?= $diajukan['NOMOR_DESAIN'] ?>" id="no_desain" class="form-control"></input>

                    <?php
                    $sertifikasi =  $diajukan['SERTIFIKASI'];
                    if ($sertifikasi != "" && $sertifikasi != '1970-01-01') {
                      $tgl_sertifikasi = date("d-m-Y", strtotime($sertifikasi));
                    } else {
                      $tgl_sertifikasi = "";
                    }
                    ?>
                    Status
                    <select id="status" class="form-control my-10 stat" name="status" data-fv-notempty="true">
                      <?php foreach ($status as $st) {
                        if ($diajukan['STATUS'] == $st['ID']) {
                          echo '<option selected value="' . $st['ID'] . '">' . $st['NAMA_REV'] . '</option>';
                        } else {
                          echo '<option value="' . $st['ID'] . '">' . $st['NAMA_REV'] . '</option>';
                        }
                      }
                      ?>
                    </select>

                    <div class="progress my-10">
                      <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 80%" role="progressbar">
                      </div>
                    </div>
                  </div>
                  <div class="tab">

                    Keterangan
                    <textarea input type="text" name="keterangan" id="keterangan" class="form-control"><?= $diajukan['KETERANGAN']; ?></textarea>
                    <div class="progress my-10">
                      <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 100%" role="progressbar">
                      </div>
                    </div>
                  </div>
                  <div style="overflow:auto;">
                    <div style="float:left;">
                      <button class="btn btn-primary" type="button" id="prevBtn" onclick="nextPrev(-1)"><i class="fa fa-chevron-circle-left"></i></button>
                    </div>
                    <div style="float:right;">
                      <button class="btn btn-primary" type="button" id="nextBtn" onclick="nextPrev(1)"><i class="fa fa-chevron-circle-right"></i></button>
                    </div>
                  </div>

                </form>
                <form>


              </div>
            </div>
          </div>
        </div>
        <!-- End Panel Tabs -->

      </div>
    </div>

    <script src="<?= base_url('assets/') ?>global/vendor/jquery/jquery.js"></script>
    <script src="<?= base_url('assets/') ?>global/vendor/bootbox/bootbox.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {

        $('.datepicker').datepicker({
          format: 'dd-mm-yyyy'
        });



        $(".add-row").click(function() {
          var jml = $('#jumlah').val();
          for (i = 0; i < jml; i++) {
            var row = $('#mytable').find('tr').length;
            var nextRow = row + 1;
            var markup = "<tr><td><input name='nama_" + nextRow + "' id='nama_" + nextRow + "' type='text' class='form-control' placeholder='Nama Kepegawaian'></input></td></tr>";

            $("#mytable").append(markup);
          }
        });

        // Find and remove selected table rows
        $(".delete-row").click(function() {
          $("table tbody").find('input[name="record"]').each(function() {
            if ($(this).is(":checked")) {
              $(this).parents("tr").remove();
            }
          });
        });


      });

      var currentTab = 0; // Current tab is set to be the first tab (0)
      showTab(currentTab); // Display the current tab

      function showTab(n) {
        // This function will display the specified tab of the form...
        var x = document.getElementsByClassName("tab");
        x[n].style.display = "block";
        //... and fix the Previous/Next buttons:
        if (n == 0) {
          document.getElementById("prevBtn").style.display = "none";
        } else {
          document.getElementById("prevBtn").style.display = "inline";
        }
        if (n == (x.length - 1)) {
          document.getElementById("nextBtn").innerHTML = "Submit";
        } else {
          document.getElementById("nextBtn").innerHTML = "<i class='fa fa-chevron-circle-right'></i>";
        }
        //... and run a function that will display the correct step indicator:
        fixStepIndicator(n)
      }

      function nextPrev(n) {
        // This function will figure out which tab to display
        var x = document.getElementsByClassName("tab");
        // Exit the function if any field in the current tab is invalid:
        if (n == 1 && !validateForm()) return false;
        // Hide the current tab:
        x[currentTab].style.display = "none";
        // Increase or decrease the current tab by 1:
        currentTab = currentTab + n;
        // if you have reached the end of the form...
        if (currentTab >= x.length) {
          // ... the form gets submitted:
          document.getElementById("regForm").submit();
          return false;
        }
        // Otherwise, display the correct tab:
        showTab(currentTab);
      }

      function validateForm() {
        // This function deals with validation of the form fields
        var x, y, i, valid = true;
        x = document.getElementsByClassName("tab");
        y = x[currentTab].getElementsByTagName("input");
        s = x[currentTab].getElementsByClassName("stat");
        sid = document.getElementById("status");

        //Validasi Combobox                
        if (s.length) {
          if (sid.value == "") {
            // add an "invalid" class to the field:
            sid.className += " text-danger";
            // and set the current valid status to false
            valid = false;
          }
        }

        return valid; // return the valid status
      }


      function check_jumlah() {
        var jml = $('#jumlah').val();

        if (jml > 20) {
          alert('Jumlah melebihi batas!');
          $('#jumlah').val('');
        }
      }
    </script>