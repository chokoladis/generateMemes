<?

if (!function_exists('jsonResponse')){
    function jsonResponse(bool $success = true, array $result = [], array $errors = []){
        return json_encode([$success, $result, $errors]);
    }
}