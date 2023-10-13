<?php

namespace Uniqoders\MyPlugin\Routing;

interface RequestInterface
{
    public function uri();

    public function method();

    public function pathVariables();

    public function pathVariable($name);

    public function parameters();

    public function parameter($name);

    public function headers();
}