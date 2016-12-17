<?php

namespace app\modules\events\components;


interface InterfaceMessage
{
    public function getTitle();
    public function getText();
    public function getFrom();
    public function getTo();
    public function getStatus();
    public function setFrom($from);
    public function setTo($to);
    public function setStatus($status);
    public function getProviderId();
    public function getNoticeId();
    public function getUserId();
    public function getUser();
}