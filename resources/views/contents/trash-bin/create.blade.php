@extends('layout.main')

@section('title', 'Create Trash bin')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .form-control[readonly] {
        background-color: #e9ecef; /* Warna abu-abu */
    }
</style>


@endsection

@section('breadcumb')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
            <a href="javascript:void(0)"></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Create Trash Bin</li>
        </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

@endsection

@section('content')

<div class="row">
    <div class="col-lg-12 col-md-12 col-md-12">
        <div class="card custom-card">
            <div class="card-header justify-content-between">
                <div class="card-title">
                    Create Trash Bin
                </div>
            </div>
            <form id="form" action="{{ route('trash-bin.store') }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    <input id="id" name="id" type="hidden" value="">
                    <div class="mb-3">
                        <p class="fw-semibold mb-2">Nama Pemilik</p>
                        <select class="form-control" data-trigger name="user_id" id="user_id" required>
                            <option value="">Pilih pengguna</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->userData->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="form-password" class="form-label fs-14 text-dark">Unique_id</label>
                        <input type="text" class="form-control disabled-input" name="unique_id" value="{{ $unique_id }}" required readonly>
                    </div>
                    <div class="mb-3">
                        <label for="form-capacity" class="form-label fs-14 text-dark">Capacity</label>
                        <input type="number" class="form-control" name="capacity" value="{{ old('capacity') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="form-latitude" class="form-label fs-14 text-dark">Latitude</label>
                        <input type="text" class="form-control disabled-input" name="latitude" placeholder="Biarkan kosong!" value="{{ old('latitude') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="form-longitude" class="form-label fs-14 text-dark">Longitude</label>
                        <input type="text" class="form-control disabled-input" name="longitude" placeholder="Biarkan kosong!" value="{{ old('longitude')}}" readonly>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </form>            
        </div>
    </div>
</div>

@endsection

@section('script')
    <!-- Internal Choices JS -->
    <script src="{{ asset('assets/js/choices.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#user_id').select2({
                placeholder: 'Pilih Pemilik Alat',
                allowClear: true
            });
        });
        
        function previewImage() {
            var preview = document.getElementById('preview-image');
            var fileInput = document.getElementById('image');
            var file = fileInput.files[0];
            
            if (file) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="width: 300px; height: 300px; border-radius: 50%; object-fit: cover;">';
                };

                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = ''; // Kosongkan pratinjau jika tidak ada gambar yang dipilih
            }
        }
    </script>

@endsection