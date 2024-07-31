@extends('layout.main')

@section('title', 'Tambah Jadwal')

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
            <li class="breadcrumb-item active" aria-current="page">Tambah Jadwal</li>
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
                    Tambah Jadwal
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-md-12">
                <form id="form" action="{{ route('schedule.store') }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @csrf
                        <input id="id" name="id" type="hidden" value="" class="">
                        <select class="form-select" data-trigger name="date" aria-label="Default select example mb-4" required>
                            <option selected>Pilih Tanggal</option>
                            @foreach($availableDates as $availableDate)
                                <option value="{{ $availableDate->id }}">{{ $availableDate->tanggal }}</option>
                            @endforeach
                        </select>                        
                        <div class="input-group mt-4">
                            <div class="input-group-text text-muted"> <i class="ri-time-line"></i> </div>
                            <input type="text" class="form-control" name="time" id="timepickr1" placeholder="Choose time in 24hr format" value="{{ old('time') }}" required>
                        </div>
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

<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/date&time_pickers.js') }}"></script>
    <!-- Internal Choices JS -->
<script src="{{ asset('assets/js/choices.js') }}"></script>

<script>
    flatpickr("#timepickr1", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    flatpickr("#date", {});
</script>

@endsection