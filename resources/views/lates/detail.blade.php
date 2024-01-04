@extends('layouts.template')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Your existing styles here */
    </style>
    <title>Detail Lates</title>
</head>
<style>
   .card-container {
    display: flex;
    justify-content: space-between;
    margin-top: 50px;
    flex-wrap: wrap; /* Allow the cards to wrap to the next row */
}

    .card {
        flex: 0 0 calc(33.33% - 20px); /* Adjust the width based on the number of cards you want in a row */
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-content {
        margin-bottom: 20px;
    }

    .card img {
        max-width: 100%;
        max-height: 100%;
        object-fit: cover;
        border-radius: 8px;
        margin-top: 16px;
    }

    h5{
        font-size: 2px;
    }
</style>

<body>
    @section('content')
    <div class="container">
        @if (Auth::check() && Auth::user()->role == 'admin')
        <h1>Detail Data Keterlambatan</h1>
        <div class="mb-1">
            <a href="{{ route('lates.index') }}">Data Keterlambatan / </a>
            <a href="{{ route('lates.create') }}">Tambah Data Keterlambatan / </a>
            <a href="{{ route('lates.rekap') }}">Rekapitulasi Data Keterlambatan</a>
        </div><br>
        @foreach ($siswa as $siswaItem)
        <h5>{{ $siswaItem['name'] }} | {{ $siswaItem['nis'] }} | {{ $siswaItem['rombel'] }} | {{ $siswaItem['rayon'] }}</h5>
        @endforeach
        <div class="card-container">
            @foreach ($siswa as $siswaItem)
                @foreach ($siswaItem['records'] as $index => $record)
                    <div class="card" id="card-{{ $siswaItem['nis'] }}">
                        <p class="card-content">{{ $siswaItem['name'] }}</p>
                        <p class="card-content">{{ $siswaItem['nis'] }}</p>
                        <p class="card-content date-time-late">{{ $record['date_time_late'] }}</p>
                        <p class="card-content"><img src="{{ asset($record['bukti']) }}" alt="Bukti"></p>
                        <p class="card-content">Keterlambatan Ke - <span class="late-index">{{ $index + 1 }}</span></p>
                    </div>
                @endforeach
            @endforeach
        </div>
        </div>

    @else
    <div class="container">
        <h1>Detail Data Keterlambatan</h1>
        <div class="mb-1">
            <a href="{{ route('lates-ps.index') }}">Data Keterlambatan / </a>
            <a href="{{ route('lates-ps.rekap') }}">Rekapitulasi Data Keterlambatan</a>
        </div><br>
        @foreach ($siswa as $siswaItem)
        <h5>{{ $siswaItem['name'] }} | {{ $siswaItem['nis'] }} | {{ $siswaItem['rombel'] }} | {{ $siswaItem['rayon'] }}</h5>
        @endforeach
    <div class="card-container">
        @foreach ($siswa as $siswaItem)
            @foreach ($siswaItem['records'] as $index => $record)
                <div class="card" id="card-{{ $siswaItem['nis'] }}">
                    <p class="card-content">{{ $siswaItem['name'] }}</p>
                    <p class="card-content">{{ $siswaItem['nis'] }}</p>
                    <p class="card-content date-time-late">{{ $record['date_time_late'] }}</p>
                    <p class="card-content"><img src="{{ asset($record['bukti']) }}" alt="Bukti"></p>
                    <p class="card-content">Keterlambatan Ke - <span class="late-index">{{ $index + 1 }}</span></p>
                </div>
            @endforeach
        @endforeach
    </div>
    </div>
    @endif
    @endsection
</body>

</html>
