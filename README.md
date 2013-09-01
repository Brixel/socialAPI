socialAPI
=========

A demo of a RESTful API in combination with a messagewall

Install
=========

Create a database called socialAPI and dump the contents of socialAPI.sql in that database.
Deploy the files in a webaccessible folder (e.g. /var/www/ in Linux-filesystems)
Check your databasesettings in classes/Database.class.php

Don't forget to switch of the "development"-flag when you go live.

Usage
=========

GET /
Returns "Hello world"

GET /messages
Returns all messages in the database

GET /message/<messageid>
Returns the message with the messageid (ID-field in table "messages")

POST /message/new
Creates a new message. Takes "content", "userid", "title" as POST-values

GET /user/<userid>
Returns the user with the userID (ID-field in table "users")

