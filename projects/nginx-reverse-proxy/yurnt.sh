#!/bin/bash
VALUE=$(cat)
echo "$VALUE" > /root/Gruntfile.js
# pwd
cd /root
/usr/bin/grunt $1
