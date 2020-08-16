<?php

namespace DI;

use Worker\Env;
use Worker\Core\Worker\BackgroundRemovalWorker;
use Worker\Core\Storage\Storage;
use Worker\Core\Console;
use Worker\Http\Controller;
use Worker\Http\Request;
use Worker\Http\Response;

class Provider
{
    /**
     * @return void
     */
    public function register()
    {
        $env = (new Env);
        $DiService = (new DiService());

        $DiService->register('Request', function() {
            return new Request();
        }, true);

        $DiService->register('Response', function() {
            return new Response();
        }, true);

        $DiService->register('Console', function() use ($env) {
            return new Console($env->rootFolder, $env->executeScript);
        }, false);

        $DiService->register('Storage', function() use ($env) {
            return new Storage($env->storagePath);
        }, true);

        $DiService->register('Worker', function() use ($DiService) {
            return new BackgroundRemovalWorker($DiService->get('Console'), $DiService->get('Storage'));
        }, false);

        $DiService->register('Controller', function() use ($DiService) {
            return new Controller($DiService->get('Request'), $DiService->get('Response'), $DiService->get('Worker'));
        }, true);
    }
}
