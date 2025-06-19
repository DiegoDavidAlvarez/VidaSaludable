<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuppliersExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
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

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // ID
            'B' => 15,  // RUC
            'C' => 30,  // Razón social
            'D' => 30,  // Dirección
            'E' => 15,  // Teléfono
            'F' => 30,  // Email
            'G' => 10,  // Estado
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar wrap text y centrado a todas las celdas con contenido
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:G' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:G' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:G' . $highestRow)->getAlignment()->setVertical('center');
        
        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ],
            // Bordes para toda la tabla
            'A1:G' . $highestRow => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ]
        ];
    }
}