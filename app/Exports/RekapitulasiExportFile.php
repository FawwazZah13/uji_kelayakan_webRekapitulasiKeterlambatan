<?php
namespace App\Exports;

use App\Models\Lates;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapitulasiExportFile implements FromCollection, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $latesData = lates::all();

        // Kelompokkan data berdasarkan NIS
        $groupedData = $latesData->groupBy('nis');

        // Ambil satu baris data untuk setiap NIS
        $transformedData = $groupedData->map(function ($group) {
            $lates = $group->first(); // Ambil satu data untuk setiap NIS

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

                // Perform logic to calculate the jumlahKeterlambatan for each student
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

        return $transformedData->values(); // Ambil nilai-nilai array
    }

    private function calculateJumlahKeterlambatan($lates)
    {
        // Your logic to calculate jumlahKeterlambatan based on $nis
        // For example, increment jumlahKeterlambatan by 1 for each student with the same nis
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

    // Metode untuk menentukan heading (judul) pada excel
    public function headings(): array
    {
        return [
            'NIS',
            'Nama',
            'Rombel',
            'Rayon',
            'Jumlah Keterlambatan'
        ];
    }
}