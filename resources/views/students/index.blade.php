@extends('layouts.template')

@section('content')
    @if (Auth::check() && Auth::user()->role == "ps")
        <h1>Data Siswa</h1>
        <div class="col-md-12">
            <form action="{{ route('students-ps.filter') }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" name="filter" id="filter" class="form-control m-2">
                    <div class="input-group-append">
                        <button class="btn btn-info m-2" id="cari_data">Cari Data</button>
                    </div>
                    <a href="{{ route('students-ps.index') }}" class="btn btn-warning m-2">Muat Data Semula</a>
                </div>
                <div class="input-group">
                    <input type="number" class="form-control m-1" id="jumlah_data" name="jumlah_data" min="1" placeholder="entries page">    
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary m-1" onclick="updateData()">Klik</button>
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Rombel</th>
                    <th>Rayon</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($students as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->nis }}</td>
                        <td>{{ $item->rombel->rombel }}</td>
                        <td>{{ $item->rayon->rayon }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <h1>Data Siswa</h1>
        <div class="mb-1">
            <a href="{{ route('students.index') }}">Data Siswa / </a>
            <a href="{{ route('students.create') }}">Tambah Data Siswa</a>
        </div>
        @if (Session::get('great'))
            <div class="alert alert-success">{{ Session::get('great') }}</div>
        @endif
        @if (Session::get('deleted'))
            <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
        @endif
        
        <a href="{{ route('students.create') }}" class="btn btn-primary ms-auto" style="margin-bottom: 10px;">Tambah Data</a>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Rombel</th>
                    <th>Rayon</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($students as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['nis'] }}</td>
                        <td>{{ $item['rombel']['rombel'] }}</td>
                        <td>{{ $item['rayon']['rayon'] }}</td>

                        <td class="d-flex justify-content-center">
                            <a href="{{ route('students.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                            <form action="{{ route('students.destroy', $item['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <script>
        function updateData() {
            var jumlahData = document.getElementById("jumlah_data").value;
            window.location.href = "{{ route('students-ps.index') }}?jumlah_data=" + jumlahData;
        }
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
@endsection
