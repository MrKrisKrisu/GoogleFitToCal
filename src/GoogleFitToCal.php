<?php

namespace GoogleFitToCal;

use Carbon\Carbon;
use Eluceo\iCal\Component\Calendar;
use Eluceo\iCal\Component\Event;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class GoogleFitToCal
{

    private $gcpBearerToken;

    public function __construct($gcpBearerToken)
    {
        $this->gcpBearerToken = $gcpBearerToken;
    }

    /**
     * @param $calendarProdId
     * @return string
     * @throws GuzzleException
     */
    public function get(string $calendarProdId): string
    {
        $client     = new Client();
        $res = $client->request('GET', 'https://www.googleapis.com/fitness/v1/users/me/sessions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->gcpBearerToken
            ]
        ]);

        $data       = json_decode($res->getBody());
        $vCalendar  = new Calendar($calendarProdId);

        foreach ($data->session as $session) {
            $start  = Carbon::createFromTimestampMs($session->startTimeMillis);
            $end    = Carbon::createFromTimestampMs($session->endTimeMillis);

            $vEvent = new Event();
            $vEvent
                ->setDtStart($start->toDateTime())
                ->setDtEnd($end->toDateTime())
                ->setSummary($session->name);
            $vCalendar->addComponent($vEvent);
        }

        return $vCalendar->render();
    }

}
