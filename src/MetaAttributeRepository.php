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

namespace KodeKeep\MetaAttributes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class MetaAttributeRepository
{
    private Model $model;

    private ?string $group = null;

    public function __construct(Model $model, ?string $group)
    {
        $this->model = $model;
        $this->group = $group;
    }

    public function all(): Collection
    {
        return $this->model->metaAttributes()->get(['group', 'key', 'value'])->map->toArray();
    }

    public function get(string $key, $default = null)
    {
        if ($this->has($key)) {
            return $this->model->metaAttributes()->where([
                'group' => $this->group,
                'key'   => $key,
            ])->first();
        }

        return $default;
    }

    public function set(string $key, $value): void
    {
        $this->model->metaAttributes()->updateOrCreate([
            'group' => $this->group,
            'key'   => $key,
        ], [
            'group' => $this->group,
            'key'   => $key,
            'value' => $value,
        ]);
    }

    public function has(string $key): bool
    {
        return $this->model->metaAttributes()->where([
            'group' => $this->group,
            'key'   => $key,
        ])->count() === 1;
    }

    public function forget(string $key): bool
    {
        return $this->model->metaAttributes()->where([
            'group' => $this->group,
            'key'   => $key,
        ])->firstOrFail()->delete();
    }
}
