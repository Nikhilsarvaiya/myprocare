<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Log;
use Exception;
use League\Csv\Reader;
use League\Csv\UnavailableStream;
use App\Models\Students;
use Excel;
// use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Carbon\Carbon;

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
                        
                        
                        // xlsx to csv
                        $file_path = 'public/reports/' . $filename;
                        if (Storage::exists($file_path)) {
                            $filePath = Storage::path($file_path);
                            
                            $reader = new Xlsx();
                            // set the Read data only option
                            $reader->setReadDataOnly(true);
                            $spreadsheet = $reader->load($filePath);
                            
                            $writer = (new Csv($spreadsheet))
                                ->setEnclosure('')
                                ->setLineEnding("\n")
                                ->setDelimiter(';');
                            $writer->setSheetIndex(0);
                            $writer->save($filePath.'.csv');
                        }

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

                    
                    $file_path = 'public/reports/' . $get_data.'.csv';
                    
                    if (Storage::exists($file_path)) {
                        
                        try {
                            $filePath = Storage::path($file_path);
                            $content = file($filePath);
                            $array = array();

                            for ($i = 1; $i < count($content); $i++) {
                                $line = explode(',', $content[$i]);
                                for ($j = 0; $j < count($line); $j++) {
                                    $array[$i][$j + 1] = $line[$j];
                                }
                            }

                            $k = $k2 = count($array) + 1;

                            $address_1 = null;
                            $address_2 = null;
                            $city = null;
                            $country_code = null;
                            $zip = null;


                            if($array[1]){
                                $address_1 = $array[1][1];
                            }
                            if($array[2]){
                                $address_2 = $array[2][1];
                                $city = $array[2][2];
                                $country_code = $array[2][3];
                                $zip = $array[2][4];
                            }

                            $student_arr_data = null;

                            for ($i = 1; $i < $k; $i++) {

                                if($i>4){  // $i>4

                                    $student_arr_data = explode(";",$array[$i][1]);
                                    
                                    $data = [
                                        'fname' => $student_arr_data[0] == '' ? null : $student_arr_data[0],
                                        'lname' => $student_arr_data[1] == '' ? null : $student_arr_data[1],
                                        'room' => $student_arr_data[2] == '' ? null : $student_arr_data[2],
                                        'type' => 'hold',
                                        'adminssion_date' => $student_arr_data[3] == '' ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($student_arr_data[3]),
                                        'nj_area' => $address_1 == '' ? null : str_replace(";","",$address_1),
                                        'address' => $address_2 == '' ? null : $address_2,
                                        'city' => $city == '' ? null : $city,
                                        'country_code' => $country_code == '' ? null : $country_code,
                                        'zip' => str_replace(";","",$zip),
                                        'enrollment_status' => $student_arr_data[4] == '' ? null : $student_arr_data[4],
                                    ];

                                    $student = Students::updateOrCreate($data);
                                }

                            }
                            // dd("exists==".$filePath);
                            Log::info('hold report file save to database');
                            return $get_data;
                            

                        } catch (UnavailableStream|Exception $e) {
                            // return response()->json(['message' => $e->getMessage()], 400);
                            Log::error('hold report api save data error: ' . $e->getMessage());
                        }
                    }

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

                    $file_path = 'public/reports/' . $get_data.'.csv';
                    
                    if (Storage::exists($file_path)) {
                        
                        try {
                            $filePath = Storage::path($file_path);
                            $content = file($filePath);
                            $array = array();

                            for ($i = 1; $i < count($content); $i++) {
                                $line = explode(',', $content[$i]);
                                for ($j = 0; $j < count($line); $j++) {
                                    $array[$i][$j + 1] = $line[$j];
                                }
                            }

                            $k = $k2 = count($array) + 1;

                            $address_1 = null;
                            $address_2 = null;
                            $city = null;
                            $country_code = null;
                            $zip = null;


                            if($array[1]){
                                $address_1 = $array[1][1];
                            }
                            if($array[2]){
                                $address_2 = $array[2][1];
                                $city = $array[2][2];
                                $country_code = $array[2][3];
                                $zip = $array[2][4];
                            }

                            $student_arr_data = null;

                            
                            for ($i = 1; $i < $k; $i++) {
                                
                                if($i>4){  // $i>4

                                    $student_arr_data = explode(";",$array[$i][1]);
                                    
                                    $data = [
                                        'fname' => $student_arr_data[0] == '' ? null : $student_arr_data[0],
                                        'lname' => $student_arr_data[1] == '' ? null : $student_arr_data[1],
                                        'room' => $student_arr_data[2] == '' ? null : $student_arr_data[2],
                                        'type' => 'active',
                                        'adminssion_date' => $student_arr_data[3] == '' ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($student_arr_data[3]),
                                        'nj_area' => $address_1 == '' ? null : str_replace(";","",$address_1),
                                        'address' => $address_2 == '' ? null : $address_2,
                                        'city' => $city == '' ? null : $city,
                                        'country_code' => $country_code == '' ? null : $country_code,
                                        'zip' => str_replace(";","",$zip),
                                        'enrollment_status' => $student_arr_data[4] == '' ? null : $student_arr_data[4],
                                    ];

                                    $student = Students::updateOrCreate($data);
                                }

                            }
                            // dd("exists==".$filePath);
                            Log::info('active report file save to database');
                            

                        } catch (UnavailableStream|Exception $e) {
                            // return response()->json(['message' => $e->getMessage()], 400);
                            Log::error('active report api save data error: ' . $e->getMessage());
                        }
                    }

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

                    $file_path = 'public/reports/' . $get_data.'.csv';
                    
                    if (Storage::exists($file_path)) {
                        
                        try {
                            $filePath = Storage::path($file_path);
                            $content = file($filePath);
                            $array = array();

                            for ($i = 1; $i < count($content); $i++) {
                                $line = explode(',', $content[$i]);
                                for ($j = 0; $j < count($line); $j++) {
                                    $array[$i][$j + 1] = $line[$j];
                                }
                            }

                            $k = $k2 = count($array) + 1;

                            $address_1 = null;
                            $address_2 = null;
                            $city = null;
                            $country_code = null;
                            $zip = null;


                            if($array[1]){
                                $address_1 = $array[1][1];
                            }
                            if($array[2]){
                                $address_2 = $array[2][1];
                                $city = $array[2][2];
                                $country_code = $array[2][3];
                                $zip = $array[2][4];
                            }

                            $student_arr_data = null;

                            // dd($array);

                            for ($i = 1; $i < $k; $i++) {
                                
                                if($i>4){  // $i>4

                                    $student_arr_data = explode(";",$array[$i][1]);
                                    
                                    $data = [
                                        'fname' => $student_arr_data[0] == '' ? null : $student_arr_data[0],
                                        'lname' => $student_arr_data[1] == '' ? null : $student_arr_data[1],
                                        'room' => $student_arr_data[2] == '' ? null : $student_arr_data[2],
                                        'type' => 'inactive',
                                        'adminssion_date' => $student_arr_data[3] == '' ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($student_arr_data[3]),
                                        'graduation_date' => $student_arr_data[4] == '' ? null : \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($student_arr_data[4]),
                                        'nj_area' => $address_1 == '' ? null : str_replace(";","",$address_1),
                                        'address' => $address_2 == '' ? null : $address_2,
                                        'city' => $city == '' ? null : $city,
                                        'country_code' => $country_code == '' ? null : $country_code,
                                        'zip' => str_replace(";","",$zip),
                                        'enrollment_status' => $student_arr_data[5] == '' ? null : $student_arr_data[5],
                                    ];

                                    $student = Students::updateOrCreate($data);
                                }

                            }
                            // dd("exists==".$filePath);
                            Log::info('inactive report file save to database');
                            

                        } catch (UnavailableStream|Exception $e) {
                            // return response()->json(['message' => $e->getMessage()], 400);
                            Log::error('inactive report api save data error: ' . $e->getMessage());
                        }
                    }

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
