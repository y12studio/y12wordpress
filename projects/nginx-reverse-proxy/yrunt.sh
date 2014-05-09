#!/bin/bash
VALUE=$(cat)
echo "save Grungfile.js"
echo "$VALUE" > /root/Gruntfile.js
if [ "$1" != "" ]; then
echo "run grunt $1"
cd /root
/usr/bin/grunt $1
fi
if [ -f /root/Gruntfile.js ]; then
echo "start nginx.."
/usr/sbin/nginx
fi

