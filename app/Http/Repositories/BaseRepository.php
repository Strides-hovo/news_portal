<?php
declare(strict_types=1);

namespace App\Http\Repositories;

use App\Jobs\AuthCodeNotificationPublisher;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class BaseRepository
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
    public function verifiedCode(int $requestCode, int $userId): bool
    {
        $code = cache()->get('code_' . $userId);

        if ($requestCode == $code) {
            cache()->forget('code_' . $userId);
            cache()->forget('userId_' . $userId);
            return true;
        }
        return false;
    }
}
