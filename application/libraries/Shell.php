<?php
/**
 * User: ed8
 * Date: 7/27/14
 */

class Shell {

    /**
     * Execute a shell command and capture its output
     * @param null $_   shell command
     * @param bool $debug
     * @return mixed
     */
    public static function execute($_ = null, $debug=true) {
        $_ = $debug ? $_." 2>&1"  : $_;
        exec("TERM=screen-256color $_ | aha --word-wrap --no-header", $output, $exitCode);
        return $output;
    }

    /**
     * Serialize to string a captured command
     * @param null $_
     */
    public static function toString($_ = null) {
        if (is_array($_ )) {
            foreach($_ as $k => $line) {
                if ($line == '1') { continue; }
                echo "$line";
            }
            echo '<br/>';
        } else {
            var_dump($_);
            show_error('Invalid command output', 500);
        }
    }

    /**
     * Shortcut to execute and serialize
     * @param $_    shell command
     * @return mixed
     */
    public function run($_) {
        $ouput = self::execute($_);
        return self::toString($ouput);
    }
}
