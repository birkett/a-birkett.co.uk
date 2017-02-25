#!/bin/sh

buildPublic='../build_output/public_html/'
buildPrivate='../build_output/private/'

if [ "$1" == "clean" ]
then
    echo "Removing generated files..."
    rm -rf ../build_output/
    exit
fi

echo "Creating Directories..."
mkdir -p $buildPublic
mkdir -p $buildPrivate

echo "Copying public Content..."
cp -R ../public/* $buildPublic

./compilesass.sh
./compilejs.sh

echo "Copying private Content..."
cp -R ../private/* $buildPrivate

echo "Copying Framework..."
mkdir -p ${buildPrivate}/ABFramework
cp -R ../thirdparty/ABFramework/admin ${buildPrivate}/ABFramework/
cp -R ../thirdparty/ABFramework/classes ${buildPrivate}/ABFramework/
cp -R ../thirdparty/ABFramework/controllers ${buildPrivate}/ABFramework/
cp -R ../thirdparty/ABFramework/models ${buildPrivate}/ABFramework/
