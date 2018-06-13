<?php
$cacheFile = "./cache.file.json";

function getCache() {
    global $cacheFile;

    if (file_exists($cacheFile) && date("d-m-Y", filemtime($cacheFile)) === date("d-m-Y")) {
        return unserialize(file_get_contents($cacheFile));
    }

    return null;
}

function createCache($content) {
    global $cacheFile;
    file_put_contents($cacheFile, serialize($content), LOCK_EX);
}