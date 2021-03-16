<?php

declare(strict_types=1);

namespace Yuuan\Tests\ReadOnly;

use PHPUnit\Framework\TestCase;
use Yuuan\ReadOnly\HasReadOnlyProperty;
use Yuuan\ReadOnly\ReadOnlyPropertyCannotBeSetException;
use Yuuan\ReadOnly\UndefinedPropertyCannotBeSetException;
use Yuuan\ReadOnly\UndefinedPropertyReferencedException;

class HasReadOnlyPeopertyTest extends TestCase
{
    public function testConstruct(): void
    {
        $subject = new class() {
            use HasReadOnlyProperty;
        };

        $this->assertNotNull($subject);
    }

    // public property

    public function testGetPublicProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;

            public string $foo = 'FOO';
        };

        $this->assertSame('FOO', $instance->foo);
    }

    public function testSetPublicProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;

            public string $foo;
        };

        $instance->foo = 'Foo';

        $this->assertSame('Foo', $instance->foo);
    }

    public function testIssetPublicProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;

            public string $foo = 'FOO';
        };

        $this->assertTrue(isset($instance->foo));
    }

    // private property

    public function testGetPrivateProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;

            private string $foo = 'FOO';
        };

        /* @phpstan-ignore-next-line */
        $this->assertSame('FOO', $instance->foo);
    }

    public function testSetPrivateProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;

            private string $foo;
        };

        $this->expectException(ReadOnlyPropertyCannotBeSetException::class);

        /* @phpstan-ignore-next-line */
        $instance->foo = 'Foo';
    }

    public function testIssetPrivateProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;

            private string $foo = 'FOO';
        };

        $this->assertTrue(isset($instance->foo));
    }

    // protected property

    public function testGetProtectedProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;

            protected string $foo = 'FOO';
        };

        /* @phpstan-ignore-next-line */
        $this->assertSame('FOO', $instance->foo);
    }

    public function testSetProtectedProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;

            protected string $foo;
        };

        $this->expectException(ReadOnlyPropertyCannotBeSetException::class);

        /* @phpstan-ignore-next-line */
        $instance->foo = 'Foo';
    }

    public function testIssetProtectedProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;

            protected string $foo = 'FOO';
        };

        $this->assertTrue(isset($instance->foo));
    }

    // undefined property

    public function testGetUndefinedProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;
        };

        $this->expectException(UndefinedPropertyReferencedException::class);
        $this->expectExceptionMessage('foo');

        /** @phpstan-ignore-next-line */
        $subject = $instance->foo;
    }

    public function testSetUndefinedProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;
        };

        $this->expectException(UndefinedPropertyCannotBeSetException::class);

        /* @phpstan-ignore-next-line */
        $instance->foo = 'Foo';
    }

    public function testIssetUndefinedProperty(): void
    {
        $instance = new class() {
            use HasReadOnlyProperty;
        };

        $this->assertFalse(isset($instance->foo));
    }
}
