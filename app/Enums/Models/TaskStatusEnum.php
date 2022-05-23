<?php

namespace App\Enums\Models;

enum TaskStatusEnum: string
{
    case waiting    = 'waiting';
    case developing = 'developing';
    case testing    = 'testing';
    case reviewing  = 'reviewing';
    case completed  = 'completed';
}
