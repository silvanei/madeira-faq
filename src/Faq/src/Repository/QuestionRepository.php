<?php

namespace Faq\Repository;

use Faq\Entity\Question;
use Faq\Entity\Tag;

interface QuestionRepository
{
    /**
     * @param string $search
     * @param string $tag
     * @param string $title
     * @return array<Question>
     */
    public function findAll(string $search = '', string $tag = '', string $title = ''): array;

    public function fetch(int $id): ?Question;

    public function store(Question $question): ?Question;

    public function update(Question $question): bool;

    /** @return array<Tag> */
    public function findAllTags(): array;
}
