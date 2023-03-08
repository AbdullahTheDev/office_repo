<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use vendor\autoload;
use Square\Environment;
use Square\SquareClient;
use Square\Models\Card;
use Square\Models\Money;
use Square\Models\Address;
use Square\Exceptions\ApiException;
use Square\Models\CreatePaymentRequest;
use Square\Models\CreateCustomerRequest;

class SquareupController extends Controller
{
    public function Squareup(Request $request)
    {
        // // Setting Variables
        $token = $request->token;
        $amount = $request->amount;
        $customer_id = "";
        $location = $request->locationId;
        $note = "Note";
        $email = 'abdullahwaseem.4401@gmail.com';

        // Get Location 
            // $client = new SquareClient([
            //     'accessToken' => env('SQUARE_ACCESS_TOKEN'),
            //     'environment' => Environment::SANDBOX,
            // ]);
            
            // try {
            
            //     $apiResponse = $client->getLocationsApi()->listLocations();
            
            //     if ($apiResponse->isSuccess()) {
            //         $result = $apiResponse->getResult();
            //         foreach ($result->getLocations() as $location) {
            //             // printf(
            //             //     "%s: %s, %s, %s<p/>", 
            //             //     $location->getId(),
            //             //     $location->getName(),
            //             //     $location->getAddress()->getAddressLine1(),
            //             //     $location->getAddress()->getLocality()
            //             // );
            //             $location = $location->getId();
            //         }
            
            //     } else {
            //         $errors = $apiResponse->getErrors();
            //         foreach ($errors as $error) {
            //             printf(
            //                 "%s<br/> %s<br/> %s<p/>", 
            //                 $error->getCategory(),
            //                 $error->getCode(),
            //                 $error->getDetail()
            //             );
            //         }
            //     }
            
            // } catch (ApiException $e) {
            //     echo "ApiException occurred: <b/>";
            //     echo $e->getMessage() . "<p/>";
            // }s
        // Location Ends 

        // Create Customer 
        // echo $location . 'LOC';

        $client = new SquareClient([
            'accessToken' => env('SQUARE_ACCESS_TOKEN'),
            'environment' => Environment::SANDBOX,
            'customUrl' => 'https://dealsondrives.com',
            'numberOfRetries'   =>  2,
            'timeout' => 60,
        ]);

        // Setting Address 
        $address = new Address();
        $address->setAddressLine1("1455 Market St");
        $address->setAddressLine2("San Francisco, CA 94103");

        $body = new CreateCustomerRequest();
        $body->setGivenName("John");
        $body->setFamilyName("Doe");
        $body->setAddress($address);
        $body->setIdempotencyKey(uniqid());

        // // End Address 
        $apiResponse = $client->getCustomersApi()->createCustomer($body);

        try {

            $apiResponse = $client->getCustomersApi()->createCustomer($body);
        
            if ($apiResponse->isSuccess()) {
                $result = $apiResponse->getResult();        
                $customer_id = $result->getCustomer()->getId();
        
            } else {
                $errors = $apiResponse->getErrors();
                foreach ($errors as $error) {
                    printf(
                        "%s: %s, %s, %s<p/>", 
                        $error->getCategory(),
                        $error->getCode(),
                        $error->getDetail()
                    );
                }
            }
        
        } catch (ApiException $e) {
            echo "ApiException occurred: <b/>";
            echo $e->getMessage() . "<p/>";
        }
        
        // echo $customer_id;
        // End Customer Create

        // // Create Payment 

        $amount_money = new Money();
        $amount_money->setAmount($amount);
        $amount_money->setCurrency('USD');

        // $app_fee_money = new Money();
        // $app_fee_money->setAmount(10);
        // $app_fee_money->setCurrency('USD');


        $pay_body = new \Square\Models\CreatePaymentRequest(
            $token,
            uniqid(),
            $amount_money
        );
        $pay_body->setAutocomplete(true);
        $pay_body->setCustomerId($customer_id);
        $pay_body->setLocationId($location);
        $pay_body->setBuyerEmailAddress($email);
        $pay_body->setNote($note);
        
        $pay_api_response = $client->getPaymentsApi()->createPayment($pay_body);
        
        if ($pay_api_response->isSuccess()) {
            $result = $pay_api_response->getResult();
            // print_r($result);
            echo json_encode($result);
        } else {
            $errors = $pay_api_response->getErrors();
        }


        

    }
}
