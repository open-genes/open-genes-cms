<?
// PROD/DEV MODE
$isProduction = 1;


// COMPOSER CLASSES AUTOLOAD
// require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


// INI SETTINGS
ini_set('opcache','Off');

// Error handling
if ($isProduction == 1) {
    ini_set('display_errors','Off');
    ini_set('error_reporting', 0); // E_ALL
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('output_buffering', 0);
}


// CONNECTION OPTIONS

// Check for existing session
if(session_id() == '' || !isset($_SESSION)) {
    session_start();
}

// Site related variables
class Site {
    public $sitename = 'Open Longevity Genes';
    public $description = 'База генов, ассоциированных со старением и продолжительностью жизни.';
}

// Authorization variables
$isAuth = 0;
$doLogout = 0;

// Requisites
// - user
$_SESSION['user'] = 'u0610688_genes';
$_SESSION['password'] = 'B1y3R5c8';

// - base
$host = 'localhost';
$database = 'u0610688_genes';
$table = 'argb';

// - options
$dsn = "mysql:host = $host; dbname = $database; charset = UTF8";

$options =
    [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
    ];

// Sign in query and error handling
try {
    $pdo = new PDO($dsn, $_SESSION['user'], $_SESSION['password'], $options);
    $sql = "SELECT * FROM `{$database}`.`{$table}`";
    $request = $pdo->prepare($sql);
    $request->execute();

    $rows = array();

    while ($row = $request->fetch(PDO::FETCH_ASSOC)) {
        array_push($rows, $row);
    }

    $_SESSION['allGenesData'] = $rows;
    
    $pdo = new PDO($dsn, $_SESSION['user'], $_SESSION['password'], $options);
    $sql = "SELECT * FROM `{$database}`.`{$table}` WHERE commentEvolution <> '' AND isHidden <> 1 ORDER BY ageMya DESC";

    $request = $pdo->prepare($sql);
    $request->execute();

    $rows = array();

    while ($row = $request->fetch(PDO::FETCH_ASSOC)) {
        array_push($rows, $row);
    }

    $_SESSION['sortedGenesData'] = $rows;
    $genesJSONdata = json_encode($_SESSION['sortedGenesData'], JSON_OBJECT_AS_ARRAY| JSON_UNESCAPED_UNICODE);
    $geneseJSONpath = $_SERVER['DOCUMENT_ROOT'] . '/export.json';
}
catch (PDOException $e) {
    die('Подключение не удалось: '.$e->getMessage());
}


// ERRORS OUTPUT IN UI
class alertMessages {
    // @param string, string, string
    public function pop_alert($request, $value, $locale) {
        if (isset($_GET[$request])) {
            if ($_GET[$request] == $value) {
                echo
                    '<div class="alert alert--error">' .
                    $locale .
                    '<div class="fa far fa-times alert__close js_alert__close"></div>' .
                    '</div>';

            }
        }
    }
}


// GENE CLASS
class Gene {
    public function gene_rating_details($rating) {
        switch ($rating) {
            case 1:
                echo 'Прямые доказательства влияния продукта гена на старение у человека';
                break;

            case 2:
                echo 'Прямые доказательства влияния продукта гена на старение у млекопитающих';
                break;

            case 3:
                echo 'Прямые доказательства влияния продукта гена на старение у не млекопитающих';
                break;

            case 4:
                echo 'Прямые доказательства влияния продукта гена на старение, полученные на культурах клеток';
                break;

            case 5:
                echo 'Доказательства возрастных изменений экспрессии гена / активности белка у человека';
                break;

            case 6:
                echo 'Доказательства возрастных изменений экспрессии гена / активности белка у млекопитающих';
                break;

            case 7:
                echo 'Доказательства возрастных изменений экспрессии гена / активности белка у не млекопитающих';
                break;

            case 8:
                echo 'Доказательства ассоциации гена с долголетием или ассоциированным с возрастом фенотипом';
                break;

            case 9:
                echo 'Доказательства участия гена в связанных со старением процессах или механизмах';
                break;

            case 10:
                echo 'Доказательства того, что продукт гена участвует в регуляции генов, связанных со старением';
                break;

            case 11:
                echo 'Использование продукта гена в часах старения';
                break;

            default:
                echo 'Причина отбора не указана';
        }
    }

    // Functions for gene items output from DB

    /**
     * @param $string - Input string to convert to array
     * @param string $separator - Separator to separate by (default: ' ')
     *
     * @return array
     */
    public function space_separated_to_array($string, $separator = ' ') {
        $vals = explode($separator, $string);
        return array_diff($vals, array(""));
    }

    public function comma_separated_to_array($string, $separator = ',')
    {
        $vals = explode($separator, $string);
        return array_diff($vals, array(""));
    }
}


// LOCALIZATION
// User language recognition and language setting
$browserLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$_SESSION['$locale_ru'] = $_SERVER['DOCUMENT_ROOT'] . '/languages/ru.json';
$_SESSION['$locale_en'] = $_SERVER['DOCUMENT_ROOT'] . '/languages/en.json';
$_SESSION['$current_locale_file'] = NULL;
$_SESSION['$current_locale'] = NULL;
$_SESSION['$alternative_locale'] = NULL;

// TODO: отрефакторить, один и тот же код повторяется много раз
if (isset($_GET['lang'])) {
    switch ($_GET['lang']) {
        case 'ru':
            $_SESSION['$current_locale'] = 'ru';
            break;
        case 'en':
            $_SESSION['$current_locale'] = 'en';
            break;
        default:
            $_SESSION['$current_locale'] = 'en';
    }
} elseif (isset($_COOKIE['lang'])) {
    switch ($_COOKIE['lang']) {
        case 'ru':
            $_SESSION['$current_locale'] = 'ru';
            break;
        case 'en':
            $_SESSION['$current_locale'] = 'en';
            break;
        default:
            $_SESSION['$current_locale'] = 'en';
    }
} else {
    switch ($browserLanguage) {
        case 'ru':
            $_SESSION['$current_locale'] = 'ru';
            break;
        case 'en':
            $_SESSION['$current_locale'] = 'en';
            break;
        default:
            $_SESSION['$current_locale'] = 'en';
    }
}

if(isset($_POST['lang'])) {
    $_SESSION['$current_locale'] = $_POST['lang'];
}

class Translation {
    public function updateLocale() {
        if ($_SESSION['$current_locale'] == 'en') {
            $_SESSION['$current_locale_file'] = $_SESSION['$locale_en'];
            $_SESSION['$alternative_locale'] = 'ru';
        } else {
            $_SESSION['$current_locale_file'] = $_SESSION['$locale_ru'];
            $_SESSION['$alternative_locale'] = 'en';
        }

        if (file_exists($_SESSION['$current_locale_file'])) {
            $localeJSON = file_get_contents($_SESSION['$current_locale_file']);
            $_SESSION['$localeArray'] = json_decode($localeJSON, TRUE);
        } else {
            die('Localization file is not found.');
        }
    }

    public function translate($key) {
        return htmlspecialchars($_SESSION['$localeArray'][$key]);
    }
}

$translation = new Translation();
$translation->updateLocale();
?>
