# mailform
Send out a given mail via a web form.

Allows sending mails to a configured and given mail address.

## Badges - remote integrations

[![Build Status](https://travis-ci.org/ottlinger/mailform.svg?branch=master)](https://travis-ci.org/ottlinger/mailform)

[![codecov](https://codecov.io/gh/ottlinger/mailform/branch/master/graph/badge.svg)](https://codecov.io/gh/ottlinger/mailform)

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/07b670b13aa944a789f40bbdf297b337)](https://www.codacy.com/app/github_25/mailform?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ottlinger/mailform&amp;utm_campaign=Badge_Grade)

[![Waffle.io - Columns and their card count](https://badge.waffle.io/ottlinger/mailform.svg?columns=all)](https://waffle.io/ottlinger/mailform)

[![Apache v2.0](https://img.shields.io/github/license/ottlinger/mailform.svg)](https://www.apache.org/licenses/LICENSE-2.0.html)

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

#### PHPMailer integration

In order to integrate PHPMailer you may want to run:
```
$ composer require phpmailer/phpmailer
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
....
mailform_mariadb_1 is up-to-date
Recreating mailform_php-apache_1 ... done
Attaching to mailform_mariadb_1, mailform_php-apache_1
```
you are ready to visit http://localhost:8888
to see the application up and running.

In case you need to tweak PHP settings:
http://localhost:8888/phpinfo.php
might be of use - please remove this file in production deployments!

* https://linuxconfig.org/how-to-create-a-docker-based-lamp-stack-using-docker-compose-on-ubuntu-18-04-bionic-beaver-linux
* https://hub.docker.com/_/php
* https://docs.docker.com/install/linux/docker-ce/ubuntu/

HINT! Even if you enable mail sending this will not work from within the container - you need to deploy the application first :-)
