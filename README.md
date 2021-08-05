# Simulations Site

## Installing Xampp

[Downaload link](https://www.apachefriends.org/download.html)
Run the program with `chmod +x filename.run` and `./filename.run`.

The folder will be in `/opt/lampp/htdocs`.
Replace the file index.html with you `index.php` file.

## MySQL database

After you run the server, you can type `localhost/phpmyadmin` and you'll see the databases.
Open a new database called `simultaiondb` and try to create a table called `test`.
Go to `User accounts` and create a new user with user name `elad` and password `Aa123456`. (Those fields are in `dbex/db_connect.php`)

## Server files

In the main folder (simulations-site) there are the regular php files.
In `dbex/` there are the php files for internal usage.
In `images/` there are the cat and the drone images.
In `javascript/` there are the javascript files.
`favicon.ico` - Logo of the site.
`filters_config.txt` - The configuration of what is good simulation and what is bad.
`style.css` - The styles of html elements.
`table.csv` - Updated every time a user gets in the site.
