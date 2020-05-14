<?php

namespace App\Imports;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class WorkTimeImport implements ToCollection
{
    public $days = [];
    public $worktimes = [];
    public $firstDay;
    public $lastDay;

    public function collection(Collection $collection)
    {
        $this->getDays($collection[0]);
        $collection = $this->removeDaysField($collection);

        foreach ($collection as $item) {
            $user = $this->getUser($item);
            if (empty($user)) continue;

            $direction = $this->getDirection($item);
            if (is_null($direction)) continue;

            foreach ($item as $key => $time){
                if(is_null($time)) continue;

                $time = trim($time);
                $time = Carbon::parse($time)->format('H:i');

                $this->worktimes[] = array(
                    'user_id' => $user->id,
                    'direction' => $direction,
                    'time' => $time,
                    'day' => $this->days[$key]
                );
            }
        }
    }

    public function getDays($collection)
    {
        unset($collection[0]); // Сотрудник column
        unset($collection[1]); // Направление column

        $period =[];
        foreach ($collection as $key => $day) {
            $day = trim($day);
            $this->days[$key] = Carbon::parse($day)->format('Y-m-d');
            $period[] = $this->days[$key];
        }
        $this->calculatePeriod($period);
    }

    public function calculatePeriod($period)
    {
        sort($period);
        $this->firstDay = reset($period);
        $this->lastDay = end($period);
    }

    public function removeDaysField($collection)
    {
        unset($collection[0]);
        return $collection;
    }

    public function getUser($item)
    {
        $username = trim($item[0]);
        $user = User::select('id')->whereName($username)->first();
        unset($item[0]);

        return $user;
    }

    public function getDirection($item)
    {
        $directionExcel = trim($item[1]);

        if ($directionExcel == 'вход') {
            $direction = 'in';
        } elseif ($directionExcel == 'выход') {
            $direction = 'out';
        } else {
            $direction = null;
        }

        unset($item[1]);

        return $direction;
    }
}
