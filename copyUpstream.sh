#!/bin/bash
echo "Will upload stuff from current directory to hoster ..... "
scp -O -r * 34021f23452@hugo-hirsch.de:~/htdocs/a_mailform/

echo "DATA SYNC finished"
echo "In case you need to sync config changes continue or press Ctrl-C to abort."
scp -O ../mailform-config-live.php 34021f23452@hugo-hirsch.de:~/htdocs/a_mailform/config/mailform-config.php
