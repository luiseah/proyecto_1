<?php

namespace Uniqoders\MyPlugin\Routing;

class Request implements RequestInterface
{
    private $method = '';
    private $uri = '';
    private $pathVariables = [];
    private $params = [];
    private $headers = [];

    public function __construct(
        string $method,
        string $uri,
        array $params,
//        array $pathVariables,
        array $headers
    )
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->params = $params;
//        $this->pathVariables = $pathVariables;
        $this->headers = $headers;
    }


    public function uri()
    {
        return $this->uri;
    }

    public function method()
    {
        return $this->method;
    }

    public function headers()
    {
        return $this->headers;
    }

    public function pathVariable($name)
    {
        if (isset($this->pathVariables[$name])) {
            return $this->pathVariables[$name];
        }

        return "";
    }

    public function pathVariables()
    {
        return $this->pathVariables;
    }

    public function parameter($name)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }

        return "";
    }

    public function parameters()
    {
        return $this->params;
    }
}