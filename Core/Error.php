<?php
namespace Core;

/**
 * Error and exception handler
 *
 * PHP version 7.0
 */
class Error
{
  /**
     * Error handler. Convert all errors to Exceptions by throwing an ErrorException.
     *
     * @param int $level  Error level
     * @param string $message  Error message
     * @param string $file  Filename the error was raised in
     * @param int $line  Line number in the file
     *
     * @return void
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) // to keep the @ operator working
		{
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    /**
     * Exception handler.
     *
     * @param Exception $exception  The exception
     *
     * @return void
     */
    public static function exceptionHandler($exception)
    {
        $code = $exception->getCode();

        http_response_code($code);

        if (Config::SHOW_ERRORS) {
            echo "<h1>Fatal error</h1>";
            echo "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
            echo "<p>Message: '" . $exception->getMessage() . "'</p>";
            echo "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
            echo "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        } else {
            $dir = dirname(__DIR__) . '/logs/';
            if (!is_dir($dir)) {
                mkdir('logs');
            }
            $log = $dir . date('Y-m-d') . '.txt';
            ini_set('error_log', $log);

            $message = "Uncaught exception: '" . get_class($exception) . "'";
            $message .= " with message '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: " . $exception->getTraceAsString();
            $message .= "\nThrown in '" . $exception->getFile() . "' on line " . $exception->getLine();

            error_log($message);

            echo json_encode(Error::errorCodeMessage($code));
        }
    }

    public static function errorCodeMessage($code) {
        switch ($code) {
            case '401':
                $json = [
                    "success" => false,
                    "code" => $code,
                    "message" => "Unauthorized."
                ];
                break;

            case '404':
                $json = [
                    "success" => false,
                    "code" => $code,
                    "message" => "The requested resource was not found."
                ];
                break;

            case '405':
                $json = [
                    "success" => false,
                    "code" => $code,
                    "message" => "Method not allowed."
                ];
                break;

            case '500':
                $json = [
                    "success" => false,
                    "code" => $code,
                    "message" => "There was an error on the server and the request could not be completed."
                ];
                break;

            case '501':
                $json = [
                    "success" => false,
                    "code" => $code,
                    "message" => "Not Implemented."
                ];
                break;

            default:
                $json = [
                    "success" => false,
                    "code" => $code,
                    "message" => "There was an error on the server and the request could not be completed."
                ];
                break;
        }
        return $json;
    }
}
