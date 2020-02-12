#!/bin/env bash

pattern='^[[:digit:]]+$'
if ! [[ $1 =~ $pattern ]] || ! [[ $2 =~ $pattern ]] ; then
   echo "Ошибка: Параметр не является числом"
    exit 1
fi

let "c = $1 + $2"
echo $c
