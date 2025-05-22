<?php
declare(strict_types=1);

namespace App\RabbitMq;

use Exception;
use InvalidArgumentException;
use PhpAmqpLib\Channel\AbstractChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPExceptionInterface;
use PhpAmqpLib\Message\AMQPMessage;
use Throwable;

class RabbitMq
{
    public AMQPStreamConnection $connection;
    public AbstractChannel $channel;
    private string $exchange = '';
    private array $queues = [];
    private ?AMQPMessage $message = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.username'),
            config('rabbitmq.password'),
            '/'
        );
        $this->channel = $this->connection->channel();
    }


    /**
     * @throws Exception
     */
    public function publish()
    {
        $this->assertReady(isPublish: true);
        $this->setup();

        foreach ($this->queues as $queue) {
            try {
                $this->channel->basic_publish($this->message, $this->exchange, $queue);
            } catch (AMQPExceptionInterface $e) {
                throw new Exception('Failed to publish message: ' . $e->getMessage());
            }
        }
    }


    /**
     * @throws Exception
     */
    public function listen(callable $callback)
    {
        $this->assertReady(isPublish: false);
        $this->setup();

        $this->channel->basic_qos(0, 1, null);
        foreach ($this->queues as $queue) {
            $this->channel->basic_consume($queue, '', false, false, false, false, function (AMQPMessage $msg) use ($callback){
                try {
                    $callback($msg);
                    $msg->ack(); // Подтверждаем успешную обработку
                } catch (Throwable  $e) {
                    echo "Ошибка обработки: " . $e->getMessage() . "\n";
                    $msg->nack(); // Отправляем сообщение обратно в очередь
                }
            });
        }

        while ($this->channel->is_consuming()) {
            $this->channel->wait(null, false, 30);
        }
    }


    private function assertReady(bool $isPublish): void
    {
        if (empty($this->queues)) {
            throw new InvalidArgumentException('At least one queue must be added');
        }

        if ($isPublish && !$this->message instanceof AMQPMessage) {
            throw new InvalidArgumentException('Message must be set before publishing');
        }
    }


    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function setExchange(string $exchange): self
    {
        $this->exchange = $exchange;
        return $this;
    }


    public function setMessage(AMQPMessage $message): self
    {
        $this->message = $message;
        return $this;
    }

    public function addQueue(string $queue): self
    {
        $this->queues[] = $queue;
        return $this;
    }

    /**
     * Настройка очереди и обменника
     */
    private function setup(): void
    {
        $this->channel->exchange_declare(
            $this->exchange,
            'direct',
            false,
            true,
            false
        );

        foreach ($this->queues as $queue) {
            $this->channel->queue_declare(
                $queue,
                false,
                true,
                false,
                false
            );
            $this->channel->queue_bind(
                $queue,
                $this->exchange,
                $queue
            );
        }
    }
}
