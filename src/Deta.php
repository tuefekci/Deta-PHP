<?php

namespace tuefekci\deta;
use GuzzleHttp\Client;

class Deta {
    private $project_id;
    private $api_key;
    private $options;

	public function __construct(string $project_id, string $api_key, array $options=[]) {
		$this->project_id = $project_id;
		$this->api_key = $api_key;

		// Create a new Guzzle client with the handler stack
        $this->options = [
			'verify' => false, // TODO: Remove this line when who ever is responsible fixes their SSL certificate
            'headers' => [
                'X-Api-Key'		=> $api_key,
				'User-Agent' 	=> 'github.com/tuefekci/Deta-PHP'
            ],
        ];
	}

	public function base(string $base_name) {
		$options = $this->options;
        $options['base_uri'] = "https://database.deta.sh/v1/{$this->project_id}/{$base_name}/";
        $client = new Client($options);
        return new Base($client);
	}

	public function drive(string $drive_name) {
		$options = $this->options;
        $options['base_uri'] = "https://drive.deta.sh/v1/{$this->project_id}/{$drive_name}/";
		$client = new Client($options);
        return new Drive($client);
	}
}