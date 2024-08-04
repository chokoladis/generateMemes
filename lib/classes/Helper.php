<?

namespace Main\Classes;

class Helper{

    public static function searchOriginalImg(){

        $dir = glob($_SERVER['DOCUMENT_ROOT'].ORIGINAL_IMG_DIR.'*');

        foreach ($dir as $file) {
            $arFiles[] = basename($file);
        }
        
        return $arFiles ?? [];
    }

    static function secureInput(string $value){
        $value = addslashes($value);
        $value = strip_tags($value);
        $value = htmlspecialchars($value);
        return $value;
    }
    
    static function getIp(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $value = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $value = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $value = $_SERVER['REMOTE_ADDR'];
        }
    
        return $value ?? '';
    }
}
