#!/bin/sh

set -e

if [ -z $1 ]
then
  echo "Runs on a local machine, copies code to the remote machine, and executes the deployment script on the remote.";
  echo "Usage: $0 <hostname>";

  return;
fi

siteName="a-birkett.co.uk";
timestamp=`date -Iseconds`;
nginxConfigDir="etc/nginx/sites-available";
deployDirName=$siteName-$timestamp;

echo "Running linter..."
npm run lint

echo "Running tests..."
npm run test

echo "Copying code...";
scp -r ../dist/ $1:/var/www/$deployDirName;

echo "Copying nginx config...";
scp $nginxConfigDir/$siteName $1:/$nginxConfigDir/$siteName;

echo "Runing remote deploy script...";
ssh $1 <<REMOTESCRIPT
  cd /var/www;
  echo "Removing symlink...";
  rm -v $siteName;
  echo "Creating new symlink...";
  ln -sv $deployDirName $siteName;
  echo "Removing old deployments...";
  ls | grep $siteName | sed '1d;\$d' | xargs rm -rv;
  echo "Restarting nginx...";
  sudo systemctl restart nginx;
REMOTESCRIPT

echo "Deployed $deployDirName";
