<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;

use Illuminate\Support\Facades\Http;

use Log;
use Exception;

use Illuminate\Support\Facades\Storage;

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
        $response = $client->request('GET', 'https://schools.procareconnect.com/login');


        // Extract article titles and URLs
        $html = $response->getBody()->getContents();

        $crawler = new Crawler($html);
        $articles = $crawler->filter('.auth__header')->each(function ($node) {
            $title = $node->filter('.auth__header-primary div')->text();

            // dd($title);
            return compact('title');
        });

        // Display the scraped data
        dd($articles);

    }

    public function scrapeLogin()
    {
        // URL of the login page
        $loginUrl = 'https://schools.procareconnect.com/login';

        // Perform the login request
        $response = Http::asForm()->post($loginUrl, [
            'username' => 'pgoswami@varemar.com',
            'password' => 'V@remar123##',
            // You may need to include any hidden fields or CSRF tokens as well
            // '_token' => 'csrf_token_value',
        ]);

        // Check if login was successful by checking the status code or response content
        if ($response->successful()) {

            // Create a Guzzle HTTP client
            $client = new Client();
            // Fetch the blog website
            $response = $client->request('GET', 'https://schools.procareconnect.com/reports');
            // Extract article titles and URLs
            $html = $response->getBody()->getContents();

            dd($response);
            // Handle cookies for further authenticated requests
            $cookies = $response->cookies();


            // Now make an authenticated request to a protected page
            $protectedPageUrl = 'https://schools.procareconnect.com/reports';
            $protectedResponse = Http::withCookies($cookies, 'schools.procareconnect.com')->get($protectedPageUrl);

            // Parse the response content (HTML)
            $html = $protectedResponse->body();

            // Extract desired information (e.g., using regex or DOM parsers)
            // For example, let's use Laravel's `Str` helper for simple parsing
            if (str_contains($html, 'auth__header')) {
                // Process the content as needed
                return "Scraped content: " . substr($html, 0, 100); // Example output
            }

            return 'Content not found';
        } else {
            return 'Login failed!';
        }
    }

    public function scrapeWithLogin()
    {
        // Initialize Guzzle client
        $client = new Client([
            'base_uri' => 'https://schools.procareconnect.com', // Replace with the site you want to scrape
            'cookies' => true,  // Guzzle will automatically manage cookies
        ]);

        // CookieJar to store session cookies
        $jar = new CookieJar();

        // Send POST request to login
        $response = $client->post('/login', [
            'cookies' => $jar,  // Pass the CookieJar
            'form_params' => [
                'username' => 'pgoswami@varemar.com',  // Replace with actual login field name
                'password' => 'V@remar123##',  // Replace with actual password field name
            ],
        ]);

        
        // Check if login is successful
        if ($response->getStatusCode() === 200) {
            // Proceed to scrape authenticated pages
            return $this->scrapeAuthenticatedPage($client, $jar);
        }

        return response()->json(['error' => 'Login failed'], 401);
    }

    // Function to scrape authenticated pages
    public function scrapeAuthenticatedPage(Client $client, CookieJar $jar)
    {
        // Make GET request to the page you want to scrape
        $response = $client->get('https://schools.procareconnect.com/reports', [
            'cookies' => $jar,  // Pass the CookieJar to maintain the session
        ]);

        // Get the response body
        $htmlContent = $response->getBody()->getContents();

        // Use DomCrawler to extract specific content
        $crawler = new Crawler($htmlContent);

        dd($htmlContent);

        // For example, extract all titles from a page
        $titles = $crawler->filter('h1')->each(function (Crawler $node, $i) {
            return $node->text();
        });

        // Return extracted data
        return response()->json($titles);
    }

    public function getLoginApiData()
    {
        try {
            // Initialize cURL
            $curl = curl_init();

            // Data to send in the POST request
            $postData = [
                'email' => env('API_USER_NAME'),
                'password' => env('API_USER_PASS'),
            ];

            // Set the cURL options
            // curl_setopt($curl, CURLOPT_URL, env('API_BASE_URL')."auth/");
            // curl_setopt($curl, CURLOPT_POST, true);
            // curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));
            // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            curl_setopt_array($curl, [
                CURLOPT_URL => env('API_BASE_URL')."auth/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query($postData),
            ]);

            // Execute the cURL request and get the response
            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            // Check for errors
            if (curl_errno($curl) ) {
                Log::error('login api error: ' . curl_error($curl));
                return response()->json(['error' => curl_error($curl)], 500);
                $error_msg = curl_error($curl);
            }
            
            // Close the cURL session
            curl_close($curl);
            
            // Convert the response to an array
            $data = json_decode($response, true);

            if ($err) {
                Log::error('login api error: ' . $err);
                return $err;
            } else {
                return $data;
            }
            
            // Return the API data
            // return response()->json($data);
        } catch(\Exception $exception) {
            Log::error('login api error: ' . $exception->getMessage());
        }
    }
    
    public function apiReport()
    {
        try {
            $user_data =  $this->getLoginApiData();
            
            $token = null;
            if($user_data['user']){
                $token = $user_data['user']['auth_token'];
            }

            // Initialize cURL
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => env('API_BASE_URL')."school/reports/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Authorization: Bearer '.$token
                ),
            ]);

            // Execute the cURL request and get the response
            $response = curl_exec($curl);
            $err = curl_error($curl);

            // Check for errors
            if (curl_errno($curl) ) {
                Log::error('report api error: ' . curl_error($curl));
                return response()->json(['error' => curl_error($curl)], 500);
                $error_msg = curl_error($curl);
            }
            
            // Close the cURL session
            curl_close($curl);

            if ($err) {
                Log::error('report api error: ' . $err);
                return $err;
            } else {
                // return $response;
                // Convert the response to an array
                $data = json_decode($response, true);
    
                
                foreach($data['reports'] as $key => $reports){

                    if($reports['xls_url']!=null && $reports['pdf_url']==null){
                        
                        $url = $reports['xls_url']; // Replace this with the actual URL of the file/image
                        $file = $reports['name']."-".date('Y-m-d h:i:s A',strtotime($reports['generated_at'])).".xlsx";
                        $contents = file_get_contents($url);
                        $filename = basename($file);
                        Storage::put('public/reports/' . $filename, $contents);
                        // return response()->download(storage_path('app/public/reports/' . $filename));

                        dd($filename);

                        break;
                    }
                }
            }

        } catch (\Exception $exception) {
            //exception $th;
        }
    }

}
