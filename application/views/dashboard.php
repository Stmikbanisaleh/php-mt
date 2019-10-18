<div class="page">
    <div class="page-content container-fluid">
        <div class="panel">
            <div class="panel-body">
                <div class="row row-lg">
                    <div class="col-lg">
                        <h4>Kekayaan Intelektual</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <!-- Card -->
                                <div class="card card-block p-10 bg-blue-600">
                                    <div class="card-watermark darker font-size-70 m-15"><i class="icon wb-clipboard" aria-hidden="true"></i></div>
                                    <div class="counter counter-md counter-inverse text-left">
                                        <div class="counter-number-group">
                                            <span class="counter-number"><?= $jumlahPaten; ?></span>
                                        </div>
                                        <h4 class="text-white">Paten</h4>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>
                            <div class="col-lg-3">
                                <!-- Card -->
                                <div class="card card-block p-10 bg-grey-600">
                                    <div class="card-watermark darker font-size-70 m-15"><i class="icon wb-clipboard" aria-hidden="true"></i></div>
                                    <div class="counter counter-md counter-inverse text-left">
                                        <div class="counter-number-group">
                                            <span class="counter-number"><?= $jumlahMerek; ?></span>
                                        </div>
                                        <h4 class="text-white">Merek</h4>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>
                            <div class="col-lg-3">
                                <!-- Card -->
                                <div class="card card-block p-10 bg-green-600">
                                    <div class="card-watermark darker font-size-70 m-15"><i class="icon wb-clipboard" aria-hidden="true"></i></div>
                                    <div class="counter counter-md counter-inverse text-left">
                                        <div class="counter-number-group">
                                            <span class="counter-number"><?= $jumlahHakcipta; ?></span>
                                        </div>
                                        <h4 class="text-white">Hak Cipta</h4>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>
                            <div class="col-lg-3">
                                <!-- Card -->
                                <div class="card card-block p-10 bg-red-600">
                                    <div class="card-watermark darker font-size-70 m-15"><i class="icon wb-clipboard" aria-hidden="true"></i></div>
                                    <div class="counter counter-md counter-inverse text-left">
                                        <div class="counter-number-group">
                                            <span class="counter-number"><?= $jumlahDesain; ?></span>
                                        </div>
                                        <h4 class="text-white">Desain Industri</h4>
                                    </div>
                                </div>
                                <!-- End Card -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel">
            <div class="panel-body">
                <div class="row row-lg text-center">
                    <div class="col col-lg text-center">
                        <h3> Produktivitas Kekayaan Intelektual </h3>
                    </div>
                </div>
                <div class="row row-lg mt-15">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h4>Produktivitas Paten</h4>
                        </div>
                        <div>
                            <?php if ($grafikPaten) {
                                foreach ($grafikPaten as $data) {
                                    $tahunpaten[] = (float) $data->tahun;
                                    $totalpaten[] = (float) $data->total;
                                }
                            } else {
                                $tahunpaten[] = date('Y');
                                $totalpaten[] = 0;
                            }
                            ?>
                            <canvas id="myChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h4>Produktivitas Merek</h4>
                        </div>
                        <div>
                            <?php if ($grafikMerek) {
                                foreach ($grafikMerek as $data) {
                                    $tahunmerek[] = (float) $data->tahun;
                                    $totalmerek[] = (float) $data->total;
                                }
                            } else {
                                $tahunmerek[] = date('Y');
                                $totalmerek[] = 0;
                            }

                            ?>
                            <canvas id="myChart2"></canvas>
                        </div>
                    </div>
                </div>
                <div class="row row-lg mt-15 ">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h4>Produktivitas Hak Cipta</h4>
                        </div>
                        <div>
                            <?php if ($grafikHakcipta) {
                                foreach ($grafikHakcipta as $data) {
                                    $tahunhakcipta[] = (float) $data->tahun;
                                    $totalhakcipta[] = (float) $data->total;
                                }
                            } else {
                                $tahunhakcipta[] = date('Y');
                                $totalhakcipta[] = 0;
                            }

                            ?>
                            <canvas id="myChart3"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h4>Produktivitas Desain Industri</h4>
                        </div>
                        <div>
                            <?php
                            if ($grafikDesain) {
                                foreach ($grafikDesain as $data) {
                                    $tahundesain[] = (float) $data->tahun;
                                    $totaldesain[] = (float) $data->total;
                                }
                            } else {
                                $tahundesain[] = date('Y');
                                $totaldesain[] = 0;
                            }
                            ?>
                            <canvas id="myChart4"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= base_url('assets/'); ?>global/vendor/chart-js/Chart.js"></script>
<script>
    var ctx = document.getElementById("myChart").getContext('2d');


    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($tahunpaten); ?>,
            datasets: [{
                label: '',
                data: <?php echo json_encode($totalpaten); ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                    }
                }],
            }
        }
    });
    var ctx2 = document.getElementById("myChart2").getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($tahunmerek); ?>,
            datasets: [{
                label: '',
                data: <?php echo json_encode($totalmerek); ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                    }
                }]
            }
        }
    });
    var ctx3 = document.getElementById("myChart3").getContext('2d');
    var myChart3 = new Chart(ctx3, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($tahunhakcipta); ?>,
            datasets: [{
                label: '',
                data: <?php echo json_encode($totalhakcipta); ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                    }
                }]
            }
        }
    });
    var ctx4 = document.getElementById("myChart4").getContext('2d');
    var myChart4 = new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($tahundesain); ?>,
            datasets: [{
                label: '',
                data: <?php echo json_encode($totaldesain); ?>,
                backgroundColor: [
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        stepSize: 1,
                    }
                }]
            }
        }
    });
</script>