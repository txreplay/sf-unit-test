<?php

namespace AppBundle\Util;

use PHPUnit\Framework\Exception;

class EmailSender
{
    function __construct()
    {
        //
    }
    public function sendEmail($emailReceiver, $messageContent)
    {
        throw new Exception('Not implemented');
    }
}