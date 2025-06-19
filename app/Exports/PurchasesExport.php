<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchasesExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Purchase::with(['user', 'supplier'])
            ->select('id', 'user_id', 'supplier_id', 'date', 'total', 'receipt_type', 'created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'user' => $item->user->name ?? 'N/A',
                    'supplier' => $item->supplier->company_name ?? 'N/A',
                    'date' => $item->date ? date('d/m/Y', strtotime($item->date)) : 'N/A',
                    'total' => 'S/ ' . number_format($item->total, 2),
                    'receipt_type' => $item->receipt_type,
                    'created_at' => $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A'
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'Usuario',
            'Proveedor',
            'Fecha Compra',
            'Total',
            'Tipo Comprobante',
            'Fecha Registro'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // ID
            'B' => 20,  // Usuario
            'C' => 25,  // Proveedor
            'D' => 15,  // Fecha Compra
            'E' => 15,  // Total
            'F' => 20,  // Tipo Comprobante
            'G' => 18,  // Fecha Registro
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