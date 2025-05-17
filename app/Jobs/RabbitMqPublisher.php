<?php

namespace App\Jobs;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqPublisher
{
    /**
     * @throws Exception
     */
    public function handle(string $email, string $code): bool
    {
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.username'),
            config('rabbitmq.password')
        );

        $channel = $connection->channel();
        $channel->queue_declare('notification_queue', false, true);
        $channel->exchange_declare('notification', 'direct', false, true, false);
        $channel->queue_bind('notification_queue', 'notification', 'notification_queue');

        $message = "Код подтверждения для {$email}: {$code}";
        $readyMessage = new AMQPMessage($message);
        $channel->basic_publish($readyMessage, 'notification', 'notification_queue');

        $channel->close();
        $connection->close();

        return true;
    }
}
