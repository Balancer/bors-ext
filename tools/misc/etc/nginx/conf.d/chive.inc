# chive nginx rewrite rules
location /chive {
	auth_basic "Chive";
	auth_basic_user_file /var/www/.htpasswd;

	try_files $uri $uri/ /chive/index.php;
}

location ~ ^/chive/(protected|framework|themes/\w+/views) {
	deny  all;
}
