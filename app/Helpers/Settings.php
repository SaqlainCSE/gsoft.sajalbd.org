<?php

if (!function_exists('option')) {
    /**
     * Get / set the specified option value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  int  $branch_id
     * @param  mixed  $default
     * @return mixed|\App\Models\Setting
     */
    function setting($key = null, $branch_id = null, $default = null)
    {
        if (is_null($key)) {
            return app('setting');
        }

        if (is_array($key)) {
            return app('setting')->set($key);
        }

        return app('setting')->get($key, $default, $branch_id);
    }
}

if (!function_exists('setting_exists')) {
    /**
     * Check the specified option exits.
     *
     * @param  string  $key
     * @return mixed
     */
    function option_exists($key)
    {
        return app('setting')->exists($key);
    }
}
if (!function_exists('option_prefix')) {
    function option_prefix($branch_id)
    {
        return Cache::rememberForever("settings_" . $branch_id, function () use ($branch_id) {
            return app('setting')->get('invoice_prefix', null, $branch_id);
        });
    }
}
