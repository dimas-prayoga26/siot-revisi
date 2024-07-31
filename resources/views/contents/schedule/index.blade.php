@extends('layout.main')

@section('title', 'Pengaturan | Schedule')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

<style>
    .btn-warning[disabled] {
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
                    <li class="breadcrumb-item active" aria-current="page">Pengaturan Schedule</li>
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
                    Pengaturan Schedule
                </div>
            </div>
            <div class="card-body">
                <form id="form" action="{{ route('schedule.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-3">
                        <div class="input-group mb-2">
                            <div class="input-group-text text-muted"> <i class="ri-time-line"></i> </div>
                            <input type="text" class="form-control" name="time" id="timepickr1" placeholder="Choose time in 24hr format">
                        </div>
                        <button class="btn btn-danger mb-1" type="submit" {{ $null ? '' : 'disabled' }}><i class="las la-sync"></i> Reset Jadwal</button>
                        {{-- <a href="{{ route('schedule.store') }}" class="btn btn-danger mb-4"><i class="las la-sync"></i> Reset Schedule</a> --}}
                </form>
                <a href="{{ route('pengaturan-tanggal-mingguan.index') }}" class=" mb-1 btn btn-warning" {{ $isPastWeek || $null ? 'disabled="disabled"' : ''}}
                ><i class="las la-calendar"></i> Reset Tanggal</a>
                </div>
                <table id="datatable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Active</th>
                            <th>Action</th>
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
        
        table = $("#datatable").DataTable({
            responsive: true,
            processing: false,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('schedule.datatable') }}",
            columnDefs: [
            {
                targets: 0,
                render: function(data, type, full, meta) {
                    return (meta.row + 1);
                }
            },
            {
                targets: 1,
                render: function(data, type, full, meta) {
                if (data !== null) {
                    return full.user.user_data.name;
                } else {
                    return 'Belum Ada Data!';
                }
            }
            },
            {
                targets: 2,
                render: function(data, type, full, meta) {
                if (data !== null) {
                    return full.date.date;
                } else {
                    return 'Belum Ada Data!';
                }
            }
            },
            {
                targets: 4,
                className: 'text-center',
                render: function(data, type, full, meta) {
                    let role = `{{ Auth::user()->getRoleNames()->first(); }}`;
                    console.log(full.id);
                    
                    let state = ``;
                    if(role == 'admin'){
                        state = `<button type="button" data-id="${full.id}" data-update="1" class="btn btn-success btn-isActive" title="Active"><span class="fe fe-check"></span></button>`;
                        
                        if(!!+full.is_active)
                            state = `<button type="button" data-id="${full.id}" data-update="0" class="btn btn-warning btn-isActive" title="Non active"><span class="fe fe-x-circle"></span></button>`;
                    }

                    let btn = `
                        <div class="btn-list">
                            ${state}
                        </div>
                        `;

                        btn = btn.replaceAll(':id', full.id);

                        return btn;
                    },
            },
            {
                targets: -1,
                render: function(data) {
                    let btn = `
                    <div class="btn-list">
                        <a href="{{ route('schedule.edit', ':id') }}" class="btn btn-md btn-primary"><span class="fe fe-edit"> </span></a>
                        <a href="javascript:void(0)" onclick="destroy('${data}')" class="btn btn-md btn-danger btn-delete"><span class="fe fe-trash-2"> </span></a>
                    </div>
                    `;

                    btn = btn.replaceAll(':id', data);

                    return btn;
                },
            },
            ],
            columns: [
                { data: null },
                { data: 'user_id'},
                { data: 'meta_date_id'},
                { data: 'start_time'},
                { data: 'is_active'},
                { data: 'id'},
            ],

            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            }
        });

        $(document).on('click', '.btn-isActive', function(){
            let id = $(this).data('id');
            console.log(id);
            let state = $(this).data('update')

            Swal.fire({
                title: "Yakin ingin mengupdate status data ini?",
                text: "Anda bisa merubah status active data ini kapanpun.",
                icon: "warning",
                showCancelButton  : true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor : "#d33",
                confirmButtonText : "Ya!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url    : `{{ route('schedule.isActive') }}`,
                        type   : "POST",
                        data: { 
                            "id": id,
                            "state": state,
                        },
                        dataType: "JSON",
                        success: function(data) {
                            table.ajax.reload();
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data berhasil diupdate',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                }
            })
        })
    })

    // function refreshDataTable() {
    //     $('#datatable').DataTable().ajax.reload(null, false); // Memuat data baru tanpa mengganti state paging
    // }

    // setInterval(refreshDataTable, 5000);

    function destroy(id) {
        var url = "{{ route('schedule.destroy',":id") }}";
        url = url.replace(':id', id);
        
        Swal.fire({
            title: "Yakin ingin menghapus data ini?",
            text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
            icon: "warning",
            showCancelButton  : true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor : "#d33",
            confirmButtonText : "Ya, Hapus!"
        }).then((result) => {
            if (result.value) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                console.log(result.value);
                $.ajax({
                    url    : url,
                    type   : "delete",
                    data: { "id":id },
                    dataType: "JSON",
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(data) {
                        table.ajax.reload();
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Data berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                })
            }
        })
    } 
</script>
@endsection
    