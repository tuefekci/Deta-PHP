<?php

namespace tuefekci\deta;

class Drive {

    private $client;
    
    public function __construct($client) {
        $this->client = $client;
    }

    public function put($name, $content, $content_type = null) {
        $url = "files?name={$name}";
        $options = ['body' => $content];
        if ($content_type !== null) {
            $options['headers']['Content-Type'] = $content_type;
        }
        return $this->client->post($url, $options);
    }

    public function initializeChunkedUpload($name) {
        $url = "uploads?name={$name}";
        return $this->client->post($url);
    }

    public function uploadChunkedPart($upload_id, $name, $part, $content) {
        $url = "uploads/{$upload_id}/parts?name={$name}&part={$part}";
        $options = ['body' => $content];
        return $this->client->post($url, $options);
    }

    public function endChunkedUpload($upload_id, $name) {
        $url = "uploads/{$upload_id}?name={$name}";
        return $this->client->patch($url);
    }

    public function abortChunkedUpload($upload_id, $name) {
        $url = "uploads/{$upload_id}?name={$name}";
        return $this->client->delete($url);
    }

    public function get($name) {
        $url = "files/download?name={$name}";
        return $this->client->get($url);
    }

    public function list($limit = null, $prefix = null, $last = null) {
        $query_params = [];
        if ($limit !== null) {
            $query_params['limit'] = $limit;
        }
        if ($prefix !== null) {
            $query_params['prefix'] = $prefix;
        }
        if ($last !== null) {
            $query_params['last'] = $last;
        }
        $url = 'files?' . http_build_query($query_params);
        return $this->client->get($url);
    }

    public function delete($names) {
        $url = 'files';
        $data = ['names' => $names];
        $options = ['json' => $data];
        return $this->client->delete($url, $options);
    }
}
