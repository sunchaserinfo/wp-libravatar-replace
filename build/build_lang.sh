#!/bin/bash

cd `dirname ${BASH_SOURCE[0]}`
cd ../languages

for file in $(find -name \*.po); do
    msgfmt ${file} -o `echo ${file} | sed -e 's/\.po/.mo/'`
done
