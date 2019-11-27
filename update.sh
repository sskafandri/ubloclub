#!/bin/bash

LOG=/home2/ublo/public_html/ublo.log

VERSION=$(cat /home2/ublo/public_html/version.txt)

echo "Ublo.Club - Update Script v"$VERSION

# set git repo
# git remote set-url origin https://github.com/whittinghamj/slistream_cms_production.git

# bash git update script
cd /home2/ublo/public_html >> $LOG
git reset --hard -q origin/master >> $LOG

find . -type d -print0 | xargs -0 chmod 0755
find . -type f -print0 | xargs -0 chmod 0644

echo "Update Complete"
echo " "
