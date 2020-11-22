<?php
namespace App\Http\Services;

class TryService
{
    public function callTry()
    {
        $service = app()->make('ShortUrlService');
        dd($service->version);
    }

    public $name = 'john';
    public function __set($name, $value)
    {
        if (isset($this->$name)) {
            return $this->$name = $value;
        } else {
            return null;
        }
    }
    public function __get($name)
    {
        return $name;
    }
    public function __call($method, $args)
    {
        dump('一般方法');
        dump($method);
        dump($args);
    }
    public function __callStatic($method, $args)
    {
        dump('特殊方法');
    }
}
