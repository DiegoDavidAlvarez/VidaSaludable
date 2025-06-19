<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SaleReceiptExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $sale;

    public function __construct($sale)
    {
        $this->sale = $sale;
    }

    public function collection()
    {
        // Crear una colección con los datos de la venta en formato tabular
        $data = collect();
        
        // Información básica de la venta
        $data->push([
            'campo' => 'ID Venta',
            'valor' => '#' . $this->sale->id
        ]);
        
        $data->push([
            'campo' => 'Tipo de Comprobante',
            'valor' => $this->sale->receipt_type
        ]);
        
        $data->push([
            'campo' => 'Fecha',
            'valor' => \Carbon\Carbon::parse($this->sale->fecha)->format('d/m/Y')
        ]);
        
        // Información del cliente
        $data->push([
            'campo' => 'Cliente',
            'valor' => $this->sale->customer->nombres . ' ' . $this->sale->customer->apellidos
        ]);
        
        $data->push([
            'campo' => 'Documento Cliente',
            'valor' => $this->sale->customer->numero_documento
        ]);
        
        // Totales
        $data->push([
            'campo' => 'Subtotal',
            'valor' => 'S/ ' . number_format($this->sale->subtotal, 2)
        ]);
        
        $data->push([
            'campo' => 'IGV',
            'valor' => 'S/ ' . number_format($this->sale->igv, 2)
        ]);
        
        $data->push([
            'campo' => 'Total',
            'valor' => 'S/ ' . number_format($this->sale->total, 2)
        ]);
        
        // Agregar productos como filas adicionales
        foreach ($this->sale->saleDetails as $index => $detail) {
            $data->push([
                'campo' => 'Producto ' . ($index + 1),
                'valor' => $detail->product->name . ' (Cant: ' . $detail->quantity . ', Precio: S/ ' . number_format($detail->unitary_price, 2) . ')'
            ]);
        }
        
        return $data->map(function ($item) {
            return [
                'campo' => $item['campo'],
                'valor' => $item['valor']
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Campo',
            'Valor'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,  // Campo
            'B' => 50,  // Valor
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar wrap text y centrado a todas las celdas con contenido
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:B' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:B' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:B' . $highestRow)->getAlignment()->setVertical('center');
        
        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ],
            // Bordes para toda la tabla
            'A1:B' . $highestRow => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ]
        ];
    }
}