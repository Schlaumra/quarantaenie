install:
	cp -R source/* /var/www/html
	mkdir -p /etc/quarantaenie
	chown -R www-data:www-data /etc/quarantaenie/
