@extends('layouts.template')

@section('content')
    @if (Auth::check() && Auth::user()->role == 'ps')
        <h1>Data Keterlambatan</h1>
        <div class="data">
            <a href="{{ route('lates-ps.index') }}"style="margin-bottom: 10px; ">Keseluruhan Data | </a>
            <a href="{{ route('lates-ps.rekap') }}"style="margin-bottom: 10px; ">Rekapitulasi Data</a>
        </div>
        <div class="col-md-12">
            <form action="{{ route('lates-ps.filter') }}" method="post">
                @csrf
                <div class="input-group">
                    <input type="text" name="filter" id="filter" class="form-control m-2">
                    <div class="input-group-append">
                        <button class="btn btn-info m-2" id="cari_data">Cari Data</button>
                    </div>
                    <a href="{{ route('lates-ps.index') }}" class="btn btn-warning m-2">Muat Data Semula</a>
                </div>
                <div class="input-group">
                    <input type="number" class="form-control m-1" id="jumlah_data" name="jumlah_data" min="1"
                        placeholder="entries page">
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
                    <th>Nis</th>
                    <th>Rombel</th>
                    <th>Rayon</th>
                    <th>Tanggal</th>
                    <th>informasi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($lates as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['nis'] }}</td>
                        <td>{{ $item->rombel }}</td>
                        <td>{{ $item->rayon }}</td>
                        <td>{{ $item->date_time_late }}</td>
                        <td>{{ $item->information }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endif
    @if (Auth::check() && Auth::user()->role == 'admin')
        <h1>Data Keterlambatan</h1>
        @if (Session::get('great'))
            <div class="alert alert-success">{{ Session::get('great') }}</div>
        @endif
        @if (Session::get('deleted'))
            <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
        @endif
        <a href="{{ route('lates.create') }}" class="btn btn-primary" style="margin-bottom: 10px; ">Tambah Data</a>
        <div class="data">
            <a href="{{ route('lates.index') }}"style="margin-bottom: 10px; ">Keseluruhan Data | </a>
            <a href="{{ route('lates.rekap') }}"style="margin-bottom: 10px; ">Rekapitulasi Data</a>
        </div>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nis</th>
                    <th>Rombel</th>
                    <th>Rayon</th>
                    <th>Tanggal</th>
                    <th>informasi</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($lates as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['nis'] }}</td>
                        <td>{{ $item['rombel'] }}</td>
                        <td>{{ $item['rayon'] }}</td>
                        <td>{{ $item['date_time_late'] }}</td>
                        <td>{{ $item['information'] }}</td>

                        <td class="d-flex justify-content-center">
                            <a href="{{ route('lates.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                            <form action="{{ route('lates.destroy', $item['id']) }}" method="POST">
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
            window.location.href = "{{ route('lates-ps.index') }}?jumlah_data=" + jumlahData;
        }
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
@endsection
