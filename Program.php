<?php

namespace Application;

use DevNet\Core\Extensions\ApplicationBuilderExtensions;
use DevNet\Core\Extensions\ServiceCollectionExtensions;
use DevNet\Core\Hosting\WebHost;
use DevNet\Core\Http\HttpContext;
use DevNet\System\Async\Task;

class Program
{
    public static function main(array $args = [])
    {
        $builder = WebHost::createDefaultBuilder($args);
        $configuration = $builder->ConfigBuilder->build();

        $builder->configureServices(function ($services) {
            // services
        });

        $host = $builder->build();

        $host->start(function ($app) use ($configuration) {
            if ($configuration->getValue('environment') == 'development') {
                $app->UseExceptionHandler();
            } else {
                $app->UseExceptionHandler("/home/error");
            }

            $app->useRouter();
            // middlewares
            $app->useEndpoint(function ($routes) {
                $routes->mapGet("/", fn (HttpContext $context): Task => $context->Response->writeAsync("Hello World!"));
            });
        });
    }
}
