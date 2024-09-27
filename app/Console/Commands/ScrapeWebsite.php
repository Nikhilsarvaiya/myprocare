<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapeWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrape-website';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape website';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create a Guzzle HTTP client
        $client = new Client();

        // Fetch the blog website
        $response = $client->request('GET', 'https://www.myprocare.com');

        // Extract article titles and URLs
        $html = $response->getBody()->getContents();
        $crawler = new Crawler($html);
        $articles = $crawler->filter('.banner__full')->each(function ($node) {
            $title = $node->filter('.container h1')->text();
            // $url = $node->filter('.col-md-4 col-sm-4 col-xs-12 text-center a')->attr('href');
            return compact('title');
        });

        // Display the scraped data
        foreach ($articles as $article) {
            $this->info("Title: {$article['title']}");
            // $this->info("URL: {$article['url']}");
            $this->line('------------------');
        }
    }
}
