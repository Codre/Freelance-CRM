<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Users\Exceptions\IncorrectUserException;
use App\Services\Users\Exceptions\UserNotFoundException;
use App\Services\Users\UsersService;
use Illuminate\Http\Request;

/**
 * Class Info
 *
 * @package App\Http\Controllers
 */
class Info
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
     * @return array
     */
    private function getRequestParams(Request $request): array
    {
        if (\Auth::check()) {
            return [];
        } else {
            return [
                'id' => (int)$request->get('id'),
                'key' => $request->get('key'),
                'hash' => $request->get('hash')
            ];
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function offer(Request $request)
    {
        if (!\Auth::check()) {
            $this->getInviteUser($request);
        }

        return view('info.offer', [
            'title' => __('info.offer.title'),
            'requestParams' => $this->getRequestParams($request)
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rules(Request $request)
    {
        if (!\Auth::check()) {
            $this->getInviteUser($request);
        }

        return view('info.rules', [
            'title' => __('info.rules.title'),
            'requestParams' => $this->getRequestParams($request)
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function privacy()
    {
        return view('info.privacy', [
            'title' => __('info.privacy.title')
        ]);
    }
}
