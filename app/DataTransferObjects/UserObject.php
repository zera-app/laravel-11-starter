<?php

namespace App\DataTransferObjects;

use App\DataTransferObjects\Base\BaseObject;
use App\Interfaces\DataTransferObjects\UserObjectInterface;

class UserObject extends BaseObject implements UserObjectInterface
{
    /**
     * Instantiate a new UserObject instance.
     */
    public function __construct()
    {
        //
    }

    /**
     *  Access the UserObject as an array.
     */
    public function toArray(): array
    {
        return [];
    }
}