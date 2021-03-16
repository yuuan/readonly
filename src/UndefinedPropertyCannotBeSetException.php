<?php

declare(strict_types=1);

namespace Yuuan\ReadOnly;

use LogicException;

class UndefinedPropertyCannotBeSetException extends LogicException
{
    /**
     * The property key that was about to be set.
     *
     * @var string
     */
    protected string $key;

    /**
     * The class whose property was about to be set.
     *
     * @var class-string
     */
    protected string $className;

    /**
     * Create an exception instance.
     *
     * @param  string  $key
     * @param  class-string  $className
     * @return void
     */
    public function __construct(string $key, string $className)
    {
        $this->className = $className;
        $this->key = $key;

        $this->message = sprintf(
            'The specified property `%s::%s` cannot be set, because it is not defined.',
            $className,
            $key
        );
    }

    /**
     * Get the property key that was about to be set.
     *
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Get the class whose property was about to be set.
     *
     * @return class-string
     */
    public function getClassName(): string
    {
        return $this->className;
    }
}
