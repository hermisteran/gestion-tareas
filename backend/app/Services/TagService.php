<?php

namespace App\Services;

use App\Models\Tag;

class TagService
{
    public function list()
    {
        return Tag::get();
    }
}
