<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Department\DepartmentRepositoryInterface;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\Name;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\UseCases\Department\DepartmentFindAction;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(DepartmentFindAction $departmentFindAction): Response
    {
        $departmentsEntities = $departmentFindAction->findAll();
        $departments         = array_map(function ($department) {
            return $department->toArray();
        }, $departmentsEntities);

        return Inertia::render('Auth/Register', [
            'departments' => $departments,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'department_id' => 'nullable|integer|exists:' . DepartmentRepositoryInterface::TABLE_NAME . ',id',
            'name'          => 'required|string|max:' . Name::MAX_LEN,
            'email'         => 'required|string|lowercase|email|max:' . Email::MAX_LEN . '|unique:' . User::class,
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        /** @var string */
        $password = $request->password;

        $user = User::create([
            'department_id' => $request->department_id,
            'name'          => $request->name,
            'email'         => $request->email,
            'password'      => Hash::make($password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
