<?php
$slackResult = array();
$slackResult['attachments'] = array();

function setAsString($attr) {
    global $slackResult;

    if (!isset($result[$attr])) {
        $slackResult[$attr] = "";
    }
}

function addToResult($string)
{
    global $slackResult;
    setAsString('text');

    $slackResult['text'] .= $string;
}

function createAttachment($title, $url, $text, $color) {
    global $slackResult;

    $object = array();
    $object['pretext'] = $title;
    $object['text'] = $text;
    $object['color'] = $color;
    $object['footer'] = $url;
    $object['footer_icon'] = "http://inqool.martinboksa.eu/fork.png";


    array_push($slackResult['attachments'], $object);
}

function getResult() {
    global $slackResult;

    return $slackResult;
}

function printResult($content = null) {
    if ($content === null) {
        $content = getResult();
    }

    if (isset($_GET['slack'])) {
        echo json_encode($content);
    } else {
        echo json_encode($content, JSON_PRETTY_PRINT);
    }
}