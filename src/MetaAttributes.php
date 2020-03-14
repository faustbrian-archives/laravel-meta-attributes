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

use ArrayAccess;
use ArrayIterator;
use Countable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use IteratorAggregate;
use JsonSerializable;

class MetaAttributes implements ArrayAccess, Arrayable, Countable, IteratorAggregate, Jsonable, JsonSerializable
{
    protected Model $model;

    protected ?string $group = null;

    protected $collection;

    public function __construct(Model $model, ?string $group)
    {
        $this->model = $model;

        $this->group = $group;

        $this->loadCollection();
    }

    public function all(): Collection
    {
        return $this->collection;
    }

    public function get($key, $default = null)
    {
        return Arr::get($this->collection, $key, $default);
    }

    public function set($key, $value)
    {
        $this->model->metaAttributes()->updateOrCreate([
            'group' => $this->group,
            'key'   => $key,
        ], [
            'group' => $this->group,
            'key'   => $key,
            'value' => $value,
        ]);

        return $this->loadCollection();
    }

    public function has($key): bool
    {
        return Arr::has($this->collection, $key);
    }

    public function forget($keys): self
    {
        foreach ((array) $keys as $key) {
            $this->model->metaAttributes()->where([
                'group' => $this->group,
                'key'   => $key,
            ])->firstOrFail()->delete();
        }

        return $this->loadCollection();
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetExists($offset)
    {
        return $this->collection->offsetExists($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset)
    {
        $this->forget($offset);
    }

    public function toArray(): array
    {
        return $this->collection->toArray();
    }

    public function toJson($options = 0): string
    {
        return $this->collection->toJson($options);
    }

    public function jsonSerialize(): array
    {
        return $this->collection->jsonSerialize();
    }

    public function count(): int
    {
        return $this->collection->count();
    }

    public function getIterator(): ArrayIterator
    {
        return $this->collection->getIterator();
    }

    private function loadCollection(): self
    {
        $this->collection = $this->model->fresh()
            ->metaAttributes()
            ->where('group', $this->group)
            ->get()
            ->mapWithKeys(fn ($item) => [$item['key'] => $item['value']]);

        return $this;
    }
}
