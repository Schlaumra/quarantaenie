# Quarantänie
Linux-System:
```txt
root-password: Kennwort0

username: quarantine
password: Kennwort0
```

DB:
```txt
DB root: Kennwort0!
DB username: quarantine
DB password: Kennwort0!
```

## Installation

Run as Root (`su -` or `sudo`):
```bash
apt update
apt upgrade

apt install mariadb-server mariadb-client php7.4 php7.4-common php7.4-mysql apache2 phpmyadmin -y
```

> Don't configure automatically for a webserver just click enter
> Don't configure phpmyadmin just choose no

```bash
mysql_secure_installation
```

Steps:
```txt
Press enter

Switch to unix_socket authentication [Y/n] n
Answer no

Change the root password? [Y/n] y
Answer yes

Remove anonymous users? [Y/n] y
Enter root password

Disallow root login remotely? [Y/n] y
Answer yes

Remove test database and access to it? [Y/n] y
Answer yes

Reload privilege tables now? [Y/n] y
Answer yes
```

### Set up phpmyadmin:
```bash
cd /var/www/html
ln -s /usr/share/phpmyadmin phpmyadmin
```

### Set up DB:
```bash
cd /root/

git clone git@github.com:Schlaumra/quarantaenie.git

mysql -u root -p
```
> Enter password and then import the SQL file
```mysql
SOURCE '/root/quarantaenie/quarantaenie.sql'
```
### Set up application:
```bash
cd /root/quarantaenie

# Manual:
cp -R source/* /var/www/html  
mkdir -p /etc/quarantaenie

# Automatic
make install
```

## Change the credentials
- Open [bcrypt.online](https://bcrypt.online/)
- Enter desired password
- Cost Factor: 10
- Output example: `$2y$10$stSWUZUPYJm02/zoqLVqLeMn3cm.SnoLsTJE/Y.OXMdjvU5udABpK`
- Copy output into  `source/inc/db/QuarantaenieDB.php`
	- After the username (admin) replace the already existing hash with the new one