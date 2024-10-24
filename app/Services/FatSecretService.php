<?php
namespace App\Services;

use Exception;
use GuzzleHttp\Client;

class FatSecretService{
    private $http;
    private $url;
    private $token;

    public function __construct(){
        try {
            $this->http = new Client();
            $this->url = config('services.fat_secret.url');

            //primero obtenemos el token
            $response = $this->http->post(config('services.fat_secret.url_token'), [
                'auth' => [
                    config('services.fat_secret.client_id'),
                    config('services.fat_secret.client_secret'),
                ],
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'form_params'       => [
                    'scope'             => 'premier',
                    'grant_type'        => 'client_credentials'
                ],
            ]);


            $token = json_decode((string)$response->getBody(), true);

            if (!isset($token['access_token'])) {
                return ['code_error' => 401, 'messages' => ['token' => 'error al generar el token']];
            }

            $this->token = $token['access_token'];
        } catch (Exception $e) {
            return ['code_error' => 401, 'messages' => ['token' => 'error al generar el token']];
        }
    }

    public function getRecipes(string $search = '')
    {
        try {
            $response = $this->http->get($this->url . '/recipes/search/v3', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->token,
                ],
                'form_params' => [
                    'search_expression' => $search,
                ],
            ]);
            $xml = simplexml_load_string((string)$response->getBody());

            return json_decode(json_encode($xml), true);
        } catch (Exception $e) {
            return ['code_error' => 401, 'messages' => ['token' => 'error al generar el token']];
        }
    }
    public function getFoods(string $search = ''){
        try {
            $response = $this->http->get($this->url. '/foods/search/v3', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer '. $this->token,
                ],
                'form_params' => [
                   'search_expression' => $search,
                ],
            ]);
            $xml = simplexml_load_string((string)$response->getBody());

            return json_decode(json_encode($xml), true);
        } catch (Exception $e) {
            return ['code_error' => 401, 'messages' => ['token' => 'error al generar el token']];
        }
    }

}



