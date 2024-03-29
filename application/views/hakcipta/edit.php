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
                <h3 class="panel-title">Manajemen Pengajuan Hakcipta</h3>
            </div>
            <div class="panel-body container-fluid">
                <div class="row row-lg">
                    <div class="col-xl-6">
                        <form id="regForm" enctype="multipart/form-data" method="post" action="<?= base_url('hakcipta/update');  ?>">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" style="display: none">
                            <!-- One "tab" for each step in the form: -->
                            <?= $this->session->flashdata('message'); ?>
                            <div class="tab">
                                <!-- tambah class inputfield untuk validasi -->
                                <input type="hidden" class="inputfield form-control" value="<?= $draft['ipman_code']; ?>" name="ipman_code" id="" readonly>
                                <input type="hidden" name="id" value="<?= $hakciptaid ?>">
                                Judul
                                <textarea class="inputfield form-control" input placeholder="Judul..." name="judul" id="judul"><?= $draft['judul'] ?></textarea>
                                Unit Kerja
                                <select id="unit_kerja" class="form-control my-10" name="unit_kerja" onchange="this.className" data-fv-notempty="true">
                                    <?php foreach ($unitkerja as $uk) {
                                        if ($draft['unit_kerja'] == $uk['id']) {
                                            echo '<option selected value="' . $uk['id'] . '">' . $uk['nama_rev'] . '</option>';
                                        } else {
                                            echo '<option value="' . $uk['id'] . '">' . $uk['nama_rev'] . '</option>';
                                        }
                                    } ?>
                                </select>
                                Objek
                                <select id="object" class="form-control my-10" name="object" onchange="this.className" data-fv-notempty="true">
                                    <?php foreach ($object as $ob) {
                                        if ($draft['object'] == $ob['id']) {
                                            echo '<option selected value="' . $ob['id'] . '">' . $ob['nama_rev'] . '</option>';
                                        } else {
                                            echo '<option value="' . $ob['id'] . '">' . $ob['nama_rev'] . '</option>';
                                        }
                                    } ?>
                                </select>
                                <div class="progress msy-10">
                                    <div class="progress-bar progress-bar-striped active" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width: 35%" role="progressbar">
                                    </div>
                                </div>

                            </div>
                            <div class="tab">
                                No Handhone
                                <input type="text" class="inputfield form-control" name="no_handphone" id="no_handphone" value="<?= $draft['no_handphone']; ?>">
                                Jumlah Pencipta
                                <?php
                                $totalPegawai = count($pencipta);
                                ?>
                                <input type="text" class="form-control" id="jumlah_pencipta" value="<?= $totalPegawai ?>" readonly></input>
                                <table class="table table-bordered mytable mt-10" id="mytable">
                                    <?php $i = 1; ?>
                                    <?php foreach ($pencipta as $penc) { ?>
                                        <tr>
                                            <td>
                                                <select name='pencipta[<?= $n; ?>][nik]' class="selectfield form-control">
                                                    <?php foreach ($pegawai as $p) {
                                                            if ($penc['nik'] == $p['nik']) {
                                                                echo '<option selected value="' . $p['nik'] . '">' . $p['nik'] . ' - '  . $p['nama'] . '</option>';
                                                            } else {
                                                                echo '<option value="' . $p['nik'] . '">'  . $p['nik'] . ' - ' . $p['nama'] . '</option>';
                                                            }
                                                        } ?>
                                                    <?php foreach ($nonpegawai as $np) {
                                                            if ($penc['NIK'] == $np['nik']) {
                                                                echo '<option selected value="' . $np['nik'] . '">' . $np['nik'] . ' - '  . $np['nama'] . '</option>';
                                                            } else {
                                                                echo '<option value="' . $np['nik'] . '">'  . $np['nik'] . ' - ' . $np['nama'] . '</option>';
                                                            }
                                                        } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <?php if ($i != 1) { ?>
                                                    <button class='btn btn-sm btn-danger remRow'><i class='fa fa-trash'></i>
                                                    </button>
                                                <?php } else { ?>
                                                    <button type="button" class='btn btn-sm btn-info add-row'><i class='fa fa-user-plus'></i>
                                                    </button>
                                                    <button type="button" class='btn btn-sm btn-warning add-row-non'><i class='fa fa-user-plus'></i>
                                                    </button>
                                                <?php } ?>
                                            </td>
                                            <?php $i++; ?>
                                        <?php } ?>
                                        </tr>


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
                                        $i = 0;
                                        $j = 1;
                                        foreach ($dokumen as $dok) {
                                            ?>
                                            <h4 class="table-info">Jenis Dokumen (<?= $dok['jenis_dokumen']; ?>)</h4>
                                            <?php if ($dok['size'] > 0) { ?>
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-sm-5">
                                                            <h5 class="text-center">Dokumen Terunggah</h5>
                                                            <a class="btn btn-default" target="_blank" href="<?= base_url('assets/dokumen/dokumen_hakcipta/') . $dok['name'] ?>"><i class="fa fa-eye"></i> Lihat Dokumen</a>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <h5 class="text-center">Ganti Dokumen</h5>
                                                            <input type="file" name="dokumen<?= $j ?>" data-plugin="dropify" data-height="60">
                                                            <input type="hidden" name="jenis_dokumen<?= $j ?>" id="dokumen<?= $j; ?>" value="<?= $dok['jenis_dokumen'] ?>">
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } else { ?>
                                                <input type="file" name="dokumen<?= $j ?>" data-plugin="dropify" data-height="75">
                                                <input type="hidden" name="jenis_dokumen<?= $j ?>" id="dokumen<?= $j; ?>" value="<?= $dok['jenis_dokumen'] ?>">
                                        <?php }
                                            $i++;
                                            $j++;
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
            var row = $('#mytable').find('tr').length;
            var nextRow = row + 1;
            var markup = "<tr id='tr_" + nextRow + "'><td><select name='pencipta[" + nextRow + "][nik]' id='kode_" + nextRow + "' class='selectfield form-control'><option value=''>Pilih Pencipta</option>";
            <?php foreach ($pegawai as $pg) : ?>
                markup += "<option value='<?php echo $pg['nik'] ?>'><?php echo $pg['kode_kepegawaian'] . ' - ' . $pg['nama']; ?></option>";
            <?php endforeach; ?>
            markup += "</select></td>";
            markup += "<td><button class='btn btn-danger remRow'><i class='fa fa-trash'></i>\
                    </button></td></tr>";

            if (nextRow <= 20) {
                $("#mytable").append(markup);
            } else {
                alert('Jumlah melebihi batas')
            }

            var row2 = $('#mytable').find('tr').length;
            $("#jumlah_pencipta").val(row2);
        });

        $(".add-row-non").click(function() {
            var row = $('#mytable').find('tr').length;
            var nextRow = row + 1;
            var markup = "<tr id='tr_" + nextRow + "'><td><select name='pencipta[" + nextRow + "][nik]' id='nik_" + nextRow + "' class='selectfield form-control'><option value=''>Pilih Pencipta Non Pegawai</option>";
            <?php foreach ($nonpegawai as $npg) : ?>
                markup += "<option value='<?php echo $npg['nik'] ?>'><?= $npg['nama']; ?></option>";
            <?php endforeach; ?>
            markup += "</select></td>";
            markup += "<td><button class='btn btn-danger remRow'><i class='fa fa-trash'></i>\
                    </button></td></tr>";

            if (nextRow <= 20) {
                $("#mytable").append(markup);
            } else {
                alert('Jumlah melebihi batas')
            }

            var row2 = $('#mytable').find('tr').length;
            $("#jumlah_pencipta").val(row2);
        });

        //Menghapus Kolom
        $(".mytable").on('click', '.remRow', function() {
            var num_rows = $("#mytable tr").length;
            if (num_rows == 0) {
                return false;
            } else {
                $(this).parent().parent().remove();
            }
            //hitung jumlah setelah delete
            var num_rows2 = $("#mytable tr").length;
            $("#jumlah_pencipta").val(num_rows2);
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
        inp = x[currentTab].getElementsByClassName("inpfield");
        sel = x[currentTab].getElementsByClassName("selectfield");
        j = document.getElementById("judul");
        u = document.getElementById("unit_kerja");
        jp = document.getElementById("jumlah_pencipta");
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

        //cek kepegawaian kosong
        for (i = 0; i < sel.length; i++) {
            // If a field is empty...
            if (sel[i].value == "") {
                // add an "invalid" class to the field:
                sel[i].className += " text-danger";
                // and set the current valid status to false
                valid = false;
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
        var jml = $('#jumlah_pencipta').val();

        if (jml > 20) {
            alert('Jumlah melebihi batas!');
            $('#jumlah_pencipta').val('');
        }
    }
</script>