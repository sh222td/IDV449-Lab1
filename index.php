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

$availableMoviesToWatch = array();
$url = $_POST['url'];
$data = curl_get_request($url);
$dom = new DomDocument();

if ($dom->loadHTML($data)) {
    $xpath = new DOMXPath($dom);
    $items = $xpath->query('//li/a');
    $indexArray = array();

    $calendarIndex =  $items->item(0)->getAttribute("href");
    $availableDays = getCalendarItems(trimSlashFromUrl($url).$calendarIndex, $dom);

    $movieIndex = $items->item(1)->getAttribute("href");
    $getMovies = getMovieValues(trimSlashFromUrl($url).$movieIndex, $dom);
    $movieOptions = checkAvailableCinema($availableDays, $getMovies, trimSlashFromUrl($url).$movieIndex);

    foreach ($movieOptions as $movieOption) {
        if ($movieOption["movie"] == 01) {
            $movieOption["movie"] = "Söderkåkar";
        }
        if ($movieOption["movie"] == 02) {
            $movieOption["movie"] = "Fabian Bom";
        }
        if ($movieOption["movie"] == 03) {
            $movieOption["movie"] = "Pensionat Paradiset";
        }
        if ($movieOption[0] == 01) {
            $movieOption[0] = "Fredag";
        }
        if ($movieOption[0] == 02) {
            $movieOption[0] = "Lördag";
        }
        if ($movieOption[0] == 03) {
            $movieOption[0] = "Söndag";
        }
        array_push($availableMoviesToWatch, $movieOption);
    }

    foreach ($availableMoviesToWatch as $movie) {
        echo "Alla kan se ".$movie["movie"]." klockan ".$movie["time"]." på ".$movie[0]."<br/>";
    }
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
// Hämtar ut url:erna för varje person och gör ett anrop till funktionen getPersonCalendar
// Returnerar funktionen checkAvailableCinemaDays som har dagarna i en array
function getCalendarItems($calendar, $dom) {
    $personArray = array();
    $data = curl_get_request($calendar);

    libxml_use_internal_errors(true);
    if ($dom->loadHTML($data)) {
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);
        $items = $xpath->query('//ul//li/a');

        $paulIndex =  $items->item(0)->getAttribute("href");
        $paulArray = getPersonCalendar($calendar."/".$paulIndex, $dom);
        array_push($personArray, $paulArray);

        $peterIndex =  $items->item(1)->getAttribute("href");
        $peterArray = getPersonCalendar($calendar."/".$peterIndex, $dom);
        array_push($personArray, $peterArray);

        $maryIndex =  $items->item(2)->getAttribute("href");
        $maryArray = getPersonCalendar($calendar."/".$maryIndex, $dom);
        array_push($personArray, $maryArray);
    }
    return checkAvailableCinemaDays($personArray);
}

//Lägger in tillgänliga dagar i en array
function checkAvailableCinemaDays($personArray) {
    $availableDays = array();
    if ($personArray[0][0] == $personArray[1][0] && $personArray[0][0] == $personArray[2][0] && $personArray[1][0] == $personArray[2][0]) {
        array_push($availableDays, "01");
    }
    if ($personArray[0][1] == $personArray[1][1] && $personArray[0][1] == $personArray[2][1] && $personArray[1][1] == $personArray[2][1]) {
        array_push($availableDays, "02");
    }
    if ($personArray[0][2] == $personArray[1][2] && $personArray[0][2] == $personArray[2][2] && $personArray[1][2] == $personArray[2][2]) {
        array_push($availableDays, "03");
    }
    return $availableDays;
}

// Funktion som kollar vilka dagar varje person har sagt "OK" på
function getPersonCalendar($person, $dom) {
    $personCalendarArray = array();
    $data = curl_get_request($person);
    libxml_use_internal_errors(true);

    if ($dom->loadHTML($data)) {
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);
        $items = $xpath->query('//table//tr/td');
        foreach ($items as $item) {
            array_push($personCalendarArray, strtolower($item->nodeValue));
        }
        return $personCalendarArray;
    }
}

// Funktion som hämtar ur filmernas värde, lägger sedan in dom i arrayen $moviearray
function getMovieValues($movieUrl, $dom) {
    $movieArray = array();
    $data = curl_get_request($movieUrl);
    libxml_use_internal_errors(true);

    if ($dom->loadHTML($data)) {
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);
        $items = $xpath->query('//form/select[@id="movie"]/option');
        foreach ($items as $item) {
            $movieValue = $item->getAttribute("value");
            if ($movieValue != null) {
                array_push($movieArray, $movieValue);
            }
        }
        return $movieArray;
    }
}

// Funktion som gör en get på samtliga filmer på dagarna som de satt som tillgängliga samt filmernas tider
// decodar json objektet som istället omvandlas till en array
function checkAvailableCinema($availableDays, $movies , $movieUrl) {
    $availableMoviesDayAndTimeArray = array();

    foreach ($availableDays as $days) {
        foreach ($movies as $movie) {
            $data = curl_get_request($movieUrl."/check?day=".$days."&movie=".$movie);
            $options = json_decode($data, true);
            foreach ($options as $option) {
                if ($option["status"] != 0) {
                    array_push($option, $days);
                    array_push($availableMoviesDayAndTimeArray, $option);
                }
            }
        }
    }
    return $availableMoviesDayAndTimeArray;
}
