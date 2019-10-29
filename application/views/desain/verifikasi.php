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
                    <input type="hidden" name="id" value="<?= $diajukan['id'] ?>">
                    Ip-Man Code
                    <input name="ipman_code" class="form-control" value="<?= $diajukan['ipman_code']; ?>" id="" readonly>
                    Judul
                    <textarea class="form-control" name="judul" id="judul" readonly><?= $diajukan['judul'] ?> </textarea>
                    Unit Kerja
                    <input class="form-control" value="<?= $diajukan['unit_kerja']; ?>" name="unit_kerja" id="unit_kerja" readonly>
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
                            if ($des['nik'] == $p['nik']) {
                              ?>
                            <tr>
                              <td><?= $p['nama'] ?></td>
                            </tr>
                        <?php }
                          } ?>

                        <?php foreach ($nonpegawai as $np) {
                            if ($des['nik'] == $np['nik']) {
                              ?>
                            <tr>
                              <td><?= $np['nama'] ?></td>
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
                    $sertifikasi =  $diajukan['sertifikasi'];
                    if ($sertifikasi != "" && $sertifikasi != '1970-01-01') {
                      $tgl_sertifikasi = date("d-m-Y", strtotime($sertifikasi));
                    } else {
                      $tgl_sertifikasi = "";
                    }
                    ?>
                    <input type="text" name="tgl_sertifikasi" id="tgl_sertifikasi" value="<?= $tgl_sertifikasi; ?>" class="datepicker form-control">
                    Pemeriksa Desain
                    <input class="form-control" name="pemeriksa_desain" value="<?= $diajukan['pemeriksa_desain']; ?>" id="pemeriksa_desain">
                    Kontak Pemeriksa
                    <input class="form-control" name="kontak_pemeriksa" value="<?= $diajukan['kontak_pemeriksa']; ?>" id="kontak_pemeriksa">
                    Email Pemeriksa
                    <input class="form-control" name="email_pemeriksa" value="<?= $diajukan['email_pemeriksa']; ?>" id="email_pemeriksa">
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
                              <td><?= $dok['jenis_dokumen'] ?></td>
                              <td>
                                <?php if ($dokumen[$d]['size'] > 0) { ?>
                                  <a class="btn btn-xs btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_paten/') . $dokumen[$d]['nama'] ?>"><i class="fa fa-download"></i></a>
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
                                <?php if ($dokver[0]['size'] > 0) { ?>
                                  <?php $dokumen1 = $dokver[0]['name'] ?>
                                  <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen1 ?>"><i class="fa fa-download"></i></a>
                                  <input type="hidden" name="currentfile1" value="<?= $dokver[0]['name']; ?>">
                                <?php } else { ?>
                                  <input type="file" name="dokumen1" id="dokumen1" data-plugin="dropify" data-height="60">
                                <?php } ?>
                              </td>
                          </tr>
                          <tr>
                            <td>Dokumen 2</td>
                            <td>
                              <?php if ($dokver[1]['size'] > 0) { ?>
                                <?php $dokumen2 = $dokver[1]['name'] ?>
                                <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen2 ?>"><i class="fa fa-download"></i></a>
                              <?php } else { ?>
                                <input type="file" name="dokumen2" id="2" data-plugin="dropify" data-height="60">
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                            <td>Dokumen 3</td>
                            <td>
                              <?php if ($dokver[2]['size'] > 0) { ?>
                                <?php $dokumen3 = $dokver[2]['name'] ?>
                                <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen3 ?>"><i class="fa fa-download"></i></a>
                              <?php } else { ?>
                                <input type="file" name="dokumen3" id="dokumen3" data-plugin="dropify" data-height="60">
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                            <td>Dokumen 4</td>
                            <td>
                              <?php if ($dokver[3]['size'] > 0) { ?>
                                <?php $dokumen4 = $dokver[3]['name'] ?>
                                <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen4 ?>"><i class="fa fa-download"></i></a>
                              <?php } else { ?>
                                <input type="file" name="dokumen4" id="dokumen4" data-plugin="dropify" data-height="60">
                              <?php } ?>
                            </td>
                          </tr>
                          <tr>
                            <td>Dokumen 5</td>
                            <td>
                              <?php if ($dokver[4]['size'] > 0) { ?>
                                <?php $dokumen5 = $dokver[4]['name'] ?>
                                <a class="btn btn-info" target="_blank" href="<?= base_url('./assets/dokumen/dokumen_verifikator/') . $dokumen5 ?>"><i class="fa fa-download"></i></a>
                              <?php } else { ?>
                                <input type="file" name="dokumen5" id="dokumen5" data-plugin="dropify" data-height="60">
                              <?php } ?>
                            </td>
                          </tr>


                        <?php } else { ?>

                          <tr>
                            <td>
                              <?php 
                                if(!empty( $newdokver[0]['jenis_dokumen'])){
                                  echo $newdokver[0]['jenis_dokumen'];
                                }
                              ?>  
                            </td>
                            <td><input type="file" name="dokumen1" id="dokumen1" data-plugin="dropify" data-height="60"></td>
                          </tr>
                          <tr>
                            <td>
                              <?php 
                                if(!empty( $newdokver[1]['jenis_dokumen'])){
                                  echo $newdokver[1]['jenis_dokumen'];
                                }
                              ?>  
                            </td>
                            <td><input type="file" name="dokumen2" id="dokumen2" data-plugin="dropify" data-height="60"></td>
                          </tr>
                          <tr>
                            <td>
                              <?php 
                                if(!empty( $newdokver[2]['jenis_dokumen'])){
                                  echo $newdokver[2]['jenis_dokumen'];
                                }
                              ?>  
                            </td>
                            <td><input type="file" name="dokumen3" id="dokumen3" data-plugin="dropify" data-height="60"></td>
                          </tr>
                          <tr>
                            <td>
                              <?php 
                                if(!empty( $newdokver[3]['jenis_dokumen'])){
                                  echo $newdokver[3]['jenis_dokumen'];
                                }
                              ?>  
                            </td>
                            <td><input type="file" name="dokumen4" id="dokumen4" data-plugin="dropify" data-height="60"></td>
                          </tr>
                          <tr>
                            <td>
                              <?php 
                                if(!empty( $newdokver[4]['jenis_dokumen'])){
                                  echo $newdokver[4]['jenis_dokumen'];
                                }
                              ?>  
                            </td>
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
                    <input type="text" name="no_pendaftaran" value="<?= $diajukan['nomor_pendaftar']; ?>" id="no_pendaftaran" class="form-control"></input>

                    <?php
                    if ($diajukan['tahun_pendaftar'] == 0) {
                      $diajukan['tahun_pendaftar'] = "";
                    }
                    ?>
                    Tahun Pendaftaran
                    <input type="text" name="thn_pendaftaran" value="<?= $diajukan['tahun_pendaftar'] ?>" id="thn_pendaftaran" class="form-control"></input>

                    <?php
                    if ($diajukan['tahun_granted'] == 0) {
                      $diajukan['tahun_granted'] = "";
                    }
                    ?>
                    Tahun Granted
                    <input type="text" name="thn_granted" value="<?= $diajukan['tahun_granted'] ?>" id="thn_granted" class="form-control"></input>

                    Nomor Desain Industri
                    <input type="text" name="no_desain" value="<?= $diajukan['nomor_desain'] ?>" id="no_desain" class="form-control"></input>

                    <?php
                    $sertifikasi =  $diajukan['sertifikasi'];
                    if ($sertifikasi != "" && $sertifikasi != '1970-01-01') {
                      $tgl_sertifikasi = date("d-m-Y", strtotime($sertifikasi));
                    } else {
                      $tgl_sertifikasi = "";
                    }
                    ?>
                    Status
                    <select id="status" class="form-control my-10 stat" name="status" data-fv-notempty="true">
                      <?php foreach ($status as $st) {
                        if ($diajukan['status'] == $st['id']) {
                          echo '<option selected value="' . $st['id'] . '">' . $st['nama_rev'] . '</option>';
                        } else {
                          echo '<option value="' . $st['id'] . '">' . $st['nama_rev'] . '</option>';
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
                    <textarea input type="text" name="keterangan" id="keterangan" class="form-control"><?= $diajukan['keterangan']; ?></textarea>
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