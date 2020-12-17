#!/bin/bash
bitrix=$(ps -axu|pgrep -f daemon-bitrix-new.php)
getresponse=$(ps -axu|pgrep -f deamon-getresponse-new.php) 
email=$(ps -axu|pgrep -f daemon-email-new.php) 
facebook=$(ps -axu|pgrep -f daemon-bitrix-fb.php) 
repeatedemail=$(ps -axu|pgrep -f daemon-repeatedemail.php) 
ege=$(ps -axu|pgrep -f daemon-bitrix-ege.php) 
dbclear=$(ps -axu|pgrep -f daemon-clear_db.php)
bitrixvk=$(ps -axu|pgrep -f daemon-bitrix-vk.php)


if [[ ! $bitrix ]]
then
	php -q /var/www/syn.su/public/worker/daemon-bitrix-new.php
fi

if [[ ! $bitrixvk ]]
then
	php -q /var/www/syn.su/public/worker/daemon-bitrix-vk.php
fi

if [[ ! $facebook ]]
then
        php -q /var/www/syn.su/public/worker/daemon-bitrix-fb.php
fi

if [[ ! $getresponse ]] 
then
	php -q /var/www/syn.su/public/worker/daemon-getresponse-new.php
fi 

if [[ ! $email ]] 
then
    php -q /var/www/syn.su/public/worker/daemon-email-new.php
fi

if [[ ! $repeatedemail ]] 
then
    php -q /var/www/syn.su/public/worker/daemon-repeatedemail.php
fi

if [[ ! $ege ]] 
then
    php -q /var/www/syn.su/public/worker/daemon-bitrix-ege.php
fi

if [[ ! $dbclear ]]
then
	php -q /var/www/syn.su/public/worker/daemon-clear_db.php
fi
