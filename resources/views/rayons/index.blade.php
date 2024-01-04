@extends ('layouts.template')

@section('content')
<h1>Data Rayon</h1>
<div class="mb-1">
    <a href="{{ route('rayons.index') }}">Data Rayon / </a>
    <a href="{{ route('rayons.create') }}">Tambah Data Rayon</a>
</div>
    @if(Session::get('great'))
        <div class="alert alert-success">{{ Session::get('great') }}</div>
    @endif
    @if(Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <a href="{{ route('rayons.create') }}" class="btn btn-primary" style="margin-bottom: 10px; ">Tambah Data</a>
   

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Rayon</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($rayons as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item['rayon'] }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('rayons.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                        <form action="{{ route('rayons.destroy', $item['id']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
            </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
