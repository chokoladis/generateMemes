<?

namespace Main\Classes;

class Lang
{

    static $dir;
    // static $invertLang;
    static $arLang = ['ru', 'en'];

    // load or contruct

    static function setLang(string $lang = LANG)
    {
        self::$dir = THEMPLATE_DIR . 'lang/' . $lang . '.php';
        
        if (!file_exists(self::$dir)){
            self::$dir = THEMPLATE_DIR . 'lang/' . $lang . '.php';
        }

        return self::$dir;
    }

    static function getText(string $code): string
    {
        global $sys_messages;

        return $sys_messages[$code] ?? '';
    }

    static function handlerLoad(){

        if (!empty($_GET['setLang']) && in_array($_GET['setLang'], self::$arLang)){
            return setcookie('LANG', $_GET['setLang'], time()+678400);
        }

    }
}
