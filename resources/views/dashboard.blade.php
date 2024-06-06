@extends('layouts.app')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold"><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark mb-1">
                            <span style="font-size: 1rem;"><b>Main Page Visit</b></span>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $dataOnToday }}<small class="font-weight-bold"> Visitor Today</small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-bar fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark mb-1">
                            <span style="font-size: 1rem;"><b>Total Visitor</b></span>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $dataTotal }} <small class="font-weight-bold"> Visitor</small>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chart-line fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark mb-1">
                            <span style="font-size: 1rem;"><b>Total Blog</b></span>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalBlog }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-secondary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-dark mb-1">
                            <span style="font-size: 1rem;"><b>Total Hashtag</b></span>
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $totalTag }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="/"><i class="fas fa-hashtag fa-2x text-danger"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-8 col-lg-12 col-md-12">
        <!-- Area Chart -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Statistics of Main Page Visits {{ date('Y') }}</h6>
            </div>
            <div class="card-body">
                <div class="chart-area" style="height: 100%;">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12 col-md-12">
        <!-- Area Chart -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Blog Tranding Today</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($trends as $row)
                            <tr>
                                <th>{{ $loop->iteration}}. </th>
                                <th><small>{{mb_strimwidth($row->title, 0, 30, "...")}}</small></th>
                                <td class="text-center">{{ $row->view_count}} Views </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var delayed;
    var ctx = document.getElementById("myAreaChart");
    var myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "Mei",
                "Jun",
                "Jul",
                "Agu",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
            datasets: [{
                label: "Kunjungan Halaman Utama",
                data: [<?= $dataOnYear ?>],
                borderColor: "rgb(22, 160, 133)",
                borderWidth: 2,
                borderRadius: 4,
                pointBorderWidth: 4,
                lineTension: 0.2,
            }, ],
        },
        options: {
            animation: {
                onComplete: () => {
                    delayed = true;
                },
                delay: (context) => {
                    let delay = 0;
                    if (context.type === "data" && context.mode === "default" && !delayed) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                },
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        callback: function(value) {
                            if (value % 1 === 0) {
                                return value;
                            }
                        },
                    },
                }, ],
            },
        },
    });
</script>
@endsection