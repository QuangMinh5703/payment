<?php

namespace App\Enum;

enum PaymentMethodStatus :string
{
    case ACTIVE = 'active';
    case CLOSED = 'closed';
    case UNDER_MAINTENANCE = 'under_maintenance';
}
