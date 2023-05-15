<?php

namespace App\Contracts\Resources;

use App\Http\Resources\ResourceList;

interface GeneratesFullLists
{
    public static function generateKeyValueList(): ResourceList;
}
