<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Log;
use Exception;

class ScrapingController extends Controller
{
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
            Log::error('report api error: ' . $exception->getMessage());
        }
    }

    // get all reports 
    public function apiReports(string $request)
    {
        try {
            $user_data =  $this->getLoginApiData();
            
            $token = null;
            $report_id = $request;
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

                    
                    if($reports['id']==$report_id){
                        
                        $url = $reports['xls_url']; // Replace this with the actual URL of the file/image
                        $file = $reports['name']."-".date('Y-m-d',strtotime($reports['generated_at'])).".xlsx";
                        $contents = file_get_contents($url);
                        $filename = basename($file);
                        Storage::put('public/reports/' . $filename, $contents);
                        // return response()->download(storage_path('app/public/reports/' . $filename));

                        return $filename;

                        break;
                    }
                }
            }

        } catch (\Exception $exception) {
            //exception $th;
            Log::error('report api error: ' . $exception->getMessage());
        }
    }

    // Report Form - hold
    public function apiHoldReport()
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
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS =>'{
                    "kind": "kids_family_info",
                    "hash_data": {
                      "status": "hold",
                      "student_status": "hold",
                      "tag_names": [],
                      "filename": "custom",
                      "fields": [
                        "first_name",
                        "last_name",
                        "room",
                        "admission_date"
                      ],
                      "family_fields": [],
                      "custom_fields": [
                        "0f02dc79-bfa4-4745-a013-c109dbf1a38f"
                      ],
                      "custom_family_fields": []
                    },
                    "filename": "custom",
                    "fields": [
                      "first_name",
                      "last_name",
                      "room",
                      "admission_date"
                    ],
                    "family_fields": [],
                    "report_fields_preset": "custom",
                    "student_status": "hold",
                    "reg_hours": 8,
                    "custom_fields": [
                      "0f02dc79-bfa4-4745-a013-c109dbf1a38f"
                    ],
                    "custom_family_fields": []
                  }',
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$token
                ),
            ]);

            // Execute the cURL request and get the response
            $response = curl_exec($curl);
            $err = curl_error($curl);

            // Check for errors
            if (curl_errno($curl) ) {
                Log::error('hold report api error: ' . curl_error($curl));
                return response()->json(['error' => curl_error($curl)], 500);
                $error_msg = curl_error($curl);
            }
            
            // Close the cURL session
            curl_close($curl);

            if ($err) {
                Log::error('hold report api error: ' . $err);
                return $err;
            } else {
                // return $response;
                // Convert the response to an array
                $data = json_decode($response, true);
    
                
                foreach($data as $key => $reports){

                    $get_data = $this->apiReports($reports['id']);

                    return $get_data;
                }
            }

        } catch (\Exception $exception) {
            //exception $th;
            Log::error('hold report api error: ' . $exception->getMessage());
        }
    }

    // Report Form - active
    public function apiActiveReport()
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
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS =>'{
                    "kind": "kids_family_info",
                    "hash_data": {
                      "status": "active",
                      "student_status": "active",
                      "tag_names": [
                        
                      ],
                      "filename": "custom",
                      "fields": [
                        "first_name",
                        "last_name",
                        "room",
                        "admission_date"
                      ],
                      "family_fields": [
                        
                      ],
                      "custom_fields": [
                        "0f02dc79-bfa4-4745-a013-c109dbf1a38f"
                      ],
                      "custom_family_fields": [
                        
                      ]
                    },
                    "filename": "custom",
                    "fields": [
                      "first_name",
                      "last_name",
                      "room",
                      "admission_date"
                    ],
                    "family_fields": [
                      
                    ],
                    "report_fields_preset": "custom",
                    "student_status": "active",
                    "reg_hours": 8,
                    "custom_fields": [
                      "0f02dc79-bfa4-4745-a013-c109dbf1a38f"
                    ],
                    "custom_family_fields": [
                      
                    ]
                }',
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$token
                ),
            ]);

            // Execute the cURL request and get the response
            $response = curl_exec($curl);
            $err = curl_error($curl);

            // Check for errors
            if (curl_errno($curl) ) {
                Log::error('active report api error: ' . curl_error($curl));
                return response()->json(['error' => curl_error($curl)], 500);
                $error_msg = curl_error($curl);
            }
            
            // Close the cURL session
            curl_close($curl);

            if ($err) {
                Log::error('active report api error: ' . $err);
                return $err;
            } else {
                // Convert the response to an array
                $data = json_decode($response, true);
    
                
                foreach($data as $key => $reports){

                    $get_data = $this->apiReports($reports['id']);

                    return $get_data;
                }
            }

        } catch (\Exception $exception) {
            //exception $th;
            Log::error('active report api error: ' . $exception->getMessage());
        }
    }

    // Report Form - inactive
    public function apiInactiveReport()
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
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS =>'{
                    "kind": "kids_family_info",
                    "hash_data": {
                      "status": "inactive",
                      "student_status": "inactive",
                      "tag_names": [
                        
                      ],
                      "filename": "custom",
                      "fields": [
                        "first_name",
                        "last_name",
                        "room",
                        "admission_date",
                        "graduation_date"
                      ],
                      "family_fields": [
                        
                      ],
                      "custom_fields": [
                        "0f02dc79-bfa4-4745-a013-c109dbf1a38f"
                      ],
                      "custom_family_fields": [
                        
                      ]
                    },
                    "filename": "custom",
                    "fields": [
                      "first_name",
                      "last_name",
                      "room",
                      "admission_date",
                      "graduation_date"
                    ],
                    "family_fields": [
                      
                    ],
                    "report_fields_preset": "custom",
                    "student_status": "inactive",
                    "reg_hours": 8,
                    "custom_fields": [
                      "0f02dc79-bfa4-4745-a013-c109dbf1a38f"
                    ],
                    "custom_family_fields": [
                      
                    ]
                }',
                CURLOPT_HTTPHEADER => array(
                    'Accept: application/json',
                    'Content-Type: application/json',
                    'Authorization: Bearer '.$token
                ),
            ]);

            // Execute the cURL request and get the response
            $response = curl_exec($curl);
            $err = curl_error($curl);

            // Check for errors
            if (curl_errno($curl) ) {
                Log::error('inactive report api error: ' . curl_error($curl));
                return response()->json(['error' => curl_error($curl)], 500);
                $error_msg = curl_error($curl);
            }
            
            // Close the cURL session
            curl_close($curl);

            if ($err) {
                Log::error('inactive report api error: ' . $err);
                return $err;
            } else {
                // Convert the response to an array
                $data = json_decode($response, true);
    
                
                foreach($data as $key => $reports){

                    $get_data = $this->apiReports($reports['id']);

                    return $get_data;
                }
            }

        } catch (\Exception $exception) {
            Log::error('inactive report api error: ' . $exception->getMessage());
        }
    }

    // call reports
    public function callReports()
    {
        try {
            $apiHoldReport = $this->apiHoldReport();
            $apiActiveReport = $this->apiActiveReport();
            $apiInactiveReport = $this->apiInactiveReport();

            Log::info('call report api success: apiHoldReport = ' . $apiHoldReport . ', apiActiveReport= ' . $apiActiveReport . ', apiInactiveReport= ' . $apiInactiveReport);
        } catch (\Exception $exception) {
            Log::error('call report api error: ' . $exception->getMessage());
        }
    }

}
