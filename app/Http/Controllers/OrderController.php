<?php

namespace App\Http\Controllers;

use App\AdvPlace;
use App\Building;
use App\Client;
use App\Company;
use App\Contractor;
use App\DesignOrder;
use App\Field;
use App\GoodCategory;
use App\Helpers\DataProcess;
use App\Helpers\Helpers;
use App\Helpers\Radio;
use App\Http\Requests\OrderList;
use App\MontageSurface;
use App\Order;
use App\OrderType;
use App\Pavilion;
use App\Photographer;
use App\PlacementSurface;
use App\Production;
use App\Promoter;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

class OrderController extends Controller
{
    public static function new($type)
    {
        $order = new Order;

        $order->type = $type;
        $order->done = 0;

        $order->save();

        return $order->id;
    }

    public function index($view = 'order', $current = '')
    {
        $pavilions = Pavilion::select("id","building_id","pavilion","shop","color")->with('paint')->get();

        $buildings = Building::select('id', 'building')->get();

        $managers = User::whereHas('role', function ($user) { $user->where('name', 'manager'); })->get();
        $designers = User::whereHas('role', function ($user) { $user->where('name', 'designer'); })->get();

        $types = OrderType::get();

        $photographers = Photographer::get();
        $promoters = Promoter::get();
        $productions = Production::get();
        $contractors = Contractor::get();
        $advs = AdvPlace::get();
        $companies = Company::get();
        $goodCategories = GoodCategory::get();
        $clients = Client::get();

        $periods = Radio::getPeriods($view);
        $radioDays = Radio::getCalendar($view, $current);

        $fields = Field::orders($current);
        $surfaceModelsPlacement = PlacementSurface::$vueModels;
        $surfaceModelsMontage = MontageSurface::$vueModels;

        $title = Helpers::getTitle($current);

        return view($view,
            compact (
                'pavilions',
                'buildings',
                'types',
                'managers',
                'photographers',
                'promoters',
                'productions',
                'designers',
                'contractors',
                'advs',
                'companies',
                'goodCategories',
                'clients',
                'current',
                'fields',
                'surfaceModelsPlacement',
                'surfaceModelsMontage',
                'title',
                'periods',
                'radioDays'
            )
        );
    }

    public function list(OrderList $request, Guard $auth)
    {
        $dateBegin = $request->dateBegin ?? Carbon::now()->subDays(30)->format('Y-m-d');
        $dateEnd = $request->dateEnd ?? Carbon::now()->format('Y-m-d');

        $user = $auth->user();

        $orders = Order::getRecent($dateBegin, $dateEnd);

        return view('order-list', compact(
            'user',
            'orders',
            'dateBegin',
            'dateEnd'
        ));
    }

    public function show($id, Guard $auth)
    {
        $user = $auth->user();

        $order = Order::getSpecific($id);

        if( ! $user->canViewOrder($order) )
            abort(403, __('error.denied_access'));

        $order->order_date_human = Helpers::humanDate($order->order_date);

        $order->size_name = DesignOrder::getSize($order);
        $order->file_link = Helpers::fileLink($order->file);
        $order->designer_file_link = Helpers::fileLink($order->designer_file);

        return view('order-show',compact('order','user'));
    }

    public function edit($id, Guard $auth)
    {
        $user = $auth->user();

        $order = Order::getSpecific($id);

        $order = DataProcess::convertDatesSubModels($order,$id);

        if ( ! $user->canViewOrder($order) )
            abort(403, __('error.denied_access'));

        $orderTemplate = DataProcess::chooseTemplate($order);

        $output = $this->index($orderTemplate, $order);

        return $output;
    }

    public static function validateHeader(Request $request)
    {
        $request->validate([
            'main-manager' => 'required|numeric',
            'order-manager' => 'numeric',
            'order-type' => 'numeric',
            'order-date' => 'required|date_format:"d.m.Y"',
            'order-building' => 'numeric',
            'order-pavilion' => 'numeric',
            'order-client-name' => 'required',
            'order-client-phone' => '',
            'order-client-email' => '',
        ]);
    }

    public static function storeMainFields($request, $new)
    {
        $new->manager = $request->input('main-manager');
        $new->add_manager = $request->input('order-manager');
        $new->order_type = $request->input('order-type');
        $new->order_date = Helpers::convertDate($request->input('order-date'));
        $new->building = $request->input('order-building');
        $new->floor = $request->input('order-floor-pavilion');
        $new->pavilion = $request->input('order-pavilion');

        $new->client_name = $request->input('order-client-name');
        $new->client_phone = $request->input('order-client-phone');
        $new->client_email = $request->input('order-client-email');

        $new->client_id = Client::prepareClient($new)->id;

        return $new;
    }

    public static function storeVisualFields($request, $new)
    {
        $new->production = $request->input('visual-product');
        $new->designer = $request->input('visual-designer');

        // if Bypass Order
        if ($request->input('visual-bypass')) {
            $new->bypass = $request->input('visual-bypass');
            $new->type = DataProcess::getBypassType($request);
            $new->pavilion_before = $request->input('visual_pavilion_before');
            $new->pavilion_after = $request->input('visual_pavilion_after');
            // if Bypass-Replacement Order
            if($new->type == 'replacement') {
                $new->category_before = $request->input('replacement-category-before');
                $new->category_after = $request->input('replacement-category-after');
            }

        } else {
            $new->bypass = 0;
            $new->type = DataProcess::getBypassType($request);
        }

        return $new;
    }

    public function delete($id)
    {
        $order = Order::whereId($id)->firstOrFail();
        $subOrder = Order::getSpecific($id);

        $order->delete();
        $subOrder->delete();

        return redirect("/orders")->with('status', 'Заказ удалён!');
    }
}
