@extends('layouts.template')

@section('content')
<h1>Tambah Data Siswa</h1>
<div class="mb-1">
    <a href="{{ route('students.index') }}">Data Siswa / </a>
    <a href="{{ route('students.create') }}">Tambah Data Siswa</a>
</div>
    <form action="{{ route('students.store') }}" method="POST" class="card p-5">
        @csrf

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

        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="nis" class="col-sm-2 col-form-label">NIS :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nis" name="nis">
            </div>
        </div>
        <div class="mb-3 row">
        <label for="rombel" class="col-sm-2 col-form-label">Rombel :</label>
        <div class="col-sm-10">
        <select name="rombel_id" id="rombel_id" class="form-select">
            <option value="" disabled selected>Select Rombel</option>
            @foreach ($rombels as $rombel)
                <option value="{{ $rombel->id }}">{{ $rombel->rombel }}</option>
            @endforeach
        </select>
        </div>
        </div>
        
        <div class="mb-3 row">
            <label for="rombel" class="col-sm-2 col-form-label">Rayon :</label>
            <div class="col-sm-10">
        <select name="rayon_id" id="rayon_id" class="form-select">
            <option value="" disabled selected>Select Rayon</option>
            @foreach ($rayons as $rayon)
                <option value="{{ $rayon->id }}">{{ $rayon->rayon }}</option>
            @endforeach
        </select>
    </div>
</div>
        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
    </form>
    <a href="#" class="theme-toggle">
        <i class="fa-regular fa-moon"></i>
        <i class="fa-regular fa-sun"></i>
    </a>
@endsection