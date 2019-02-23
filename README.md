# mailform
Send out a given mail form

## PHP project init

### Composer
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
```

done with version 1.8.4.

### Project init

```
$ ./composer.phar init
```

#### Project layout

tbd: https://getcomposer.org/doc/01-basic-usage.md#introduction

##### Base structure

following https://blog.nikolaposa.in.rs/2017/01/16/on-structuring-php-projects/

```
bin/              # command-line executables
config/           # configuration files
public/           # web server files, assets
resources/        # other resource files
src/              # PHP source code
templates/        # view and layout files
tests/            # test code
```


#### PHPUnit setup

https://phpunit.de/getting-started/phpunit-7.html

```
$ composer require --dev phpunit/phpunit ^7
```

