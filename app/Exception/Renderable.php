<?php
/*
 * Copyright (c) 2022, Kinal.co, Inc. All Rights Reserved.
 * Internal use only.
 */

declare(strict_types=1);

namespace App\Exception;

use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

trait Renderable
{
    /**
     * @var string
     */
    protected string $errorCode;

    /**
     * @var MessageBag
     */
    protected MessageBag $errors;

    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function render(Request $request): Response
    {
        $className = get_class($this);
        $className = Str::snake(class_basename($className));

        $payload = [
            'errorCode' => $this->errorCode ?? Str::before($className, '_exception'),
            'statusCode' => $this->statusCode(),
        ];
        if (!empty($message = $this->getMessage())) {
            $payload['message'] = $message;
        } else {
            if ($this->errors->isNotEmpty() && $this->statusCode() != \Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY) {
                $payload['message'] = $this->errors->first();
            }
            if ($this->errors->has('gReCaptchaToken') && $this->errors->count() === 1) {
                $payload['message'] = $this->errors->first();
            }
        }
        if (!empty($this->errors))
            $payload['errors'] = $this->errors;

        return response($payload, $this->statusCode());
    }

    /**
     * @param string $errorCode
     */
    public function setErrorCode(string $errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @param array|MessageBag $errors
     */
    public function setErrors(array|MessageBag $errors): void
    {
        if (is_array($errors)) {
            $errors = new \Illuminate\Support\MessageBag($errors);
        }
        $this->errors = $errors;
    }

    /**
     * Response status code
     *
     * @return int
     */
    public abstract function statusCode(): int;
}
