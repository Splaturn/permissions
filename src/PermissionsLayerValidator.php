<?php

namespace splaturn\permissions;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;

/**
 * use of this class is optional
 * you may use this in start up to prevent unexpected crash when running.
 */
final class PermissionsLayerValidator{

    public static function validate(PermissionsLayer $layer) : void{
        $reflection = new ReflectionClass($layer);

        $props = $reflection->getProperties();

        foreach($props as $prop){
            if(!self::satisfyPropertyCondition($prop)){
                $name = $reflection->getName();
                throw new InvalidArgumentException("property of $name {$prop->getName()} type must be ?bool but actually $prop.");
            }
        }
    }

    private static function satisfyPropertyCondition(ReflectionProperty $prop) : bool{
        $type = $prop->getType();
        return (!$prop->hasDefaultValue()) && ($type instanceof ReflectionNamedType && !$type->allowsNull() && $type->getName() === 'bool');
    }
}