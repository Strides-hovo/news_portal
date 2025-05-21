<?php

namespace App\Jobs;

use App\RabbitMq\RabbitMq;
use Exception;
use PhpAmqpLib\Message\AMQPMessage;

readonly class AuthCodeNotificationPublisher
{

    public function __construct(private RabbitMq $rabbitMq)
    {
    }

    /**
     * @throws Exception
     */
    public function handle(string $email, int $code): bool
    {
        $message = "Код подтверждения для {$email}: {$code}";
        $readyMessage = new AMQPMessage($message);

        $this->rabbitMq
            ->setExchange('notification')
            ->addQueue('notification_queue')
            ->setMessage($readyMessage)
            ->publish();

        return true;
    }
}
