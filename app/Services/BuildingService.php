<?php

namespace App\Services;

use App\Imports\PavilionImport;
use App\Pavilion;
use Maatwebsite\Excel\Facades\Excel;

class BuildingService
{
    public static function processFile($request, $buildingID)
    {
        $import = new PavilionImport;
        Excel::import($import, $request->file[0]);

        if ( ! empty($import->pavilions) && count($import->pavilions)) {

            Pavilion::whereBuildingId($buildingID)->delete();

            $pavilions = [];
            foreach ($import->pavilions as $pavilion) {
                $pavilions[] = array(
                    'building_id' => $buildingID,
                    'pavilion' => $pavilion
                );
            }

            Pavilion::insert($pavilions);
        }
    }
}