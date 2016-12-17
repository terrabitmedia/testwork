<?php

namespace app\modules\events\components;

class MessageData implements InterfaceMessage
{

    private $title;
    private $text;
    private $from = NULL;
    private $to = NULL;
    private $user;
    private $user_id;
    private $notice_id;
    private $provider_id;
    private $status = 'error';

    public function __construct($config)
    {
        foreach ($config as $key=>$item) {
            if (property_exists($this,$key)) {
                $this->$key = $item;
            }
        }
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getProviderId()
    {
        return $this->provider_id;
    }

    public function getNoticeId()
    {
        return $this->notice_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setFrom($from)
    {
        $this->from = $from;
    }

    public function setTo($to)
    {
        $this->to = $to;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
}