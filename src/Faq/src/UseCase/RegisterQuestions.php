<?php

declare(strict_types=1);

namespace Faq\UseCase;

use Faq\Entity\Question;
use Faq\Repository\QuestionRepository;

final class RegisterQuestions
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @return array<Question>
     */
    public function findAll(): array
    {
        return  $this->questionRepository->findAll();
    }

    public function find(int $id): ?Question
    {
        return $this->questionRepository->fetch($id);
    }
}
