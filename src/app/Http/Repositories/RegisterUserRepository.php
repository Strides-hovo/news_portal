<?php
declare(strict_types=1);

namespace App\Http\Repositories;

use App\Models\User;
use Exception;

final  class RegisterUserRepository extends BaseRepository
{

    /**
     * @throws Exception
     */
    public function register(array $userData): User
    {
        $code = $this->generateCode();
        $user = $this->createUser($userData, $code);
        cache()->put('code_' . $user->id, $code, now()->addMinutes(10));
        cache()->put('userId_' . $user->id, $user->id, now()->addMinutes(10));
        cache()->put('context_' . $user->id, 'register', now()->addMinutes(10));

        $this->rabbitMqNotificationService->handle($user->email, $code);
        return $user;
    }

    public function createUser(array $userData, int $code): User
    {
        return User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'code' => $code,
        ]);
    }
}
