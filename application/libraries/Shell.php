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
        $_ = "( TERM=screen-256color $_ )";
        $_ = $debug ? $_." 2>&1"  : $_;
        # we wrap the commands in a subshell so all stdout is piped to aha
        exec("$_ | aha --no-header", $output, $exitCode);
        return $output;
    }

    /**
     * Serialize to string a captured command
     * @param null $_
     */
    public static function toString($_ = null) {
        if (is_array($_ )) {
            foreach($_ as $k => $line) {
                echo $line.'<br/>';
            }
        } else {
            var_dump($_);
            show_error('Invalid command output in '.basename(__FILE__), 500);
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

    public static function list_channels($_) {
        $output = self::execute(sprintf("%s %s NAME=%s", MAST_UTILS, "list-channels", $_));
        return $output;
    }

}
