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
    input.invalid {
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
                <h3 class="panel-title">Manajemen Pengajuan Desain Industri</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-xl-6">
                        <form id="regForm" enctype="multipart/form-data" method="post" action="<?= base_url('desain/save');  ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <!-- One "tab" for each step in the form: -->
                            <div class="tab">
                                <?= $this->session->flashdata('message'); ?>
                                <!-- tambah class inputfield untuk validasi -->
                                <input type="hidden" class="inputfield form-control" name="ipman_code" id="ipman_code" value="<?= $ipmancode ?>" readonly>
                                Judul
                                <textarea class="inputfield form-control" input placeholder="Judul..." name="judul" id="judul"></textarea>
                                Unit Kerja
                                <select id="unit_kerja" class="form-control my-10" name="unit_kerja" onchange="this.className" data-fv-notempty="true">
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
                                Jumlah Tambahan Pendesain
                                <input type="text" name="jumlah_pendesain" id="jumlah_pendesain" onkeyup="check_jumlah()" placeholder="(Max 20)" class="form-control"></input>
                                <input type="button" class="add-row btn btn-info my-5 right" value="Tambah Nama">

                                <table class="table table-bordered mytable" id="mytable">
                                    <tr>
                                        <td>
                                            <select name="pendesain[1][nik]" id="nik_1" class="selectfield form-control">
                                                <option value="">Pilih Pendesain Utama</option>
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
                                            <a type="button" href="<?= base_url('desain/input_pendesain') ?>" class="my-5 btn btn-success btn-sm">Add</a>
                                        </td>
                                    </tr>
                                    <small>Jika Pendesain Non Pegawai belum terdaftar klik tombol Add!</small>
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
                                        foreach ($dokdesain as $dok) {
                                            ?>
                                            <h5>Jenis Dokumen (<?= $dok['JENIS_DOKUMEN']; ?>)</h5>
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
            var jml = $('#jumlah_pendesain').val();
            var rowtbl = $('#mytable').find('tr').length;

            if (jml <= 20 - rowtbl) {
                for (i = 0; i < jml; i++) {
                    var row = $('#mytable').find('tr').length;
                    var nextRow = row + 1;
                    var markup = "<tr><td><select name='pendesain[" + nextRow + "][nik]' id='kode_" + nextRow + "' class='selectfield form-control'><option value=''>Kode Kepegawaian</option>";
                    <?php foreach ($pegawai as $pg) : ?>
                        markup += "<option value='<?php echo $pg['NIK'] ?>'><?php echo $pg['KODE_KEPEGAWAIAN'] . ' - ' . $pg['NAMA']; ?></option>";
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
            var markup = "<tr><td><select name='pendesain[" + nextRow + "][nik]' id='nik_" + nextRow + "' class='selectfield form-control'><option value=''>Pilih Pendesain</option>";
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
            var markup = "<tr id='tr_" + nextRow + "'><td><select name='pendesain[" + nextRow + "][nik]' id='nik_" + nextRow + "' class='selectfield form-control'><option value=''>Pilih Pendesain Non Pegawai</option>";
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
        inp = x[currentTab].getElementsByClassName("inputfield");
        sel = x[currentTab].getElementsByClassName("selectfield");
        j = document.getElementById("judul");
        u = document.getElementById("unit_kerja");
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
            u.className += " text-danger invalid-feedback";
            // and set the current valid status to false
            valid = false;
        }

        return valid; // return the valid status
    }

    function check_jumlah() {
        var jml = $('#jumlah_pendesain').val();

        if (jml > 20) {
            alert('Jumlah melebihi batas!');
            $('#jumlah_pendesain').val('');
        }
    }
</script>