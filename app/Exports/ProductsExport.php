<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Product::where('status', true)
            ->with(['category', 'supplier'])
            ->select('id', 'category_id', 'supplier_id', 'name', 'description', 'bar_code', 'sale_price', 'purchase_price', 'stock', 'min_stock', 'status')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'category' => $item->category->name ?? 'N/A',
                    'supplier' => $item->supplier->company_name ?? 'N/A',
                    'name' => $item->name,
                    'description' => $item->description,
                    'bar_code' => $item->bar_code,
                    'sale_price' => number_format($item->sale_price, 2),
                    'purchase_price' => number_format($item->purchase_price, 2),
                    'stock' => $item->stock,
                    'min_stock' => $item->min_stock,
                    'status' => $item->status ? 'Activo' : 'Inactivo'
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'Categoría',
            'Proveedor',
            'Nombre',
            'Descripción',
            'Código de Barras',
            'Precio Venta',
            'Precio Compra',
            'Stock',
            'Stock Mínimo',
            'Estado'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // ID
            'B' => 20,  // Categoría
            'C' => 25,  // Proveedor
            'D' => 25,  // Nombre
            'E' => 30,  // Descripción
            'F' => 18,  // Código de Barras
            'G' => 15,  // Precio Venta
            'H' => 15,  // Precio Compra
            'I' => 10,  // Stock
            'J' => 12,  // Stock Mínimo
            'K' => 10,  // Estado
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar wrap text y centrado a todas las celdas con contenido
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:K' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:K' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:K' . $highestRow)->getAlignment()->setVertical('center');
        
        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ],
            // Bordes para toda la tabla
            'A1:K' . $highestRow => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ]
        ];
    }
}