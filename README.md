Let your laravel-admin grid support simple-pagination
======
This is an extension to integrates [Laravel simple-pagination ](https://laravel.com/docs/#pagination#main-content) into laravel-admin.


## Installation 

```bash
composer require swooder/simple-pagination
```

## Configurations

Open `config/app.php`, add configurations for providers sections
```php

'providers' => [
    ...
    Swooder\SimplePagination\SimplePaginationServiceProvider::class
]
   
```

## Usage

Use it in the grid:
```php
// origin use case in  grid
$grid = new Grid(new User());

//now replace Grid to SimpleGird
$grid = new SimpleGrid(new User());

//if you need the defalut paginator
$grid->simplePaginate(false);

```



License
------------
Licensed under [The MIT License (MIT)](LICENSE).
