<?php

namespace App\Console\Commands;

use App\Http\Services\ImportNewsService;
use App\Models\News;
use App\RabbitMq\RabbitMq;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use PhpAmqpLib\Message\AMQPMessage;

class ImportNewsCustomer extends Command
{
    protected $signature = 'app:import-news-listener';
    protected $description = 'Command description';

    /**
     * @throws Exception
     */
    public function handle()
    {
        $rabbit = new RabbitMq();
        $rabbit
            ->setExchange('news')
            ->addQueue('import-news')
            ->listen(function (AMQPMessage $msg){
                $url = $msg->getBody();
                $response = app(ImportNewsService::class)->handle($url);

                $articles = collect($response)->filter(fn($i) => $i['urlToImage'])->map(function ($article) {
                    return [
                        'source' => $article['source']['name'] ?? '',
                        'image' => $article['urlToImage'],
                        'preview' => Str::limit($article['description']),
                        'content' => $article['content'] ?? '',
                    ];
                })->toArray();
                $this->info('Importing news...');
                News::insert($articles);
            });
    }
}
