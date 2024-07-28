<?

require_once('config/const.php');
require_once('classes/Img.php');

spl_autoload_register('autoload');
 
function autoload($name)
{
    $arPathClass = explode('\\', $name);
    $nameClass = $arPathClass[array_key_last($arPathClass)];
	require_once 'classes/' . strtolower($nameClass) . '.php';
}