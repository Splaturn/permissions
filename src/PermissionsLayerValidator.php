<?php

namespace splaturn\permissions;

use InvalidArgumentException;
use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;

/**
 * use of this class is optional
 * recommend: use this in test to prevent unexpected crash when running.
 */
final class PermissionsLayerValidator{

    /**
     * check whether all properties' declaration satisfy a specification.
     */
    public static function declaration(PermissionsLayer $layer) : void{
        $reflection = new ReflectionClass($layer);

        $props = $reflection->getProperties();

        foreach($props as $prop){
            if(!self::satisfyPropertyCondition($prop)){
                $name = $reflection->getName();
                throw new InvalidArgumentException("property of $name {$prop->getName()} type must be ?bool but actually $prop.");
            }
        }
    }

    /**
     * check whether all properties are initialized.
     */
    public static function defaultLayer(PermissionsLayer $layer) : void{
        $reflection = new ReflectionClass($layer);

        $props = $reflection->getProperties();
        foreach($props as $prop){
            if(!$prop->isInitialized()){
                $name = $reflection->getName();
                throw new InvalidArgumentException("property of $name {$prop->getName()} must be initialized.");
            }
        }
    }

    private static function satisfyPropertyCondition(ReflectionProperty $prop) : bool{
        $type = $prop->getType();
        return (!$prop->hasDefaultValue()) && ($type instanceof ReflectionNamedType && !$type->allowsNull() && $type->getName() === 'bool');
    }
}