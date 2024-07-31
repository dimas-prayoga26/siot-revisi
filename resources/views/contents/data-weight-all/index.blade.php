@extends('layout.main')

@section('title', 'Data / Trash-Data-all')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

<style>
    .disabled-link {
    color: gray;
    text-decoration: none;
    cursor: default;
  }
</style>

@endsection

@section('breadcumb')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                    <a href="javascript:void(0)"></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Data Sampah Kepemilikan (Keseluruhan)</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

@endsection

@section('content')
<!-- Start:: row-3 -->
<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    Data Sampah Kepemilikan (Keseluruhan)
                </div>
            </div>
            <div class="card-body">
                <div class="col-xl-12">
                    <div class="row">
                        <div class="col-xl-6 mb-2">
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="filterMonth" class="form-label">Filter Bulan</label>
                                    <select id="filterMonth" class="form-select">
                                        <option value="">Pilih Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="filterYear" class="form-label">Filter Tahun</label>
                                    <select id="filterYear" class="form-select">
                                        <option value="">Pilih Tahun</option>
                                        @foreach ($years as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <table id="datatable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Berat</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<!-- DATA TABLE JS-->

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> --}}
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> --}}


<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var $table;

    
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih Pemilik Sampah",
            allowClear: true
        });

        // Initialize DataTable
        var table = $("#datatable").DataTable({
        responsive: true,
        processing: false,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: "{{ route('trash-data-all.datatable') }}",
            data: function(d) {
                d.year = $('#filterYear').val() || '{{ now()->year }}';
                d.month = $('#filterMonth').val() || '{{ now()->month }}';
            }
        },
        columnDefs: [
            {
                targets: 0,
                render: function(data, type, full, meta) {
                    return (meta.row + 1);
                }
            },
        ],
        columns: [
            { data: null },
            { data: 'date' },
            { data: 'jam' },
            { data: 'berat' }
        ],
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        },
        order: [[1, 'desc']] // Urutkan berdasarkan kolom tanggal (indeks 1) secara descending
    });

    $('#filterMonth, #filterYear').change(function() {
        table.draw();
    });

    refreshDataTable();
});

function refreshDataTable() {
        $('#datatable').DataTable().ajax.reload(null, false); // Memuat data baru tanpa mengganti state paging
        setTimeout(refreshDataTable, 3000);
    }
</script>
@endsection