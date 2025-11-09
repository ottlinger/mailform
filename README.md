# mailform

Send out a given mail via a web form. A running live-demo is deployed at https://mailform.aiki-it.de

Allows sending mails to a configured and given mail address.

## Badges for GitHub integrations

[![GHA build status](https://github.com/ottlinger/mailform/actions/workflows/ci.yml/badge.svg?branch=master)](https://github.com/ottlinger/mailform/actions)

[![codecov](https://codecov.io/gh/ottlinger/mailform/branch/master/graph/badge.svg)](https://codecov.io/gh/ottlinger/mailform)

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/d46db8cba9d04a82940f955790ff6553)](https://app.codacy.com/gh/ottlinger/mailform/dashboard)

[![StyleCI](https://github.styleci.io/repos/172128768/shield?branch=master)](https://github.styleci.io/repos/172128768?branch=master)

[![Apache v2.0](https://img.shields.io/github/license/ottlinger/mailform.svg)](https://www.apache.org/licenses/LICENSE-2.0.html)

## PHP project init
### PHP

Project requires at least PHP 8.3 in order to run with PHPUnit 12.x.

### Running tests locally

In order to launch tests locally it may make sense to define the following alias:

```
alias phpunit='export export XDEBUG_MODE=coverage; ./vendor/bin/phpunit'
```

and run

```
$ phpunit
```

in the project's base directory.

#### Ubuntu
Depending on your installation you may need to install a more recent PHP version,
as I had to do on Ubuntu 18.0.4 LTS:
https://tecadmin.net/install-php-7-on-ubuntu/

* Upgrade to PHP 8.3
```
sudo apt-get install -y php8.3
```
* Additional modules:
```
sudo apt-get install -y php-curl php-xml php-mbstring php-mysql php-intl php-sqlite3 php-xdebug sqlite3
```
#### Mac
```
$ brew install php@8.3
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

Above example was performed with version 1.8.4.

### Project init

```
$ ./composer.phar init
$ ./composer.phar validate
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

https://phpunit.de/getting-started/phpunit-11.html

```
$ ./composer.phar require --dev phpunit/phpunit ^11
```

#### PHPMailer integration

In order to integrate PHPMailer you may want to run:
```
$ composer require phpmailer/phpmailer
```

#### PHP CodeSniffer integration

In order to verify your code structure, you may use the [PHP_CodeSniffer](https://github.com/PHPCSStandards/PHP_CodeSniffer/):
```
$ ./vendor/bin/phpcs -v ./src/
```

#### Templates

The mail form web template is based on [Html5UP ReadOnly](https://html5up.net/read-only/download)
which is available under [Creative Commons Attribution 3.0 Unported](./templates/LICENSE.txt)

#### Favicon

The used favicon [House](https://www.freefavicon.com/freefavicons/objects/iconinfo/house-152-237998.html) is taken from [FreeFavicon](http://www.freefavicon.com/blog/).

#### Application configuration

This application can be configured if used in you own context.
Please copy the given template [mailform-config.php.template](./config/mailform-config.php.template)
to [mailform-config.php](./config) in the config-directory.

#### Docker integration

With a more recent Docker setup you may simply run:
```
$ docker-compose up
```

If you see something like:
```
Recreating mailform_php-apache_1 ... done
Attaching to mailform_php-apache_1
....
```
you are ready to visit http://localhost:8888
to see the application up and running.

In case you need to tweak PHP settings:
http://localhost:8888/phpinfo.php
might be of use - please remove this file in production deployments!

##### Docker installation

In order to run the dockerized version on Ubuntu you may follow this installation instruction (please do not forget the postinstallation steps to be able to run as non-root).

* https://docs.docker.com/install/linux/docker-ce/ubuntu/ - preferred way on Ubuntu 18.04 as newer versions are supported
* https://linuxconfig.org/how-to-create-a-docker-based-lamp-stack-using-docker-compose-on-ubuntu-18-04-bionic-beaver-linux
* https://hub.docker.com/_/php

*HINT!* Even if you enable mail sending this will not work from within the container - you need to deploy the application first :-)
