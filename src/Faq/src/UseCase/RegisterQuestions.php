<?php

declare(strict_types=1);

namespace Faq\UseCase;

use DateTimeImmutable;
use DomainException;
use Faq\Entity\Question;
use Faq\Entity\Slug;
use Faq\Entity\Tag;
use Faq\Repository\QuestionRepository;

final class RegisterQuestions
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    /**
     * @param string $search
     * @param string $tag
     * @param string $title
     * @return array<Question>
     */
    public function findAll(string $search = '', string $tag = '', string $title = ''): array
    {
        return $this->questionRepository->findAll($search, $tag, $title);
    }

    /**
     * @return array<Tag>
     */
    public function findAllTags(): array
    {
        return $this->questionRepository->findAllTags();
    }

    public function find(int $id): ?Question
    {
        return $this->questionRepository->fetch($id);
    }

    public function store(Question $question): ?Question
    {
        $question->title_slug = (string)new Slug($question->title);
        $question->created_at = new DateTimeImmutable();
        $question->updated_at = new DateTimeImmutable();
        $question->enabled = true;
        return $this->questionRepository->store($question);
    }

    public function update(Question $question): bool
    {
        $question->title_slug = (string)new Slug($question->title);
        $question->updated_at = new \DateTimeImmutable();
        return $this->questionRepository->update($question);
    }

    public function delete(int $id): bool
    {
        $question = $this->find($id);

        if (is_null($question)) {
            throw new DomainException(sprintf('Pergunta com ID: %s não encontrada', $id));
        }

        $question->updated_at = new DateTimeImmutable();
        $question->enabled = false;
        return $this->questionRepository->update($question);
    }
}
