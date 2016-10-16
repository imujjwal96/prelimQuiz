FROM centos:7

RUN yum update -y
RUN yum install -y epel-release
RUN rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
RUN yum install -y php56w php56w-opcache httpd php56w-pdo php56w-pecl-mongodb

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

RUN yum install -y php56w-mysqlnd

RUN sed -i -e 's/DocumentRoot \"\/var\/www\/html\"/DocumentRoot \"\/var\/www\/html\/public\"/g' /etc/httpd/conf/httpd.conf
RUN sed -i -e 's/AllowOverride None/AllowOverride All/g' /etc/httpd/conf/httpd.conf

EXPOSE 80
ENTRYPOINT ["httpd", "-D", "FOREGROUND"]
