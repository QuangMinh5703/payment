<?php
/*
 * Copyright (c) 2022, Kinal.co, Inc. All Rights Reserved.
 * Internal use only.
 */

declare(strict_types=1);

namespace App\Exception;

use App\Exception\KinalException;
use Symfony\Component\HttpFoundation\Response;

class ValidationException extends KinalException
{
    /**
     * @inheritDoc
     */
    public function statusCode(): int
    {
        return Response::HTTP_UNPROCESSABLE_ENTITY;
    }
}
