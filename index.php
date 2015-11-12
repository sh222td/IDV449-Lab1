<!DOCTYPE html>
<html>
    <head>
        <title>Laboration 1</title>
        <link rel='stylesheet' href='style.css'/>
        <meta charset="utf-8">
    </head>
    <body>
    <h1>Ange url</h1>
    <form method='post' action='?booking'>
        <div>
            <input type='text' name='url' />
        </div>
        <div id='sendButton'>
            <input type='submit' value='Starta' />
        </div>
    </form>

    </body>
</html>

<?php
ini_set('display_errors', 'Off');

checkButton();

$url = $_POST['url'];
$data = curl_get_request($url);
$dom = new DomDocument();

if ($dom->loadHTML($data)) {
    $xpath = new DOMXPath($dom);
    $items = $xpath->query('//li/a');
    $indexArray = array();

    $calendarIndex =  $items->item(0)->getAttribute("href");
    $calenderData = getCalendarItems(trimSlashFromUrl($url).$calendarIndex, $dom);

    $movieIndex = $items->item(1)->getAttribute("href");
    $movieData = getMovieItems(trimSlashFromUrl($url).$movieIndex, $dom);

    $indexArray[] = array($calenderData);

    //print_r($indexArray);
    //print_r($calenderData);
}

// Tar bort alla "/" från slutet av huvud url:en
function trimSlashFromUrl($url){
    $url = rtrim($url, '/');

    return $url;
}
function checkButton() {
    if (isset($_POST['url'])) {
        curl_get_request($_POST['url']);
    }
}

// Funktion som gör ett anrop till url:en
function curl_get_request($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    // Talar om att det som ska hämtas, inte skrivs ut direkt
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Exekverar anropet och stänger sedan ner det
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function getCalendarItems($calendar, $dom) {
    $calendarArray = array();
    $paulArray = array();
    $peterArray = array();
    $maryArray = array();
    $data = curl_get_request($calendar);
    libxml_use_internal_errors(true);

    if ($dom->loadHTML($data)) {
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);
        $items = $xpath->query('//ul//li/a');

        $paulIndex =  $items->item(0)->getAttribute("href");
        $paulData = getPersonCalendar($calendar."/".$paulIndex, $dom);

        $peterIndex =  $items->item(1)->getAttribute("href");
        $peterData = getPersonCalendar($calendar."/".$peterIndex, $dom);

        $maryIndex =  $items->item(2)->getAttribute("href");
        $maryData = getPersonCalendar($calendar."/".$maryIndex, $dom);

        /*$paulArray[] = array($paulData);
        $peterArray[] = array($peterData);
        $maryArray[] = array($maryData);*/

        /*foreach ($items as $item) {
            $collections = $item->nodeValue;
            $calendarArray[] = array($collections);
        }*/

        //return $calendarArray;
    }
}

function getPersonCalendar($person, $dom) {
    $paulArray = array();
    $peterArray = array();
    $maryArray = array();
    $data = curl_get_request($person);
    libxml_use_internal_errors(true);

    if ($dom->loadHTML($data)) {
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);
        $items = $xpath->query('//table//tr/td');

        foreach ($items as $item) {
            $collections = $item->nodeValue;
            $paulArray[] = array($collections);
        }

        foreach ($items as $item) {
            $collections = $item->nodeValue;
            $peterArray[] = array($collections);
        }

        foreach ($items as $item) {
            $collections = $item->nodeValue;
            $maryArray[] = array($collections);
        }
        echo "<pre>";
        print_r($peterArray[1]);
        /*print_r($maryArray);
        print_r($paulArray);*/
        echo "</pre>";

       /* if ($peterArray[0]) {

        }*/
    }
}

function getMovieItems($movie, $dom) {
    $movieArray = array();
    $data = curl_get_request($movie);
    libxml_use_internal_errors(true);

    if ($dom->loadHTML($data)) {
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);
        $items = $xpath->query('//h1');

        foreach ($items as $item) {
            $collections = $item->nodeValue;
            $movieArray[] = array($collections);
        }

        return $movieArray;
    }
}
