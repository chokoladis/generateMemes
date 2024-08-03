<?

use Main\Classes\db;

require_once('config/const.php');
require_once('functions.php');
// require_once('classes/Img.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/template/lang/'.LANG.'.php');

spl_autoload_register('autoload');
 
function autoload($name)
{
    $arPathClass = explode('\\', $name);
    $nameClass = $arPathClass[array_key_last($arPathClass)];
	require_once 'classes/' . strtolower($nameClass) . '.php';
}

$db = new db();