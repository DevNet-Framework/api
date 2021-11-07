<?php

namespace Application;

use DevNet\System\Async\Task;
use DevNet\Core\Http\HttpContext;
use DevNet\Core\Middleware\IApplicationBuilder;
use DevNet\Core\Configuration\IConfiguration;
use DevNet\Core\Dependency\IServiceCollection;
use DevNet\Core\Extensions\ServiceCollectionExtensions;
use DevNet\Core\Extensions\ApplicationBuilderExtensions;

class Startup
{
    private IConfiguration $Configuration;

    public function __construct(IConfiguration $configuration)
    {
        $this->Configuration = $configuration;
    }

    public function configureServices(IServiceCollection $services)
    {
        // services
    }

    public function configure(IApplicationBuilder $app)
    {
        $app->UseExceptionHandler();

        $app->useRouter();

        $app->useEndpoint(function ($routes) {
            $routes->mapGet("/", function (HttpContext $context): Task {
                $context->Response->Body->write("Hello World!");
                return Task::completedTask();
            });
        });
    }
}
