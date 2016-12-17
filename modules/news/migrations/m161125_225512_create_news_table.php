<?php
use yii\db\Schema;

class m161125_225512_create_news_table extends \yii\db\Migration
{
    public function safeUp()
    {
        $this->createTable('{{%news}}', [
            'id' => Schema::TYPE_PK,
            'author_id' => Schema::TYPE_INTEGER,
            'short_text' => Schema::TYPE_STRING . '(512) NOT NULL',
            'full_text' => Schema::TYPE_TEXT,
            'create_at' => Schema::TYPE_INTEGER,
            'update_at' => Schema::TYPE_INTEGER,
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('author_id_index', '{{%news}}', ['author_id']);

        $arrText = [
            'Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One Test text One ',
            'Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two Test text Two ',
            'Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three Test text Three ',
            'Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four Test text Four ',
            'Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five Test text Five ',
            'Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six Test text Six ',
            'Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven Test text Seven '
        ];

        foreach ($arrText as $text) {
            $this->insert('{{%news}}',[
                'author_id' => 1,
                'short_text' => mb_substr($text,0,500).'...',
                'full_text' => $text,
                'create_at' => time(),
                'update_at' => time()
            ]);
        }

    }

    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }
}