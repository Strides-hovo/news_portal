<?php

namespace App\Console\Commands;

use App\Http\Services\TelegramService;
use App\RabbitMq\RabbitMq;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Message\AMQPMessage;

class AuthCodeNotificationCustomer extends Command
{
    protected $signature = 'app:auth-code-notification';
    protected $description = 'Command description';


    /**
     * @throws Exception
     */
    public function handle()
    {
        $rabbit = new RabbitMq();
        $callback = function (AMQPMessage $msg): void {
            $message = $msg->getBody();
            app(TelegramService::class)->sendNotification($message);
        };
        $rabbit
            ->setExchange('notification')
            ->addQueue('notification_queue')
            ->listen($callback);
    }
}
