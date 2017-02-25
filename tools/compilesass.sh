#!/bin/sh

buildPublic='../build_output/public_html/'

if [ "$1" == "clean" ]
then
    echo "Removing generated files..."
    rm -rf ${buildPublic}a-birkett.co.uk/css
    rm -rf ${buildPublic}a-birkett.co.uk/admin/css
    exit
fi

outstyle='compressed'
includes='../sass'

echo "Building stylesheets..."
mkdir -p ${buildPublic}a-birkett.co.uk/css/
mkdir -p ${buildPublic}a-birkett.co.uk/admin/css/

pscss -i=${includes} -f=${outstyle} ../sass/main.scss > ${buildPublic}a-birkett.co.uk/css/main.css
pscss -i=${includes} -f=${outstyle} ../sass/christmas.scss > ${buildPublic}a-birkett.co.uk/christmas.css
pscss -i=${includes} -f=${outstyle} ../sass/admin.scss > ${buildPublic}a-birkett.co.uk/admin/admin.css
