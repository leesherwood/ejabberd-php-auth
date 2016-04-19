####What is this?
An example implementation of the ejabberd php auth library.

####How to use this?
Copy the entire folder somewhere and don't forget to:
````
composer install
````
You will need to configure ejabber.cfg to use external authentication (see main README). Here's a command for linux users that you might find useful here:
````
watch -n 1 tail -n 50 /var/log/syslog
````
That will allow you to monitor the debug output based on the example's logger setup.

####This documentation is ^$*!
Yep, i know. Feel free to do a PR :)