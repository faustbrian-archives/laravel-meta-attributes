<?php

declare(strict_types=1);

/*
 * This file is part of kodekeep/laravel-meta-attributes.
 *
 * (c) KodeKeep <hello@kodekeep.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KodeKeep\MetaAttributes\Tests\Unit\Concerns;

use ArrayIterator;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use KodeKeep\MetaAttributes\Tests\TestCase;

/**
 * @covers \KodeKeep\MetaAttributes\Concerns\HasMetaAttributes
 * @covers \KodeKeep\MetaAttributes\MetaAttributes
 */
class HasMetaAttributesTest extends TestCase
{
    /** @test */
    public function it_morphs_many_meta_attributes(): void
    {
        $this->assertInstanceOf(MorphMany::class, $this->user()->metaAttributes());
    }

    /** @test */
    public function it_can_get_all_attributes(): void
    {
        $user = $this->user();

        $this->assertTrue($user->meta()->all()->isEmpty());

        $user->meta()->set('key1', 'value');
        $user->meta()->set('key2', 'value');

        $this->assertInstanceOf(Collection::class, $user->meta()->all());
        $this->assertCount(2, $user->meta()->all());
    }

    /** @test */
    public function it_can_set_and_get_a_value(): void
    {
        $user = $this->user();

        $this->assertFalse($user->meta()->has('key'));

        $user->meta()->set('key', 'value');

        $this->assertTrue($user->meta()->has('key'));
        $this->assertSame('value', $user->meta()->get('key'));
        $this->assertSame('defaultValue', $user->meta()->get('unknownKey', 'defaultValue'));
    }

    /** @test */
    public function it_can_set_and_get_a_value_via_offset(): void
    {
        $user = $this->user();

        $this->assertFalse(isset($user->meta()['key']));

        $user->meta()['key'] = 'value';

        $this->assertTrue(isset($user->meta()['key']));
        $this->assertSame('value', $user->meta()['key']);
    }

    /** @test */
    public function it_can_set_and_forget_a_value(): void
    {
        $user = $this->user();

        $this->assertFalse($user->meta()->has('key'));

        $user->meta()->set('key', 'value');

        $this->assertTrue($user->meta()->has('key'));

        $user->meta()->forget('key');

        $this->assertFalse($user->meta()->has('key'));
    }

    /** @test */
    public function it_can_set_and_forget_a_value_via_offset(): void
    {
        $user = $this->user();

        $this->assertFalse(isset($user->meta()['key']));

        $user->meta()->set('key', 'value');

        $this->assertTrue(isset($user->meta()['key']));

        unset($user->meta()['key']);

        $this->assertFalse(isset($user->meta()['key']));
    }

    /** @test */
    public function it_implements_to_array(): void
    {
        $user = $this->user();

        $user->meta()->set('key1', 'value');
        $user->meta()->set('key2', 'value');

        $this->assertIsArray($user->meta()->toArray());
        $this->assertSame(['key1' => 'value', 'key2' => 'value'], $user->meta()->toArray());
    }

    /** @test */
    public function it_implements_to_json(): void
    {
        $user = $this->user();

        $user->meta()->set('key', 'value');

        $this->assertIsString($user->meta()->toJson());
    }

    /** @test */
    public function it_implements_json_serialize(): void
    {
        $user = $this->user();

        $user->meta()->set('key', 'value');

        $this->assertIsArray($user->meta()->jsonSerialize());
    }

    /** @test */
    public function it_implements_count(): void
    {
        $user = $this->user();

        $user->meta()->set('key', 'value');

        $this->assertSame(1, $user->meta()->count());
    }

    /** @test */
    public function it_implements_get_iterator(): void
    {
        $user = $this->user();

        $user->meta()->set('key', 'value');

        $this->assertInstanceOf(ArrayIterator::class, $user->meta()->getIterator());
    }
}
