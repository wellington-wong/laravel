#!/bin/bash
ssh perxi@hiv "mysqldump perxi_main --lock-tables=false " | mysql -uperxi_main -pTwk9128OrsSHXFkLF3 -Dperxi_main
rsync -u perxi@hiv:~/site/public/company-logos/ /var/www/incentful/public/company-logos/

