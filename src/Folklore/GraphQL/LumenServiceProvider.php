<?php namespace Folklore\GraphQL;

use Illuminate\Support\Facades\Facade;

class LumenServiceProvider extends ServiceProvider
{
    /**
     * Get the active router.
     *
     * @return Router
     */
    protected function getRouter()
    {
        return $this->app;
    }
    
    /**
     * Bootstrap publishes
     *
     * @return void
     */
    protected function bootPublishes()
    {
        $configPath = __DIR__ . '/../../config';
        $this->mergeConfigFrom($configPath . '/config.php', 'graphql');
    }

    /**
     * Register facade
     *
     * @return void
     */
    public function registerGraphQL()
    {
        // Check if facades are activated
        if (Facade::getFacadeApplication() == $this->app) {
            class_alias(\Folklore\GraphQL\Support\Facades\GraphQL::class, 'GraphQL');
        }

        parent::registerGraphQL();
    }

    /**
     * Register the helper command to publish the config file
     */
    public function registerConsole()
    {
        parent::registerConsole();
        
        $this->command(\Folklore\GraphQL\Console\PublishCommand::class);
    }
}
