<?php

namespace App\Jobs;

use App\Http\Services\TelegramService;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqConsumer
{
    /**
     * @throws Exception
     */
    public function listen(): void
    {
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.username'),
            config('rabbitmq.password')
        );

        $channel = $connection->channel();
        $channel->queue_declare('notification_queue', false, true);


        $callback = function (AMQPMessage $msg): void {
            $message = $msg->getBody();
            app(TelegramService::class)->sendNotification($message);
        };

        $channel->basic_consume('notification_queue', '', false, true, false, false, $callback);

        while ($channel->is_consuming()) {
            $channel->wait();
        }
    }
}

