@extends('layouts.template')

@section('content')
<h1>Edit Data Rombel</h1>
<div class="mb-1">
    <a href="{{ route('rombels.index') }}">Data Rombel / </a>
    <a href="{{ route('rombels.create') }}">Tambah Data Rombel</a>
</div>
<form action="{{ route('rombels.update', $rombels['id']) }}" method="POST" class="card p-5">
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

        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Rombel :</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" value="{{ $rombels->rombel }}" id="rombel" name="rombel">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
    </form>
    <a href="#" class="theme-toggle">
        <i class="fa-regular fa-moon"></i>
        <i class="fa-regular fa-sun"></i>
    </a>
@endsection