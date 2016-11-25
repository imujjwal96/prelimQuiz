This file will contain installation steps.


## For later references

#### NGINX setup: <a name="nginx-setup"></a>
 
```
server {
    # your listening port
    listen 80;

    # your server name
    server_name example.com;

    # your path to access log files
    access_log /srv/www/example.com/logs/access.log;
    error_log /srv/www/example.com/logs/error.log;

    # your root
    root /srv/www/example.com/public_html;

    # huge
    index index.php;

    # huge
    location / {
        try_files $uri /index.php?url=$uri&$args;
    }

    # your PHP config
    location ~ \.php$ {
        try_files $uri  = 401;
        include /etc/nginx/fastcgi_params;
        fastcgi_pass unix:/var/run/php-fastcgi/php-fastcgi.socket;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```
