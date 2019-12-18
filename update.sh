#!/bin/bash

LOG=/home/ublo/public_html/ublo.log

VERSION=$(cat /home/ublo/public_html/version.txt)

echo "Ublo.Club - Update Script v"$VERSION

# bash git update script
cd /home/ublo/public_html >> $LOG

git pull >> $LOG

echo "Update Complete"
echo " "
