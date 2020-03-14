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

namespace KodeKeep\MetaAttributes\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use KodeKeep\MetaAttributes\Tests\TestCase;

/**
 * @covers \KodeKeep\MetaAttributes\Models\MetaAttribute
 */
class MetaAttributeTest extends TestCase
{
    /** @test */
    public function it_morphs_to_an_eloquent_model(): void
    {
        $attribute = $this->user()->metaAttributes()->create([
            'group' => 'group',
            'key'   => 'key',
            'value' => 'value',
        ]);

        $this->assertInstanceOf(MorphTo::class, $attribute->metable());
    }
}
