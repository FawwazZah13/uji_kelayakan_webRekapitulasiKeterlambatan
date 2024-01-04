@extends ('layouts.template')

@section('content')
@if (Auth::check() && Auth::user()->role == 'admin')
<h1>Data Rayon</h1>
    @if(Session::get('great'))
        <div class="alert alert-success">{{ Session::get('great') }}</div>
    @endif
    @if(Session::get('deleted'))
        <div class="alert alert-warning">{{ Session::get('deleted') }}</div>
    @endif
    <a href="{{ route('lates.create') }}" class="btn btn-primary" style="margin-bottom: 10px; ">Tambah Data</a>
    <a href="{{ route('export-excel') }}" class="btn btn-info" style="margin-bottom: 10px;">Export Data Keterlambatan</a>

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
                <th>Jumlah Keterlambatan</th>
                <th>Detail</th>
                <th>Cetak Surat</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($siswa as $item)
                <tr>
                    <td>{{ $no++ }}</td>
<td>{{ $item['name'] }}</td>
<td>{{ $item['nis'] }}</td>
<td>{{ $item['rombel'] }}</td>
<td>{{ $item['rayon'] }}</td>
<td>{{ $item['jumlahKeterlambatan'] }}</td>
<td>
    <a href="{{ route('lates.detail', ['nis' => $item['nis']]) }}" class="btn btn-secondary">Lihat</a>
</td>
                    <td>
                    
                        @if ($item['jumlahKeterlambatan'] >= 3)
                            <a href="{{ route('lates.download', ['id' => $item['nis']]) }}" class="btn-print btn btn-primary">Cetak (.pdf)</a>
                        @endif
                    </td>

                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">Yakin ingin menghapus Akun  ?</div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                {{-- <form action="{{ route('lates.destroy', $item['id']) }}" method="post"> --}}
                                <form action="" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-primary">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            </tr>
        @endforeach
    </tbody>
</table>

@else
<h1>Rekapitulasi Keterlambatan</h1>

<a href="{{ route('lates-ps.export-excel') }}" class="btn btn-info" style="margin-bottom: 10px;">Export Data Keterlambatan</a>
<div class="data">
    <a href="{{ route('lates-ps.index') }}" style="margin-bottom: 10px;">Keseluruhan Data | </a>
    <a href="{{ route('lates-ps.rekap') }}" style="margin-bottom: 10px;">Rekapitulasi Data</a>
</div>
<div class="col-md-12">
    <form action="{{ route('lates-ps.rekap') }}" method="post">
        @method('GET')
        @csrf
        <div class="input-group">
            <input type="text" name="filter" id="filter" class="form-control m-2">
            <div class="input-group-append">
                <button class="btn btn-info m-2" id="cari_data">Cari Data</button>
            </div>
            <a href="{{ route('lates-ps.rekap') }}" class="btn btn-warning m-2">Muat Data Semula</a>
        </div>
        <div class="input-group">
            <input type="number" class="form-control m-1" id="jumlah_data" name="jumlah_data" min="1"
                placeholder="entries page">
            <div class="input-group-append">
                <button type="button" class="btn btn-primary m-1" onclick="updateData()">Klik</button>
            </div>
        </div>
    </form>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Nis</th>
            <th>Jumlah Keterlambatan</th>
            <th>Detail</th>
            <th>Cetak Surat</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($siswa as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item['name'] }}</td>
                <td>{{ $item['nis'] }}</td>
                <td>{{ $item['jumlahKeterlambatan'] }}</td>
                <td>
                    <a href="{{ route('lates-ps.detail', ['nis' => $item['nis']]) }}" class="btn btn-secondary">Lihat</a>
                </td>
                <td>
                    @if ($item['jumlahKeterlambatan'] >= 3)
                        <a href="{{ route('lates-ps.download', ['id' => $item['nis']]) }}" class="btn-print btn btn-primary">Cetak (.pdf)</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif
<script>
    function updateData() {
        var jumlahData = document.getElementById("jumlah_data").value;
        window.location.href = "{{ route('lates-ps.rekap') }}?jumlah_data=" + jumlahData;
    }
</script>
<script src="{{ asset('js/script.js') }}"></script>
@endsection
