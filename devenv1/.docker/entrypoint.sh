#!/bin/sh
#
# Copyright (c) 2022, Kinal.co, Inc. All Rights Reserved.
# Internal use only.
#

set -e

composer install
php artisan optimize

exec "$@"
