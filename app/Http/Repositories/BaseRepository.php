<?php
declare(strict_types=1);

namespace App\Http\Repositories;

use App\Events\UserConnectEvent;
use App\Jobs\AuthCodeNotificationPublisher;
use App\Models\User;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

abstract class BaseRepository
{

    public function __construct(protected AuthCodeNotificationPublisher $rabbitMqNotificationService)
    {}

    protected function generateCode(): int
    {
        return rand(1000, 9999);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function verifyTwoFactorCode(int $requestCode, User $user): bool
    {
        $userId = $user->id;
        $code = cache()->get('code_' . $userId);

        if ($requestCode == $code) {
            cache()->forget('code_' . $userId);
            cache()->forget('userId_' . $userId);
            $this->eventStrategy($user);

            return true;
        }
        return false;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function eventStrategy(User $user): void
    {
        $context = cache()->get("context_{$user->id}") ?? 'login';
        $message = $this->buildMessage($context, $user);

        event(new UserConnectEvent($message));
        cache()->forget('context_' . $user->id);
    }

    private function buildMessage(string $context, User $user): string
    {
        return match ($context) {
            'register' => "Регистрировался новый пользователь: {$user->name}",
            default    => "Авторизовался пользователь: {$user->name}",
        };
    }
}
