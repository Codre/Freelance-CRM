<?php

namespace App\Services\interfaces;


interface CacheServiceInterface
{
    /**
     * Очистить кэш
     */
    public function clear();

    /**
     * Создать кэш
     */
    public function warm();
}
