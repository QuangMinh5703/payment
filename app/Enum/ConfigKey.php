<?php
/*
 * Copyright (c) 2022-2024. Kinal Games, Inc. All Rights Reserved.
 */

declare(strict_types=1);

namespace App\Enum;

enum ConfigKey: string
{
    case VERSION = 'version';
    case DEFAULT_EXCHANGE_RATE = 'default_exchange_rate';
    case PAYMENT_SYNTAX = 'payment_syntax';
    case ORDER_PREFIX = 'order_prefix';
    case SECRET_KEY = 'secret_key';
    case CREDIT_NAME = 'credit_name';
}
