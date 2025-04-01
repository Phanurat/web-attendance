# ใช้ official PHP image ที่มี Apache และ PHP ติดตั้ง
FROM php:7.4-apache

# ติดตั้งส่วนขยาย PHP ที่จำเป็น
RUN docker-php-ext-install mysqli pdo pdo_mysql

# ตั้งค่า DocumentRoot ให้ชี้ไปที่โฟลเดอร์ /var/www/html
ENV APACHE_DOCUMENT_ROOT /var/www/html

# ก๊อปปี้ไฟล์ทั้งหมดจากโฟลเดอร์ปัจจุบันไปที่ /var/www/html
COPY . /var/www/html/

# เปิดใช้ mod_rewrite ของ Apache (บางฟังก์ชันอาจต้องใช้)
RUN a2enmod rewrite

# กำหนดสิทธิ์การเข้าถึงไฟล์
RUN chown -R www-data:www-data /var/www/html

# เปิดพอร์ต 80 ของ container
EXPOSE 80
