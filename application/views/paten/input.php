<style>
    body {
        background-color: #f1f1f1;
    }

    input {
        padding: 10px;
        width: 100%;
        font-size: 17px;
        font-family: Raleway;
        border: 1px solid #aaaaaa;
    }

    /* Mark input boxes that gets an error on validation: */
    .input.invalid {
        background-color: #ffdddd;
    }


    /* Mark input boxes that gets an error on validation: */
    .inputfield.invalid {
        background-color: #ffdddd;
    }

    .textempty {
        background-color: #ffdddd;
    }

    /* Hide all steps by default: */
    .tab {
        display: none;
    }


    button:hover {
        opacity: 0.8;
    }
</style>

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
                    <div class="col-xl-6">
                        <form id="regForm" enctype="multipart/form-data" method="post" action="<?= base_url('paten/save');  ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <!-- One "tab" for each step in the form: -->
                            <?= $this->session->flashdata('message'); ?>
                            <div class="tab">
                                <!-- tambah class inputfield untuk validasi -->
                                Jenis Paten
                                <select id="jenis_paten" class="form-control my-10" name="jenis_paten" value="<?= set_value('jenis_paten'); ?>">
                                    <option value="">Pilih Jenis Paten</option>
                                    <?php foreach ($jenispaten as $jp) : ?>
                                        <option value="<?= $jp['ID']; ?>"><?= $jp['NAMA_REV'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                Judul
                                <textarea class="inputfield form-control my-10 " input placeholder="Judul..." name="judul" id="judul"></textarea>
                                Abstrak
                                <small class="text-primary">*ekstensi txt</small>
                                <input class="my-10" type="file" name="abstrak" data-plugin="dropify" data-height="75">
                                <?= $this->session->flashdata('message_errorabs'); ?>
                                Gambar yang ingin ditampilkan
                                <small class="text-primary">*ekstensi jpg</small>
                                <input type="file" name="gambar" data-plugin="dropify" data-height="75" class="my-10">
                                <?= $this->session->flashdata('message_errorgam'); ?>
                                Bidang Invensi
                                <input type="text" class="inputfield form-control my-10" name="bidang_invensi" id="bidang_invensi" placeholder="Bidang Invensi" value="<?= set_value('bidang_invensi'); ?>">
                                Unit Kerja
                                <select id="unit_kerja" class="form-control my-10" name="unit_kerja">
                                    <option value="">Pilih Unit Kerja</option>
                                    <?php foreach ($unitkerja as $uk) : ?>
                                        <option value="<?= $uk['ID']; ?>"><?= $uk['NAMA_REV'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="progress my-10">
                                    <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 35%" role="progressbar">
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                No Handhone
                                <input type="text" class="inputfield form-control" name="no_handphone" id="no_handphone" placeholder="No Handphone">
                                Jumlah Tambahan Inventor
                                <input type="text" class="form-control" name="jumlah_inventor" id="jumlah_inventor" onkeyup="check_jumlah()" placeholder="(Max 20)" class="form-control"></input>
                                <input type="button" class="add-row btn btn-info my-5 right" value="Tambah Nama">

                                <table class="table table-bordered mytable" id="mytable">
                                    <tr>
                                        <td>
                                            <select id="nik_1" class="selectfield form-control " name="inventor[1][nik]">
                                                <option value="">Pilih Inventor Utama</option>
                                                <?php foreach ($pegawai as $peg) { ?>
                                                    <option value="<?= $peg['NIK'] ?>"><?= $peg['KODE_KEPEGAWAIAN']; ?> - <?= $peg['NAMA']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td>
                                            <button type="button" class='btn btn-sm btn-info add-row-one'><i class='fa fa-user-plus'></i>
                                            </button>
                                            <button type="button" class='btn btn-sm btn-warning add-row-non'><i class='fa fa-user-plus'></i>
                                            </button>
                                            <a type="button" href="<?= base_url('paten/input_inventor') ?>" class="my-5 btn btn-success btn-sm">Add</a>
                                        </td>
                                    </tr>
                                    <small>Jika Inventor Non Pegawai belum terdaftar klik tombol Add!</small>
                                </table>

                                <div class="progress my-10">
                                    <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 70%" role="progressbar">
                                    </div>
                                </div>
                            </div>
                            <div class="tab">
                                <div class="row row-lg my-10">
                                    <div class="col-md-12 text-center">
                                        <?php
                                        $i = 1;
                                        foreach ($dokpaten as $dok) {
                                            ?>
                                            <h5>Jenis Dokumen (<?= $dok['JENIS_DOKUMEN']; ?>) </h5>
                                            <input type="file" name="dokumen<?= $i; ?>" id="dokumen<?= $i; ?>" data-plugin="dropify" data-height="75">
                                            <input type="hidden" name="jenis_dokumen<?= $i ?>" id="dokumen<?= $i; ?>" value="<?= $dok['ID'] ?>">
                                        <?php $i++;
                                        } ?>

                                    </div>

                                </div>
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
                    </div>
                    <div class="col-xl-6">
                        <!-- Example Default Accordion -->

                        <h4><b>Keterangan</b></h4>
                        <div class="example">
                            <div class="panel-group" id="exampleAccordionDefault" aria-multiselectable="true" role="tablist">

                                <div class="panel">
                                    <div class="panel-heading" id="exampleHeadingDefaultThree" role="tab">
                                        <a class="panel-title collapsed" data-toggle="collapse" href="#exampleCollapseDefaultThree" data-parent="#exampleAccordionDefault" aria-expanded="false" aria-controls="exampleCollapseDefaultThree">
                                            <b>Upload Dokumen</b>
                                        </a>
                                    </div>
                                    <div class="panel-collapse collapse" id="exampleCollapseDefaultThree" aria-labelledby="exampleHeadingDefaultThree" role="tabpanel">
                                        <div class="panel-body">
                                            <table class="table">

                                                <thead>
                                                    <tr>
                                                        <th>Dokumen</th>
                                                        <th>Keterangan</th>
                                                    </tr>
                                                </thead>

                                                <tr>
                                                    <td>Nodin</td>
                                                    <td>Upload type pdf</td>
                                                </tr>
                                                <tr>
                                                    <td>Surat Pernyataan Kepemilikan Hak</td>
                                                    <td>Upload type pdf</td>
                                                </tr>
                                                <tr>
                                                    <td>Surat Pernyataan Pengalihan Hak</td>
                                                    <td>Upload type pdf</td>
                                                </tr>
                                                <tr>
                                                    <td>KTP Inventor</td>
                                                    <td>Disusun dalam satu file doc</td>
                                                </tr>
                                                <tr>
                                                    <td>Formulir Penilaian ATB</td>
                                                    <td>Upload type pdf</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Example Default Accordion -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Panel Tabs -->

    </div>
</div>

<script src="<?= base_url('assets/') ?>global/vendor/jquery/jquery.js"></script>
<script src="<?= base_url('assets/jscustom/'); ?>ValidasiHandphone.js"></script>
<script type="text/javascript">
    $(document).ready(function() {


        $(".add-row").click(function() {
            var jml = $('#jumlah_inventor').val();
            var rowtbl = $('#mytable').find('tr').length;

            if (jml <= 20 - rowtbl) {
                for (i = 0; i < jml; i++) {
                    var row = $('#mytable').find('tr').length;
                    var nextRow = row + 1;
                    var markup = "<tr><td><select name='inventor[" + nextRow + "][nik]' id='nik_" + nextRow + "' class='selectfield form-control'><option value=''>Pilih Inventor</option>";
                    <?php foreach ($pegawai as $pg) : ?>
                        markup += "<option value='<?php echo $pg['NIK'] ?>'><?php echo $pg['NIK'] . ' - ' . $pg['NAMA']; ?></option>";
                    <?php endforeach; ?>
                    markup += "</select></td>";
                    markup += "<td><button class='btn btn-danger remRow'><i class='fa fa-trash'></i>\
                        </button></td></tr>";

                    $("#mytable").append(markup);
                }
            } else {
                alert('Jumlah melebihi batas');
            }

        });

        $(".add-row-one").click(function() {
            var row = $('#mytable').find('tr').length;
            var nextRow = row + 1;
            var markup = "<tr><td><select name='inventor[" + nextRow + "][nik]' id='nik_" + nextRow + "' class='selectfield form-control'><option value=''>Pilih Inventor</option>";
            <?php foreach ($pegawai as $pg) : ?>
                markup += "<option value='<?php echo $pg['NIK'] ?>'><?php echo $pg['NIK'] . ' - ' . $pg['NAMA']; ?></option>";
            <?php endforeach; ?>
            markup += "</select></td>";
            markup += "<td><button class='btn btn-danger remRow'><i class='fa fa-trash'></i>\
                        </button></td></tr>";

            if (nextRow <= 20) {
                $("#mytable").append(markup);
            } else {
                alert('Jumlah melebihi batas')
            }
        });

        $(".add-row-non").click(function() {
            var row = $('#mytable').find('tr').length;
            var nextRow = row + 1;
            var markup = "<tr id='tr_" + nextRow + "'><td><select name='inventor[" + nextRow + "][nik]' id='nik_" + nextRow + "' class='selectfield form-control'><option value=''>Pilih Inventor Non Pegawai</option>";
            <?php foreach ($nonpegawai as $npg) : ?>
                markup += "<option value='<?php echo $npg['NIK'] ?>'><?= $npg['NAMA']; ?></option>";
            <?php endforeach; ?>
            markup += "</select></td>";
            markup += "<td><button class='btn btn-danger remRow'><i class='fa fa-trash'></i>\
                    </button></td></tr>";

            if (nextRow <= 20) {
                $("#mytable").append(markup);
            } else {
                alert('Jumlah melebihi batas')
            }
        });

        //Menghapus Kolom
        $(".mytable").on('click', '.remRow', function() {
            var num_rows = $("#mytable tr").length;
            if (num_rows == 0) {
                return false;
            } else {
                $(this).parent().parent().remove();
            }
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
        // Tambahkan  !validateForm() setelah n == 1 && untuk validasi
        //if (n == 1 && !validateForm()) return false;
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
        var x, y, i, z, valid = true;
        x = document.getElementsByClassName("tab");
        inp = x[currentTab].getElementsByClassName("inputfield");
        sel = x[currentTab].getElementsByClassName("selectfield");
        tab = x[currentTab].getElementsByClassName("mytable");
        j = document.getElementById("judul");
        jp = document.getElementById("jenis_paten");
        u = document.getElementById("unit_kerja");
        ji = document.getElementById("jumlah_inventor");
        // A loop that checks every input field in the current tab:
        for (i = 0; i < inp.length; i++) {
            // If a field is empty...
            if (inp[i].value == "") {
                // add an "invalid" class to the field:
                inp[i].className += " invalid";
                // and set the current valid status to false
                valid = false;
            }
        }

        // A loop that checks every select field in the current tab:
        for (i = 0; i < sel.length; i++) {
            // If a field is empty...
            if (sel[i].value == "") {
                // add an "invalid" class to the field:
                sel[i].className += " text-danger";
                // and set the current valid status to false
                valid = false;
            } else {
                sel[i].className = " selectfield form-control";
            }
        }

        if (tab.value == "") {
            // add an "invalid" class to the field:
            tab.className += " invalid";
            // and set the current valid status to false
            valid = false;
        }
        //cek jenis paten kosong
        if (jp.value == "") {
            // add an "invalid" class to the field:
            jp.className += " text-danger";
            // and set the current valid status to false
            valid = false;
        }
        //cek judul kosong
        if (j.value == "") {
            // add an "invalid" class to the field:
            j.className += " textempty";
            // and set the current valid status to false
            valid = false;
        }
        //cek unit kosong
        if (u.value == "") {
            // add an "invalid" class to the field:
            u.className += " text-danger";
            // and set the current valid status to false
            valid = false;
        }

        return valid; // return the valid status
    }

    function check_jumlah() {
        var jml = $('#jumlah_inventor').val();

        if (jml > 20) {
            alert('Jumlah melebihi batas!');
            $('#jumlah_inventor').val('');
        }
    }
</script>