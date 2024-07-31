@extends('layout.main')

@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('assets/libs/apexcharts/apexcharts.cs') }}s" />
@endsection

@section('breadcumb')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title my-auto">Dashboard</h1>
        <div>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
            <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

@endsection

@section('content')

    <!-- ROW-1 -->
    <div class="row">

        <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6 class="fw-normal">Organik</h6>
                            <h2 id="weightsByTypeOrganic" class="mb-0 text-dark fw-semibold">{{ $weightsByTypeOrganic }}<small style="font-size: 70%;"> kg</small></h2>
                        </div>
                        <div class="ms-auto">
                            <div class="chart-wrapper mt-1">
                                <img src="{{ asset('icon-dashboard/food.png') }}" alt="logo" class="toggle-white mt-4 " width="64px">
                            </div>
                        </div>
                    </div>
                    {{-- <span class="text-muted fs-12"><span class="text-green"><i class="fe fe-arrow-up-circle text-green"></i> 0.9%</span> Last 9 days</span> --}}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6 class="fw-normal">Anorganik</h6>
                            <h2 id="weightsByTypeAnorganic" class="mb-0 text-dark fw-semibold">{{ $weightsByTypeAnorganic }}<small style="font-size: 70%;"> kg</small></h2>
                        </div>
                        <div class="ms-auto">
                            <div class="chart-wrapper mt-1">
                                <img src="{{ asset('icon-dashboard/plastic.png') }}" alt="logo" class="toggle-white mt-4 " width="64px">
                            </div>
                        </div>
                    </div>
                    {{-- <span class="text-muted fs-12"><span class="text-pink"><i class="fe fe-arrow-down-circle text-pink"></i> 0.75%</span> Last 6 days</span> --}}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6 class="fw-normal">Daur Ulang</h6>
                            <h2 id="weightsByTypeRecyclable" class="mb-0 text-dark fw-semibold">{{ $weightsByTypeRecyclable }}<small style="font-size: 70%;"> kg</small></h2>
                        </div>
                        <div class="ms-auto">
                            <div class="chart-wrapper mt-1">
                                <img src="{{ asset('icon-dashboard/recycling.png') }}" alt="logo" class="toggle-white mt-4 " width="64px">
                            </div>
                        </div>
                    </div>
                    {{-- <span class="text-muted fs-12"><span class="text-green"><i class="fe fe-arrow-up-circle text-green"></i> 0.9%</span> Last 9 days</span> --}}
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 col-xxl-3">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="mt-2">
                            <h6 class="fw-normal">Sampah Keseluruhan</h6>
                            <h2 id="weightsByTypeAll" class="mb-0 text-dark fw-semibold">{{ $weightsByTypeAll }}<small style="font-size: 70%;"> kg</small></h2>
                        </div>
                        <div class="ms-auto">
                            <div class="chart-wrapper mt-1">
                                <img src="{{ asset('icon-dashboard/delete.png') }}" alt="logo" class="toggle-white mt-4 " width="64px">
                            </div>
                        </div>
                    </div>
                    {{-- <span class="text-muted fs-12"><span class="text-green"><i class="fe fe-arrow-up-circle text-green"></i> 0.9%</span> Last 9 days</span> --}}
                </div>
            </div>
        </div>

    </div>
    <!-- ROW-1 END -->

    <div class="row">
        <div class="col-xxl-12">
            <div class="card overflow-hidden">
                <div class="card-header">
                    <h3 class="card-title">Sales Analytics</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; justify-content: flex-start; align-items: center; margin-bottom: 20px;">
                        <!-- Dropdown untuk Tahun -->
                        <select name="tahun" id="tahun" style="margin-right: 10px; padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
                            <option value="">Pilih Tahun</option>
                            @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
    
                        <!-- Dropdown untuk Bulan -->
                        <select name="bulan" id="bulan" style="margin-right: 10px; padding: 8px; border-radius: 5px; border: 1px solid #ccc;">
                            <option value="">Pilih Bulan</option>
                            @foreach ($monthsCreated_at as $month)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endforeach
                        </select>
    
                        <!-- Tambahkan Tombol Ekspor di Samping Dropdown Bulan -->
                        <button id="exportButton" style="padding: 8px 12px; background-color: #007bff; color: white; border: none; border-radius: 5px; margin-left: 10px;">
                            Export Data
                        </button>
                    </div>
    
                    <div class="chartjs-wrapper-demo w-100">
                        <div id="area" class="chart-dropshadow w-100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- ROW-2 END -->

@endsection

@section('script')

<script>

$('#exportButton').on('click', function() {
    var selectedYear = $('#tahun').val();
    var selectedMonth = $('#bulan').val();

    var url = `/dashboard/export/trash-excel?tahun=${selectedYear}&bulan=${selectedMonth}`;

    window.location.href = url;
});

$(document).ready(function() {
    // function fetchData() {
    //     $.ajax({
    //         url: "{{ route('dashboard.fetchData') }}",
    //         method: 'GET',
    //         success: function(data) {
    //             $('#weightsByTypeOrganic').text(data.weightsByTypeOrganic);
    //             $('#weightsByTypeAnorganic').text(data.weightsByTypeAnorganic);
    //             $('#weightsByTypeRecyclable').text(data.weightsByTypeRecyclable);
    //             $('#weightsByTypeAll').text(data.weightsByTypeAll);
    //         },
    //         complete: function() {
    //             setTimeout(fetchData, 5000); // 5000 milidetik = 5 detik
    //         }
    //     });
    // }

    // fetchData();

    function pollData() {
    var bulan = $('#bulan').val();
    var tahun = $('#tahun').val();
    
    $.ajax({
        url: "{{ route('dashboard.chartData') }}",
        type: 'GET',
        data: { tahun: tahun, bulan: bulan },
        success: function(response) {
            var newData = response.data;
            // Update chart only if the new data is different from the current data
            if (JSON.stringify(newData) !== JSON.stringify(currentChartData)) {
                updateChart(newData);
                currentChartData = newData; // Update the current data
            }
        },
        error: function(xhr, status, error) {
            console.error(error);
        },
        complete: function() {
            setTimeout(pollData, 3000); // Poll every 30 seconds
        }
    });
}

pollData();

var currentChartData = {
    chartDataAnorganic: {!! json_encode($weightsByTypeAnorganic) !!},
    chartDataOrganic: {!! json_encode($weightsByTypeOrganic) !!},
    chartDataRecylable: {!! json_encode($weightsByTypeRecyclable) !!},
    chartDataTypeAll: {!! json_encode($weightsByTypeAll) !!}
};

function getMaxValue(data) {
    var values = Object.values(data).map(function(val) {
        return parseFloat(val);
    });
    return Math.max(...values);
}

var maxAnorganic = getMaxValue(currentChartData.chartDataAnorganic);
var maxOrganic = getMaxValue(currentChartData.chartDataOrganic);
var maxRecylable = getMaxValue(currentChartData.chartDataRecylable);
var maxAll = getMaxValue(currentChartData.chartDataTypeAll);

var maxYValue = Math.max(maxAnorganic, maxOrganic, maxRecylable, maxAll);

var chartDataAnorganic = Object.keys(currentChartData.chartDataAnorganic).map(function(key) {
    return { x: key, y: parseFloat(currentChartData.chartDataAnorganic[key]) };
});

var chartDataOrganic = Object.keys(currentChartData.chartDataOrganic).map(function(key) {
    return { x: key, y: parseFloat(currentChartData.chartDataOrganic[key]) };
});

var chartDataRecylable = Object.keys(currentChartData.chartDataRecylable).map(function(key) {
    return { x: key, y: parseFloat(currentChartData.chartDataRecylable[key]) };
});

var chartDataTypeAll = Object.keys(currentChartData.chartDataTypeAll).map(function(key) {
    return { x: key, y: parseFloat(currentChartData.chartDataTypeAll[key]) };
});

var options = {
    series: [
        { name: 'anorganik', data: chartDataAnorganic },
        { name: 'organik', data: chartDataOrganic },
        { name: 'daur ulang', data: chartDataRecylable },
        { name: 'all', data: chartDataTypeAll }
    ],
    chart: {
        type: 'area',
        height: 350,
        events: {
            selection: function (chart, e) {
                console.log(new Date(e.xaxis.min))
            }
        },
    },
    colors: ['#ffd98c', '#62dbfb', '#b3e59f', '#FF5733'],
    grid: {
        borderColor: '#f2f5f7',
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'smooth'
    },
    fill: {
        type: 'gradient',
        gradient: {
            opacityFrom: 0.2,
            opacityTo: 0.6,
        }
    },
    legend: {
        position: 'top',
        horizontalAlign: 'left',
        offsetX: -10
    },
    xaxis: {
        type: 'categories',
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des']
    },
    yaxis: {
        min: 0,
        max: maxYValue // Menggunakan nilai maksimum yang dihitung
    },
    dataLabels: {
        enabled: false
    }
};

function updateChart(newData) {
    var chartDataAnorganic = Object.keys(newData.chartDataAnorganic).map(function(key) {
        return { x: key, y: parseFloat(newData.chartDataAnorganic[key]) };
    });

    var chartDataOrganic = Object.keys(newData.chartDataOrganic).map(function(key) {
        return { x: key, y: parseFloat(newData.chartDataOrganic[key]) };
    });

    var chartDataRecylable = Object.keys(newData.chartDataRecylable).map(function(key) {
        return { x: key, y: parseFloat(newData.chartDataRecylable[key]) };
    });

    var chartDataTypeAll = Object.keys(newData.chartDataTypeAll).map(function(key) {
        return { x: key, y: parseFloat(newData.chartDataTypeAll[key]) };
    });

    var maxAnorganic = getMaxValue(newData.chartDataAnorganic);
    var maxOrganic = getMaxValue(newData.chartDataOrganic);
    var maxRecylable = getMaxValue(newData.chartDataRecylable);
    var maxAll = getMaxValue(newData.chartDataTypeAll);

    var maxYValue = Math.max(maxAnorganic, maxOrganic, maxRecylable, maxAll);

    chart.updateOptions({
        yaxis: {
            min: 0,
            max: maxYValue
        }
    });

    chart.updateSeries([
        { name: 'anorganik', data: chartDataAnorganic },
        { name: 'organik', data: chartDataOrganic },
        { name: 'daur ulang', data: chartDataRecylable },
        { name: 'all', data: chartDataTypeAll }
    ]);
}

var chart = new ApexCharts(document.querySelector("#area"), options);
chart.render();

});



    
</script>

@endsection