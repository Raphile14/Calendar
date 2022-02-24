<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendars;

class CalendarsController extends Controller
{
    public function get()
    {
        $month = request('month');
        $year = request('year');
        $from = date("{$year}-{$month}-1");
        $nextMonth = request('nextMonth');
        $nextYear = request('nextYear');
        $to = date("{$nextYear}-{$nextMonth}-1");
        return Calendars::where('time', '>=', $from)
            ->where('time', '<', $to)
            ->get();
    }

    public function post()
    {
        $data = array();

        // Override if true        
        if (request('override')) {
            $override = array();
            foreach (request('days') as $time) {
                array_push($override, $time);
            }
            Calendars::whereIn('time', $override)
                ->delete();
        }

        // Insert data
        foreach (request('days') as $time) {
            $item = array();
            $item['title'] = request('title');
            $item['body'] = request('body');
            $item['time'] = $time;
            array_push($data, $item);
        }
        Calendars::insert($data);
        return [
            'status' => $data
        ];
    }

    public function put(Calendars $calendar)
    {
        $parameters = array();
        if (request('title') != null) $parameters['title'] = request('title');
        if (request('body') != null) $parameters['body'] = request('body');
        if (request('time') != null) $parameters['time'] = request('time');
        $success = $calendar->update($parameters);
        return [
            'success' => $success
        ];
    }

    public function delete(Calendars $calendar)
    {
        $success = $calendar->delete();
        return [
            'success' => $success
        ];
    }
}
