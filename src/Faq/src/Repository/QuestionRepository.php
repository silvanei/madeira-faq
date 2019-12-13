<?php

namespace Faq\Repository;

use Faq\Entity\Question;

interface QuestionRepository
{
    /**
     * @return array<Question>
     */
    public function findAll(): array;

    public function fetch(int $id): ?Question;
}
