#!/bin/sh
date > /tmp/boottime.txt
if [ ! -f /mnt/hhvm/wp-config.php ]; then
WORDPRESS_DB="wordpress"
MYSQL_PASSWORD=`pwgen -c -n -1 12`
WORDPRESS_PASSWORD=`pwgen -c -n -1 12`
#This is so the passwords show up in logs. 
echo mysql root password: $MYSQL_PASSWORD
echo wordpress password: $WORDPRESS_PASSWORD
echo $MYSQL_PASSWORD > /mysql-pw.txt
echo $WORDPRESS_PASSWORD > /wordpress-pw.txt
sed -e "s/database_name_here/$WORDPRESS_DB/
s/username_here/$WORDPRESS_DB/
s/password_here/$WORDPRESS_PASSWORD/
/'AUTH_KEY'/s/put your unique phrase here/`pwgen -c -n -1 65`/
/'SECURE_AUTH_KEY'/s/put your unique phrase here/`pwgen -c -n -1 65`/
/'LOGGED_IN_KEY'/s/put your unique phrase here/`pwgen -c -n -1 65`/
/'NONCE_KEY'/s/put your unique phrase here/`pwgen -c -n -1 65`/
/'AUTH_SALT'/s/put your unique phrase here/`pwgen -c -n -1 65`/
/'SECURE_AUTH_SALT'/s/put your unique phrase here/`pwgen -c -n -1 65`/
/'LOGGED_IN_SALT'/s/put your unique phrase here/`pwgen -c -n -1 65`/
/'NONCE_SALT'/s/put your unique phrase here/`pwgen -c -n -1 65`/" /mnt/hhvm/wp-config-sample.php > /mnt/hhvm/wp-config.php

# zh_TW version
sed -i "s/'WPLANG', ''/'WPLANG', 'zh_TW'/g" /mnt/hhvm/wp-config.php 

#
DB_HOST='getenv("DB_1_PORT_3306_TCP_ADDR") . ":" . getenv("DB_1_PORT_3306_TCP_PORT")'
sed -i "s/'DB_HOST', 'localhost'/'DB_HOST', $DB_HOST/g" /mnt/hhvm/wp-config.php 

# set permissions for plugin installation without ftp/ftps
chmod -R 777 /mnt/hhvm/wp-content 
sed -i "s/define('WP_DEBUG.*/define('FS_METHOD','direct');\ndefine('FS_CHMOD_DIR', 0777);\ndefine('FS_CHMOD_FILE', 0777);\n&/" /mnt/hhvm/wp-config.php

chown -R www-data:www-data /mnt/hhvm
fi