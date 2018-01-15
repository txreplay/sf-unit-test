<?php

namespace AppBundle\Util;


class Exchange
{
    private $receiver;
    private $product;
    private $begin;
    private $end;
    private $databaseConnection;
    private $emailSender;

    function __construct(User $receiver, Product $product, $begin, $end, DBConnection $dbConn, EmailSender $emailSender)
    {
        $this->receiver = $receiver;
        $this->product = $product;
        $this->begin = $begin;
        $this->end = $end;
        $this->databaseConnection = $dbConn;
        $this->emailSender = $emailSender;
    }
    public function save()
    {
        if (! $this->receiver->isValid())
        {
            return new \Exception('Exchange creation failed because the receiver is not active');
        } elseif (! $this->product->isValid())
        {
            return new \Exception('Exchange creation failed because the product is not active');
        }
        $now = new \DateTime();
        if ($this->begin < $now)
        {
            return new \Exception('Exchange creation failed because begin date must not be in the past');
        } elseif ($this->begin > $this->end) {
            return new \Exception('Exchange creation failed because begin date must be before end date');
        }

        $userIsTooYoung = $this->databaseConnection->saveExchange($this);

        if ($userIsTooYoung)
        {
            $this->emailSender->sendEmail($this->product->getOwner(), "You have a new exchange !!");
        }
        return true;
    }
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
    }
    public function setProduct($product)
    {
        $this->product = $product;
    }
    public function setBegin($begin)
    {
        $this->begin = $begin;
    }
    public function setEnd($end)
    {
        $this->end = $end;
    }
    public function setDatabaseConnection($dbConn)
    {
        $this->databaseConnection = $dbConn;
    }
    public function setEmailSender($emailSender)
    {
        $this->emailSender = $emailSender;
    }
    public function getReceiver()
    {
        return $this->receiver;
    }
    public function getProduct()
    {
        return $this->product;
    }
    public function getBegin()
    {
        return $this->begin;
    }
    public function getEnd()
    {
        return $this->end;
    }
    public function getDatabaseConnection()
    {
        return $this->databaseConnection;
    }
    public function getEmailSender()
    {
        return $this->emailSender;
    }
}