<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PavilionImport implements ToCollection
{
    public $pavilions = [];

    public function collection(Collection $collection)
    {
        foreach ($collection as $item) {
            foreach ($item as $pavilion) {
                if(is_null($pavilion)) continue;
                $this->pavilions[] = $pavilion;
            }
        }
    }
}
