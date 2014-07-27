<?php
/**
 * Created by PhpStorm.
 * User: ed8
 * Date: 7/27/14
 * Time: 12:02 PM
 */

class Utils {

    public function shell($command = null, $output = array(), $exitCode = null, $debug=true) {
        $command = $debug ? $command." 2>&1"  : $command;
        exec("$command", $output, $exitCode);
        foreach($output as $line) {
            echo $line;
        }
    }
} 