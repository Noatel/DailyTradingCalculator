#!/usr/bin/env bash
set -e

if [[ "${1#-}" != "$1" ]]; then
	set -- php-fpm "$@"
fi

docker_wait() {
  START=$(date +%s)
  echo "PHP | Scanning $1 on port $2..."
  while ! nc -z -v $1 $2;
    do
    if [[ $(($(date +%s) - $START)) -gt ${MAX_EXECUTION_TIME:=300} ]]; then
        echo "PHP | Service $1 on port $2 did not start or could not be reached within ${MAX_EXECUTION_TIME:=300} seconds. Aborting..."
        exit 1
    fi
    echo "PHP | Retry scanning $1 on port $2 in ${SCAN_INTERVAL:=2} seconds..."
    sleep ${SCAN_INTERVAL:=2}
  done
}

CONTAINER=${CONTAINER_TYPE=PHP}

echo "PHP | -------------------------"
echo "PHP | CONTAINER_TYPE: $CONTAINER"
echo "PHP | HOSTNAME: $HOSTNAME"
echo "PHP | APP_ENV: ${APP_ENV:=dev}"
echo "PHP | MYSQL HOST: ${MYSQL_HOST:=db}"
echo "PHP | PHP Version: $(php -r 'echo PHP_VERSION;')"
echo "PHP | -------------------------"

docker_wait ${MYSQL_HOST:=db} 3306

echo "PHP | Ready"
exec docker-php-entrypoint "$@"
