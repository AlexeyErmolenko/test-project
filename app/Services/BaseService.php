<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * Base class for services.
 */
abstract class BaseService
{
    /**
     * Execute a Closure within a transaction.
     *
     * @param Closure $callback Callback to wrap into transaction
     *
     * @return mixed
     *
     * @throws Throwable
     */
    protected function transaction(Closure $callback)
    {
        return DB::transaction($callback);
    }
}
