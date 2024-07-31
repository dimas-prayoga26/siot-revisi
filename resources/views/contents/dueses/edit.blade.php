@extends('layout.main')

@section('title', 'Edit Tagihan')

@section('css')

<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />


@endsection

@section('breadcumb')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
            <a href="javascript:void(0)"></a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Edit Tagihan</li>
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
                    Edit Tagihan
                </div>
            </div>
            <form id="form" action="{{ route('dueses.update', $dueses->id) }}" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                    @csrf
                    @method('PUT')
                    <input id="id" name="id" type="hidden" value="{{ $dueses->id }}">
                    <div class="mb-3">
                        <p class="fw-semibold mb-2">Nama Pemilik Alat</p>
                        <select class="form-control" data-trigger name="user_id" id="user_id" required>
                            <option value="">Pilih pengguna</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $dueses->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->userdata->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <p class="fw-semibold mb-2">Nominal</p>
                        <select class="form-control" data-trigger name="nominal_id" id="nominal_id" required>
                            <option value="">Pilih Nominal</option>
                            @foreach($nominals as $nominal)
                                <option value="{{ $nominal->id }}" {{ $dueses->meta_dues_nominal_id == $nominal->id ? 'selected' : '' }}>
                                    {{ $formatRupiah($nominal->nominal) }}
                                </option>
                            @endforeach
                        </select>
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

<script src="{{ asset('assets/js/choices.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#user_id').select2({
            placeholder: 'Nama Pemilik Alat',
            allowClear: true
        });
    });
</script>

@endsection