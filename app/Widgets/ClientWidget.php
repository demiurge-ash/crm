<?php

namespace App\Widgets;

use App\Client;
use Arrilot\Widgets\AbstractWidget;
use App\Service;

class ClientWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Client::count();

        $string = \Lang::choice('клиент|клиента|клиентов', $count, [], 'ru');

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-people',
            'title'  => "{$count} {$string}",
            'text'   => "&nbsp;",
            'button' => [
                'text' => "Клиенты",
                'link' => route('voyager.clients.index'),
            ],
            'image' => '/img/widget-backgrounds/clients.jpg',
        ]));
    }

    /**
     * Determine if the widget should be displayed.
     *
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        return true;
//        return Auth::user()->can('browse', Voyager::model('Products'));
    }
}
