@extends('layout.main')

@section('title', 'Setting tanggal mingguan')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

<style>
    .data-table-btn[disabled] {
        pointer-events: none;
        opacity: 0.5;
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
                    <li class="breadcrumb-item active" aria-current="page">Setting data tanggal mingguan</li>
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
                    Setting data tanggal mingguan
                </div>
            </div>
            <div class="card-body">
                @if($isPastWeek)
                    <form id="resetDateForm" method="POST" action="{{ route('pengaturan-tanggal-mingguan.store') }}">
                        @csrf
                        <!-- Konten formulir lainnya -->
                        <button type="submit" class="btn btn-primary mb-4 btn-success data-table-btn">
                            <i class="las la-sync"></i> Reset Date
                        </button>
                    </form>
                
                @else
                    <a href="{{ route('schedule.index') }}" class="btn btn-primary mb-4 btn-primary data-table-btn"><i class="las la-calendar-check"></i> Reset Tanggal</a>
                    {{-- <button class="btn btn-primary mb-4 btn-danger data-table-btn" disabled>
                        <i class="las la-sync"></i> Reset Date
                    </button> --}}
                @endif                          
                <table id="datatable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>date</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End:: row-3 -->


@endsection

@section('script')

<!-- DATA TABLE JS-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.6/pdfmake.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script> --}}
<script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> --}}

<!-- Internal Datatables JS -->
<script src="{{ asset('assets/js/datatables.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var $table;

    
    $(document).ready(function() {
        
        table = $("#datatable").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('pengaturan-tanggal-mingguan.datatable') }}",
            columnDefs: [
            {
                targets: 0,
                render: function(data, type, full, meta) {
                    return (meta.row + 1);
                }
            }, ],
            columns: [
                { data: null },
                { data: 'date'},
            ],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            }
        });

        $('#btnSave').on('click', function () {
            submit();
        })
        
        $('#form').on('submit', function(e){
            e.preventDefault();

            submit();
        })
    })




</script>
    
@endsection