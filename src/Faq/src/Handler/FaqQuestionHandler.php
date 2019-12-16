<?php

declare(strict_types=1);

namespace Faq\Handler;

use Faq\UseCase\RegisterQuestions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class FaqQuestionHandler implements RequestHandlerInterface
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
        $template = 'faq::faq/question';

        $search = $request->getQueryParams()['search'] ?? '';
        $tag = $request->getAttribute('tag', '');
        $title = $request->getAttribute('title', '');

        if (!empty($search) || !empty($title)) {
            $template = 'faq::faq/answer';
        }

        return new HtmlResponse(
            $this->renderer->render(
                $template,
                [
                    'search' => $search,
                    'selectedTag' => $tag,
                    'tags' => $this->registerQuestions->findAllTags(),
                    'questions' => $this->registerQuestions->findAll($search, $tag, $title)
                ]
            )
        );
    }
}
