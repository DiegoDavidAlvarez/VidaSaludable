<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuppliersExport implements FromCollection, WithHeadings, WithStyles
{
    public function collection()
    {
        return Supplier::where('status', true)
            ->select('id', 'ruc', 'company_name','address','phone_number','email', 'status')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'ruc' => $item->ruc,
                    'company_name' => $item->company_name,
                    'address' => $item->address,
                    'phone_number' => $item->phone_number,
                    'email' => $item->email,
                    'status' => $item->status ? 'Activo' : 'Inactivo'
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'RUC',
            'Razon social',
            'Direccion',
            'Telefono',
            'Email',
            'Estado'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']]
            ],
            // Bordes para toda la tabla
            'A1:D' . ($sheet->getHighestRow()) => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ]
            ],
            // Ajustar ancho de columnas
            'A' => ['width' => 5],
            'B' => ['width' => 20],
            'C' => ['width' => 40],
            'D' => ['width' => 20],
            'E' => ['width' => 20],
            'F' => ['width' => 20],
            'G' => ['width' => 20],
        ];
    }
}
