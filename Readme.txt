On the server which runs the PHP the files needed are 'handler.php' and 'geoplugin.class.php'
In the file handler.php, on line 22 where there is this line of code 
"$send_to = 'ENTER EMAIL TO SEND TO';"
change ENTER EMAIL TO SEND TO to your desired email address, 
that is the email address where the details are sent.

On the server where the index.html is hosted, only the index.html file is needed. 
In the index page on line 766 is the URL where the data is being send to 
as per the current file its 'handler.php' change that to your URL.
Use an absolute URL eg http://example.com/handler.php

Also on this server is the file 'geoplugin.class.php' and in the same folder as handler.php

Open files using notepad++;


