<?php

namespace app\models;

use Yii;

class Calendar
{
    public static function makeCalendarEvents(array $events)
    {
        $calendarEvents = [];

        foreach ($events as $event) {
            $calendarEvent = new \yii2fullcalendar\models\Event();
            $calendarEvent->id = $event->id;
            $calendarEvent->title = $event->title;
            $calendarEvent->start = $event->date . ' ' . $event->time;
            $calendarEvents[] = $calendarEvent;
        }

        return $calendarEvents;
    }
}