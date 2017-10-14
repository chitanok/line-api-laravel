# line-api-laravel
A basic implementation of Line BOT. You can create a simple bot using this repositories.

* [Background: What is Line and Line BOT](#background-what-is-line-and-line-bot)
* [Installation](#installation)
* [Copyright and License](#copyright-and-license)


## Background what is Line and Line bot?

Line is a Messaging app you can text, call anytime from your Line app. It is free. Line BOT is a BOT application, you can develop it as per your business need (like sending push notification to your clients, who connected with your BOT account).

## Installation

This is a Laravel based package so if you building your application using Laravel framework then you can simply run this command.

    ```sh
    $ composer require chitanok/line-api-laravel
    ```
    OR
        ```sh
    $ composer require "chitanok/line-api-laravel":"dev-master"
    ```

Then add the service provider in config\app.php
	```sh
	Chitanok\LineApiLaravel\LineMessageServiceProvider::class,
	```


Copyright (c) 2017 Agile Tech Solution.
