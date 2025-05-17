<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Repositories\AuthUserRepository;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\VerificationRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AuthUserController extends Controller
{

    public function __construct(private readonly AuthUserRepository $repository)
    {
    }

    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'status' => session('status'),
        ]);
    }


    /**
     * @throws Exception
     */
    public function store(LoginRequest $request)
    {
        $data = $request->validated();
        $user = $this->repository->login($data['email']);

        return redirect()->route('verification.create')->with([
            'status' => 'success',
            'userId' => $user->id,
        ]);
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function verification(): Response
    {
        return Inertia::render('Auth/ConfirmCode', [
            'status' => session()->get('status'),
            'userId' => session()->get('userId'),
        ]);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function verificationUser(VerificationRequest $request)
    {
        $data = $request->validated();
        $userId = $data['userId'];
        $code = $data['code'];

        if ($this->repository->verifiedCode($code, $userId)) {
            $user = User::findOrFail($userId);
            $user->update([
                'is_verified' => now(),
            ]);
            Auth::login($user);
            return redirect()->route('dashboard')->with('status', 'success');
        } else {
            return redirect()->back()->withErrors(['code' => 'Код неверный'])
                ->withInput()
                ->with(['status' => 'error', 'userId' => $userId]);

        }
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
