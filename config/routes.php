<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;
use Faq\Handler\QuestionListHandler;
use Faq\Handler\QuestionEditHandler;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');

    $app->get('/admin/faq/question', QuestionListHandler::class, 'admin.faq.question.list');
    $app->get('/admin/faq/question/{id}', QuestionEditHandler::class, 'admin.faq.question.edit');
};
