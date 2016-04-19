##Ejabberd External Authentication (PHP)

This library provides a convenient way to customise the ejabberd authentication module `extauth_program`. 

#### Installation (via composer)
Run this:
````
composer require leesherwood/ejabberd-php-auth:~1.0
````

or add this to your composer.json
````
"leesherwood/ejabberd-php-auth":"~1.0"
````

#### Installation (other)
Download a zip, copy and paste the raw files, whatever you like :]

###The Basics
This library implements a service and command pattern which acts as the interface between ejabberd and your custom auth solution. All you need to do is bootstrap the AuthenticationService (see examples) and create your CommandExecutor following the CommandExecutorInterface contract.

###Command Executors
This is what you create to implement your custom solution. You can have it connect to a database, look at a flat file such as a `.htpasswd`, send a request to another service, or pretty much anything else you can think of, this library simply provides the scaffolding.

###Command Executor Collections
This is a special command executor that allows you to register multiple command executors. It complies with the same interface as a normal command executor so you can layer these up as much as you need to (i.e. you can add an entire collection of commands to another collection).

Collections can be set to two requirements. 
 - `REQUIRE_ALL`: Is like an `AND`, all commands registers in that collection must return true for true to be the final output.
 - `REQUIRE_ANY`: Is like an `OR`, the first command that returns true will be accepted as the final output.

These can be mixed if layering up collections, so you could have a business requirement that a user exists in 1 of 3 databases, plus be in a whitelist txt file. You would have a database command collection set to `REQUIRE_ANY` (OR), and your main collection (where you add the single whitelist cmd + the database collection) set to `REQUIRE_ALL` (AND).
