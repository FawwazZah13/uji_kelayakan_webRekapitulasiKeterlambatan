@extends('layouts.template')

@section('content')

<h1>Form Edit Data Keterlambatan</h1>
    <form action="{{ route('lates.update', ['id' => $lates->id]) }}" method="POST" class="card p-5" enctype="multipart/form-data">
        @csrf
@method('PUT')
        @if(Session::get('success'))
            <div class="alert alert-success"> {{ Session::get('success') }} </div>
        @endif
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <style>
                img {
            max-width: 100px;
            max-height: 100px;
            margin-top: 5px;
        }
        </style>
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Siswa:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $lates['name'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nis" class="col-sm-2 col-form-label">NIS:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nis" name="nis" value="{{ $lates['nis'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="rombel" class="col-sm-2 col-form-label">Rombel:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="rombel" name="rombel" value="{{ $lates['rombel'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="rayon" class="col-sm-2 col-form-label">Rayon:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="rayon" name="rayon" value="{{ $lates['rayon'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="date_time_late" class="col-sm-2 col-form-label">Tanggal:</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" id="date_time_late" name="date_time_late" value="{{ $lates['date_time_late'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="information" class="col-sm-2 col-form-label">Keterangan Keterlambatan:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="information" name="information" value="{{ $lates['information'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="bukti" class="col-sm-2 col-form-label">Bukti:</label>
            <div class="col-sm-10">
                <input type="file" class="form-control" id="bukti" name="bukti" value="{{ $lates->bukti }}">
                @if($lates->bukti)
                    {{-- Display existing image --}}
                    <img src="{{ asset($lates->bukti) }}" alt="Bukti Image" style="max-width: 100%; height: auto;">
                @endif
            </div>
            <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
        </div>
    </form>
    <a href="#" class="theme-toggle">
        <i class="fa-regular fa-moon"></i>
        <i class="fa-regular fa-sun"></i>
    </a>
@endsection