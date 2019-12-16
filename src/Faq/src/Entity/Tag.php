<?php

declare(strict_types=1);

namespace Faq\Entity;

use DateTimeImmutable;

final class Tag
{
    public int $id;
    public string $title;
    public string $title_slug;

    public DateTimeImmutable $created_at;
    public DateTimeImmutable $updated_at;
    public bool $enabled;

    public function __toString()
    {
        return $this->title;
    }
}
