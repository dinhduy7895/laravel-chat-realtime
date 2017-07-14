<?php

namespace App\Repositories\Conversation;

use Illuminate\Support\ServiceProvider;

class ConversationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Conversation\ConversationRepositoryInterface', 'App\Repositories\Conversation\ConversationRepositoryEloquent');

    }
}
