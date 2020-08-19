<?php


namespace App\Services\Users;

use App\Models\Group;
use App\Models\User;
use App\Services\Users\Handlers\SendBalanceEmail;
use App\Services\Users\Handlers\SendResetPasswordEmail;
use App\Services\Users\Repositories\UsersRepositoryInterface;

/**
 * Class UsersEmailsService
 * Класс для отправки e-mail сообщений пользователям
 *
 * @package App\Services\Users
 */
class UsersEmailsService
{
    /**
     * @var SendBalanceEmail
     */
    private $sendBalanceEmail;
    /**
     * @var UsersRepositoryInterface
     */
    private $usersRepository;
    /**
     * @var SendResetPasswordEmail
     */
    private $sendResetPasswordEmail;

    /**
     * UsersEmailsService constructor.
     *
     * @param SendBalanceEmail         $sendBalanceEmail
     * @param UsersRepositoryInterface $usersRepository
     * @param SendResetPasswordEmail   $sendResetPasswordEmail
     */
    public function __construct(
        SendBalanceEmail $sendBalanceEmail,
        UsersRepositoryInterface $usersRepository,
        SendResetPasswordEmail $sendResetPasswordEmail
    ) {
        $this->sendBalanceEmail = $sendBalanceEmail;
        $this->usersRepository = $usersRepository;
        $this->sendResetPasswordEmail = $sendResetPasswordEmail;
    }

    /**
     * Отправить сообщение о текущем балансе клиенту
     *
     * @param int $userId
     *
     * @throws Exceptions\UserNotFoundException
     */
    public function balance(int $userId)
    {
        $this->sendBalanceEmail->handle($userId);
    }

    /**
     * Отправить сообщение о текущем балансе клиентам (только с долгом или всем)
     *
     * @param bool $ifDebt
     *
     * @throws Exceptions\UserNotFoundException
     */
    public function balanceAll(bool $ifDebt = true)
    {
        $users = $this->usersRepository->search(Group::CLIENTS, 0);

        if ($ifDebt) {
            $users = $users->where('balance', '<', 0);
        }

        /** @var User $item */
        foreach ($users->all() as $item) {
            $this->balance($item->id);
        }
    }

    /**
     * Отправить ссылку на восстановление пароля
     *
     * @param User   $user
     * @param string $token
     */
    public function resetPassword(User $user, string $token)
    {
        $this->sendResetPasswordEmail->handler($user, $token);
    }
}
