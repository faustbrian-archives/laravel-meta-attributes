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

namespace KodeKeep\MetaAttributes\Tests\Unit;

use Illuminate\Foundation\Auth\User;
use KodeKeep\MetaAttributes\Concerns\HasMetaAttributes;

/**
 * @coversNothing
 */
class ClassThatHasMetaAttributes extends User
{
    use HasMetaAttributes;

    protected $table = 'users';

    protected $fillable = ['name', 'email', 'password'];
}
