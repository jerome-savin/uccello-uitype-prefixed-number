<?php

namespace JeromeSavin\UccelloUitypePrefixedNumber\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * App Service Provider
 */
class AppServiceProvider extends ServiceProvider
{
  /**
   * Indicates if loading of the provider is deferred.
   *
   * @var bool
   */
  protected $defer = false;

  public function boot()
  {
    // Views
    $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'uccello-uitype-prefixed-number');

    // Translations
    $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'uccello-uitype-prefixed-number');

    // Migrations
    $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

    // Routes
    $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

    // Publish assets
    $this->publishes([
      __DIR__ . '/../../resources/views' => base_path('resources/views/vendor/jerome-savin/uccello-uitype-prefixed-number'),
    ]); // CSS

  }

  public function register()
  {

  }
}