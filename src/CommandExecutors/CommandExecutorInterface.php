<?php namespace Tbcdigital\Ejabberd\CommandExecutors;

/**
 * Implement this interface to support ejabberd external authentication
 *
 * This interface defines all methodssupported by ejabberd external authentication module.
 * Each method accepts up to 3 common parameters which are:
 *  - username: The users login username determined by everything before the @ symbol in the jabber ID
 *  - servername: The server/host name of the xmpp service, this is everything between the @ symbol and the / symbol, or EOL if no / symbol.
 *  - password: The user supplied password
 *
 * All methods should return a boolean which is passed directly back to ejabberd to indicate success or failure. Any non-boolean
 * returns will be casted to boolean to avoid issues with communicating with the ejabberd service, however this
 * may cause hard to debug issues. It is up to you as the interface implementor to validate the return values if you require a
 * more strict control on return values (i.e. you may wish to implement a common return method)
 *
 * @package Tbcdigital\Ejabberd
 * @author Lee Sherwood <lee.sherwood@tbc-digital.com>
 */
interface CommandExecutorInterface {

    /**
     * Authenticate a user (login)
     *
     * @param string $username
     * @param string $servername
     * @param string $password
     *
     * @return bool
     */
    public function authenticate($username, $servername, $password);


    /**
     * Check if a user exists
     *
     * @param string $username
     * @param string $servername
     *
     * @return bool
     */
    public function userExists($username, $servername);


    /**
     * Set a password for a user
     *
     * @param string $username
     * @param string $servername
     * @param string $password
     *
     * @return bool
     */
    public function setPassword($username, $servername, $password);


    /**
     * Register a user
     *
     * @param string $username
     * @param string $servername
     * @param string $password
     *
     * @return bool
     */
    public function register($username, $servername, $password);


    /**
     * Delete a user
     *
     * @param string $username
     * @param string $servername
     *
     * @return bool
     */
    public function removeUser($username, $servername);


    /**
     * Delete a user with password validation
     *
     * @param string $username
     * @param string $servername
     * @param string $password
     *
     * @return bool
     */
    public function removeUserWithPassword($username, $servername, $password);

}
