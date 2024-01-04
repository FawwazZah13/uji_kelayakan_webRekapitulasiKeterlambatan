<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Pernyataan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .content {
            text-align: justify;
            line-height: 1.5;
        }
        .signature {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <h2>SURAT PERNYATAAN TIDAK AKAN DATANG TERLAMBAT KESEKOLAH</h2>
    @foreach ($lates as $item)
    <div class="container">
        <div class="content">
            <p>Yang bertanda tangan dibawah ini:</p>
            <p>NIS: {{ $item->nis }}</p>
            <p>Nama: </p>
            <p>Rombel PPLGX0-1</p>
            <p>Rayon Wikrama 1</p>
            <p>Dengan ini menyatakan bahwa saya telah melakukan pelanggaran tata tertib sekolah, yaitu terlambat datang ke sekolah sebanyak 3 Kali yang mana hal tersebut termasuk kedalam pelanggaran kedisiplinan. Saya berjanji tidak akan terlambat datang ke sekolah lagi. Apabila saya terlambat datang ke sekolah lagi saya siap diberikan sanksi yang sesuai dengan peraturan sekolah.</p>
            <p>Demikian surat penyataan terlambat ini saya buat dengan penuh penyesalan.</p>
            <p>Bogor, 24 November 2023</p>
            <div class="signature">
                <p>Orang Tua/Wali Peserta Didik,</p>
                <p>Peserta Didik,</p>
                <p>(UI) Pembimbing Siswa Kesiswaan, (PS Wikrama 1)</p>
            </div>
        </div>
    </div>
@endforeach

</body>
</html>
