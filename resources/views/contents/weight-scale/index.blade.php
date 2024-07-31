@extends('layout.main')

@section('title', 'Data / Trash-counter')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">

<style>
    #qr-reader {
        width: 100%;
        height: 300px;
        border-radius: 15px; /* Sesuaikan nilai sesuai keinginan Anda */
        overflow: hidden; /* Untuk menghindari konten meluap dari border-radius */
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
                    <li class="breadcrumb-item active" aria-current="page">Pengelolaan Alat Ukur Berat Tempat Sampah</li>
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
                    Pengelolaan Alat Ukur Berat Tempat Sampah
                </div>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" onclick="openQrModal()">Scan untuk nambahkan data alat</button>
                <table id="datatable" class="table table-bordered text-nowrap w-100">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Petugas</th>
                            <th>Name</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

     <!-- Modal Structure -->
     <div class="modal fade" id="qr-modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">Tambah data alat</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="qr-reader" ></div>
                    <button class="btn btn-danger mt-3 float-end" onclick="closeQrModal()">Close</button>
                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
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
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: "{{ route('weight-scale.datatable') }}",
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
                    if (data == null){
                        return "Belum Ada Data!";
                    } else {
                        return data;
                    }
                }
            },
            {
                targets: 4,
                render: function(data, type, full, meta) {
                    if (data == null){
                        return "Belum Ada Data!";
                    } else {
                        return data;
                    }
                }
            },
            // {
            //     targets: 3,
            //     className: 'text-center',
            //     render: function(data, type, full, meta) {
            //         let role = `{{ Auth::user()->getRoleNames()->first(); }}`;
                    
            //         let state = ``;
            //         if(role == 'admin'){
            //             state = `<button type="button" data-id="${full.id}" data-update="1" class="btn btn-success btn-isActive" title="Active"><span class="fe fe-check"></span></button>`;
                        
            //             if(!!+full.is_active)
            //                 state = `<button type="button" data-id="${full.id}" data-update="0" class="btn btn-warning btn-isActive" title="Non active"><span class="fe fe-x-circle"></span></button>`;
            //         }

            //         let btn = `
            //             <div class="btn-list">
            //                 ${state}
            //             </div>
            //             `;

            //             btn = btn.replaceAll(':id', full.id);

            //             return btn;
            //         },
            // },
            {
                targets: -1,
                render: function(data) {
                    let btn = `
                    <div class="btn-list">
                        <a href="javascript:void(0)" onclick="destroy('${data}')" class="btn btn-md btn-danger btn-delete"><span class="fe fe-trash-2"> </span></a>
                    </div>
                    `;

                    btn = btn.replaceAll(':id', data);

                    return btn;
                },
            }, ],
            columns: [
                { data: null },
                { data: 'user_id'},
                { data: 'name'},
                { data: 'latitude'},  
                { data: 'longitude'}, 
                { data: 'id'}, 
            ],
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
            }
        });


        // $(document).on('click', '.btn-isActive', function(){
        //     let id = $(this).data('id');
        //     console.log(id);
        //     let state = $(this).data('update')

        //     Swal.fire({
        //         title: "Yakin ingin mengupdate status data ini?",
        //         text: "Anda bisa merubah status active data ini kapanpun.",
        //         icon: "warning",
        //         showCancelButton  : true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor : "#d33",
        //         confirmButtonText : "Ya!"
        //     }).then((result) => {
        //         if (result.value) {
        //             $.ajax({
        //                 url    : `{{ route('weight-scale.isActive') }}`,
        //                 type   : "POST",
        //                 data: { 
        //                     "id": id,
        //                     "state": state,
        //                 },
        //                 dataType: "JSON",
        //                 success: function(data) {
        //                     table.ajax.reload();
        //                     Swal.fire({
        //                         toast: true,
        //                         position: 'top-end',
        //                         icon: 'success',
        //                         title: 'Data berhasil diupdate',
        //                         showConfirmButton: false,
        //                         timer: 1500
        //                     });
        //                 }
        //             })
        //         }
        //     })
        // })
    })

    function destroy(id) {
        var url = "{{ route('weight-scale.destroy',":id") }}";
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

    let html5QrCode;

        function openQrModal() {
            $('#qr-modal').modal('show');

            // Menginisialisasi QR code reader
            html5QrCode = new Html5Qrcode("qr-reader");
            html5QrCode.start({ facingMode: "environment" }, {
                fps: 10,    // Frame per second
                qrbox: 250  // Ukuran kotak QR code
            }, (decodedText, decodedResult) => {
                // Handle hasil decode QR code
                // console.log(`Code matched = ${decodedText}`, decodedResult);
                closeQrModal();

                // Arahkan ke URL create dengan parameter unique_id
                window.location.href = `/data/weight-scale/create?unique_id=${decodedText}`;
            }).catch(err => {
                console.error(`QR Code scanning failed. Reason: ${err}`);
            });
        }

        function closeQrModal() {
            $('#qr-modal').modal('hide');

            if (html5QrCode) {
                html5QrCode.stop().then(ignore => {
                    // QR code scanning stopped.
                    console.log("QR Code scanning stopped.");
                }).catch(err => {
                    console.error(`Unable to stop scanning. Reason: ${err}`);
                });
            }
        }

        // Menangani event saat modal ditutup untuk menghentikan kamera
        $('#qr-modal').on('hidden.bs.modal', function () {
            closeQrModal();
        });
</script>
@endsection
    