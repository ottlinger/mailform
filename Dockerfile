# https://hub.docker.com/_/php/
FROM php:8.2-cli
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
CMD [ "php", "./templates/index.php" ]
#
# https://gist.github.com/Tazeg/a49695c24b97ca879d4b6806a206981e
# docker build - < Dockerfile
# docker run - start app
# docker-compose up later

