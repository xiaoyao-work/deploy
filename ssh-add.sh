#!/usr/bin/expect -f
spawn ssh-add /home/xiaoyao/.ssh/id_rsa
expect "Enter passphrase for /home/xiaoyao/.ssh/id_rsa:"
send "19910409\n";
interact