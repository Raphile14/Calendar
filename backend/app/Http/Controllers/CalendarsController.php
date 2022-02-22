<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendars;

class CalendarsController extends Controller
{
    public function get()
    {
        return Calendars::all();
    }

    public function post()
    {
        Calendars::create([
            'title' => request('title'),
            'body' => request('body'),
            'time' => request('time')
        ]);
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
