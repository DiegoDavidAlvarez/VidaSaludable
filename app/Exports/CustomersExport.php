<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomersExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    public function collection()
    {
        return Customer::select('id', 'tipo_documento', 'numero_documento', 'nombres', 'apellidos', 'created_at', 'updated_at')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tipo_documento' => $item->tipo_documento,
                    'numero_documento' => $item->numero_documento,
                    'nombres' => $item->nombres,
                    'apellidos' => $item->apellidos,
                    'nombre_completo' => trim($item->nombres . ' ' . $item->apellidos),
                    'created_at' => $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A',
                    'updated_at' => $item->updated_at ? $item->updated_at->format('d/m/Y H:i') : 'N/A'
                ];
            });
    }

    public function headings(): array
    {
        return [
            '#',
            'Tipo Documento',
            'Número Documento',
            'Nombres',
            'Apellidos',
            'Nombre Completo',
            'Fecha Registro',
            'Última Actualización'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // ID
            'B' => 15,  // Tipo Documento
            'C' => 18,  // Número Documento
            'D' => 25,  // Nombres
            'E' => 25,  // Apellidos
            'F' => 35,  // Nombre Completo
            'G' => 18,  // Fecha Registro
            'H' => 20,  // Última Actualización
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Aplicar wrap text y centrado a todas las celdas con contenido
        $highestRow = $sheet->getHighestRow();
        $sheet->getStyle('A1:H' . $highestRow)->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:H' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:H' . $highestRow)->getAlignment()->setVertical('center');
        
        return [
            // Estilo para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => 'solid', 'color' => ['argb' => 'FF1A73E8']],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ],
            // Bordes para toda la tabla
            'A1:H' . $highestRow => [
                'borders' => [
                    'allBorders' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF000000']]
                ],
                'alignment' => ['wrapText' => true, 'horizontal' => 'center', 'vertical' => 'center']
            ]
        ];
    }
}