<?php

namespace App\Enum;

enum TransferHistoryStatus: string
{
    case NEW = 'new';
    case DONE = 'done';
    case PARSED = 'parsed';
    case PARSE_FAILED = 'parse_failed';
    case PROCESS_FAILED = 'process_failed';
    case SKIPPED = 'skipped';
    case RECALLED = 'recalled';
}
