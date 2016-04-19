<?php namespace LeeSherwood\Ejabberd\CommandExecutors;

/**
 * Provides a proxy for running multiple command executors
 *
 * Create an instance of this class and push your command executor instances into it and it will
 * run all executors one by one allowing you to authenticate against multiple databases.
 *
 * @package LeeSherwood\Ejabberd
 * @author Lee Sherwood
 */
class CommandExecutorCollection implements CommandExecutorInterface
{
    const REQUIRE_ANY = 'AND';
    const REQUIRE_ALL = 'OR';

    /**
     * Requirement behaviour
     *
     * @var string
     */
    protected $require;

    /**
     * Command executors
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Create instance of command collection
     */
    public function construct()
    {
        $this->require = $this::REQUIRE_ANY;
    }

    /**
     * Set the requirement behaviour of the collection
     *
     * @param string $require
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setRequirement($require)
    {
        if (!in_array($require, [$this::REQUIRE_ANY, $this::REQUIRE_ALL])) {
            throw new \Exception('Invalid requirement');
        }

        $this->require = $require;
        return $this;
    }

    /**
     * Add a command executor
     *
     * @param CommandExecutorInterface $command
     *
     * @return $this
     */
    public function addCommand(CommandExecutorInterface $command)
    {
        $this->commands[] = $command;
        return $this;
    }

    /**
     * Process a command
     *
     * This method acts as a proxy for all the interface methods.
     * Use the $require parameter to configure whether the executors
     * require a consensus or not (basically AND vs OR)
     *
     * @param string $command
     * @param array $args
     *
     * @return bool
     *
     * @throws \Exception
     */
    protected function processCommand($command, $args)
    {
        // Ensure we have at least 1 cmd exe
        if (empty($this->commands)) {
            throw new \Exception('Command executor collection is empty');
        }

        $returnValues = [];

        // Execute each command and test the response
        foreach($this->commands as $index => $commandExe) {

            // Call the command on the executor
            $ret = (bool)call_user_func_array([$commandExe, $command], $args);

            // If it succeeds and REQUIRE_ANY, then we can pass back
            if (true === $ret && $this->require === $this::REQUIRE_ANY) {
                return true;
            }

            // If false and REQUIRE_ALL, then pass back false
            if (false === $ret && $this->require === $this::REQUIRE_ALL) {
                return false;
            }

            // Keep a log
            $returnValues[$index] = $ret;
        }

        // Since we require at least 1 cmd exe, this should never be reached,
        // but in the wonderful world of programming - i like fallbacks to be 100% sure
        return $this->require === $this::REQUIRE_ALL;
    }

    //-------------------------------------------------------------------------
    // Interface methods - proxies to the processCommand method
    //-------------------------------------------------------------------------

    public function authenticate($username, $servername, $password)
    {
        return $this->processCommand(__FUNCTION__, func_get_args());
    }

    public function userExists($username, $servername)
    {
        return $this->processCommand(__FUNCTION__, func_get_args());
    }

    public function setPassword($username, $servername, $password)
    {
        return $this->processCommand(__FUNCTION__, func_get_args());
    }

    public function register($username, $servername, $password)
    {
        return $this->processCommand(__FUNCTION__, func_get_args());
    }

    public function removeUser($username, $servername)
    {
        return $this->processCommand(__FUNCTION__, func_get_args());
    }

    public function removeUserWithPassword($username, $servername, $password)
    {
        return $this->processCommand(__FUNCTION__, func_get_args());
    }
}
