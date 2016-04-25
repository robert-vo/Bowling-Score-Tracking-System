# Bowling Score Tracking System ![Image](https://travis-ci.com/robert-vo/Bowling-Score-Tracking-System.svg?token=MDyyKNy4sp8cUiysL5c6&branch=master)

Database to collect scores, events, pin falls, players, balls used, etc. The reports could be various statistics about players such as single-pin spares left, strike percentage, split-conversion percentage, etc.)

Website can be viewed [here](http://bowling-score-tracking-system.azurewebsites.net/public_html/index.php).

It can also be viewed through this link http://bowling-score-tracking-system.azurewebsites.net/public_html/index.php

Before running this project locally, you will need PHP version 5.5, or higher, and a working MySQL environment. 

Using a MySQL client (MySQL Workbench, for example), execute the following four files, in order, found in the resources/ folder.
* mysql < archive_table.sql
* mysql < database_schema.sql
* mysql < database_triggers.sql
* mysql < insert_data.sql
_
To run this project locally, click "Download ZIP" on the top right portion of this page. Extract the .zip file a directory of choice. Once extracted, instantiate a PHP server using, in command line or terminal - 
[code] php -S localhost:xxxx [/code]
If the command is successfully worked, it will display that it is listening on http://localhost:xxxx, and the document root is $dir. In a web browser of choice, navigate to http://localhost:xxxx/path/to/project/public_html/index.php and enjoy!

Team 12