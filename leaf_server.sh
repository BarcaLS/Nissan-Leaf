#!/bin/bash
# leaf_server.sh
#
# Script which should be always run. It periodically checks if there're new logs from Leaf Spy.
# When there are new logs in "Logs_synced_with_LeafSpy" the script opens "leaf_server.php" to grab them and save to "logs" dir.
# Script should be run from cron, e.g. every 1 minute. It runs constantly, can't be run in multiple instances.
# You should add "#cron" at the end to allow detecting properly if the script is running already. Example:
# */1 * * * * /home/user/Leaf/leaf_server.sh >/dev/null 2>&1 #cron

############
# Settings #
############

LEAF_SERVER_URL="http://host.com/Leaf/leaf_server.php"
LOG_PATH="/home/user/Leaf/logs_synced_with_LeafSpy/LOG_FILES"
LOG_FILE_NAME="Log_DC413267_cf0c3.csv"
CURL="/usr/local/bin/curl"
DELETE_OLD_LOG="enable" # should I delete old, already parsed log? "enable" is normal and "disable" is for debugging purposes
PAUSE=60 # pause between checking logs (in seconds)

#############
# Main Part #
#############

while true; do

    # check if this script is currently running
    NUMBER_OF_THIS_SCRIPTS_RUNNING=`ps aux | grep leaf_server.sh | grep -v grep | grep -v cron | wc -l`

    if [ "$NUMBER_OF_THIS_SCRIPTS_RUNNING" -gt 2 ]; then
    	echo "This script is currently running. Exiting."; exit
    fi

    # get current date and time
    DATE=`date +%Y.%m.%d`
    TIME=`date +%H:%M:%S`

    # check if Leaf Spy sent us new logs
    if [ -f "$LOG_PATH/$LOG_FILE_NAME" ]; then
	echo "::: $DATE $TIME ::: New log arrived, parsing. :::"
	$CURL $LEAF_SERVER_URL
	if [ "$DELETE_OLD_LOG" == "enable" ]; then rm -f $LOG_PATH/$LOG_FILE_NAME; fi
    else
	echo "::: $DATE $TIME ::: No new log. :::"
    fi
    

    # pause
    sleep $PAUSE

done
