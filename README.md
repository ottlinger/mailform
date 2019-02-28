# mailform
Send out a given mail form

## Badges - remote integrations
[![Build Status](https://travis-ci.org/ottlinger/mailform.svg?branch=master)](https://travis-ci.org/ottlinger/mailform)

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/07b670b13aa944a789f40bbdf297b337)](https://www.codacy.com/app/github_25/mailform?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ottlinger/mailform&amp;utm_campaign=Badge_Grade)

[![Waffle.io - Columns and their card count](https://badge.waffle.io/ottlinger/mailform.svg?columns=all)](https://waffle.io/ottlinger/mailform)

## PHP project init
### PHP

Project requires at least PHP 7.2.

#### Ubuntu
Depending on your installation you may need to install a more recent PHP version,
as I had to do on Ubuntu 18.0.4 LTS:
https://tecadmin.net/install-php-7-on-ubuntu/

* Upgrade to PHP 7.2
```
sudo apt-get install -y php7.2
```
* Additional modules:
```
sudo apt install php7.2-xml php7.2-mbstring php7.2-mysql php7.2-intl php7.2-sqlite3 php-xdebug sqlite3
```
#### Mac
```
$ brew install php@7.2
```
In case you have older versions of PHP installed follow this cleanup procedure:
https://medium.com/@romaninsh/install-php-7-2-xdebug-on-macos-high-sierra-with-homebrew-july-2018-d7968fe7e8b8

If you have multiple PHP versions and need to switch per project you may need this:
```
$ brew install brew-php-switcher
```

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

https://phpunit.de/getting-started/phpunit-8.html

```
$ composer require --dev phpunit/phpunit ^8 (needs a modern PHP)
```

#### Templates

The mail form is based on
https://html5up.net/read-only/download
which is available under [Creative Commons Attribution 3.0 Unported
](./templates/LICENSE.txt)
