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

namespace KodeKeep\MetaAttributes\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use KodeKeep\MetaAttributes\MetaAttributes;
use KodeKeep\MetaAttributes\Models\MetaAttribute;

trait HasMetaAttributes
{
    public function metaAttributes(): MorphMany
    {
        return $this->morphMany(MetaAttribute::class, 'metable');
    }

    public function meta(?string $group = null): MetaAttributes
    {
        return new MetaAttributes($this, $group);
    }
}
