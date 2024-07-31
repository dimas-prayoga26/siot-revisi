@extends('layout.main')

@section('title', 'Data / Dueses')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

<style>
    /* .btn-warning[disabled] {
        pointer-events: none;
        opacity: 0.5;
    } */

    .btn-success[disabled] {
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
                    <li class="breadcrumb-item active" aria-current="page">Tagihan</li>
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
                    Tagihan
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('dueses.store') }}" method="POST">
                    @csrf
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-xl-2 mb-2">
                                <div class="form-group">
                                    <label for="nominal">Pilih Nominal:</label>
                                    <select name="nominal_id" id="nominal" class="form-control">
                                        <option value="" disabled selected>Pilih Nominal</option>
                                        @foreach($nominals as $nominal)
                                            <option value="{{ $nominal->id }}">{{ number_format($nominal->nominal, 0, ',', '.') }} IDR</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-2">
                                <button type="submit" class="btn btn-primary mb-4"><i class="las la-plus"></i> Tagihan</button>
                                <a href="{{ route('dueses.export') }}" class="btn btn-success mb-4"><i class="las la-file-excel"></i> Export Excel</a>
                            </div>
                        </div>
                    </div>
                </form>
                {{-- <a href="{{ route('dueses.create') }}" class="btn btn-primary mb-4"><i class="las la-plus"></i> Tagihan</a> --}}
                <div class="form-group">
                    <input type="radio" name="filter" value="all" checked> Semua
                    <input type="radio" name="filter" value="paid"> Sudah Bayar
                    <input type="radio" name="filter" value="unpaid"> Belum Bayar
                </div>
                <table id="datatable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Masyarakat</th>
                            <th>Nominal</th>
                            <th>Status</th>
                            <th>Tagih</th>
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

    
    
    // var table;
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        ajax: {
            url: '{{ route("dueses.datatable") }}',
            data: function (d) {
                d.filter = $('input[name="filter"]:checked').val();
            }
        },
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
                    return full.user.user_data.name || 'Belum Ada Data!';
                }
            },
            {
                targets: 2,
                render: function(data, type, full, meta) {
                    if (data !== null) {
                        var nominal = full.meta_dues_nominal.nominal;
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(nominal).replace(/,00$/, '');
                    } else {
                        return 'Belum Ada Data!';
                    }
                }
            },
            {
                targets: 3,
                render: function(data, type, full, meta) {
                    var colorClass = data === 1 ? 'text-success' : 'text-warning';
                    return `
                        <select class="form-control update-status ${colorClass}" data-id="${full.id}">
                            <option value="0" ${data === 0 ? 'selected' : ''} class="text-warning">Belum Di Bayar</option>
                            <option value="1" ${data === 1 ? 'selected' : ''} class="text-success">Sudah Di Bayar</option>
                        </select>
                    `;
                }
            },
            {
                targets: 4,
                render: function(data, type, full, meta) {
                    if (data === 1) {
                        return `<div class="btn-list">
                                    <a href="javascript:void(0)" class="btn btn-md btn-success disabled"><span class="fe fe-check"></span></a>
                                </div>`;
                    } else if (data === 0) {
                        return `<div class="btn-list">
                                    <a href="javascript:void(0)" data-id="${full.user_id}" data-update="1" class="btn btn-md btn-info btn-isActive" title="Active"><span class="fe fe-bell"></span></a>
                                </div>`;
                    } else {
                        return 'Data Tidak Valid!';
                    }
                }
            },
            {
                targets: -1,
                render: function(data) {
                    return `
                    <div class="btn-list">
                        <a href="{{ route('dueses.edit', ':id') }}" class="btn btn-md btn-warning"><span class="fe fe-edit"></span></a>
                        <a href="javascript:void(0)" onclick="destroy('${data}')" class="btn btn-md btn-danger"><span class="fe fe-trash-2"></span></a>
                    </div>
                    `.replaceAll(':id', data);
                }
            }
        ],
        columns: [
            { data: null },
            { data: 'user_id' },
            { data: 'meta_dues_nominal_id' },
            { data: 'is_paid' },
            { data: 'is_paid' },
            { data: 'id' }
        ],
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        }
    });

    $('input[name="filter"]').change(function() {
        table.ajax.reload();
    });

    $('#datatable').on('change', '.update-status', function() {
        var id = $(this).data('id');
        var status = $(this).val();

        $.ajax({
            url: '{{ route("dueses.updateStatus") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                is_paid: status
            },
            success: function(response) {
                table.ajax.reload();
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Status pembayaran berhasil diubah',
                    showConfirmButton: false,
                    timer: 1500
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Gagal mengubah status pembayaran',
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });

        window.destroy = function(id) {
            var url = "{{ route('dueses.destroy',":id") }}";
            url = url.replace(':id', id);
            
            Swal.fire({
                title: "Yakin ingin menghapus data ini?",
                text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersebut!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.value) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: url,
                        type: "delete",
                        data: { "id": id },
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
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'error',
                                title: 'Terjadi kesalahan saat menghapus data',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            });
        }
    });


    $(document).on('click', '.btn-isActive', function(){
            let id = $(this).data('id');
            console.log(id);
            let state = $(this).data('update')

            Swal.fire({
                title: "Ingin menagih tagihan ?",
                icon: "warning",
                showCancelButton  : true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor : "#d33",
                confirmButtonText : "Ya!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url    : `{{ route('dueses.notification') }}`,
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
</script>
@endsection
    