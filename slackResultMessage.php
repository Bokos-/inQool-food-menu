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
    $object['pretext'] = strtoupper($title);
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

function printOldResult($content = null) {
    if ($content === null) {
        $content = getResult();
    }

    if (isset($_GET['slack'])) {
        echo json_encode($content);
    } else {
        echo json_encode($content, JSON_PRETTY_PRINT);
    }
}

function formatToNiceMessage($content) {
    if (isset($content["attachments"]) && is_array($content["attachments"])) {
    
        $result = "";
        $i = 1;

        foreach ($content["attachments"] as $row) {

            if (isset($row["pretext"]) && isset($row["text"]) && isset($row['footer'])) {

                $text = trim($row["text"]);

                $result .= $i . ". " . $row["pretext"];
                $result .= " ```";

                if (!empty($text)) {
                    $result .= $text . " \n\n";
                }

                $result .= "<" . $row['footer'] . "|LINK TO MENU>";
                $result .= "```";
                $result .= "\n";

                $i++;
            }

        }
        
        return $slackResult = ["text" => $result];

    } else {
        return $slackResult = ["text" => "Things to do when bad weather keeps you home: board games, winter cleaning, movie, read, cook, ..."];
    }
}

function printNiceResult($content = null) {
    if ($content === null) {
        $content = getResult();
    }

    $text = formatToNiceMessage($content);

    if (isset($_GET['slack'])) {
        echo json_encode($text);
    } else {
        echo json_encode($text, JSON_PRETTY_PRINT);
    }
}

function printOutput($content = null) {
    if (isset($_GET['old'])) {
        printOldResult($content);
    } else {
        printNiceResult($content);
    }
}