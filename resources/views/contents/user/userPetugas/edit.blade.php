@extends('layout.main')

@section('title', 'Edit Petugas')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">


@endsection

@section('breadcumb')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
            <a href="javascript:void(0)"></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit Petugas</li>
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
                    Edit Petugas
                </div>
            </div>
            <form id="form" action="{{ route('petugas.update', $petugas->id) }}" method="POST" enctype="multipart/form-data">
            <div class="card-body">
                @csrf
                @method('PUT')
                {{-- @dd($petugas->name) --}}
                <input id="id" name="id" type="hidden" value="{{ $petugas->id }}">
                <div class="mb-3">
                    <label for="form-password" class="form-label fs-14 text-dark">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') ?? $petugas->name }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="form-password" class="form-label fs-14 text-dark">Nomor Hp</label>
                    <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') ?? $petugas->phone_number }}" required>
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="form-password" class="form-label fs-14 text-dark">Alamat</label>
                    <input type="text" class="form-control" name="address" value="{{ old('address') ?? $petugas->address }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="form-password" class="form-label fs-14 text-dark">Foto</label>
                    <input type="file" id="image" class="form-control" name="image" accept="image/*" onchange="previewImage()">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mt-3" id="preview-image"></div>
                </div>                
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
    <script>
        function previewImage() {
            var preview = document.getElementById('preview-image');
            var fileInput = document.getElementById('image');
            var file = fileInput.files[0];
            
            if (file) {
                var reader = new FileReader();
                
                reader.onload = function (e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview" style="max-width:300px;max-height:300px;">';
                };
                
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = ''; // Kosongkan pratinjau jika tidak ada gambar yang dipilih
            }
        }
    </script>
@endsection