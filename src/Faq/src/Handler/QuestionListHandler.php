<?php

declare(strict_types=1);

namespace Faq\Handler;

use Faq\UseCase\RegisterQuestions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Flash\Messages;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class QuestionListHandler implements RequestHandlerInterface
{
    private TemplateRendererInterface $renderer;
    private RegisterQuestions $registerQuestions;

    public function __construct(TemplateRendererInterface $renderer, RegisterQuestions $registerQuestions)
    {
        $this->renderer = $renderer;
        $this->registerQuestions = $registerQuestions;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var Messages $flash */
        $flash = $request->getAttribute('flash');
        $messages = $flash->getMessages();

        $search = $request->getQueryParams()['search'] ?? '';
        $tag = $request->getQueryParams()['tag'] ?? '';

        return new HtmlResponse(
            $this->renderer->render(
                'faq::question/question-list',
                [
                    'messages' => $messages,
                    'search' => $search,
                    'tag' => $tag,
                    'tags' => $this->registerQuestions->findAllTags(),
                    'questions' => $this->registerQuestions->findAll($search, $tag)
                ]
            )
        );
    }
}
