<?php

namespace App\Http\Controllers;

use App\Building;
use App\Pavilion;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::get();

        return $buildings;
    }

    public function pavilions($id)
    {
        $pavilions = Pavilion::whereBuildingId($id)->with('paint')->get();

        return $pavilions;
    }
}
