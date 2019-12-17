<?php

declare(strict_types=1);

namespace Faq;

use Faq\Driver\Repository\PdoQuestionRepositoryFactory;
use Faq\Handler\FaqHandler;
use Faq\Handler\QuestionDeleteHandler;
use Faq\Handler\QuestionEditHandler;
use Faq\Handler\QuestionListHandler;
use Faq\Handler\QuestionNewHandler;
use Faq\Repository\QuestionRepository;
use Faq\UseCase\RegisterQuestions;
use Zend\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;

class ConfigProvider
{
    /**
     * @return array<array>
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates' => $this->getTemplates(),
        ];
    }

    /**
     * @return array<array>
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
            ],
            'factories' => [
                FaqHandler::class => ReflectionBasedAbstractFactory::class,
                QuestionListHandler::class => ReflectionBasedAbstractFactory::class,
                QuestionNewHandler::class => ReflectionBasedAbstractFactory::class,
                QuestionEditHandler::class => ReflectionBasedAbstractFactory::class,
                QuestionDeleteHandler::class => ReflectionBasedAbstractFactory::class,
                RegisterQuestions::class => ReflectionBasedAbstractFactory::class,
                QuestionRepository::class => PdoQuestionRepositoryFactory::class,
            ],
        ];
    }

    /**
     * @return array<array>
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'faq' => [__DIR__ . '/../templates/'],
                'error' => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
