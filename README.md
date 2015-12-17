Backend for TAMS
====================================


How to install the Backend
--------------------------
This document goes over how we have set up the TAMS web application and API.


**Assumptions**

For a server set up, you can use this as a base, however, it might require a different approach unless you have complete control (i.e. you are root) on the server and can install all the dependencies, secure the machine, etc. So, use these instructions as a starting point rather than a definitive “this is the ultimate way” step-by-step guide.


**Download**
- Option 1: If you don’t have the version control system git you’ll need to install it. For Debian based system use: apt-get install git
- Option 2: Copy the contets of the "Backend" folder into the machine.



Install the Dependencies
------------------------
**We need the following bits and pieces**
- Apache with the fillowing modules enabled:
  - rewrite
  - headers
  - php
- PHP
  - Version >=5.5
- MySQL

**For Debian based machines run the following commands to install the requirements:**

```
sudo apt-get install apache2 php5 php5-cli mysql-server libmysqlclient15-dev php5-mysql
```
```
# Enable the apache modules
a2enmod php
a2enmod rewrite
a2enmod headers
service apache2 restart
```


**Moving the web application in the correct spot**
```
# For Debian
mv Backend/* /var/www       # This will overwrite anything in the www directory
```


MySQL
-----
We now need to create a database in MySQL and load the schema. We assume that you have MySQL running and that your MySQL super user is root and the account has a password.

Step one. Create the database. This is pretty simple:
```
mysqladmin -u root -p create tams
Enter password: ****
```

Step two. Import the schema:
```
mysql -u root -p tams < Backend/db/schema.sql
Enter password: ****
```


Configure the web application itself (If required)
--------------------------------------------------
Edit the file "config.php" which should now reside in "/var/www/config.php"

```
# For Debian Based systems
nano /var/www/config.php

# Change the data base configuration to suit your setup
```


Look at the result
------------------
You should now be able to view the results at your webserver URL

Hopefully, you should see a working version of TAMS but without any data in it. This is because we haven’t loaded anything into the database yet.
