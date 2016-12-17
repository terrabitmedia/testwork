<?php

use yii\db\Migration;
use yii\db\Schema;

class m161125_235534_create_structure_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%event_providers}}', [
            'provider_id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'class' => Schema::TYPE_STRING . '(512) NOT NULL',
            'data' => Schema::TYPE_TEXT
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('{{%event_notices}}', [
            'notice_id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'class' => Schema::TYPE_STRING . '(512) NOT NULL',
            'title_template' => Schema::TYPE_TEXT,
            'template' => Schema::TYPE_TEXT,
            'data' => Schema::TYPE_TEXT
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('{{%events}}', [
            'event_id' => Schema::TYPE_PK,
            'notice_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'class' => Schema::TYPE_STRING . '(512) NOT NULL',
            'description' => Schema::TYPE_TEXT
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('events_name_and_class_index', '{{%events}}', ['name','class']);
        $this->createIndex('fk_events_notices_one_idx', '{{%events}}', ['notice_id']);
        $this->addForeignKey('fk_events_notices_one', '{{%events}}', 'notice_id', '{{%event_notices}}', 'notice_id', 'CASCADE');

        $this->createTable('{{%event_rules}}', [
            'rule_id' => Schema::TYPE_PK,
            'event_id' => Schema::TYPE_INTEGER,
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'class' => Schema::TYPE_STRING . '(512) NOT NULL',
            'data' => Schema::TYPE_TEXT
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('fk_event_rules_one_idx', '{{%event_rules}}', ['event_id']);
        $this->addForeignKey('fk_event_rules_one', '{{%event_rules}}', 'event_id', '{{%events}}', 'event_id', 'CASCADE');

        $this->createTable('{{%event_assignment}}', [
            'id' => Schema::TYPE_PK,
            'event_id' => Schema::TYPE_INTEGER,
            'provider_id' => Schema::TYPE_INTEGER,
            'attach' => Schema::TYPE_STRING . '(64) NOT NULL',
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('event_assignment_role_index', '{{%event_assignment}}', ['attach']);
        $this->createIndex('fk_event_assignment_provider1_idx', '{{%event_assignment}}', ['provider_id']);
        $this->createIndex('fk_event_assignment_events1_idx', '{{%event_assignment}}', ['event_id']);
        $this->addForeignKey('fk_event_assignment_providers1', '{{%event_assignment}}', 'provider_id', '{{%event_providers}}', 'provider_id', 'CASCADE');
        $this->addForeignKey('fk_event_assignment_events1', '{{%event_assignment}}', 'event_id', '{{%events}}', 'event_id', 'CASCADE');

        $this->createTable('{{%prepared}}', [
            'prepared_id' => Schema::TYPE_PK,
            'provider_id' => Schema::TYPE_INTEGER,
            'notice_id' => Schema::TYPE_INTEGER,
            'attach' => Schema::TYPE_STRING . '(64) NOT NULL',
            'priority' => "ENUM('low', 'high') NOT NULL DEFAULT 'low'",
            'status' => "ENUM('wait', 'process', 'close') NOT NULL DEFAULT 'wait'",
            'data' => Schema::TYPE_TEXT
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('prepared_role_index', '{{%prepared}}', ['attach']);
        $this->createIndex('messages_status_and_priority_index', '{{%prepared}}', ['status','priority']);
        $this->createIndex('fk_messages_providers1_idx', '{{%prepared}}', ['provider_id']);
        $this->createIndex('fk_messages_notices1_idx', '{{%prepared}}', ['notice_id']);
        $this->addForeignKey('fk_messages_providers1', '{{%prepared}}', 'provider_id', '{{%event_providers}}', 'provider_id', 'CASCADE');
        $this->addForeignKey('fk_messages_notices1', '{{%prepared}}', 'notice_id', '{{%event_notices}}', 'notice_id', 'CASCADE');

        $this->createTable('{{%messages}}', [
            'message_id' => Schema::TYPE_PK,
            'user_id' => Schema::TYPE_INTEGER,
            'provider_id' => Schema::TYPE_INTEGER,
            'notice_id' => Schema::TYPE_INTEGER,
            'status' => "ENUM('wait', 'error', 'done') NOT NULL DEFAULT 'wait'",
            'text' => Schema::TYPE_TEXT,
            'title' => Schema::TYPE_TEXT,
            'from' => Schema::TYPE_STRING . '(255) DEFAULT NULL',
            'to' => Schema::TYPE_STRING . '(255) DEFAULT NULL'
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('messages_user_id_index', '{{%messages}}', ['user_id']);
        $this->createIndex('messages_status_index', '{{%messages}}', ['status']);
        $this->createIndex('fk_messages_notices2_idx', '{{%messages}}', ['notice_id']);
        $this->createIndex('fk_messages_providers2_idx', '{{%messages}}', ['provider_id']);
        $this->addForeignKey('fk_messages_notices2', '{{%messages}}', 'notice_id', '{{%event_notices}}', 'notice_id', 'CASCADE');
        $this->addForeignKey('fk_messages_providers2', '{{%messages}}', 'provider_id', '{{%event_providers}}', 'provider_id', 'CASCADE');

        $this->createTable('{{%provider_has_user}}', [
            'provider_id' => Schema::TYPE_INTEGER,
            'user_id' => Schema::TYPE_INTEGER
        ],'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createIndex('fk_provider_has_user_user1_idx', '{{%provider_has_user}}', ['user_id']);
        $this->createIndex('fk_provider_has_user_provider1_idx', '{{%provider_has_user}}', ['provider_id']);
        $this->addForeignKey('fk_provider_has_user_provider1', '{{%provider_has_user}}', 'provider_id', '{{%event_providers}}', 'provider_id', 'CASCADE');
        $this->addForeignKey('fk_provider_has_user_user1', '{{%provider_has_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE');

    }

    public function safeDown()
    {
        $this->dropTable('{{%messages}}');
        $this->dropTable('{{%prepared}}');
        $this->dropTable('{{%event_assignment}}');
        $this->dropTable('{{%provider_has_user}}');
        $this->dropTable('{{%event_providers}}');
        $this->dropTable('{{%event_rules}}');
        $this->dropTable('{{%events}}');
        $this->dropTable('{{%event_notices}}');
    }
}