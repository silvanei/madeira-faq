<?php

namespace Db\Migrations;

use Phinx\Migration\AbstractMigration;

class MadeiraFaqTagsTable extends AbstractMigration
{
    public function up()
    {
        $this->execute("
            CREATE TABLE IF NOT EXISTS madeira_faq.tags (
              id int(11) NOT NULL AUTO_INCREMENT,
              title varchar(255) NOT NULL,
              title_slug varchar(255) NOT NULL,
              created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
              enabled tinyint(4) NOT NULL DEFAULT '1',
              PRIMARY KEY (id),
              FULLTEXT KEY FUILLTEXT_TAGS (title)
            ) ENGINE=InnoDB COMMENT='Categorização das perguntas'
        ");
    }

    public function down()
    {
        $this->execute('DROP TABLE madeira_faq.tags');
    }
}
