#!/usr/bin/env bash

    sed '1d' table_city |
    cut -d ' ' -f3,5- | sort | uniq -c | 
    sort -r |
    awk '{$1=$1};1' | 
    head -n3
