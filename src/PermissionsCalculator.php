<?php

namespace splaturn\permissions;

use ReflectionClass;

final class PermissionsCalculator{

    /**
     * calculate PermissionLayers.
     * 
     * given layers should be sorted by priority.
     * 
     * @template T of PermissionsLayer
     * @phpstan-param T $defaultLayer
     * @phpstan-param array<int, T> $layers
     * @phpstan-return T
     */
    public static function calculate(PermissionsLayer $defaultLayer, array $layers) : PermissionsLayer{
        PermissionsLayerValidator::declaration($defaultLayer);
        PermissionsLayerValidator::defaultLayer($defaultLayer);

        $reflection = new ReflectionClass($defaultLayer);
        $base = clone $defaultLayer;
        $props = $reflection->getProperties();

        foreach($props as $prop){
            foreach($layers as $layer){
                if($prop->isInitialized($layer)){
                    /** @var bool $value */
                    $value = $prop->getValue($layer);
                    if($value !== null){
                        $prop->setValue($base, $value);
                        continue 2;
                    }
                }
            }
        }

        return $base;
    }
}