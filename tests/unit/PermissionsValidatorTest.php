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

    public function testDeclarationPassed1(): void{
        PermissionsLayerValidator::declaration(new GoodPermissionsLayer1);
        $this->assertTrue(true);
    }

    public function testDeclarationFailed1(): void{
        $this->expectException(InvalidArgumentException::class);
        PermissionsLayerValidator::declaration(new BadPermissionsLayer1);
    }

    public function testDeclarationFailed2(): void{
        $this->expectException(InvalidArgumentException::class);
        PermissionsLayerValidator::declaration(new BadPermissionsLayer2);
    }

    public function testDeclarationFailed3(): void{
        $this->expectException(InvalidArgumentException::class);
        PermissionsLayerValidator::declaration(new BadPermissionsLayer3);
    }

    public function testDeclarationFailed4(): void{
        $this->expectException(InvalidArgumentException::class);
        PermissionsLayerValidator::declaration(new BadPermissionsLayer4);
    }

    public function testDefaultLayerPassed1() : void{
        $layer = new GoodPermissionsLayer1;
        $layer->sayHello = $layer->sayGoodBye = $layer->makeFriends = true;
        $layer->joinGames = $layer->dig = $layer->mine = false;
        PermissionsLayerValidator::defaultLayer($layer);
        $this->assertTrue(true);
    }

    public function testDefaultLayerFailed1() : void{
        $layer = new GoodPermissionsLayer1;
        $layer->sayHello = $layer->sayGoodBye = $layer->makeFriends = true;
        $this->expectException(InvalidArgumentException::class);
        PermissionsLayerValidator::defaultLayer($layer);
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