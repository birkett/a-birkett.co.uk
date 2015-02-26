#!/bin/sh

if [ -z $1 ]
then
    phpcs.phar -i
    exit
else
    standard=${1}
fi

if [ -z $2 ]
then
    phpversion=""
else
    phpversion='--runtime-set testVersion '${2}
fi

echo "Testing for standard ${standard}"
phpcs.phar --standard=${standard} ${phpversion} ../
