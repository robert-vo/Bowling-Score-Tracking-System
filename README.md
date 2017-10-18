# Bowling Score Tracking System [![Build Status](https://travis-ci.org/bglopez/Bowling-Score-Tracking-System.svg?branch=master)](https://travis-ci.org/bglopez/Bowling-Score-Tracking-System)

Database to collect scores, events, pin falls, players, balls used, etc. The reports could be various statistics about players such as single-pin spares left, strike percentage, split-conversion percentage, etc.)

Technologies used include:
* PHP/HTML/CSS/JS (front-end) 
* Amazon RDS MySQL (back-end)
* TravisCI (continuous integration)
* PhpUnit (testing framework)
* GitHub (version control)
* Trello (project management)
* GroupMe (team communication)
* SendGrid (email service)

## Running The Project
Before running this project locally, you will need PHP version 5.5, or higher, and a working MySQL environment. 

Using a MySQL client (MySQL Workbench, for example), execute the following four files, in order, found in the resources/ folder. Make sure you take note of your MySQL credentials, as it is necessary to run the project locally. 
* `mysql < archive_table.sql`
* `mysql < database_schema.sql`
* `mysql < database_triggers.sql`
* `mysql < insert_data.sql`

To run this project locally, click "Download ZIP" on the top right portion of this page. Extract the .zip file to a directory of choice. 

Once extracted, open up `databaseFunctions.php`, located in the `public_html` folder. On lines 14-17, please replace the current credentials with your local MySQL credentials.   

Next, instantiate a PHP server using, in command line or terminal,
` php -S localhost:xxxx `, where `xxxx` is a port of your choice.

If the command is successfully worked, it will display that it is listening on `http://localhost:xxxx`, and the document root is `$dir`. In a web browser, preferably Google Chrome, navigate to `http://localhost:xxxx/path/to/project/public_html/index.php`, where `path/to/project` is the path to the project relative to `$dir`. 

Once there, the welcome message, "Welcome to Bowling Score Tracking System!", should appear. Enjoy!

### Team 12 - Spring 2016
