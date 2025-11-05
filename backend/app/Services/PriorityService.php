<?php

namespace App\Services;

use App\Models\Priority;

class PriorityService
{
    public function list()
    {
        return Priority::get();
    }
}
