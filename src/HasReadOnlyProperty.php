<?php

declare(strict_types=1);

namespace Yuuan\ReadOnly;

trait HasReadOnlyProperty
{
    /**
     * Get the value of the specified property.
     *
     * @param  string  $key
     * @return mixed
     *
     * @throws \Yuuan\ReadOnly\UndefinedPropertyReferencedException
     */
    public function __get(string $key)
    {
        if (property_exists($this, $key)) {
            return $this->$key;
        }

        throw new UndefinedPropertyReferencedException($key, get_class($this));
    }

    /**
     * Set the value of the specified property.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     *
     * @throws \Yuuan\ReadOnly\ReadOnlyPropertyCannotBeSetException
     * @throws \Yuuan\ReadOnly\UndefinedPropertyCannotBeSetException
     */
    public function __set(string $key, $value)
    {
        if (property_exists($this, $key)) {
            throw new ReadOnlyPropertyCannotBeSetException($key, get_class($this));
        }

        throw new UndefinedPropertyCannotBeSetException($key, get_class($this));
    }

    /**
     * Determine if a property is declared and is different than null.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset(string $key): bool
    {
        return property_exists($this, $key) ? isset($this->$key) : false;
    }
}
