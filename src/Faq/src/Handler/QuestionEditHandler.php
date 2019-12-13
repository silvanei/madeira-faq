<?php

declare(strict_types=1);

namespace Faq\Handler;

use Faq\Form\QuestionForm;
use Faq\UseCase\RegisterQuestions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;

class QuestionEditHandler implements RequestHandlerInterface
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
        $id = (int)$request->getAttribute('id');
        $form = new QuestionForm();
        $questions = $this->registerQuestions->find($id);

        $form->setData((array)$request->getParsedBody());
        $form->isValid();

        return new HtmlResponse(
            $this->renderer->render(
                'faq::question/question-edit',
                [
                    'form' => $form,
                    'question' => $questions
                ]
            )
        );
    }
}
