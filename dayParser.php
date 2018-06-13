<?php
require_once 'simple_html_dom.php';
require_once "removeAccents.php";

$days = [
    "PONDĚLÍ",
    "ÚTERÝ",
    "STŘEDA",
    "ČTVRTEK",
    "PÁTEK",
    "SOBOTA",
    "NEDĚLE"
];

for ($i = 0; $i < count($days); $i++) {
    $days[$i] = strtoupper(remove_accents($days[$i]));
}

function getTodayInCZ()
{
    global $days;
    return $days[date('N') - 1];
}

function textContainsAnyDay($text)
{
    global $days;
    $text = strtoupper($text);

    foreach ($days as $day) {
        if (strpos($text, $day) !== false) {
            return true;
        }
    }

    return false;
}

function textContainsToday($text)
{
    $today = getTodayInCZ();
    $text = strtoupper($text);
    return strpos(strtoupper($text), $today) !== false;
}

function convertTextToUsableState($text) {
    $text = preg_replace("/\s\s\s+/", '', remove_accents(trim($text)));
    $text = str_replace("&nbsp;", " ", $text);
    return $text;
}

function getResultString($text, $removeChars = 0) {
    return "\t" . ($removeChars !== 0 ? substr($text, 0, $removeChars) : $text) . "\n";
}

function getFoodMenu($url, $bodySelector, $daySelector, $bodySelectorIndex = 0, $removeChars = 0)
{
    $result = "";
    $doc = file_get_html($url);
    $menuTable = $doc->find($bodySelector)[$bodySelectorIndex];
    $dayFound = false;

    if (!$menuTable) {
        return $result;
    }

    $rows = $menuTable->find($daySelector);

    if (!$rows) {
        return $result;
    }

    foreach ($rows as $row) {

        $text = convertTextToUsableState($row->plaintext);

        if ($dayFound) {
            if (textContainsAnyDay($text)) {
                break;
            }
            $result .= getResultString($text, $removeChars);

        } else {
            if (textContainsToday($text)) {
                $dayFound = true;
            }
        }
    }

    return $result;
}

function getZomatoDailyMenuAsString($restaurantId)
{
    $json = fetchZomatoDailyMenu($restaurantId);
    $result = "";

    if (isset($json->daily_menus)) {
        foreach ($json->daily_menus as $dailyMenu) {
            if (!isset($dailyMenu->daily_menu) || !isset($dailyMenu->daily_menu->dishes)) continue;


            foreach ($dailyMenu->daily_menu->dishes as $dish) {
                $result .= "\t" . $dish->dish->name . " " . $dish->dish->price . "\n";
            }
        }
    }

    return $result;
}

function fetchZomatoDailyMenu($restaurantId)
{
    $ch = curl_init("https://developers.zomato.com/api/v2.1/dailymenu?res_id=" . $restaurantId);

    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_MAXREDIRS => 5,
        CURLOPT_ENCODING => "",
        CURLOPT_USERAGENT => "curl",
        CURLOPT_AUTOREFERER => true,
        CURLOPT_CONNECTTIMEOUT => 3,
        CURLOPT_TIMEOUT => 3,
    );
    curl_setopt_array($ch, $options);

    // GET KEY https://developers.zomato.com/api
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'user_key: USER_ZOMATO_API_KEY'
    ));

    $content = curl_exec($ch);
    curl_close($ch);

    return json_decode($content);
}

function getFoodMenuUZlatehoMeceAsString() {
    $page = file_get_html('http://www.uzlatehomece.cz/denni-menu/');
    $findIFrame = $page->find('.menu .container article iframe');
    if (!$findIFrame) return "";

    $result = "";
    $dailyMenu = file_get_html($findIFrame[0]->src);

    foreach ($dailyMenu->find("div.content") as $content) {
        $day = $content->find('h2');

        if ($day && textContainsToday(convertTextToUsableState($day[0]->plaintext))) {

            foreach ($content->find('table.menu tbody tr') as $row) {
                $result .= getResultString(convertTextToUsableState($row->plaintext));
            }

            break;
        }
    }

    return $result;
}