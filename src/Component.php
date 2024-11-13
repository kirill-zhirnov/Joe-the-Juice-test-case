<?php
declare(strict_types=1);

namespace App;

class Component
{
    public function __get($name): mixed
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new \RuntimeException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    public function __isset($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }

        if (property_exists($this, $name)) {
            return isset($this->{$name});
        }

        return false;
    }
}
