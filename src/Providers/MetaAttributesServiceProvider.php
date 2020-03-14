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

namespace KodeKeep\MetaAttributes\Providers;

use Illuminate\Support\ServiceProvider;

class MetaAttributesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/meta-attributes.php', 'meta-attributes');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/meta-attributes.php' => $this->app->configPath('meta-attributes.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../../database/migrations/' => $this->app->databasePath('migrations'),
            ], 'migrations');
        }
    }
}
