<?php
$json = file_get_contents('scratch.json');
$array = json_decode($json, true);
var_dump(current($array['data']));

foreach ($array['data'] as $gene) {
    echo $gene[1] . ' ' . strip_tags($gene[2]) . PHP_EOL;

}