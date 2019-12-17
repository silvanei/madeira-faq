<?php

declare(strict_types=1);

namespace Faq\Driver\Repository;

use DateTimeImmutable;
use Exception;
use Faq\Entity\Question;
use Faq\Entity\Tag;
use Faq\Repository\QuestionRepository;
use PDO;

class PdoQuestionRepository implements QuestionRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @param string $search
     * @param string $tag
     * @param string $title
     * @return array<Question>
     * @throws Exception
     */
    public function findAll(string $search = '', string $tag = '', string $title = ''): array
    {
        $allQuestions = [];
        $parameters = [];

        $query = '
            SELECT 
                q.id, t.id as tag_id, 
                t.title as tag_title, 
                t.title_slug as tag_title_slug, 
                q.tags_id,
                q.title,
                q.title_slug,
                q.answer,
                q.created_at,
                q.updated_at,
                q.enabled
            FROM madeira_faq.questions q
            INNER JOIN madeira_faq.tags t ON t.id = q.tags_id
            WHERE 
                q.enabled = 1
        ';

        if (!empty($search)) {
            $parameters[':search'] = $search;
            $query .= ' AND MATCH (q.title, q.answer) AGAINST (:search)';
        }

        if (!empty($tag)) {
            $parameters[':tag_slug'] = $tag;
            $query .= ' AND t.title_slug = :tag_slug';
        }

        if (!empty($title)) {
            $parameters[':title_slug'] = $title;
            $query .= ' AND q.title_slug = :title_slug';
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($parameters);

        foreach ((array)$stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $allQuestions[] = $this->questionMap($row);
        }

        return $allQuestions;
    }

    /**
     * @return array<Tag>
     * @throws Exception
     */
    public function findAllTags(): array
    {
        $allTags = [];
        $stmt = $this->pdo->prepare('
            SELECT tags.id,
                tags.title,
                tags.title_slug,
                tags.created_at,
                tags.updated_at,
                tags.enabled
            FROM madeira_faq.tags
            WHERE tags.enabled = 1
        ');
        $stmt->execute();

        foreach ((array)$stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tag = new Tag();
            $tag->id = (int)$row['id'];
            $tag->title = $row['title'];
            $tag->title_slug = $row['title_slug'];
            $tag->created_at = new DateTimeImmutable($row['created_at']);
            $tag->updated_at = new DateTimeImmutable($row['updated_at']);
            $tag->enabled = (bool)$row['enabled'];

            $allTags[] = $tag;
        }

        return $allTags;
    }

    /**
     * @param int $id
     * @return Question|null
     * @throws Exception
     */
    public function fetch(int $id): ?Question
    {
        $query = '
            SELECT 
                q.id, t.id as tag_id, 
                t.title as tag_title, 
                t.title_slug as tag_title_slug, 
                q.tags_id,
                q.title,
                q.title_slug,
                q.answer,
                q.created_at,
                q.updated_at,
                q.enabled
            FROM madeira_faq.questions q
            INNER JOIN madeira_faq.tags t ON t.id = q.tags_id
            WHERE 
                q.enabled = 1
                AND q.id = :id
        ';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            return null;
        }

        return $this->questionMap($row);
    }

    /**
     * @param Question $question
     * @return Question|null
     * @throws Exception
     */
    public function store(Question $question): ?Question
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO madeira_faq.questions
            (
                tags_id,
                title,
                title_slug,
                answer,
                created_at,
                updated_at,
                enabled
            ) VALUES  (
                :tags_id,
                :title,
                :title_slug,
                :answer,
                :created_at,
                :updated_at,
                :enabled
            )
        ');

        $stmt->bindValue(':tags_id', $question->tag->id);
        $stmt->bindValue(':title', $question->title);
        $stmt->bindValue(':title_slug', $question->title_slug);
        $stmt->bindValue(':answer', $question->answer);
        $stmt->bindValue(':created_at', $question->created_at->format('Y-m-d H:i:s'));
        $stmt->bindValue(':updated_at', $question->updated_at->format('Y-m-d H:i:s'));
        $stmt->bindValue(':enabled', $question->enabled);
        $stmt->execute();

        return $this->fetch((int)$this->pdo->lastInsertId());
    }

    public function update(Question $question): bool
    {
        $stmt = $this->pdo->prepare('
            UPDATE madeira_faq.questions
            SET
                tags_id = :tags_id,
                title = :title,
                title_slug = :title_slug,
                answer = :answer,
                updated_at = :updated_at,
                enabled = :enabled
            WHERE id = :id
        ');

        $stmt->bindValue(':tags_id', $question->tag->id);
        $stmt->bindValue(':title', $question->title);
        $stmt->bindValue(':title_slug', $question->title_slug);
        $stmt->bindValue(':answer', $question->answer);
        $stmt->bindValue(':updated_at', $question->updated_at->format('Y-m-d H:i:s'));
        $stmt->bindValue(':enabled', (int)$question->enabled);
        $stmt->bindValue(':id', $question->id);
        $stmt->execute();

        return true;
    }

    /**
     * @param array<mixed> $row
     * @return Question
     * @throws Exception
     */
    private function questionMap(array $row): Question
    {
        $tag = new Tag();
        $tag->id = (int)$row['tag_id'];
        $tag->title = $row['tag_title'];
        $tag->title_slug = $row['tag_title_slug'];

        $question = new Question();
        $question->id = (int)$row['id'];
        $question->tag = $tag;
        $question->title = $row['title'];
        $question->title_slug = $row['title_slug'];
        $question->answer = $row['answer'];
        $question->created_at = new DateTimeImmutable($row['created_at']);
        $question->updated_at = new DateTimeImmutable($row['updated_at']);
        $question->enabled = (bool)$row['enabled'];

        return $question;
    }
}
