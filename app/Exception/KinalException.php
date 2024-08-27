<?php
/*
 * Copyright (c) 2022, Kinal.co, Inc. All Rights Reserved.
 * Internal use only.
 */

declare(strict_types=1);

namespace App\Exception;

use Throwable;
use RuntimeException;
use Illuminate\Contracts\Support\MessageBag;

abstract class KinalException extends RuntimeException
{
    use Renderable;

    /**
     * @param array|MessageBag $errors
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(array|MessageBag $errors = [], string $message = '', int $code = 0, Throwable $previous = null)
    {
        $this->setErrors($errors);
        parent::__construct($message, $code, $previous);
    }
}
