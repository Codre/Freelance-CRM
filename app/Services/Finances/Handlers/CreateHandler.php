<?php

namespace App\Services\Finances\Handlers;

use App\Models\Finance;
use App\Models\User;
use App\Services\Finances\Repositories\FinancesRepositoryInterface;

/**
 * Class CreateHandler
 *
 * @package App\Services\Finances\Handlers
 */
class CreateHandler
{
    /**
     * @var FinancesRepositoryInterface
     */
    private $repository;

    /**
     * CreateHandler constructor.
     *
     * @param FinancesRepositoryInterface $repository
     */
    public function __construct(FinancesRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param array $data
     *
     * @return Finance
     */
    public function handler(array $data): Finance
    {
        $user = User::find($data['user_id']);
        $newBalance = $data['operation'] ? $user->balance + $data['sum'] : $user->balance - $data['sum'];

        $user->update(['balance' => $newBalance]);

        return $this->repository->createFromArray($data);
    }
}
