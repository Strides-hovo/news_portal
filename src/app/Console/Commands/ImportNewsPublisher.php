<?php

namespace App\Console\Commands;

use App\RabbitMq\RabbitMq;
use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Message\AMQPMessage;

class ImportNewsPublisher extends Command
{
    protected $signature = 'app:import-news';
    protected $description = 'Import news from api';


    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $apiKey = env('NEWS_API_KEY');
        $url = "https://newsapi.org/v2/top-headlines?country=us&category=business&apiKey=$apiKey";

        $rabbit = new RabbitMq();
        $rabbit
            ->setExchange('news')
            ->addQueue('import-news')
            ->setMessage(new AMQPMessage($url))
            ->publish();
    }
}
