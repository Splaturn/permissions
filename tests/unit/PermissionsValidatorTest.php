<?php

namespace splaturn\permissions;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * Class PermissionsCalculatorTest.
 *
 * @covers \splaturn\permissions\PermissionsCalculator
 */
final class PermissionsValidatorTest extends TestCase
{

    public function testValidatePassed1(): void{
        PermissionsLayerValidator::validate(new GoodPermissionsLayer1);
        $this->assertTrue(true);
    }

    public function testValidateFailed1(): void{
        $this->expectException(InvalidArgumentException::class);
        PermissionsLayerValidator::validate(new BadPermissionsLayer1);
    }

    public function testValidateFailed2(): void{
        $this->expectException(InvalidArgumentException::class);
        PermissionsLayerValidator::validate(new BadPermissionsLayer2);
    }

    public function testValidateFailed3(): void{
        $this->expectException(InvalidArgumentException::class);
        PermissionsLayerValidator::validate(new BadPermissionsLayer3);
    }

    public function testValidateFailed4(): void{
        $this->expectException(InvalidArgumentException::class);
        PermissionsLayerValidator::validate(new BadPermissionsLayer4);
    }
    
}

class GoodPermissionsLayer1 implements PermissionsLayer{
    public function __construct(){}

    public bool $sayHello;

    public bool $sayGoodBye;

    public bool $makeFriends;

    public bool $joinGames;

    public bool $dig;

    public bool $mine;
}

class BadPermissionsLayer1 implements PermissionsLayer{
    public function __construct(){}

    // should not be nullable
    public ?bool $sayHello;
}

class BadPermissionsLayer2 implements PermissionsLayer{
    public function __construct(){}

    // should not be types other than bool
    public string $sayHello;
}

class BadPermissionsLayer3 implements PermissionsLayer{
    public function __construct(){}

    // should not have default value
    public bool $sayHello = false;
}


class BadPermissionsLayer4 implements PermissionsLayer{
    public function __construct(){}

    // should not be union.
    public bool|string $sayHello;
}

