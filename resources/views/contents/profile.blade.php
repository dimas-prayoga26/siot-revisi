@extends('layout.main')

@section('title', 'Dashboard')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">

@endsection

@section('breadcumb')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title my-auto">Profile</h1>
        <div>
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
              <a href="javascript:void(0)">Pages</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
          </ol>
        </div>
      </div>
      <!-- PAGE-HEADER END -->

@endsection

@section('content')

{{-- Row Start --}}

    <!-- resources/views/profile/index.blade.php -->

<div class="row">
    <div class="col-xxl-12">
        <div class="card custom-card overflow-hidden">
            <div class="card-body border-bottom">
                <div class="d-sm-flex main-profile-cover">
                    <span class="avatar avatar-xxl me-3">
                        <img src="{{ asset($user->userData->image) }}" alt="Profile Image" class="avatar avatar-xxl">
                    </span>
                    <div class="flex-fill main-profile-info my-auto">
                        <h5 class="fw-semibold mb-1 ">{{ $user->userData->name }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="card custom-card">
            <div class="p-4 border-bottom border-block-end-dashed">
                <p class="fs-15 mb-2 me-4 fw-semibold">Personal Info :</p>
                <ul class="list-group">
                    <li class="list-group-item border-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="me-2 fw-semibold">
                                Name :
                            </div>
                            <span class="fs-12 text-muted">{{ $user->userData->name }}</span>
                        </div>
                    </li>
                    <li class="list-group-item border-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="me-2 fw-semibold">
                                Email :
                            </div>
                            <span class="fs-12 text-muted">{{ $user->email }}</span>
                        </div>
                    </li>
                    <li class="list-group-item border-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="me-2 fw-semibold">
                                Phone :
                            </div>
                            <span class="fs-12 text-muted">{{ $user->userData->phone_number ?? 'N/A' }}</span>
                        </div>
                    </li>
                    <li class="list-group-item border-0">
                        <div class="d-flex flex-wrap align-items-center">
                            <div class="me-2 fw-semibold">
                                Address :
                            </div>
                            <span class="fs-12 text-muted">{{ $user->userData->address ?? 'N/A' }}</span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="p-4 border-bottom border-block-end-dashed d-flex align-items-center">
                <div class="ms-auto">
                    <button type="button" onclick="edit('{{ $user->id }}')" class="btn btn-secondary btn-wave">Edit</button>
                </div>
            </div>                
        </div>
    </div>
</div>

<div class="modal fade" id="modal_form" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Edit Data Profiel</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input id="image" class="dropify" type="file" name="image" data-max-file-size="2M" data-allowed-file-extensions="jpeg jpg png webp svg" required />
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control mb-2" id="name" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control mb-2" id="email" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">No Hp</label>
                        <input type="text" name="phone_number" class="form-control mb-2" id="phone_number" value="" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control mb-2" id="address" value="" required>
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
<!-- ROW-1 END -->

@endsection

@section('script')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>
    
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $(document).ready(function() {
            $('.dropify').dropify();
            
        $('#btnSave').on('click', function () {
            submit();
        })
            
        $('#form').on('submit', function(e){
            e.preventDefault();

            submit();
        })
    });

    function edit(id) {

        var df = "";
        df = $('#image').dropify();

        submit_method = 'edit';

        $('#form')[0].reset();
        var url = `{{ route('edit.profile', ':id') }}`;
        url = url.replace(':id', id);
        $.get(url, function (response) {
            response = response.data;
            
            $('#id').val(response.id);
            $('#name').val(response.user_data.name);
            $('#email').val(response.email);
            $('#phone_number').val(response.user_data.phone_number);
            $('#address').val(response.user_data.address);

            
            df = df.data('dropify');
            df.resetPreview();
            df.clearElement();
            df.settings.defaultFile = `{{ asset('storage') }}/${response.user_data.image}`;
            df.destroy();
            df.init();

            $('#modal_form').modal('show');
            $('.modal-title').text('Edit Data Profil');
            $('#btnSave').removeClass('d-none');
        });
    }

    function submit() {
        var id          = $('#id').val();
        var name      = $('#name').val();
        var email = $('#email').val();
        var phone_number = $('#phone_number').val();
        var address  = $('#address').val();
        var imageInput  = $('#image')[0].files[0];

        var formData = new FormData(); 
        console.log(formData);

        formData.append('id', id);
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone_number', phone_number);
        formData.append('address', address);
        formData.append('image', imageInput);
        
        $('#btnSave').text('Menyimpan...');
        $('#btnSave').attr('disabled', true);

        // Pastikan variabel submit_method sudah didefinisikan dengan benar sebelum digunakan
        if(submit_method == 'edit'){
            url = "{{ route('update.profile', ":id") }}";
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
</script>
@endsection