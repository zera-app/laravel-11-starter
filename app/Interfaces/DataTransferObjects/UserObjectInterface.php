<?php

namespace App\Interfaces\DataTransferObjects;
use App\Interfaces\Base\BaseObjectInterface;

interface UserObjectInterface extends BaseObjectInterface
{
    /**
     *  Access the UserObjectInterface as an array.
     */
    public function toArray(): array;
}