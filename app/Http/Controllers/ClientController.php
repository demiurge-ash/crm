<?php

namespace App\Http\Controllers;

use App\Client;
use App\MontageOrder;
use App\Order;
use App\PlacementOrder;
use App\ProductionOrder;
use App\RadioOrder;
use App\DesignOrder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    public function autocomplete(Request $request){
        $query = $request->q;
        $users = Client::where('name','like','%'.$query.'%')->get();
        return response()->json($users);
    }

    public function index()
    {
        return view('clients');
    }

    public function ajax(Request $request)
    {
        $model = Client::query();

        return DataTables::eloquent($model)->toJson();
    }

    public function show($id)
    {
        $client = Client::whereId($id)->firstOrFail();

        $designFiles = DesignOrder::whereClientId($client->id)
            ->where(function($query) {
                $query->whereNotNull('file');
                $query->orWhereNotNull('designer_file');
            })->get();

        $radioFiles = RadioOrder::whereClientName($client->name)
            ->whereNotNull('file')
            ->get();

        $orders = Order::getRecent(false, false, $client->id);

        return view('client', compact(
            'client',
            'designFiles',
            'radioFiles',
            'orders'
        ));
    }

}
