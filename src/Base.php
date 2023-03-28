<?php

namespace tuefekci\deta;

class Base {
    private $client;
    
    public function __construct($client) {
        $this->client = $client;
    }
    
    public function put($items) {
        $payload = array("items" => $items);
        $response = $this->client->put("items", ['json' => $payload]);
        return json_decode($response->getBody()->getContents());
    }
    
    public function get($key) {
        $response = $this->client->get("items/$key");
        return json_decode($response->getBody()->getContents());
    }
    
    public function delete($key) {
        $response = $this->client->delete("items/$key");
        return json_decode($response->getBody()->getContents());
    }
    
    public function insert($item) {
        $payload = array("item" => $item);
        $response = $this->client->post("items", ['json' => $payload]);
        return json_decode($response->getBody()->getContents());
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
        $response = $this->client->patch("items/$key", ['json' => $payload]);
        return json_decode($response->getBody()->getContents());
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
        $response = $this->client->post("query", ['json' => $payload]);
        return json_decode($response->getBody()->getContents());
    }
    
}
