<?php

namespace splaturn\permissions;

/**
 * this is interface for permission layer
 * all properties must have bool type
 * @see PermissionLayerValidator
 */
interface PermissionsLayer{
    /** 
     * layer MUST NOT have any params in constructor.
     * objects implments this will be created dynamically in permission calculator.
     */
    public function __construct();
}