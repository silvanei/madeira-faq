<?php

namespace Db\Migrations;

use Phinx\Migration\AbstractMigration;

class MadeiraFaqQuestionsTable extends AbstractMigration
{
    public function up()
    {
        $this->execute("            
            CREATE TABLE IF NOT EXISTS madeira_faq.questions (
              id int(11) NOT NULL AUTO_INCREMENT,
              tags_id int(11) NOT NULL,
              title varchar(255) NOT NULL,
              title_slug varchar(255) NOT NULL,
              answer text NOT NULL,
              created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              enabled tinyint(4) NOT NULL DEFAULT '1',
              PRIMARY KEY (id),
              KEY fk_questions_tags_idx (tags_id),
              FULLTEXT KEY FULLTEXT_QUESTIONS (title,answer),
              CONSTRAINT fk_questions_tags FOREIGN KEY (tags_id) REFERENCES tags (id)
            ) ENGINE=InnoDB
        ");
    }

    public function down()
    {
        $this->execute('DROP TABLE madeira_faq.questions');
    }
}
