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

namespace KodeKeep\MetaAttributes\Models;

use Illuminate\Database\Eloquent\Model;

class MetaAttribute extends Model
{
    protected $fillable = ['group', 'key', 'value'];

    public function metable()
    {
        return $this->morphTo();
    }
}
