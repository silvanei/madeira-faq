<?php

declare(strict_types=1);

namespace Faq\Entity;

use DateTimeImmutable;

final class Question
{

    public int $id;
    public Tag $tag;
    public string $title;
    public string $title_slug;
    public string $answer;

    public DateTimeImmutable $created_at;
    public DateTimeImmutable $updated_at;
    public bool $enabled;
}
