####What is this?
An example implementation of the command collection feature.

####How to use this?
Copy the entire folder somewhere and don't forget to:
````
composer install
````

You can either configure ejabber.cfg to use external authentication, or just to see what's going on, i'd recommend using the PHP CLI.
To use the PHP CLI to see how it works, simply use the following command:
```
php EjabberdAuthenticationApplication.php
```

You can test by entering something like this:
```
00auth:lee:server:password
```

You should see the following output:
```
[2016-04-19 09:20:48] ejabberdAuth.DEBUG: Input detected, reading 12336 bytes... [] []
[2016-04-19 09:20:48] ejabberdAuth.DEBUG: Input read was: auth:lee:server:password  [] []
[2016-04-19 09:20:48] ejabberdAuth.INFO: Cmd-1: Running authenticate  [] []
[2016-04-19 09:20:48] ejabberdAuth.INFO: Cmd-2: Running authenticate  [] []
[2016-04-19 09:20:48] ejabberdAuth.INFO: Cmd-3: Running authenticate  [] []
```

Note how it checks each command in turn. This is because the collection is set to `REQUIRE_ALL`, setting it too `REQUIRE_ANY` changes the behaviour to return on the first successful command:
```
[2016-04-19 09:22:02] ejabberdAuth.DEBUG: Input detected, reading 12336 bytes... [] []
[2016-04-19 09:22:02] ejabberdAuth.DEBUG: Input read was: auth:lee:server:password  [] []
[2016-04-19 09:22:02] ejabberdAuth.INFO: Cmd-1: Running authenticate  [] []
```