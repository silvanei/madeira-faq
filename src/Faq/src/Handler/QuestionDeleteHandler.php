<?php

declare(strict_types=1);

namespace Faq\Handler;

use DomainException;
use Faq\UseCase\RegisterQuestions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

class QuestionDeleteHandler implements RequestHandlerInterface
{
    private UrlHelper $urlHelper;
    private TemplateRendererInterface $renderer;
    private RegisterQuestions $registerQuestions;

    public function __construct(
        UrlHelper $helper,
        TemplateRendererInterface $renderer,
        RegisterQuestions $registerQuestions
    ) {
        $this->urlHelper = $helper;
        $this->renderer = $renderer;
        $this->registerQuestions = $registerQuestions;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $body = (array)$request->getParsedBody();
        $id = (int)$body['id']  ?? 0;
        $flash = $request->getAttribute('flash');

        try {
            $this->registerQuestions->delete($id);
            $flash->addMessage('success', 'Pergunta excluída com sucesso');
        } catch (DomainException $exception) {
            $flash->addMessage('danger', $exception->getMessage());
        }

        return new JsonResponse([
            'location' => $this->urlHelper->generate('admin.faq.question.list')
        ]);
    }
}
