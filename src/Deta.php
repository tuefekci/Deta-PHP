<?php

namespace tuefekci\deta;

class Deta {
    private $project_id;
    private $project_key;

	public function __construct($project_id, $project_key) {
		$this->project_id = $project_id;
		$this->project_key = $project_key;
	}

	public function base($base_name) {
		return new Base($this->project_id, $this->project_key, $base_name);
	}
}