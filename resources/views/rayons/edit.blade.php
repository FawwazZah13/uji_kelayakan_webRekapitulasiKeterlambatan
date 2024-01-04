@extends('layouts.template')

@section( 'content' )
<h1>Edit Data Rayon</h1>
<div class="mb-1">
    <a href="{{ route('rayons.index') }}">Data Rayon / </a>
    <a href="{{ route('rayons.create') }}">Tambah Data Rayon</a>
</div>
<form action="{{ route('rayons.update', ['id' => $rayons->id]) }}" method="POST">
    @csrf
    @method('PUT')
        @if(Session::get('success'))
            <div class="alert alert-success"> {{ Session::get('success') }}</div>
        @endif
        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        
    <div class="mb-3 row">
        <label for="rayon"  class="col-sm-2 col-form-label">Rayon:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="rayon" name="rayon" autocomplete="off" value="{{ $rayons->rayon }}">
        </div>
    </div>
    <div class="mb-2 row">
        <label for="pembimbing" class="col-sm-2 col-form-label">Pembimbing Siswa:</label>
        <div class="col-sm-10">
            <select class="form-select" id="pembimbing" name="pembimbing" aria-label="Pembimbing Siswa">
                @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
            </select>
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Simpan</button>
</form>
<a href="#" class="theme-toggle">
    <i class="fa-regular fa-moon"></i>
    <i class="fa-regular fa-sun"></i>
</a>

@endsection

