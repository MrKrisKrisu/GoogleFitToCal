<?php

use GoogleFitToCal\GoogleFitToCal;

require_once '../vendor/autoload.php';

$fitToCal = new GoogleFitToCal('ya29.TOKEN');
$ics = $fitToCal->get('domain');

echo strlen($ics) . " Bytes of your fitness data will be written to file googlefit.ics...";

$handle = fopen('googlefit.ics', 'w+');
fwrite($handle, $ics);
fclose($handle);