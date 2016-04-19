<?php

use LeeSherwood\Ejabberd\CommandExecutors\CommandExecutorInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

/**
 * Echo command executor for ejabberd
 *
 * This is an example class to show how the command collection works and should
 * not be used in production (in fact it will probably break your ejabberd auth
 * mechanism as it echo's data out to the output stream).
 * It's intended to run manually via PHP CLI just to show you how it all works.
 *
 * @package LeeSherwood\Ejabberd
 * @author Lee Sherwood
 */
class EchoCommandExecutor implements CommandExecutorInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * Something to identify each instance
     *
     * @var string
     */
    protected $tag = 'Something';

    /**
     * Create an instance of our dummy echo command
     *
     * @param $tag
     */
    public function __construct($tag)
    {
        $this->tag = $tag;
    }

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
        $this->logger->info($this->tag.": Running authenticate".PHP_EOL);
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
        $this->logger->info($this->tag.": Running ".__FUNCTION__);
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
        $this->logger->info($this->tag.": Running ".__FUNCTION__);
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
        $this->logger->info($this->tag.": Running ".__FUNCTION__);
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
        $this->logger->info($this->tag.": Running ".__FUNCTION__);
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
        $this->logger->info($this->tag.": Running ".__FUNCTION__);
        return false;
    }
}
