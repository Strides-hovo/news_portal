<?php
declare(strict_types=1);

namespace App\Http\Repositories;

use App\Models\User;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class AuthUserRepository extends BaseRepository
{
    /**
     * @throws Exception
     */
    public function login(string $email): User
    {
        $code = $this->generateCode();
        $user = $this->getUser($email);
        cache()->put('code_' . $user->id, $code, now()->addMinutes(10));
        cache()->put('userId_' . $user->id, $user->id, now()->addMinutes(10));
        cache()->put('context_' . $user->id, 'login', now()->addMinutes(10));

        $this->rabbitMqNotificationService->handle($email, $code);
        return $user;
    }


    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function verification(int $requestCode, int $userId): ?User
    {
        $user = User::findOrFail($userId);
        if ($this->verifyTwoFactorCode($requestCode, $user)) {
            $user->update([
                'is_verified' => now(),
            ]);
        }
        return $user;
    }

    private function getUser(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }
}
