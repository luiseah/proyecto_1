<?php

namespace Uniqoders\MyPlugin;

use Illuminate\Container\Container;

class Plugin extends Container
{
    /**
     * @param $key
     * @param $value
     * @return bool
     */
    public function setCache($key, $value): bool
    {
        return set_transient($key, $value);
    }

    /**
     * @param $key
     * @return string
     */
    public function getCache($key): string
    {
        return get_transient($key);
    }

    /**
     * @param $key
     * @return bool
     */
    public function deleteCache($key): bool
    {
        return delete_transient($key);
    }

    private function getCachePrefix($key): string
    {
        return !str_starts_with('_transient_', $key)
            ? "_transient_{$key}"
            : $key;
    }
}