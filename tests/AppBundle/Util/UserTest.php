<?php

namespace Tests\AppBundle\Util;

use AppBundle\Util\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsValidNominal()
    {
        $user = new User('toto@gmail.com', 'Doe', 'John', 20);
        $result = $user->isValid();
        $this->assertTrue($result);
    }

    public function testIsNotValidEmailFormat()
    {
        $user = new User('troll.com', 'Doe', 'John', 20);
        $result = $user->isValid();
        $this->assertFalse($result);
    }

    public function testIsNotValidTooYoung()
    {
        $user = new User('toto@gmail.com', 'Doe', 'John', 4);
        $result = $user->isValid();
        $this->assertFalse($result);
    }
}