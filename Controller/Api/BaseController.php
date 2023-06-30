<?php

use JetBrains\PhpStorm\NoReturn;

class BaseController
{

    /**
     * __call magic method.
     */
    #[NoReturn] public function __call($name, $arguments)
    {
        $this->sendOutput('', array('HTTP/1.1 404 Not Found'));
    }

    /**
     * Get URI elements.
     *
     * @return array
     */
    protected function getUriSegments(): array
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return explode('/', $uri);
    }

    /**
     * Get querystring params.
     *
     * @return array
     */
    protected function getQueryStringParams(): array
    {
        parse_str($_SERVER['QUERY_STRING'], $query);
        return $query;
    }

    /**
     * Get the request body as an associative array
     *
     * @return array|null
     */
    protected function getRequestBody(): ?array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (stripos($contentType, 'application/json') !== false) {
            // Request body is in JSON format
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            return is_array($data) ? $data : null;
        } else {
            // Request body is not in JSON format (e.g., form data)
            return $_POST;
        }
    }

    /**
     * Send API output.
     *
     * @param mixed $data
     * @param array $httpHeaders
     */
    #[NoReturn] protected function sendOutput(mixed $data, array $httpHeaders = array()): void
    {
        header_remove('Set-Cookie');
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        echo $data;
        exit;
    }
}

