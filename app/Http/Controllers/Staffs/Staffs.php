<?php

namespace App\Http\Controllers\Staffs;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Group;
use App\Services\Users\UsersService;

class Staffs extends Controller
{

    /**
     * @var UsersService
     */
    private $usersService;

    public function __construct(UsersService $usersService)
    {
        $this->usersService = $usersService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $this->authorize('staff.viewAny');

        $list = $this->usersService->searchUsers(Group::STAFFS);
        $list->load('group');

        return view('staffs.index')->with([
            'list' => $list,
            'title' => __("staffs/general.title")
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $this->authorize('staff.create');

        $groups = Group::whereIn('id', Group::STAFFS)->get();
        $groups = array_column($groups->toArray(), 'name', 'id');

        return view('staffs.create')->with([
            'title' => __("staffs/create.title"),
            'back' => route('staffs.index'),
            'groups' => $groups,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('staff.create');

        $this->usersService->storeUser($request->getFormData());

        return redirect(route('staffs.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $staff = $this->usersService->findUser($id);

        if (!$staff) {
            abort(404);
        }

        $this->authorize('staff.view', [$staff]);

        return view('staffs.show')->with([
            'staff' => $staff,
            'title' => $staff->name
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(int $id)
    {
        $staff = $this->usersService->findUser($id);

        if (!$staff) {
            abort(404);
        }

        $this->authorize('staff.update', [$staff]);

        $groups = Group::whereIn('id', Group::STAFFS)->get();
        $groups = array_column($groups->toArray(), 'name', 'id');

        return view('staffs.edit')->with([
            'staff' => $staff,
            'title' => __("staffs/edit.title"),
            'back' => $staff->id == \Auth::id() ? route('staffs.show', $staff) : route('staffs.index'),
            'groups' => $groups
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param int               $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $staff = $this->usersService->findUser($id);

        if (!$staff) {
            abort(404);
        }

        $this->authorize('staff.update', [$staff]);

        $this->usersService->updateUser($staff, $request->getFormData());

        return redirect(route('staffs.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        $staff = $this->usersService->findUser($id);

        if (!$staff) {
            abort(404);
        }

        $this->authorize('staff.delete', [$staff]);

        $this->usersService->deleteUser($staff);

        return redirect(route('staffs.index'));
    }
}
