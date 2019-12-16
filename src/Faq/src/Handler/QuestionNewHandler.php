<?php

declare(strict_types=1);

namespace Faq\Handler;

use Faq\Entity\Question;
use Faq\Entity\Tag;
use Faq\Form\QuestionForm;
use Faq\UseCase\RegisterQuestions;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Flash\Messages;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

class QuestionNewHandler implements RequestHandlerInterface
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
        $form = new QuestionForm(
            'question',
            ['tags' => $this->registerQuestions->findAllTags()]
        );

        /** @var Messages $flash */
        $flash = $request->getAttribute('flash');

        if ($request->getMethod() === 'GET') {
            return new HtmlResponse(
                $this->renderer->render(
                    'faq::question/question-form',
                    [
                        'titleForm' => 'Adicionar: Perguntas mais frequentes',
                        'form' => $form,
                    ]
                )
            );
        }

        $form->setData((array)$request->getParsedBody());
        if (!$form->isValid()) {
            return new HtmlResponse(
                $this->renderer->render(
                    'faq::question/question-form',
                    [
                        'titleForm' => 'Adicionar: Perguntas mais frequentes',
                        'form' => $form
                    ]
                )
            );
        }

        $validData = (array)$form->getData();

        $tag = new Tag();
        $tag->id = $validData['tags_id'];

        $question = new Question();
        $question->tag = $tag;
        $question->title = $validData['title'];
        $question->title_slug = $validData['title'];
        $question->answer = $validData['answer'];

        $this->registerQuestions->store($question);

        $flash->addMessage('success', 'Pergunta adicionada com sucesso');
        return new RedirectResponse($this->urlHelper->generate('admin.faq.question.list'));
    }
}
