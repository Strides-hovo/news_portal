<?php

namespace App\Http\Controllers\Auth;

use App\Http\Repositories\RegisterUserRepository;
use App\Http\Requests\Auth\RegisterRequest;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{

    public function __construct(private readonly RegisterUserRepository $repository)
    {
    }


    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }


    /**
     * @throws Exception
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $this->repository->register($data);

        return redirect()->route('verification.create')->with([
            'status' => 'success',
            'userId' => $user->id,
        ]);
    }
}
