<?php

// namespace App\Exports;

// use App\Models\lates;
// use Illuminate\Support\Collection;
// use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithStyles;
// use Illuminate\Http\Request;

// class RekapitulasiExportPs implements FromCollection, WithHeadings, WithStyles
// {
//     public function collection()
//     {
//         $latesData = lates::all();

//         // Kelompokkan data berdasarkan NIS
//         $groupedData = $latesData->groupBy('nis');

//         // Ambil satu baris data untuk setiap NIS
//         $transformedData = $groupedData->map(function ($group) {
//             $lates = $group->first(); // Ambil satu data untuk setiap NIS

//             $siswa = [];
//             foreach ($group as $item) {
//                 $nis = $item->nis;

//                 if (!isset($siswa[$nis])) {
//                     $siswa[$nis] = [
//                         'name' => $item->name,
//                         'nis' => $nis,
//                         'rombel' => $item->rombel,
//                         'rayon' => $item->rayon,
//                         'jumlahKeterlambatan' => 0,
//                     ];
//                 }

//                 // Perform logic to calculate the jumlahKeterlambatan for each student
//                 $siswa[$nis]['jumlahKeterlambatan'] += $this->calculateJumlahKeterlambatan($item);
//             }

//             return [
//                 'nis' => $lates->nis,
//                 'name' => $lates->name,
//                 'rombel' => $lates->rombel,
//                 'rayon' => $lates->rayon,
//                 'jumlahKeterlambatan' => $siswa[$lates->nis]['jumlahKeterlambatan'],
//             ];
//         });

//         return $transformedData->values(); // Ambil nilai-nilai array
//     }

//     private function calculateJumlahKeterlambatan($lates)
//     {
//         // Your logic to calculate jumlahKeterlambatan based on $nis
//         // For example, increment jumlahKeterlambatan by 1 for each student with the same nis
//         $jumlahKeterlambatan = 1;

//         return $jumlahKeterlambatan;
//     }


//     public function styles(Worksheet $sheet)
//     {
//         // Styling untuk header
//         $sheet->getStyle('A1:E1')->applyFromArray([
//             'font' => [
//                 'bold' => true,
//             ],
//             'fill' => [
//                 'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
//                 'startColor' => ['rgb' => 'DDDDDD'],
//             ],
//         ]);

//         // Styling untuk sel data
//         $sheet->getStyle('A2:E' . $sheet->getHighestRow())->applyFromArray([
//             'font' => [
//                 'bold' => false,
//             ],
//         ]);
//     }

//     // Metode untuk menentukan heading (judul) pada excel
//     public function headings(): array
//     {
//         return [
//             'NIS',
//             'Nama',
//             'Rombel',
//             'Rayon',
//             'Jumlah Keterlambatan'
//         ];
//     }
// }

namespace App\Exports;
use App\Models\lates; // Sesuaikan dengan namespace yang sesuai
use Illuminate\Support\Collection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;

class RekapitulasiExportPs implements FromCollection, WithHeadings, WithStyles
{
    private $rayon;
    private $rayonNumber;

    public function __construct($rayon, $rayonNumber)
    {
        $this->rayon = $rayon;
        $this->rayonNumber = $rayonNumber;
    }

    public function collection()
    {
        $latesData = lates::with('rayon')
            ->whereHas('rayon', function ($query) {
                $query->where('rayon', $this->rayon . ' ' . $this->rayonNumber);
            })
            ->get();

        $groupedData = $latesData->groupBy('nis');

        $transformedData = $groupedData->map(function ($group) {
            $lates = $group->first();

            $siswa = [];
            foreach ($group as $item) {
                $nis = $item->nis;

                if (!isset($siswa[$nis])) {
                    $siswa[$nis] = [
                        'name' => $item->name,
                        'nis' => $nis,
                        'rombel' => $item->rombel,
                        'rayon' => $item->rayon,
                        'jumlahKeterlambatan' => 0,
                    ];
                }

                $siswa[$nis]['jumlahKeterlambatan'] += $this->calculateJumlahKeterlambatan($item);
            }

            return [
                'nis' => $lates->nis,
                'name' => $lates->name,
                'rombel' => $lates->rombel,
                'rayon' => $lates->rayon,
                'jumlahKeterlambatan' => $siswa[$lates->nis]['jumlahKeterlambatan'],
            ];
        });

        return $transformedData->values();
    }

    private function calculateJumlahKeterlambatan($lates)
    {
        // Implementasi logika Anda untuk menghitung jumlah keterlambatan berdasarkan $nis
        // Misalnya, tingkatkan jumlah keterlambatan sebanyak 1 untuk setiap siswa dengan nis yang sama
        $jumlahKeterlambatan = 1;

        return $jumlahKeterlambatan;
    }

    public function styles(Worksheet $sheet)
    {
        // Styling untuk header
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'DDDDDD'],
            ],
        ]);

        // Styling untuk sel data
        $sheet->getStyle('A2:E' . $sheet->getHighestRow())->applyFromArray([
            'font' => [
                'bold' => false,
            ],
        ]);
    }

    public function headings(): array
    {
        return [
            'NIS',
            'Nama',
            'Rombel',
            'Rayon',
            'Jumlah Keterlambatan',
        ];
    }
}