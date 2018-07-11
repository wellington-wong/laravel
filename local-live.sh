#!/bin/bash
ssh perxi@hiv "mysqldump perxi_main --lock-tables=false " | mysql -uincentful -pincentful -Dincentful
rsync -u perxi@hiv:~/site/public/company-logos/ /var/www/incentful/public/company-logos/

