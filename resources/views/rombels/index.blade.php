@extends('layouts.template')

@section('content')
    <h1>Data Rombel</h1>
    <div class="mb-1">
        <a href="{{ route('rombels.index') }}">Data Rombel / </a>
        <a href="{{ route('rombels.create') }}">Tambah Data Rombel</a>
    </div>
    <div class="container border py-4 rounded">
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('deleted'))
            <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
        @endif
        <div class="col-md-6">
            <form action="{{ route('rombels.filter') }}" method="post"> 
                @csrf
                <div class="input-group">
                    <input type="text" name="filter" id="filter" class="form-control m-2">
                    <div class="input-group-append">
                        <button class="btn btn-info m-2" id="cari_data">Cari Data</button>
                    </div>
                    <a href="{{ route('rombels.index') }}" class="btn btn-warning m-2">Muat Data Semula</a>
                </div>
                <div class="input-group">
                    <input type="number" class="form-control m-1" id="jumlah_data" name="jumlah_data" min="1" placeholder="entries page">    
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary m-1" onclick="updateData()">Klik</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-secondary" href="{{ route('rombels.create') }}">Tambah</a>
        </div>

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Rombel</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($rombels as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->rombel }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('rombels.edit', $item->id) }}" class="btn btn-primary me-3">Edit</a>
                            <form action="{{ route('rombels.destroy', $item['id']) }}" method="POST">
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
    <script>
        function updateData() {
            var jumlahData = document.getElementById("jumlah_data").value;
            window.location.href = "{{ route('rombels.index') }}?jumlah_data=" + jumlahData;
        }
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
@endsection
