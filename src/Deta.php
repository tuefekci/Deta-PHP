<?php

namespace tuefekci\deta;
use GuzzleHttp\Client;

class Deta {
    private $project_id;
    private $api_key;
    private $options;

	public function __construct(string $project_id="", string $api_key="", array $options=[]) {

		if($project_id == "" && isset($_ENV['DETA_PROJECT_ID'])) {
			$project_id = $_ENV['DETA_PROJECT_ID'];
		}elseif($project_id == "" && isset($_ENV['DETA_SPACE_APP_INSTANCE_ID'])) {
			$project_id = $_ENV['DETA_SPACE_APP_INSTANCE_ID'];
		}

		if($api_key == "" && isset($_ENV['DETA_API_KEY'])) {
			$api_key = $_ENV['DETA_API_KEY'];
		}

		$this->project_id = $project_id;
		$this->api_key = $api_key;

		if($this->project_id == "" || $this->api_key == "") {
			throw new \Exception("Project ID and API Key are required");
		}

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