<?php

namespace App\Enums;

enum PostStatus: string
{
    case PUBLISHED = 'published';
    case SCHEDULED = 'scheduled';
    case DRAFT = 'draft';
}
