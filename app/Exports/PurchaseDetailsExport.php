<?php

namespace App\Exports;

use App\Models\PurchaseDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PurchaseDetailsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return PurchaseDetail::with(['purchase.supplier', 'product', 'purchase.user'])
            ->select('id', 'purchase_id', 'product_id', 'quantity', 'unitary_cost', 'created_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'purchase_id' => $item->purchase_id,
                    'supplier' => $item->purchase->supplier->company_name ?? 'N/A',
                    'user' => $item->purchase->user->name ?? 'N/A',
                    'product' => $item->product->name ?? 'N/A',
                    'bar_code' => $item->product->bar_code ?? 'N/A',
                    'quantity' => $item->quantity,
                    'unitary_cost' => 'S/ ' . number_format($item->unitary_cost, 2),
                    'total_cost' => 'S/ ' . number_format($item->quantity * $item->unitary_cost, 2),
                    'created_at' => $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A'
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'ID Compra',
            'Proveedor',
            'Usuario',
            'Producto',
            'Código de Barras',
            'Cantidad',
            'Costo Unitario',
            'Costo Total',
            'Fecha Registro'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // ID
            'B' => 12,  // ID Compra
            'C' => 25,  // Proveedor
            'D' => 20,  // Usuario
            'E' => 30,  // Producto
            'F' => 18,  // Código de Barras
            'G' => 12,  // Cantidad
            'H' => 15,  // Costo Unitario
            'I' => 15,  // Costo Total
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