<?php

class m161125_235559_create_data_into_structure extends \yii\db\Migration
{
    public function safeUp()
    {

        $this->insert('{{%event_providers}}',[
            'provider_id' => 1,
            'name' => 'Отправить сообщение через почту',
            'class' => 'app\modules\events\components\providers\Mailer',
            'data' => \yii\helpers\Json::encode([
                'container' => [
                    'class' => 'yii\swiftmailer\Mailer',
                    'useFileTransport' => true,
                    'transport' => [
                        'class' => 'Swift_SmtpTransport',
                        'host' => 'localhost',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                        'username' => 'admin@rgk.terabit-media.com',
                        'password' => '123456',
                        'port' => '587', // Port 25 is a very common port too
                        'encryption' => 'tls', // It is often used, check your provider or mail server specs
                    ]
                ]
            ])
        ]);

        $this->insert('{{%event_providers}}',[
            'provider_id' => 2,
            'name' => 'Открыть диалоговое окно на экране',
            'class' => 'app\modules\events\components\providers\Dialog',
            'data' => \yii\helpers\Json::encode([
                'config' => [
                    'dialog' => [
                        'id'=>'dialog-id',
                        'clientOptions' => [
                            'modal' => true,
                            'title'=>'Оповещение на сайте',
                            'autoOpen'=>true,
                            'height'=>'auto',
                            'min-height'=>350,
                            'width'=>600,
                        ]
                    ],
                ]
            ])
        ]);

        $this->insert('{{%provider_has_user}}',[
            'provider_id' => 1,
            'user_id' => 1
        ]);

        $this->insert('{{%provider_has_user}}',[
            'provider_id' => 2,
            'user_id' => 1
        ]);

        $this->insert('{{%provider_has_user}}',[
            'provider_id' => 1,
            'user_id' => 2
        ]);

        $this->insert('{{%provider_has_user}}',[
            'provider_id' => 2,
            'user_id' => 2
        ]);

        $this->insert('{{%provider_has_user}}',[
            'provider_id' => 1,
            'user_id' => 3
        ]);

        $this->insert('{{%provider_has_user}}',[
            'provider_id' => 2,
            'user_id' => 3
        ]);

        // Оповещать о новых новостях всех зарегистрированных пользователей кроме админов и модеров

        $this->insert('{{%event_notices}}',[
            'notice_id' => 1,
            'name' => 'Обработчик сообщений для новых новостей',
            'class' => 'app\modules\events\components\notices\AdvancedHandler',
            'title_template'=> 'На сайте {{site}} была создана новая новость. Url: {{url_news_item}}',
            'template' => 'На сайте {{site}} была создана новая новость. <br> Короткий текст новости: <br> {{news.short_text}} <br> {{url_news_item}}',
            'data' => \yii\helpers\Json::encode([
                'url' => '/news/news/view',
                'parametersUrl' => ['id'],
                'useCreateUrl' => true,
                'maskUrl' => '{{url_news_item}}',
                'replaceFields' => [
                    '{{site}}' => 'RogaIKopita.RU'
                ]
            ])
        ]);

        $this->insert('{{%events}}',[
            'event_id' => 1,
            'notice_id' => 1,
            'name' => 'afterInsert',
            'class' => 'app\modules\news\models\News',
            'description' => 'Оповещать пользователей о новых новостях'
        ]);

        $this->insert('{{%event_rules}}',[
            'rule_id' => 1,
            'event_id' => 1,
            'name' => 'Пустое правило для новых новостей',
            'class' => 'app\modules\events\components\rules\FakeRule',
            'data' => \yii\helpers\Json::encode([])
        ]);

        $this->insert('{{%event_assignment}}',[
            'id' => 1,
            'event_id' => 1,
            'provider_id' => 1,
            'attach' => 'user'
        ]);

        $this->insert('{{%event_assignment}}',[
            'id' => 2,
            'event_id' => 1,
            'provider_id' => 2,
            'attach' => 'user'
        ]);

        // Создать событие для изменения пароля

        $this->insert('{{%event_notices}}',[
            'notice_id' => 2,
            'name' => 'Обработчик сообщений для изменения пароля',
            'class' => 'app\modules\events\components\notices\StandardHandler',
            'title_template' => 'На сайте {{site}} под вашей учетной записью {{user.username}} был изменен пароль.',
            'template' => 'На сайте {{site}} под вашей учетной записью {{user.username}} был изменен пароль. <br> Если вы получили это письмо то это потому что ваша электронная почта {{user.email}} была указана в качестве почтового ящика для связи.'  ,
            'data' => \yii\helpers\Json::encode([
                'replaceFields' => [
                    '{{site}}' => 'RogaIKopita.RU'
                ]
            ])
        ]);

        $this->insert('{{%events}}',[
            'event_id' => 2,
            'notice_id' => 2,
            'name' => 'afterUpdate',
            'class' => 'app\modules\users\models\User',
            'description' => 'Оповещать пользователей о изменение пароля'
        ]);

        $this->insert('{{%event_rules}}',[
            'rule_id' => 2,
            'event_id' => 2,
            'name' => 'Правело проверки изменения пароля',
            'class' => 'app\modules\events\components\rules\FilledFieldRule',
            'data' => \yii\helpers\Json::encode(['fields'=>['password']])
        ]);

        $this->insert('{{%event_assignment}}',[
            'id' => 3,
            'event_id' => 2,
            'provider_id' => 1,
            'attach' => 'self'
        ]);

    }

    public function safeDown()
    {
        $this->delete('{{%event_rules}}',['rule_id'=>1]);
        $this->delete('{{%event_assignment}}',['id'=>1]);
        $this->delete('{{%event_assignment}}',['id'=>2]);
        $this->delete('{{%events}}',['event_id'=>1]);
        $this->delete('{{%event_notices}}',['notice_id'=>1]);

        $this->delete('{{%event_rules}}',['rule_id'=>2]);
        $this->delete('{{%event_assignment}}',['id'=>3]);
        $this->delete('{{%events}}',['event_id'=>2]);
        $this->delete('{{%event_notices}}',['notice_id'=>2]);

        $this->delete('{{%provider_has_user}}',['user_id'=>1]);
        $this->delete('{{%provider_has_user}}',['user_id'=>2]);
        $this->delete('{{%provider_has_user}}',['user_id'=>3]);

        $this->delete('{{%event_providers}}',['provider_id'=>1]);
        $this->delete('{{%event_providers}}',['provider_id'=>2]);
    }
}