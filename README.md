# Google Fit to ics (Calendar)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/02c78d23fb63479a8cdded50b887a69f)](https://www.codacy.com/manual/MrKrisKrisu/GoogleFitToCal?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=MrKrisKrisu/GoogleFitToCal&amp;utm_campaign=Badge_Grade)

This library will retrieve the latest activities (e.g. sleep, jogging, ...) from Google Fit and 
returnes an iCalendar, so you can embed them to your Calendar.

## Example output
``` ics
BEGIN:VCALENDAR
VERSION:2.0
PRODID:k118.de
BEGIN:VEVENT
UID:5f60602545786
DTSTART:20200820T190620Z
SEQUENCE:0
TRANSP:OPAQUE
DTEND:20200820T192025Z
SUMMARY:Evening jog
CLASS:PUBLIC
DTSTAMP:20200915T063309Z
END:VEVENT
BEGIN:VEVENT
UID:5f60602545813
DTSTART:20200821T123715Z
SEQUENCE:0
TRANSP:OPAQUE
DTEND:20200821T142221Z
SUMMARY:Sleep
CLASS:PUBLIC
DTSTAMP:20200915T063309Z
END:VEVENT
END:VCALENDAR
```

## Installation

`composer require mrkriskrisu/google-fit-to-ics`

## Requirements

*   PHP 7.0
*   PHP JSON Extension
*   Composer

To retrieve the data you'll also need the Bearer Token for the Google Account 
you want to access.

## Example
``` php
use GoogleFitToCal\GoogleFitToCal;

require_once '../vendor/autoload.php';

$fitToCal = new GoogleFitToCal('ya29.TOKEN');
$ics = $fitToCal->get('example.org');

echo strlen($ics) . " Bytes of your fitness data will be written to file googlefit.ics...";

$handle = fopen('googlefit.ics', 'w+');
fwrite($handle, $ics);
fclose($handle);
```