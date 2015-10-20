<?php
    exec("bash -c 'exec nohup setsid ./senddata.py 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 255 -f 180000 > /dev/null 2>&1 &'");
    // Add to this after completion to set it to zero
    // exec('bash -c "exec nohup setsid ./warmup.py > /dev/null 2>&1 &"');
    // using this command so that we do not wait up for it to finish
    // SRC:http://stackoverflow.com/questions/3819398/php-exec-command-or-similar-to-not-wait-for-result
    echo('OK');
?>
