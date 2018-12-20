<?php
require_once 'dayParser.php';
require_once 'slackResultMessage.php';
require_once 'cache.php';

error_reporting(E_ALL);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

if (!isset($_GET['refresh'])) {
    $myCache = getCache();
    if ($myCache !== null) {
        printResult($myCache);
        return;
    }
}

// Potrafena Husa
$title = "POTRAFENÁ HUSA";
$url = "http://www.staropramen.cz/hospody/brno-zelny-trh";
$text = getFoodMenuPotrafenaHusa();
$color = "#CD175C";
createAttachment($title, $url, $text, $color);

// Vesela Cajovna
$title = "VESELÁ ČAJOVŇA";
$url = "http://www.veselacajovna.cz/tydenni-nabidka/";
$text = "Ako menu je len obrázok.";
$color = "#DFB74A";
createAttachment($title, $url, $text, $color);

// My Kitchen
// $title = "MY KITCHEN";
// $url = "https://www.my-kitchen.cz/kategorie-produktu/denni-menu/";
// $text = getFoodMenu($url,
//     '.content-main .obedy',
//     'tr',
//     0,
//     -4);
// $color = "#7F9530";
// createAttachment($title, $url, $text, $color);

// U Dreveneho Orla
$title = "U DREVENEHO ORLA";
$url = "http://www.drevenyorel.cz/cz/page/tydenni-menu.html";
$text = getZomatoDailyMenuAsString(16506896);
$color = "#36183A";
createAttachment($title, $url, $text, $color);

// U Dřevěného vlka
$title = "U Dřevěného vlka";
$url = "https://www.zomato.com/brno/u-d%C5%99ev%C4%9Bn%C3%A9ho-vlka-brno-m%C4%9Bsto-brno-st%C5%99ed/daily-menu";
$text = getZomatoDailyMenuAsString(16507597);
$color = "#dd681a";
createAttachment($title, $url, $text, $color);

// U Troch Certov
$title = "U TROCH CERTOV";
$url = "http://ucertu.cz/nabidka-starobrnenska/";
$text = getZomatoDailyMenuAsString(16506534);
$color = "#CA4A76";
createAttachment($title, $url, $text, $color);

// Pivni opice
$title = "Pivní opice";
$url = "https://www.zomato.com/brno/pivn%C3%AD-opice-brno-m%C4%9Bsto-brno-st%C5%99ed/daily-menu";
$text = getZomatoDailyMenuAsString(16506709);
$color = "#4c0218";
createAttachment($title, $url, $text, $color);


// Dominik Pub
// $title = "DOMINIK PUB";
// $url = "http://www.dominikpub.cz/";
// $text = getZomatoDailyMenuAsString(18326441);
// $color = "#F4F3F1";
// createAttachment($title, $url, $text, $color);

// Padowetz original restaurant & pub
$title = "Padowetz original restaurant & pub";
$url = "http://ukola.cz/polednimenu.php";
$text = getZomatoDailyMenuAsString(16507074);
$color = "#75ecff";
createAttachment($title, $url, $text, $color);

// Pod Radnicnim kolem
$title = "POD RADNICNIM KOLEM";
$url = "http://ukola.cz/polednimenu.php";
$text = getZomatoDailyMenuAsString(16506903);
$color = "#1370A6";
createAttachment($title, $url, $text, $color);

// U Zlateho mece
$title = "U ZLATEHO MECE";
$url = "http://www.uzlatehomece.cz/denni-menu/";
$text = getFoodMenuUZlatehoMeceAsString();
$color = "#9DCFDD";
createAttachment($title, $url, $text, $color);

// MAZANÝ ANDĚL
$title = "MAZANÝ ANDĚL";
$url = "https://www.zomato.com/MazanyAndelBrno/daily-menu";
$text = getZomatoDailyMenuAsString(16507371);
$color = "#227c12";
createAttachment($title, $url, $text, $color);

// Suzie's Steak pub
$title = "Suzie's Steak pub";
$url = "https://www.zomato.com/brno/suzies-steak-pub-veve%C5%99%C3%AD-brno-st%C5%99ed/daily-menu";
$text = getZomatoDailyMenuAsString(18126190);
$color = "#3a0000";
createAttachment($title, $url, $text, $color);

// Suzie's
$title = "Suzie's";
$url = "https://www.zomato.com/brno/suzies-veve%C5%99%C3%AD-brno-st%C5%99ed/daily-menu";
$text = getZomatoDailyMenuAsString(16506939);
$color = "#d32c50";
createAttachment($title, $url, $text, $color);




// Output
createCache(getResult());
printResult();