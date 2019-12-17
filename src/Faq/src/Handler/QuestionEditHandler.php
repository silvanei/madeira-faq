<?php

declare(strict_types=1);

namespace Faq\Handler;

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

class QuestionEditHandler implements RequestHandlerInterface
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
        $id = (int)$request->getAttribute('id');

        $form = new QuestionForm(
            'question',
            ['tags' => $this->registerQuestions->findAllTags()]
        );

        $question = $this->registerQuestions->find($id);

        /** @var Messages $flash */
        $flash = $request->getAttribute('flash');

        if (is_null($question)) {
            $flash->addMessage('danger', sprintf('Pergunta com ID: %s não encontrada', $id));
            return new RedirectResponse($this->urlHelper->generate('admin.faq.question.list'));
        }

        if ($request->getMethod() === 'GET') {
            $form->setData([
                'tags_id' => $question->tag->id,
                'title' => $question->title,
                'answer' => $question->answer,
            ]);

            return $this->createHtmlResponse($form);
        }

        $form->setData((array)$request->getParsedBody());
        if (!$form->isValid()) {
            return $this->createHtmlResponse($form);
        }

        $validData = (array)$form->getData();

        $tag = new Tag();
        $tag->id = $validData['tags_id'];

        $question->title = $validData['title'];
        $question->answer = $validData['answer'];
        $question->tag = $tag;

        $this->registerQuestions->update($question);

        $flash->addMessage('success', 'Pergunta atualizada com sucesso');
        return new RedirectResponse($this->urlHelper->generate('admin.faq.question.list'));
    }

    /**
     * @param QuestionForm $form
     * @return HtmlResponse
     */
    private function createHtmlResponse(QuestionForm $form): HtmlResponse
    {
        return new HtmlResponse(
            $this->renderer->render(
                'faq::question/question-form',
                [
                    'titleForm' => 'Editar: Perguntas mais frequentes',
                    'form' => $form
                ]
            )
        );
    }
}
