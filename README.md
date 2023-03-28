# Deta PHP
This is a PHP client for the [Deta](https://deta.sh/) API.

## Installation

You can install the package via composer:

```bash
composer require tuefekci/deta
```

## Usage

To use the Deta client, first create an instance of the `Deta` class, passing in your project ID and API key:

```php
use tuefekci\deta\Deta;

$deta = new Deta('your_project_id', 'your_api_key');
```

Then, you can use the `base` method to get a reference to a base in your project:

```php
$my_base = $deta->base('my_base');
```

You can then use the methods on the base to interact with the items stored in the base:

```php
// Insert an item
$my_base->insert(['name' => 'Alice', 'age' => 30]);

// Get an item by key
$item = $my_base->get('abc123');

// Update an item
$my_base->update('abc123', ['name' => 'Bob']);

// Delete an item
$my_base->delete('abc123');

// Query items
$items = $my_base->query(['age' => ['lt' => 40]]);
```

Similarly, you can use the `drive` method to get a reference to a drive in your project:

```php
$my_drive = $deta->drive('my_drive');
```

And then use the methods on the drive to interact with the files stored in the drive:

```php
// Upload a file
$my_drive->put('file.txt', 'Hello, world!');

// Download a file
$file = $my_drive->get('file.txt');
$content = $file->getBody()->getContents();

// List files
$files = $my_drive->list();
```


## Documentation for `Deta-PHP` classes and files

This repository contains `Deta-PHP`, which is a PHP SDK for interacting with the Deta API. The SDK contains the following files and classes:

### deta.php

This file contains the `Deta` class, which is used to instantiate a Deta client. The `Deta` class constructor takes the following parameters:

- `project_id`: the Deta project ID
- `api_key`: the Deta project API key
- `options`: an optional array of options for the Guzzle HTTP client

The `Deta` class provides the following methods:

- `base($base_name)`: creates and returns a new `Base` instance
- `drive($drive_name)`: creates and returns a new `Drive` instance

### base.php

This file contains the `Base` class, which provides methods for interacting with Deta Base. The `Base` class constructor takes a single parameter, which is an instance of the Guzzle HTTP client.

The `Base` class provides the following methods:

- `put($items)`: adds or updates items in the base
- `get($key)`: retrieves an item from the base by key
- `delete($key)`: deletes an item from the base by key
- `insert($item)`: adds a new item to the base
- `update($key, $set = null, $increment = null, $append = null, $delete = null)`: updates an item in the base by key
- `query($query = null, $limit = null, $last = null)`: queries the base

### drive.php

This file contains the `Drive` class, which provides methods for interacting with Deta Drive. The `Drive` class constructor takes a single parameter, which is an instance of the Guzzle HTTP client.

The `Drive` class provides the following methods:

- `put($name, $content, $content_type = null)`: uploads a new file to Deta Drive
- `initializeChunkedUpload($name)`: initiates a chunked upload to Deta Drive
- `uploadChunkedPart($upload_id, $name, $part, $content)`: uploads a part of a chunked upload to Deta Drive
- `endChunkedUpload($upload_id, $name)`: ends a chunked upload to Deta Drive
- `abortChunkedUpload($upload_id, $name)`: aborts a chunked upload to Deta Drive
- `get($name)`: retrieves a file from Deta Drive
- `list($limit = null, $prefix = null, $last = null)`: lists files in Deta Drive
- `delete($name)`: deletes a file from Deta Drive by name

### Namespace
All classes are defined in the `tuefekci\deta` namespace. To use the SDK in your PHP code, include the following statement:

```php
use tuefekci\deta\Deta;
use tuefekci\deta\Base;
use tuefekci\deta\Drive;
```

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.


