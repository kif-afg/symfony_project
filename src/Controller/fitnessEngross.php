<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpClient\HttpClient;


class fitnessEngross
{
    public function Custom_function()
    {
    
        function cvrapi($vat, $country)
        {
            $client = HttpClient::create();
            $response = $client->request('GET', 'http://cvrapi.dk/api?search=' . $vat . '&country=' . $country);
            
            $statusCode = $response->getStatusCode();
            if($statusCode != 200)
            {
                return $statusCode;
            }
            else
            {
                $contentType = $response->getHeaders()['content-type'][0];
                $content = $response->getContent();
                 $content = $response->toArray();
                return $content;
            }
            
        }
        $output = "";
        
        
        $objects =array(

           array(

            "Navn" => "Jens",
            "Efternavn" => "Ullasen",
            "Address" => "Sandbanken 24",
            "postnummer" => "4320",
            "CVR" => "38159062",

                ),

           array (

            "Navn" => "Ulla",
            "Efternavn" => "Andersen",
            "Address" => "Imaneq 1",
            "postnummer" => "3900",
            "CVR" => "1023145495",

                ),

             array (

            "Navn" => "Thomas",
            "Efternavn" => "Jensen",
            "Address" => "Baggesensvænge 5",
            "postnummer" => "4700",
            "CVR" => "46564544",

                ),

             array

                (

            "Navn" => "Gert",
            "Efternavn" => "Thomsen",
             "Address" => "Sportsvej 19",
            "postnummer" => "8600",
            "CVR" => "36267410",

                ),
                array

                (

            "Navn" => "Lone",
            "Efternavn" => "Gertsen",
             "Address" => "Hans Knudsensplads 1",
            "postnummer" => "2100",
            "CVR" => "38849166",

                )
                    );
                        //looping through objects 
                        foreach($objects as $object) {
                            $output .= "<ul>";
                            foreach ($object as $key => $value) {
                                $output .=  "<li>".$key." = ".$value."</li>";
                            }
                           
                            $cvr = $object['CVR'];
                            $address = $object['Address'];
                            //search results from api using company's cvr
                            $api_response = cvrapi($cvr,'dk');
                            if($api_response == 404 )
                            {
                                $output .= '<li><p style="color:green;">CVR is not correct</p><li>';
                            }
                            else{

                            //$output .= $cvr_data; 
                            $cvr_address = $api_response['address'];
                            $output  .= "Address from the API is ".$cvr_address."<br>";
                            if($cvr_address == $address)
                            {
                                $output .= '<p style="color:green;">Addresses match</p>';
                            }
                            else{
                                $output .= '<p style="color:red;">Addresses do not match</p>';
                            }
                            
                            }
                            $output .=  "</ul>";    
                        }
                           
                        return new response ($output);

    }
}