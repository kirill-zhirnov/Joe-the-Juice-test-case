# How to launch locally?

The easiest way to start is by using Docker compose:

`docker compose up` - The service will be launched on port `8080` - it can be accessed by visiting [http://localhost:8080](http://localhost:8080)

## Running tests:

Connect to the launched docker container: `docker exec -it <container> /bin/sh` (Container Name or Id could be found 
by `docker ps` command).

After the connection to the container: `./vendor/bin/codecept run`

## Code Quality Tool:

Connect to the container, then: `./vendor/bin/phpcs --standard=PSR2 ./src`



