<?php

namespace App\Widgets;

use App\User;
use Arrilot\Widgets\AbstractWidget;
use App\Service;

class UserWidget extends AbstractWidget
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
        $count = User::whereActive('1')->count();

        $string = \Lang::choice('сотрудник|сотрудника|сотрудников', $count, [], 'ru');

        return view('voyager::dimmer', array_merge($this->config, [
            'icon'   => 'voyager-person',
            'title'  => "{$count} {$string}",
            'text'   => "&nbsp;",
            'button' => [
                'text' => "Сотрудники",
                'link' => route('voyager.users.index'),
            ],
            'image' => '/img/widget-backgrounds/users.jpg',
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
