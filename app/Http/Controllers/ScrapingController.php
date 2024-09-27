<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

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
}
