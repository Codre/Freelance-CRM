<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Clients\Requests\StoreInviteUserRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Users\Exceptions\IncorrectUserException;
use App\Services\Users\Exceptions\UserNotFoundException;
use App\Services\Users\UsersService;
use \Illuminate\Http\Request;

/**
 * Class Invite
 *
 * @package App\Http\Controllers\Clients
 */
class Invite extends Controller
{
    /**
     * @var UsersService
     */
    private $usersService;

    /**
     * Invite constructor.
     *
     * @param UsersService $usersService
     */
    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * @param Request $request
     *
     * @return User|null
     */
    private function getInviteUser(Request $request): ?User
    {
        try {
            $user = $this->usersService->getInviteUser(
                (int)$request->get('id'),
                $request->get('key'),
                $request->get('hash')
            );
        } catch (IncorrectUserException | UserNotFoundException $e) {
            abort(401);
            return null;
        }

        return $user;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (\Auth::check()) {
            return redirect(route('overview'));
        }

        $user = $this->getInviteUser($request);

        return view('clients.invite', [
            'user' => $user,
            'title' => __('clients/invite.title'),
            'requestParams' => [
                'id' => (int)$request->get('id'),
                'key' => $request->get('key'),
                'hash' => $request->get('hash')
            ]
        ]);
    }

    /**
     * @param StoreInviteUserRequest $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreInviteUserRequest $request)
    {
        if (\Auth::check()) {
            return redirect(route('overview'));
        }

        $user = $this->getInviteUser($request);

        $this->usersService->updateUser($user, $request->getFormData());

        \Auth::login($user, true);

        return redirect(route('overview'));
    }

}
