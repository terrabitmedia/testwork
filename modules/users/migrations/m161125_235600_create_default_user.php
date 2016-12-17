<?php


class m161125_235600_create_default_user extends \yii\db\Migration
{
    public function safeUp()
    {
        $this->insert('{{%user}}',[
            'id' => '1',
            'username' => 'admin',
            'email' => 'testAdmin@test1010.ru',
            'password_hash' => '$2y$10$iX61PoIM8P1Dx88IlK6I2eQk6A17WYl.YuVcqyW2EFUoafrkt5Xv.',
            'auth_key' => 'nrPDIeHB6O5TqQvFyihO8aCPa5dJogc8',
            'confirmed_at' => '1479932867',
            'unconfirmed_email' => NULL,
            'blocked_at' => NULL,
            'registration_ip' => '127.0.0.1',
            'created_at' => '1479929698',
            'updated_at' => '1480004238',
            'flags' => '0'
        ]);
        $this->insert('{{%user}}',[
            'id' => '2',
            'username' => 'manager',
            'email' => 'testManager@test1010.ru',
            'password_hash' => '$2y$10$aZnbE7yG0iYWedne3hMPjuSfMAr0QbwcfrDkIsawhgyaBVVnojZdi',
            'auth_key' => 'FJvuW5WMpuDw9J4MlbvdSXEgUHiBCKZT',
            'confirmed_at' => '1479932867',
            'unconfirmed_email' => NULL,
            'blocked_at' => NULL,
            'registration_ip' => '127.0.0.1',
            'created_at' => '1479929698',
            'updated_at' => '1480004238',
            'flags' => '0'
        ]);
        $this->insert('{{%user}}',[
            'id' => '3',
            'username' => 'user',
            'email' => 'testUser@test1010.ru',
            'password_hash' => '$2y$10$0gxS5MLHXWhLrtGOibsyaeeUBiaJlrEN7VG98ctzbxwB1SRm3MSfa',
            'auth_key' => 'OQ2FN-Rr-q17QKKG5W-Ru_TL-vx9kEpg',
            'confirmed_at' => '1479932867',
            'unconfirmed_email' => NULL,
            'blocked_at' => NULL,
            'registration_ip' => '127.0.0.1',
            'created_at' => '1479929698',
            'updated_at' => '1480004238',
            'flags' => '0'
        ]);

        $this->insert('{{%profile}}',[
            'user_id' => '1',
            'name' => NULL,
            'public_email' => NULL,
            'gravatar_email' => NULL,
            'gravatar_id' => NULL,
            'location' => NULL,
            'website' => NULL,
            'bio' => NULL,
            'timezone' => NULL
        ]);

        $this->insert('{{%profile}}',[
            'user_id' => '2',
            'name' => NULL,
            'public_email' => NULL,
            'gravatar_email' => NULL,
            'gravatar_id' => NULL,
            'location' => NULL,
            'website' => NULL,
            'bio' => NULL,
            'timezone' => NULL
        ]);

        $this->insert('{{%profile}}',[
            'user_id' => '3',
            'name' => NULL,
            'public_email' => NULL,
            'gravatar_email' => NULL,
            'gravatar_id' => NULL,
            'location' => NULL,
            'website' => NULL,
            'bio' => NULL,
            'timezone' => NULL
        ]);

    }

    public function safeDown()
    {
        $this->delete('{{%profile}}',['user_id'=>'1']);
        $this->delete('{{%profile}}',['user_id'=>'2']);
        $this->delete('{{%profile}}',['user_id'=>'3']);
        $this->delete('{{%user}}',['id'=>'1']);
        $this->delete('{{%user}}',['id'=>'2']);
        $this->delete('{{%user}}',['id'=>'3']);
    }
}