<?php

namespace App;

use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Order extends Model
{
    const ORDERS_PER_PAGE = 10;

    public static $type;

    public static $orderTypes = [
        'visual-design' => 'Дизайн',
        'visual-production' => 'Производство',
        'visual-placement' => 'Размещение',
        'visual-montage' => 'Монтаж',
        'photo' => 'Фотосъемка',
        'promo' => 'Промо',
        'radio' => 'Радио'
    ];

    public static $bypass = [
        'order',
        'entry',
        'departure',
        'replacement',
    ];
    public static $orderCategories = [
        'order' => 'Визуальная. ',
        'entry' => 'Обходной. Въезд. ',
        'departure' => 'Обходной. Выезд. ',
        'replacement' => 'Обходной. Замена. '
    ];

    public static  $modelsNames = [
        DesignOrder::class      => 'visual-design',
        MontageOrder::class     => 'visual-montage',
        PhotoOrder::class       => 'photo',
        PlacementOrder::class   => 'visual-placement',
        ProductionOrder::class  => 'visual-production',
        PromoOrder::class       => 'promo',
        RadioOrder::class       => 'radio'
    ];

    // create human name for Order's Category
    public static function applyCategories($orders)
    {
        foreach ($orders as $order) {
            $order->category = Order::applyCategory($order->type, $order->typeTemplate);
        }
        return $orders;
    }

    public static function applyCategory($orderType, $orderTemplate)
    {
        $type = Order::$orderTypes[$orderType];

        $category = "";
        if (Str::contains($orderType,'visual')) {
            $category = Order::$orderCategories[$orderTemplate];
        }

        return $category . $type;
    }

    // get a specific order from several types of orders
    public static function getSpecific($id)
    {
        $orderID = Order::whereId($id)->firstOrFail();
        $orderType = array_search($orderID->type, self::$modelsNames);
        $order = $orderType::whereOrderId($orderID->id)->firstOrFail();
        $manager = User::select('name')->whereId($order->manager)->first();
        $order->date_payment = Helpers::deconvertDate($order->date_payment);
        $order->order_date = Helpers::deconvertDate($order->order_date);
        $order->file_link = Helpers::fileLink($order->file);
        $order->designer_file_link = Helpers::fileLink($order->designer_file);
        $order->manager_name = $manager->name;
        $order->orderType = $orderID->type;
        return $order;
    }

    // get recent orders of all types
    public static function getRecent($dateBegin=false, $dateEnd=false, $client=false)
    {
        $user = Auth::user();

        $orders = collect([]);

        foreach (Order::$modelsNames as $model => $type) {

            $query = $model::query();

            if ($client) {
                // only current client
                $query = $query->whereClientId($client);

            } elseif ( $user->isBoss() ) {
                // all orders for super users

            } elseif ( $user->isDesigner() && $type == 'visual-design' ) {
                // only design orders for specific designer
                $query = $query->whereDesigner($user->id);

            } elseif ( $user->isManager() ) {
                // only orders for specific managers and sub-managers
                $query = $query->whereManager($user->id)->orWhere('add_manager', $user->id);

            } else {
                // kill model's query
                unset($query);
            }

            // make order's collection from query
            if( ! empty($query)) {
                $limit = Helpers::getLimit($dateBegin, $dateEnd);
                $query = Helpers::limitQuery($query, $limit, $dateBegin, $dateEnd);
                $collection = $query->orderBy('id', 'desc')->get();
                $collection = Helpers::addTypeOfOrder($collection, $type);
                $collection = Order::applyCategories($collection);
                $collection = Helpers::link($collection);
                $orders = $orders->merge($collection);
                unset($collection);
                unset($query);
            }
        }

        $orders = $orders->sortByDesc('order_id');
        $orders = Helpers::limitCollection($orders, $limit);

        return $orders;
    }

    /**
     * Get all Models with Orders.
     * type = row with name of suborders table
     * id = row with suborders id
     * order_id = key in suborders tables
     */
    public function orderable()
    {
        return $this->morphTo(null,'type','id','order_id');
    }

    public static function editOrNew($request, $typeOrder)
    {
        $orderId = intval($request->input('order-number')) ?? '';

        $currentOrder = $typeOrder::whereOrderId($orderId)->first();

        if ($orderId > 0 && ( ! empty($currentOrder))){
            $new = $currentOrder;
        } else {
            $new = new $typeOrder;
        }

        return $new;
    }
}
