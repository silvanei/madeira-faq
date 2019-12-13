<?php

declare(strict_types=1);

namespace Faq\Driver\Repository;

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
     * @return array<Question>
     */
    public function findAll(): array
    {
        $allQuestions = [];

        $query = '
            SELECT q.id, t.title as tag_title, q.title
            FROM madeira_faq.questions q
            INNER JOIN madeira_faq.tags t ON t.id = q.tags_id
            WHERE q.enabled = 1
        ';

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        foreach ((array)$stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tag = new Tag();
            $tag->title = $row['tag_title'];

            $question = new Question();
            $question->id = (int)$row['id'];
            $question->tag = $tag;
            $question->title = $row['title'];

            $allQuestions[] = $question;
        }

        return $allQuestions;
    }

    public function fetch(int $id): ?Question
    {
        $query = '
            SELECT q.id, t.title as tag_title, q.title
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

        $tag = new Tag();
        $tag->title = $row['tag_title'];

        $question = new Question();
        $question->id = (int)$row['id'];
        $question->tag = $tag;
        $question->title = $row['title'];

        return $question;
    }
}
