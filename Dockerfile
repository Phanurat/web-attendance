# ใช้ PHP 7.4 Apache base image
FROM php:7.4-apache

# ติดตั้ง PHP extensions ที่ต้องการ
RUN docker-php-ext-install mysqli

# เปิดการใช้งาน mod_rewrite
RUN a2enmod rewrite

# กำหนดโฟลเดอร์การทำงาน
WORKDIR /var/www/html

# คัดลอกไฟล์ทั้งหมดจากเครื่องโฮสต์ไปยังคอนเทนเนอร์
COPY . /var/www/html/
