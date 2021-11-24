<?php

namespace Barberry;

class Pipe
{
    private $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

//--------------------------------------------------------------------------------------------------

    /**
     * @throws Pipe\Exception
     * @param null|string $binaryString to put into STDIN
     * @return string read from STDOUT
     */
    public function process($binaryString = null)
    {
        $pipes = null;
        $proc = proc_open(
            $this->command,
            [
                0 => ["pipe", 'r'], // stdin
                1 => ["pipe", "w"], // stdout
                2 => ["pipe", "w"] // stderr
            ],
            $pipes,
            null,
            null,
            ['binary_pipes' => true]
        );

        if (is_resource($proc)) {
            if (!is_null($binaryString)) {
                fwrite($pipes[0], $binaryString);
            }
            fclose($pipes[0]);

            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $error = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            proc_close($proc);

            if ($error && !strlen($output)) {
                throw new Pipe\Exception($error);
            }

            return $output;

        }

        throw new Pipe\Exception('Cannot proc_open(' . $this->command . ')');
    }
}
