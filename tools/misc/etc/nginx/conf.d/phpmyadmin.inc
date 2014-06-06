location /phpmyadmin {

	auth_basic "phpMyAdmin";
	auth_basic_user_file /var/www/.htpasswd;

	root /usr/share/;
	index index.php index.html index.htm;
	location ~ ^/phpmyadmin/(.+\.php)$ {
		try_files $uri =404;
		root /usr/share/;
		fastcgi_pass unix:/var/run/php-fpm.sock;
		fastcgi_index index.php;
		fastcgi_param SCRIPT_FILENAME $request_filename;
		include /etc/nginx/fastcgi_params;
	}

	location ~* ^/phpmyadmin/(.+\.(jpg|jpeg|gif|css|png|js|ico|html|xml|txt))$ {
		root /usr/share/;
	}
}
