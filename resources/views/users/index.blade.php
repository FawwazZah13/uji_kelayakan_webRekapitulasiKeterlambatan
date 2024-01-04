@extends('layouts.template')

@section('content')
    <h1>Data Users</h1>
    <div class="mb-1">
        <a href="{{ route('users.index') }}">Data User / </a>
        <a href="#">Edit Data User</a>
    </div>
    <div class="container border py-4 rounded">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('deleted'))
            <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
        @endif

        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-secondary" href="{{ route('users.create') }}">Tambah</a>
        </div>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>role</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($users as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->role }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('users.edit', $item->id) }}" class="btn btn-primary me-3">Edit</a>
                            <form action="{{ route('users.destroy', $item['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
