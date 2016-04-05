<?php namespace LeeSherwood\Ejabberd\CommandExecutors;

/**
 * Dummy command executor for ejabberd
 *
 * This class implements the command executor interface and just returns some sane boolean values.
 * You may want to use this class to test your ejabberd external authentication module is set up correctly
 * before you start creating your custom code.
 *
 * @package LeeSherwood\Ejabberd
 * @author Lee Sherwood <lee.sherwood@tbc-digital.com>
 */
class DummyCommandExecutor implements CommandExecutorInterface {

    /**
     * Authenticate a user (login)
     *
     * @param string $username
     * @param string $servername
     * @param string $password
     *
     * @return bool
     */
    public function authenticate($username, $servername, $password)
    {
        return true;
    }

    /**
     * Check if a user exists
     *
     * @param string $username
     * @param string $servername
     *
     * @return bool
     */
    public function userExists($username, $servername)
    {
        return true;
    }

    /**
     * Set a password for a user
     *
     * @param string $username
     * @param string $servername
     * @param string $password
     *
     * @return bool
     */
    public function setPassword($username, $servername, $password)
    {
        return false;
    }

    /**
     * Register a user
     *
     * @param string $username
     * @param string $servername
     * @param string $password
     *
     * @return bool
     */
    public function register($username, $servername, $password)
    {
        return false;
    }

    /**
     * Delete a user
     *
     * @param string $username
     * @param string $servername
     *
     * @return bool
     */
    public function removeUser($username, $servername)
    {
        return false;
    }

    /**
     * Delete a user with password validation
     *
     * @param string $username
     * @param string $servername
     * @param string $password
     *
     * @return bool
     */
    public function removeUserWithPassword($username, $servername, $password)
    {
        return false;
    }
}
