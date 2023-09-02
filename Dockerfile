
FROM php:8.1.21-apache

ENV REFRESH_DATE 5


#RUN echo "deb https://mirrors.aliyun.com/debian/ bookworm main non-free contrib" > /etc/apt/sources.list && \
#    echo "deb-src https://mirrors.aliyun.com/debian/ bookworm main non-free contrib " >> /etc/apt/sources.list  && \
#    echo "deb https://mirrors.aliyun.com/debian-security/ bookworm-security main " >> /etc/apt/sources.list && \
#    echo "deb-src https://mirrors.aliyun.com/debian-security/ bookworm-security main " >> /etc/apt/sources.list && \
#    echo "deb https://mirrors.aliyun.com/debian/ bookworm-updates main non-free contrib " >> /etc/apt/sources.list && \
#    echo "deb-src https://mirrors.aliyun.com/debian/ bookworm-updates main non-free contrib " >> /etc/apt/sources.list  && \
#    echo "deb https://mirrors.aliyun.com/debian/ bookworm-backports main non-free contrib " >> /etc/apt/sources.list  && \
#    echo "deb-src https://mirrors.aliyun.com/debian/ bookworm-backports main non-free contrib" >> /etc/apt/sources.list
#

RUN apt-get update
RUN apt-get install -y wget zip libzip-dev zlib1g-dev autoconf automake libtool
RUN apt-get install -y vim git

WORKDIR /home
# 安装 oniguruma
ENV ORIGURUMA_VERSION=6.9.8

RUN wget https://github.com/kkos/oniguruma/archive/v${ORIGURUMA_VERSION}.tar.gz -O oniguruma-${ORIGURUMA_VERSION}.tar.gz \
    && tar -zxvf oniguruma-${ORIGURUMA_VERSION}.tar.gz \
    && cd oniguruma-${ORIGURUMA_VERSION} \
    && ./autogen.sh \
    && ./configure \
    && make \
    && make install

# 安装必要的扩展
RUN docker-php-ext-install bcmath mbstring zip pdo_mysql
RUN pecl install redis \
    && docker-php-ext-enable redis

# protobuf
RUN pecl install protobuf && docker-php-ext-enable  protobuf


# 安装 protoc
ENV PRPTOTBUF_VERSION=21.10
RUN wget "https://github.com/protocolbuffers/protobuf/releases/download/v${PRPTOTBUF_VERSION}/protoc-${PRPTOTBUF_VERSION}-linux-x86_64.zip" && \
     unzip protoc-${PRPTOTBUF_VERSION}-linux-x86_64.zip && ls && cp bin/protoc /usr/bin/ && \
 protoc --version


RUN apt-get install -y zlib1g-dev libz-dev libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
        && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/  && \
    docker-php-ext-install gd &&  docker-php-ext-enable  gd


RUN docker-php-ext-install opcache &&  docker-php-ext-enable  opcache


# 安装composer
RUN wget https://mirrors.aliyun.com/composer/composer.phar \
	&& mv composer.phar /usr/local/bin/composer \
	&& chmod +x /usr/local/bin/composer && composer config -g repo.packagist composer https://mirrors.cloud.tencent.com/composer/
RUN a2enmod rewrite;
RUN apt install -y cron
#复制cron配置文件到crontab中
## Copy cron file to the cron.d directory
COPY crontab.bak /etc/cron.d/cronla
## Give execution rights on the cron job
RUN chmod 0644 /etc/cron.d/cronla

RUN crontab /etc/cron.d/cronla

RUN mkdir -p /var/log/cron

# xdebug
## RUN pecl install xdebug-3.2.0 && docker-php-ext-enable  xdebug

#RUN useradd php
COPY default.conf /etc/apache2/sites-enabled/000-default.conf
# RUN mkdir /home/php && chown php /home/php


WORKDIR /var/www/html

COPY . /var/www/html

RUN chmod 777 -R storage
RUN chmod 777 -R bootstrap

#USER php
RUN composer install

WORKDIR /var/www/html


RUN sed -i 's/^exec /service cron start \n\n exec /' /usr/local/bin/apache2-foreground


