<?

if (!function_exists('jsonResponse')){
    function jsonResponse(bool $success = true, array $result = [], array $errors = []){
        return json_encode(['success' => $success, 'result' => $result, 'errors' => $errors]);
    }
}