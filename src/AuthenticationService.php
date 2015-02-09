<?php namespace Tbcdigital\Ejabberd;

/**
 * Main application class
 *
 * @package Tbcdigital\Ejabberd
 * @author Lee Sherwood <lee.sherwood@tbc-digital.com>
 */
class AuthenticationService
{

    /**
     * The command+args from ejabberd passed to the application
     *
     * @var string
     */
    private $data = null;

    /**
     * Standard Input Stream
     *
     * @var resource
     */
    private $stdInput = null;

    /**
     * Standard Output Stream
     *
     * @var resource
     */
    private $stdOutput = null;

    /**
     * Somewhere to write the logs
     *
     * @var \Psr\Log\LoggerInterface
     */
    private $logger = null;

    /**
     * The command executor instance
     *
     * @var \Tbcdigital\Ejabberd\CommandExecutors\CommandExecutorInterface
     */
    private $executor = null;


    /**
     * Boot up the service ready for the run loop
     *
     * @param \Psr\Log\LoggerInterface|\Psr\Log\LoggerInterface $logger
     * @param \Tbcdigital\Ejabberd\CommandExecutors\CommandExecutorInterface $executor
     */
    public function __construct(\Psr\Log\LoggerInterface $logger, \Tbcdigital\Ejabberd\CommandExecutors\CommandExecutorInterface $executor)
    {

        $this->logger = $logger;
        $this->executor = $executor;
    }


    /**
     * Start's it up
     */
    public function run()
    {

        // Open resource streams ready
        if (null === $this->stdInput) {
            $this->bindResourceStreams();
        }

        // Clear everything just in case this is a second run
        $this->clear();

        // Start the run loop
        do {

            if (true === $this->checkInput()) {

                $result = $this->processCommand();

                $this->writeOutput($result);

                $this->clear();

            }

        } while (true);

    }



    /**
     * Open the standard input/output streams ready for read/write
     *
     * @return bool
     */
    private function bindResourceStreams()
    {

        $this->logger->debug("Binding Resource Streams...");

        if (false === ($this->stdInput = @fopen("php://stdin", "rb"))) {
            $this->logger->error("Failed to bind STDIN");
            return false;
        }

        if (false ===($this->stdOutput = @fopen("php://stdout", "wb"))) {
            $this->logger->error("Failed to bind STDOUT");
            return false;
        }

        $this->logger->debug("Resource streams STDIN and STDOUT bound successfully");

    }


    /**
     * Check to see if there is any data available, and read it if so
     *
     * @return bool True if there was data, False if not
     */
    private function checkInput()
    {

        // Get the first 3 bytes of input (the byte length identifier from ejabberd), this will block until something is available
        $input = @fgets($this->stdInput, 3);

        // Get the byte length as a decimal
        if (false === ($inputParsed = @unpack("n", $input)) || !is_array($inputParsed) || !isset($inputParsed[1])) {
            return false;
        }

        // This should never match, but just to be 100% sure
        if (0 >= ($readLength = intval($inputParsed[1]))) {
            return false;
        }

        // Read the data :]
        $this->logger->debug("Input detected, reading $readLength bytes...");
        $this->data = @fgets($this->stdInput, $readLength+1);
        $this->logger->debug("Input read was: ".$this->data);

        return true;

    }


    /**
     * Writes the output back to ejabberd
     *
     * @param bool $output
     */
    private function writeOutput($output)
    {

        $returnInt = true === boolval($output) ? 1 : 0;
        $out = @pack("nn", 2, $returnInt);

        if (false === @fwrite($this->stdOutput, $out)) {
            $this->logger->error("Failed to write output [$returnInt] to stdout");
        } else {
            $this->logger->debug("Successfully wrote output [$returnInt] to stdout");
        }

    }


    /**
     * Clears the class properties ready for the next command to come in
     */
    private function clear()
    {

        $this->logger->debug("Clearing previous command data");
        $this->data = null;

    }


    /**
     * Parses the command and routes it to the correct command executor method
     *
     * @return bool
     */
    private function processCommand()
    {

        if (empty($this->data)) {
            return false;
        }

        $parts = explode(':', $this->data);
        if (empty($parts) || !is_array($parts) || empty($parts[0])) {
            return false;
        }

        // All commands use the same ordering of vars
        $orderedVars = array("command", "username", "servername", "password");
        foreach ($orderedVars as $var) {
            $$var = !empty($parts) ? array_shift($parts) : "";
        }

        // Route the command
        switch ($command) {

            case 'auth':
                $result = $this->executor->authenticate($username, $servername, $password);
                break;

            case 'isuser':
                $result = $this->executor->userExists($username, $servername);
                break;

            case 'setpass':
                $result = $this->executor->setPassword($username, $servername, $password);
                break;

            case 'tryregister':
                $result = $this->executor->register($username, $servername, $password);
                break;

            case 'removeuser':
                $result = $this->executor->removeUser($username, $servername);
                break;

            case 'removeuser3':
                $result = $this->executor->removeUserWithPassword($username, $servername, $password);
                break;

            default:
                $result = false;

        }

        return $result;

    }

}
