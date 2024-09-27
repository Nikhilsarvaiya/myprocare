<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class ScrapingController extends Controller
{
    public function scrapeQuotes(): JsonResponse
    {

        // scraping logic...

        // return response()->json('Hello, World!');

        // initialize a browser-like HTTP client
        $browser = new HttpBrowser(HttpClient::create());

        // download and parse the HTML of the target page
        $crawler = $browser->request('GET', 'https://www.myprocare.com/');

        // get the page outer HTML and return it
        $html = $crawler->outerHtml();

        return response()->json($html);

    }

    public function scrapeData()
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

            // dd($title);
            return compact('title');
        });

        // Display the scraped data
        dd($articles);

    }

}
