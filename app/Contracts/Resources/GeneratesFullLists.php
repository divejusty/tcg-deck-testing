<?php

namespace App\Contracts\Resources;

use Illuminate\Http\Request;

interface GeneratesFullLists
{
    public static function generateKeyValue(Request $request): array;
}
