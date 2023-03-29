<?php

namespace tuefekci\deta;

/*

stream_wrapper_register('deta', '\tuefekci\deta\DetaStreamWrapper');

$handle = fopen('deta://my-file.txt', 'r+');
fwrite($handle, 'Hello, world!');
rewind($handle);
echo fread($handle, 1024);
fclose($handle);

*/

class DetaStreamWrapper
{
    private $position = 0;
    private $client;
    private $name;

    public function __construct()
    {
        $this->client = new Drive(new DetaClient());
    }

    public function stream_open($path, $mode, $options, &$opened_path)
    {
        $parsed_url = parse_url($path);
        $this->name = $parsed_url['host'] . $parsed_url['path'];

        // handle read or write modes
        switch ($mode) {
            case 'r':
                $response = $this->client->get($this->name);
                if ($response->getStatusCode() !== 200) {
                    return false;
                }
                $this->contents = $response->getBody()->getContents();
                break;
            case 'w':
                $this->contents = '';
                break;
            default:
                return false;
        }

        return true;
    }

    public function stream_read($count)
    {
        $contents = substr($this->contents, $this->position, $count);
        $this->position += strlen($contents);
        return $contents;
    }

    public function stream_write($data)
    {
        $this->contents .= $data;
        return strlen($data);
    }

    public function stream_eof()
    {
        return $this->position >= strlen($this->contents);
    }

    public function stream_close()
    {
        if ($this->contents !== '') {
            $response = $this->client->put($this->name, $this->contents);
            if ($response->getStatusCode() !== 200) {
                return false;
            }
        }
        return true;
    }

    // Implement other required streamWrapper methods as needed
    // dir_closedir(), dir_opendir(), dir_readdir(), dir_rewinddir(),
    // mkdir(), rename(), rmdir(), stream_cast(), stream_flush(),
    // stream_lock(), stream_metadata(), stream_seek(),
    // stream_set_option(), stream_stat(), stream_tell(),
    // stream_truncate(), unlink(), url_stat(), __destruct()
}
