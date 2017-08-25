# Intro to CronManager

It is a bundle that provides a web interface for managing cron table.

[![Build Status](https://secure.travis-ci.org/michelsalib/BCCCronManagerBundle.png?branch=master)](http://travis-ci.org/michelsalib/BCCCronManagerBundle)

## Features:

- Displays cron table with time expression, command, output file, error file and comment
- Can guess last execution time and status (based on log files)
- Can display log files
- Support edit/add cron entry
- Includes shortcuts to easily get common time expression, symfony command and symfony log directory
- Translated in english, french and german

## Screenshots
### Cron list
![](https://github.com/michelsalib/BCCCronManagerBundle/raw/master/Resources/screens/cron-list.png)
### Cron form
![](https://github.com/michelsalib/BCCCronManagerBundle/raw/master/Resources/screens/cron-form.png)
### Cron output
![](https://github.com/michelsalib/BCCCronManagerBundle/raw/master/Resources/screens/cron-file.png)

## Installation and configuration:

### Get the bundle

If you are using Symfony 2.1 see previous tags according to your Symfony version

Add BCCCronManagerBundle:

``` bash
    composer require bcc/cron-manager-bundle v3.1
    bin/console assets:install
```

### Add BCCCronManagerBundle to your application kernel

``` php
<?php

    // app/AppKernel.php
    public function registerBundles()
    {
        return array(
            // ...
            new BCC\CronManagerBundle\BCCCronManagerBundle(),
            // ...
        );
    }
```

### Import the routing configuration

Add to your `routing.yml`:

``` yml
#BCCCronManager routing
BCCCronManagerBundle:
    resource: "@BCCCronManagerBundle/Resources/config/routing.xml"
    prefix:   admin/cron-manager
```
You can customize the prefix as you wish.

Don't forget to secure your route :

``` yml
    access_control:
        - { path: ^/admin, role: ROLE_ADMIN }
```