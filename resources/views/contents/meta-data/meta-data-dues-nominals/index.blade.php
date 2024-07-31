@extends('layout.main')

@section('title', 'Setting nominal iruan')

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
                    <li class="breadcrumb-item active" aria-current="page">Setting data nominal tagihan</li>
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
                    Setting data nominal tagihan
                </div>
            </div>
            <div class="card-body">                  
                <a class="btn btn-primary modal-effect mb-4 data-table-btn" onclick="create()">
                    <i class="las la-plus"></i> Data nominal tagihan
                </a>
                <table id="datatable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nominal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel1">Modal title</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form id="form" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="type" class="form-label">Nominal</label>
                            <input type="number" placeholder="Rp. 10.000" value="" name="nominal" class="form-control" id="nominal" value="{{ old('nominal') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                </div>
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
            ajax: "{{ route('meta-dueses-nominal.datatable') }}",
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
                        // Format nominal dengan simbol mata uang Rp
                        var nominal = data;
                        var formattedNominal = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(nominal);
                        return formattedNominal.replace(/,00$/, ''); // Menghilangkan ,00 jika diperlukan
                    } else {
                        return 'Belum Ada Data!';
                    }
                }
            },
            {
                targets: -1,
                render: function(data) {
                    let btn = `
                    <div class="btn-list">
                        <a href="javascript:void(0)" onclick="edit('${data}')" class="btn btn-md btn-primary"><span class="fe fe-edit"> </span></a>
                        <a href="javascript:void(0)" onclick="destroy('${data}')" class="btn btn-md btn-danger btn-delete"><span class="fe fe-trash-2"> </span></a>
                    </div>
                    `;

                    btn = btn.replaceAll(':id', data);

                    return btn;
                },
            }, ],
            columns: [
                { data: null },
                { data: 'nominal'},
                { data: 'id'},
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

    function create() {
        submit_method = 'create';
        $('#form')[0].reset();

        // Ensure all fields are cleared and enabled
        $('#id').val('').prop('disabled', false);
        $('#nominal').val('').prop('disabled', false);

        $('#modal_form').modal('show');
        $('.modal-title').text('Tambah Data Pelanggan');
    }

    function edit(id) {
        submit_method = 'edit';
        $('#form')[0].reset();

        var url = `{{ route('meta-dueses-nominal.edit', ":id") }}`;
        url = url.replace(':id', id);
        $.get(url, function (response) {
            response = response.data;
            // console.log('edit', response[0].nominal);
            
            // Enable all fields for editing
            $('#id').val(response[0].id).prop('disabled', false);
            $('#nominal').val(response[0].nominal).prop('disabled', false);

            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Data Nominal');

         
            $('#btnSave').removeClass('d-none');
        });
    }

    function submit() {
        var id          = $('#id').val();
        var nominal  = $('#nominal').val();
        // var imageInput  = $('#image')[0].files[0];

        var formData = new FormData(); 
        console.log(formData);

        formData.append('id', id);
        formData.append('nominal', nominal);
        // formData.append('image', imageInput);

        var url = "{{ route('meta-dueses-nominal.store') }}";
        
        $('#btnSave').text('Menyimpan...');
        $('#btnSave').attr('disabled', true);

        // Pastikan variabel submit_method sudah didefinisikan dengan benar sebelum digunakan
        if(submit_method == 'edit'){
            url = "{{ route('meta-dueses-nominal.update', ":id") }}";
            url = url.replace(':id', id);
            formData.append('_method', 'PUT'); 
        }

        $.ajax({
            url: url,
            type: 'POST', 
            dataType: 'json',
            data: formData,
            contentType: false, 
            processData: false, 
            success: function (data) {
                if(data.status) {
                    $('#modal_form').modal('hide');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    table.ajax.reload();
                } else {
                    // Periksa apakah data.error ada sebelum mencoba mengaksesnya
                    if (data.error) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'ERROR !',
                            text: data.error,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    } else {
                        // Periksa apakah data.inputerror dan data.error_string ada sebelum mencoba mengaksesnya
                        if (data.inputerror && data.error_string) {
                            for (var i = 0; i < data.inputerror.length; i++) {
                                $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); 
                                $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); 
                            }
                        }
                    }
                }
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
            }, 
            error: function(xhr, status, error) {
                var errorMessage = "Error: " + xhr.status + ": " + xhr.statusText;
                console.error(errorMessage);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'ERROR !',
                    text: 'Terjadi kesalahan saat memproses permintaan.',
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#btnSave').text('Simpan');
                $('#btnSave').attr('disabled', false);
            }
        });
    }

    function destroy(id) {
        var url = "{{ route('meta-dueses-nominal.destroy',":id") }}";
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