<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SalesExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Sale::with(['user', 'customer'])
            ->select('id', 'user_id', 'customer_id', 'date', 'total', 'receipt_type', 'igv', 'subtotal', 'created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'user' => $item->user->name ?? 'N/A',
                    'customer' => trim(($item->customer->nombres ?? '') . ' ' . ($item->customer->apellidos ?? '')) ?: 'N/A',
                    'customer_document' => $item->customer->numero_documento ?? 'N/A',
                    'date' => $item->date ? date('d/m/Y', strtotime($item->date)) : 'N/A',
                    'subtotal' => 'S/ ' . number_format($item->subtotal ?? 0, 2),
                    'igv' => 'S/ ' . number_format($item->igv ?? 0, 2),
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
            'Cliente',
            'Documento Cliente',
            'Fecha Venta',
            'Subtotal',
            'IGV',
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
            'C' => 30,  // Cliente
            'D' => 18,  // Documento Cliente
            'E' => 15,  // Fecha Venta
            'F' => 15,  // Subtotal
            'G' => 12,  // IGV
            'H' => 15,  // Total
            'I' => 20,  // Tipo Comprobante
            'J' => 18,  // Fecha Registro
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar wrap text y centrado a todas las celdas con contenido
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:J' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:J' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:J' . $highestRow)->getAlignment()->setVertical('center');
        
        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ],
            // Bordes para toda la tabla
            'A1:J' . $highestRow => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ]
        ];
    }
}