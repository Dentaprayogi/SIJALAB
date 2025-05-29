<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class JadwalLabImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Template' => new JadwalTemplateSheetImport()
        ];
    }
}
