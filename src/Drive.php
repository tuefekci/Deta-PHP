<?php

namespace tuefekci\deta;

class Drive {

    private $client;
    
    public function __construct($client) {
        $this->client = $client;
    }

	private function handleResponse($response, $acceptedStatus = 200) {

		switch ($response->getStatusCode()) {
			case $acceptedStatus:
				if (!empty($response->getHeader('content-type')) && strpos($response->getHeader('content-type')[0], 'application/json') !== false) {
					return json_decode($response->getBody()->getContents());
				} else {
					return $response->getBody()->getContents();
				}
				break;
			case 400:
			case 404:
				return throw new \Exception(json_decode($response->getBody()->getContents()));
				break;
			default:
				return throw new \Exception($response->getBody()->getContents());
				break;
		}
	}

    public function put($name, $content, $content_type = null) {
        $url = "files?name={$name}";
        $options = ['body' => $content];
        if ($content_type !== null) {
            $options['headers']['Content-Type'] = $content_type;
        }
		$response = $this->client->post($url, $options);
        return $this->handleResponse($response, 201);
    }

    public function initializeChunkedUpload($name) {
        $url = "uploads?name={$name}";
        $response = $this->client->post($url);

		return $this->handleResponse($response, 202);
    }

    public function uploadChunkedPart($upload_id, $name, $part, $content) {
        $url = "uploads/{$upload_id}/parts?name={$name}&part={$part}";
        $options = ['body' => $content];
        $response = $this->client->post($url, $options);

		return $this->handleResponse($response, 200);
    }

    public function endChunkedUpload($upload_id, $name) {
        $url = "uploads/{$upload_id}?name={$name}";
        $response = $this->client->patch($url);

		return $this->handleResponse($response, 200);
    }

    public function abortChunkedUpload($upload_id, $name) {
        $url = "uploads/{$upload_id}?name={$name}";
        $response = $this->client->delete($url);

		return $this->handleResponse($response, 200);
    }

    public function get($name) {
        $url = "files/download?name={$name}";
        $response = $this->client->get($url);

		return $this->handleResponse($response, 200);
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
        $response = $this->client->get($url);

		return $this->handleResponse($response, 200);
    }

    public function delete($names) {
		$names = is_array($names) ? $names : [$names];

        $url = 'files';
        $data = ['names' => $names];
        $options = ['json' => $data];
        $response = $this->client->delete($url, $options);

		return $this->handleResponse($response, 200);
    }
}
