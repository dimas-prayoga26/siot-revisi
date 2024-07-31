@extends('layout.main')

@section('title', 'Menu | Feedback')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">

<style>
    .btn-warning[disabled] {
        pointer-events: none;
        opacity: 0.5;
    }

    .btn-info[disabled] {
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
                    <li class="breadcrumb-item active" aria-current="page">Data Komplen</li>
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
                    Komplen
                </div>
            </div>
            <div class="card-body">
                {{-- <a href="{{ route('feedback.create') }}" class="btn btn-primary mb-4 data-table-btn"><i class="las la-plus"></i> Tambah Feedback</a> --}}
                <table id="datatable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Ditangguhkan</th>
                            <th>Dikonfirmasi</th>
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

<div class="modal fade" id="modal_form" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Response Komplen</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="form-floating mb-4">
                        <textarea class="form-control"
                            id="desc" value="{{ old('desc') }}" required></textarea>
                        <label for="desc">Deskripsi Komplen</label>
                    </div>
                    <div class="mb-3">
                        <label for="petugas" class="form-label">Nama Peutgas Yang Merespon</label>
                        <input type="text" name="" class="form-control mb-2" id="petugas" value="{{ old('petugas') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input id="image" class="dropify" type="file" name="image" data-max-file-size="2M" data-allowed-file-extensions="jpeg jpg png webp svg" value="{{ old('image') }}" required />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End:: row-3 -->


@endsection

@section('script')

<!-- DATA TABLE JS-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            ajax: "{{ route('feedback.datatable') }}",
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
                console.log(full);
                if (data !== null) {
                    return full.user.user_data.name;
                } else {
                    return 'Belum Ada Data!';
                }
            }
            },
            {
                targets: 3,
                render: function(data, type, full, meta) {
                    if (data) {
                        return `<a href="${data}" data-fancybox><img class="img-thumbnail" style="border-radius: 50%; width: 100px; height: 75px; object-fit: cover;" src="${data}" alt="Image"></a>`;
                    } else {
                        return `<a href="{{ asset('assets/images/faces/1.jpg') }}" data-fancybox><img class="img-thumbnail" style="border-radius: 50%; width: 100px; height: 75px; object-fit: cover;" src="{{ asset('assets/images/faces/1.jpg') }}" alt="Image"></a>`;
                    }
                }
            },
            {
                targets: 4,
                render: function(data, type, full, meta) {
                    let statusText = '';
                    let statusColor = '';

                    switch (data) {
                        case 'submitted':
                            statusText = 'Komplen Belum Di Tanggapi';
                            statusColor = 'red';
                            break;
                        case 'needs_validation':
                            statusText = 'Komplen Sedang Di Proses Petugas';
                            statusColor = 'yellow';
                            break;
                        case 'on_hold':
                            statusText = 'Komplen Sedang Di Review Admin';
                            statusColor = 'orange';
                            break;
                        case 'resolved':
                            statusText = 'Komplen Sudah Di Tanggapi';
                            statusColor = 'green';
                            break;
                        default:
                            statusText = data;
                            break;
                    }

                    return '<span style="border: 1px solid ' + statusColor + '; padding: 2px 5px; border-radius: 5px; font-weight: bold;">' + statusText + '</span>';
                }

            },
            {
                targets: 5,
                className: 'text-center',
                render: function(data, type, full, meta) {
                    let role = `{{ Auth::user()->getRoleNames()->first(); }}`;
                    let state = ``;

                    // Check if the role is admin and status is needs_validation
                    if (role === 'admin' && full.status === 'needs_validation') {
                        state = `<button type="button" data-id="${full.id}" data-update="on_hold" class="btn btn-warning btn-needsValidation" title="Active"><span class="fe fe-alert-circle"></span></button>`;
                    } else {
                        // If not needs_validation or not admin, disable the button
                        state = `<button type="button" class="btn btn-warning" disabled><span class="fe fe-alert-circle"></span></button>`;
                    }

                    let btn = `
                        <div class="btn-list">
                            ${state}
                        </div>
                    `;

                    return btn;                 
                }
            },
            {
                targets: 6,
                className: 'text-center',
                render: function(data, type, full, meta) {
                    let role = `{{ Auth::user()->getRoleNames()->first(); }}`;
                    let state = ``;

                    // Check if the role is admin and status is needs_validation
                    if (role === 'admin' && full.status === 'on_hold') {
                        state = `<button type="button" data-id="${full.id}" data-update="resolved" class="btn btn-success btn-onHold" title="Active"><span class="fe fe-check"></span></button>`;
                    } else {
                        // If not needs_validation or not admin, disable the button
                        state = `<button type="button" class="btn btn-success" disabled><span class="fe fe-check"></span></button>`;
                    }

                    let btn = `
                        <div class="btn-list">
                            ${state}
                        </div>
                    `;

                    return btn;                 
                }
            },
            {
                targets: -1,
                render: function(data, type, full, meta) {
                    console.log(full.status);
                let btn = `
                    <div class="btn-list">
                        <a href="javascript:void(0)" onclick="show('${data}')" class="btn btn-md btn-info" ${full.status !== 'submitted' ? '' : 'disabled'}>
                            <span class="fe fe-eye"> </span>
                        </a>
                        <a href="javascript:void(0)" onclick="destroy('${data}')" class="btn btn-md btn-danger ${full.status !== 'resolved' ? 'disabled' : ''}">
                            <span class="fe fe-trash-2"> </span>
                        </a>
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
                { data: 'desc'},
                { data: 'image'},
                { data: 'status'},
                { data: 'status'},
                { data: 'status'},
                { data: 'id'},
            ],

            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            }
        });

        $(document).on('click', '.btn-needsValidation', function(){
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
                        url    : `{{ route('feedback.needsValidation') }}`,
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

        $(document).on('click', '.btn-onHold', function(){
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
                        url    : `{{ route('feedback.onHold') }}`,
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

    function show(id) {
        // submit_method = 'edit';
        var df = "";
        df = $('#image').dropify();

        $('#form')[0].reset();

        var url = `{{ route('feedback.show', ":id") }}`;
        url = url.replace(':id', id);
        $.get(url, function (response) {
            responseComplaintResponse = response.dataComplaintResponse;
            responseNamePetugas = response.dataPetugas;

            console.log('test', response);

            $('#id').val(responseComplaintResponse.id).prop('disabled', true);
            $('#desc').val(responseComplaintResponse.desc).prop('disabled', true);
            $('#petugas').val(responseNamePetugas).prop('disabled', true);

            $('#modal_form').modal('show');
            $('.modal-title').text('Show Data Complaint');
            
            df = df.data('dropify');
            df.resetPreview();
            df.clearElement();
            df.settings.defaultFile = `{{ asset('storage') }}/${responseComplaintResponse.image}`;
            df.destroy();
            df.init();
            
            $('#image').prop('disabled', true); 
            
            $('#btnSave').addClass('d-none');
            $('#password_field').addClass('d-none');
        });
    }
</script>
@endsection