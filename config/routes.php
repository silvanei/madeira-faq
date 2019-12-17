<?php

declare(strict_types=1);

use Faq\Handler\FaqHandler;
use Faq\Handler\QuestionDeleteHandler;
use Faq\Handler\QuestionEditHandler;
use Faq\Handler\QuestionListHandler;
use Faq\Handler\QuestionNewHandler;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container): void {
    $app->get('/', App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', App\Handler\PingHandler::class, 'api.ping');

    $app->get('/faq', FaqHandler::class, 'faq.question');
    $app->get('/faq/{tag}', FaqHandler::class, 'faq.question.tag');
    $app->get('/faq/{tag}/{title}', FaqHandler::class, 'faq.answer');
    $app->get('/admin/faq/question', QuestionListHandler::class, 'admin.faq.question.list');
    $app->route('/admin/faq/question/new', QuestionNewHandler::class, ['GET', 'POST'], 'admin.faq.question.new');
    $app->route('/admin/faq/question/delete', QuestionDeleteHandler::class, ['POST'], 'admin.faq.question.delete');
    $app->route('/admin/faq/question/{id:\d+}', QuestionEditHandler::class, ['GET', 'POST'], 'admin.faq.question.edit');
};
