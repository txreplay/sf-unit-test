<?php

namespace Tests\AppBundle\Util;

use AppBundle\Util\DBConnection;
use AppBundle\Util\EmailSender;
use AppBundle\Util\Exchange;
use AppBundle\Util\Product;
use AppBundle\Util\User;

use PHPUnit\Framework\TestCase;

class ExchangeTest extends TestCase
{
    private $exchange;

    /**
     * @covers Exchange::save
     */
    public function testExchangeCreationNominal()
    {
        $result = $this->exchange->save();
        $this->assertTrue($result);
    }

    /**
     * @covers Exchange::save
     * @expected\Exception \Exception
     * @expected\ExceptionMessage Exchange creation failed because begin date must not be in the past
     */
    public function testExchangeCreationFailedBeginInThePast()
    {

        $begin = new \DateTime();
        $begin->modify('-1 day');
        $end = new \DateTime();
        $end->modify('+1 day');

        $this->exchange->setBegin($begin);
        $this->exchange->setEnd($end);

        $this->exchange->save();
    }

    /**
     * @covers Exchange::save
     * @expected\Exception \Exception
     * @expected\ExceptionMessage Exchange creation failed because begin date must be before end date
     */
    public function testExchangeCreationFailedEndBeforeBegin()
    {

        $begin = new \DateTime();
        $begin->modify('+2 day');
        $end = new \DateTime();
        $end->modify('+1 day');

        $this->exchange->setBegin($begin);
        $this->exchange->setEnd($end);

        $this->exchange->save();
    }

    /**
     * @covers Exchange::save
     * @expected\Exception \Exception
     * @expected\ExceptionMessage Exchange creation failed because the receiver is not active
     */
    public function testExchangeCreationFailedUserIsNotValid()
    {
        $mockedUserNotValid = $this->createMock(User::class);
        $mockedUserNotValid->expects($this->any())->method('isValid')->willReturn(false);
        $this->exchange->setReceiver($mockedUserNotValid);

        $this->exchange->save();
    }

    /**
     * @covers Exchange::save
     */
    public function testExchangeCreationWithYoungUser()
    {
        $mockedDatabase = $this->createMock(DBConnection::class);
        $mockedDatabase->expects($this->any())->method('saveExchange')->willReturn(true);
        $this->exchange->setDatabaseConnection($mockedDatabase);

        $mockedEmailSender = $this->createMock(EmailSender::class);
        $mockedEmailSender->expects($this->once())->method('sendEmail');
        $this->exchange->setEmailSender($mockedEmailSender);

        $result = $this->exchange->save();
        $this->assertFalse($result);
    }

    protected function setUp()
    {
        $begin = new \DateTime();
        $begin->modify('+1 day');
        $end = new \DateTime();
        $end->modify('+2 day');

        // Mock User
        $mockedUser = $this->createMock(User::class);
        $mockedUser->expects($this->any())->method('isValid')->willReturn(true);

        // Mock Product
        $mockedProduct = $this->createMock(Product::class);
        $mockedProduct->expects($this->any())->method('isValid')->willReturn(true);
        $mockedProduct->expects($this->any())->method('getOwner')->willReturn($mockedUser);

        // Mock Database connection
        $mockedDBConn = $this->createMock(DBConnection::class);
        $mockedDBConn->expects($this->any())->method('saveExchange')->willReturn(false);

        // Mock Email sender
        $mockedEmailSender = $this->createMock(EmailSender::class);
        $mockedEmailSender->expects($this->never())->method('sendEmail');

        $this->exchange = new Exchange($mockedUser,$mockedProduct, $begin, $end, $mockedDBConn, $mockedEmailSender);
    }

    protected function tearDown()
    {
        $this->exchange = NULL;
    }
}