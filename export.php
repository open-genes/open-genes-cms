<?
include $_SERVER['DOCUMENT_ROOT'] . '/contollers/core.php';
echo $genesJSONdata;

// Request to generate JSON
$rebuild = 0;
if (isset($_GET['rebuild'])) {
    $fp = fopen($geneseJSONpath, 'w');
    fwrite($fp, $genesJSONdata);
    fclose($fp);
}
?>