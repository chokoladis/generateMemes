<?

use Main\Classes\db;
use Main\Classes\Lang;

require_once('config/const.php');
require_once('functions.php');
// require_once('classes/Img.php');

require_once(THEMPLATE_DIR.'/lang/'.LANG.'.php');

spl_autoload_register('autoload');
 
function autoload($name)
{
    $arPathClass = explode('\\', $name);
    $nameClass = $arPathClass[array_key_last($arPathClass)];
	include_once 'classes/' . strtolower($nameClass) . '.php';
    include_once 'base/' . strtolower($nameClass) . '.php';
}

// require_once('handlers.php');
Lang::handlerLoad();
