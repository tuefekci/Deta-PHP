<?php

namespace tuefekci\deta;

class Base {
    private $project_id;
    private $base_name;
    private $project_key;
    private $base_url;
    private $client;
    
    public function __construct($project_id, $project_key, $base_name) {
        $this->project_id = $project_id;
        $this->base_name = $base_name;
        $this->project_key = $project_key;
        $this->base_url = "https://database.deta.sh/v1/$project_id/$base_name";

        $this->client = new \GuzzleHttp\Client([
            'verify' => false, // disable SSL verification
        ]);
    }
    
    private function sendRequest($method, $endpoint, $payload = null) {
        $url = $this->base_url . $endpoint;
        $requestOptions = [
            'headers' => [
                'User-Agent'    => 'tuefekci/deta-php',
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/json',
                "X-API-Key"     => $this->project_key
            ]
        ];

        if ($payload) {
            $requestOptions['body'] = json_encode($payload);
        }

        var_dump($url);
        var_dump($requestOptions);

        $response = $this->client->request($method, $url, $requestOptions);
        return json_decode($response->getBody(), true);
    }
    
    public function put($items) {
        $payload = array("items" => $items);
        $response = $this->sendRequest("PUT", "/items", $payload);
        return $response;
    }
    
    public function get($key) {
        $response = $this->sendRequest("GET", "/items/$key");
        return $response;
    }
    
    public function delete($key) {
        $response = $this->sendRequest("DELETE", "/items/$key");
        return $response;
    }
    
    public function insert($item) {
        $payload = array("item" => $item);
        $response = $this->sendRequest("POST", "/items", $payload);
        return $response;
    }
    
    public function update($key, $set = null, $increment = null, $append = null, $delete = null) {
        $payload = array();
        if ($set) {
            $payload["set"] = $set;
        }
        if ($increment) {
            $payload["increment"] = $increment;
        }
        if ($append) {
            $payload["append"] = $append;
        }
        if ($delete) {
            $payload["delete"] = $delete;
        }
        $response = $this->sendRequest("PATCH", "/items/$key", $payload);
        return $response;
    }
    
    public function query($query = null, $limit = null, $last = null) {
        $payload = array();
        if ($query) {
            $payload["query"] = $query;
        }
        if ($limit) {
            $payload["limit"] = $limit;
        }
        if ($last) {
            $payload["last"] = $last;
        }

        $response = $this->sendRequest("POST", "/query", $payload);
        return $response;
    }
}
