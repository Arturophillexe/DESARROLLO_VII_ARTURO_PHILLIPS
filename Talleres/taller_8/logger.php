<?php
/**
 * @param string $message oops sucedio un imprevisto.
 */
function log_error($message) {
    
    $log_file = __DIR__ . '/error.log';
    
    $formatted_message = "[" . date("Y-m-d H:i:s") . "] Error: " . $message . PHP_EOL;
    file_put_contents($log_file, $formatted_message, FILE_APPEND | LOCK_EX);
}
?>