# ใช้ base image ของ PHP + Apache
FROM php:7.4-apache

# ติดตั้ง PHP extensions ที่จำเป็น
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libmysqlclient-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd mysqli && \
    docker-php-ext-enable mysqli

# ตั้งค่าโฟลเดอร์ที่เก็บไฟล์ PHP
COPY . /var/www/html/

# เปิดใช้งาน mod_rewrite ของ Apache
RUN a2enmod rewrite

# ตั้งค่าภาษาและ timezone
RUN echo "date.timezone = Asia/Bangkok" >> /usr/local/etc/php/conf.d/docker-php.ini

# เปิดพอร์ต 80 สำหรับการเข้าถึงเว็บ
EXPOSE 80

# เริ่ม Apache เมื่อ container เปิด
CMD ["apache2-foreground"]
