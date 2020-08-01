#!/usr/bin/env bash

pattern='^[-+]?[0-9]+.?[0-9]*?$'

if ! [[ $1 ]] || ! [[ $2 ]] ; then
    echo "Ошибка: Обязательные параметры не были переданы"
    exit 1
fi

if ! [[ $1 =~ $pattern ]] || ! [[ $2 =~ $pattern ]] ; then
    echo "Ошибка: Параметр не является числом"
    exit 1
fi

echo $1 + $2 | bc

exit 0