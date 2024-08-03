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
}
