@extends('layout.main')

@section('title', 'Dashboard')

@section('css')

<style>
    #map {
        height: 400px;
        width: 100%;
    }
</style>

@endsection

@section('breadcumb')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <h1 class="page-title my-auto">Maps</h1>
        <div>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
            <a href="javascript:void(0)">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Maps</li>
        </ol>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

@endsection

@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">Maps</div>
            </div>
            <div class="card-body">
                <!-- Menambahkan style untuk memperbesar ukuran map -->
                <div id="google-map" style="height: 400px; width: 100%;"></div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')

<script>

function getAddressFromLatLng(lat, lng, callback) {
    var nominatimUrl = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng;

    $.ajax({
        url: nominatimUrl,
        method: 'GET',
        success: function(response) {
            if (response && response.display_name) {
                var address = response.display_name; // Dapatkan alamat
                callback(address); // Panggil callback dengan alamat
            } else {
                console.error('Tidak ada hasil geocoding atau kesalahan dalam permintaan.');
                callback(null);
            }
        },
        error: function(xhr, status, error) {
            console.error('Kesalahan saat memanggil API Nominatim:', error);
            callback(null);
        }
    });
}


    
function initMap() {
    // Inisialisasi peta
    var location = { lat: {{ $data->latitude }}, lng: {{ $data->longitude }} };

    var map = new google.maps.Map(document.getElementById('google-map'), {
        center: location, // Koordinat awal
        zoom: 12 // Tingkat zoom awal
    });

    function updateMap() {
        $.ajax({
            url: "{{ route('mapsIot.data') }}",
            method: 'GET',
            success: function(response) {
                var locations = response.locations;
                locations.forEach(function(location) {
                    var marker = new google.maps.Marker({
                        position: {lat: parseFloat(location.lat), lng: parseFloat(location.lng)},
                        map: map,
                        title: location.name,
                        icon: {
                            url: "{{ asset('icon-dashboard/recycling.png') }}", // Ganti dengan path ikon kustom Anda
                            scaledSize: new google.maps.Size(32, 32), // Ubah ukuran sesuai kebutuhan
                            origin: new google.maps.Point(0, 0), // Titik awal gambar
                            anchor: new google.maps.Point(16, 16) // Titik jangkar (tengah bawah)
                        }

                    });

                    getAddressFromLatLng(location.lat, location.lng, function(address) {
                        var content = `
                            <h5>${location.name}</h5>
                            Alamat: ${address}<br>
                            Berat Organic: ${location.organic}<br>
                            Berat Anorganic: ${location.anorganic}<br>
                            Berat Recyclable: ${location.recyclable}<br>
                            Berat Keseluruhan: ${location.all}<br>
                        `;

                        var infoWindow = new google.maps.InfoWindow({
                            content: content
                        });

                        marker.addListener('click', function() {
                            infoWindow.open(map, marker);
                        });
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

    // Update map setiap 5 menit
    setInterval(updateMap, 10000); // 300000 ms = 5 menit
    
    // Panggil pertama kali saat inisialisasi
    updateMap();
}

initializeMap(); // Inisialisasi peta


</script>
<!-- Sertakan Google Maps API dengan kunci API Anda -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBFIytYJl-mSVSkqZQ3PKvR0DcbKd3agvo&callback=initMap" async defer></script>

@endsection