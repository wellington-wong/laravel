#!/bin/bash
ssh allyear3@hiv "mysqldump allyear3_live" | mysql -urewards -prewards -Drewards
mysqldump -urewards -prewards rewards users | sed -e 's/`users`/`rewards_users`/' > rewards_users.sql
mysqldump -urewards -prewards rewards referrals | sed -e 's/`referrals`/`rewards_referrals`/' > rewards_referrals.sql
mysql -uincentful -pincentful incentful < ./rewards_referrals.sql
mysql -uincentful -pincentful incentful < ./rewards_users.sql
