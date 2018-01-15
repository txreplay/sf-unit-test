<?php

namespace Tests\AppBundle\Util;

use AppBundle\Util\Product;
use AppBundle\Util\User;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    private $owner;

    public function testIsValidNominal()
    {
        $product = new Product('myProduct', $this->owner);

        $result = $product->isValid();
        $this->assertTrue($result);
    }

    public function setUp()
    {
        $this->owner = new User('toto@gmail.com', 'Doe', 'John', 20);
    }

    public function tearDown()
    {
        $this->owner = NULL;
    }
}