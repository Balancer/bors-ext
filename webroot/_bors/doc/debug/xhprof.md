xhprof
======

### Установка

	sudo apt-cache search xhprof
	composer require facebook/xhprof=*

### /etc/nginx/...

    location /xhprof/ {
        alias /path/to/composer/vendor/facebook/xhprof/xhprof_html/;
        index index.php;
        error_log /var/log/nginx/xhprof-error.log;

        location ~ \.php$ {
            fastcgi_pass   unix:/var/run/php-fpm/aviaport.ru.sock;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include fastcgi_params;
        }
    }
