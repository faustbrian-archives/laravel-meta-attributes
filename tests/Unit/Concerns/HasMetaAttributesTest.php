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

use Illuminate\Database\Eloquent\Relations\MorphMany;
use KodeKeep\MetaAttributes\Tests\TestCase;

/**
 * @covers \KodeKeep\MetaAttributes\Concerns\HasMetaAttributes
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
        $user->meta()->set('key3', 'value');

        $this->assertSame([
            [
                'group' => null,
                'key'   => 'key1',
                'value' => 'value',
            ], [
                'group' => null,
                'key'   => 'key2',
                'value' => 'value',
            ], [
                'group' => null,
                'key'   => 'key3',
                'value' => 'value',
            ],
        ], $user->meta()->all()->toArray());
    }

    /** @test */
    public function it_can_set_and_get_a_value(): void
    {
        $user = $this->user();

        $this->assertFalse($user->meta()->has('key'));

        $user->meta()->set('key', 'value');

        $this->assertTrue($user->meta()->has('key'));
        $this->assertSame('value', $user->meta()->get('key')->value);
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
}
