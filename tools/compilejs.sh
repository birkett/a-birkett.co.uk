#!/bin/sh

buildPublic='../build_output/public_html/'

if [ "$1" == "clean" ]
then
    echo "Removing generated files..."
	rm -rf ${buildPublic}a-birkett.co.uk/js
    exit
fi

echo "Building JavaScript..."
mkdir -p ${buildPublic}a-birkett.co.uk/js/

minifyjs ../js/ajax.js > ${buildPublic}a-birkett.co.uk/js/ajax.js
minifyjs ../js/postwidget.js > ${buildPublic}a-birkett.co.uk/js/postwidget.js
