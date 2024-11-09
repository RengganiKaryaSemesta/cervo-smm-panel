<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DuplicatePurchaseOrderItemExport implements FromCollection, WithHeadings
{
    protected $duplicateRows;

    public function __construct(array $duplicateRows)
    {
        $this->duplicateRows = $duplicateRows;
    }

    /**
     * Mengembalikan koleksi data duplikat
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect($this->duplicateRows);
    }

    /**
     * Menentukan heading untuk kolom di file Excel
     *
     * @return array
     */
    public function headings(): array
    {
        return ['NO_BAL', 'BRUTO', 'NETO', 'HARGA'];
    }
}
