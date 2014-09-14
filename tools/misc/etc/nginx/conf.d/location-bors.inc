index           index.html index.xml index.php;

location @bors {
    include /etc/nginx/fastcgi_params;
    fastcgi_param SCRIPT_FILENAME $bors_loader;
    fastcgi_pass $php_sock;
    log_not_found off;
}

if ($args = 'nc') {
    rewrite ^(.*)$ /_bors/nc$1;
}

if ($args = 'cdrop') {
    rewrite ^(.*)$ /_bors/nc$1;
}

location /_bors/nc/ {
    error_page 418 = @bors;
    return 418;
}

try_files \
    /cache-static/$uri \
    /cache-static/$uri/index.html \
    /cache-static/$uri/index.xml \
    $uri $uri/index.html $uri/index.xml @bors;
