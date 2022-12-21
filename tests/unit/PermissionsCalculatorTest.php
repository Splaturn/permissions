<?php

namespace splaturn\permissions;

use splaturn\permissions\PermissionsCalculator;
use PHPUnit\Framework\TestCase;

/**
 * Class PermissionsCalculatorTest.
 *
 * @covers \splaturn\permissions\PermissionsCalculator
 */
final class PermissionsCalculatorTest extends TestCase
{

    public function testCalculate1(): void{
        $layers = [SamplePermissionsLayer::allowRead()];
        $base = SamplePermissionsLayer::denyAll();

        $calculated = PermissionsCalculator::calculate($base, $layers);

        $this->assertInstanceOf(SamplePermissionsLayer::class, $calculated);

        /** @var SamplePermissionsLayer $calculated */
        $this->assertTrue($calculated->read);
        $this->assertFalse($calculated->write);
        $this->assertFalse($calculated->execute);
    }

    public function testCalculate2(): void{
        $layers = [SamplePermissionsLayer::allowWrite(), SamplePermissionsLayer::allowExecute()];
        $base = SamplePermissionsLayer::denyAll();

        $calculated = PermissionsCalculator::calculate($base, $layers);

        $this->assertInstanceOf(SamplePermissionsLayer::class, $calculated);

        /** @var SamplePermissionsLayer $calculated */
        $this->assertFalse($calculated->read);
        $this->assertTrue($calculated->write);
        $this->assertTrue($calculated->execute);
    }

    public function testCalculate3(): void{
        $layers = [SamplePermissionsLayer::denyWrite()];
        $base = SamplePermissionsLayer::allowAll();

        $calculated = PermissionsCalculator::calculate($base, $layers);

        $this->assertInstanceOf(SamplePermissionsLayer::class, $calculated);

        /** @var SamplePermissionsLayer $calculated */
        $this->assertTrue($calculated->read);
        $this->assertFalse($calculated->write);
        $this->assertTrue($calculated->execute);
    }

}

class SamplePermissionsLayer implements PermissionsLayer{

    public bool $read;

    public bool $write;

    public bool $execute;

    public function __construct(){}

    public static function allowRead() : self{
        $result = new self;
        $result->read = true;
        return $result;
    }

    public static function allowWrite() : self{
        $result = new self;
        $result->write = true;
        return $result;
    }

    public static function allowExecute() : self{
        $result = new self;
        $result->execute = true;
        return $result;
    }

    public static function allowAll() : self{
        $result = new self;
        $result->read = $result->write = $result->execute = true;
        return $result;
    }

    public static function denyRead() : self{
        $result = new self;
        $result->read = false;
        return $result;
    }

    public static function denyWrite() : self{
        $result = new self;
        $result->write = false;
        return $result;
    }

    public static function denyExecute() : self{
        $result = new self;
        $result->execute = false;
        return $result;
    }

    public static function denyAll() : self{
        $result = new self;
        $result->read = $result->write = $result->execute = false;
        return $result;
    }
}