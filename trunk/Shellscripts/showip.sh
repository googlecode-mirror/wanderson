#!/bin/bash
### BEGIN INIT INFO
# Provides:          showip.sh
# Required-Start:    networking
# Required-Stop:
# Default-Start:     2 3 4 5
# Default-Stop:      0 1 6
# Short-Description: Show IP Address at Boot Time
### END INIT INFO

COUNTER=0
CURRENT_ADDR=''
MAX_ATTEMPTS=10

function getip() {
    CURRENT_ADDR=$(ifconfig eth0 | grep 'inet addr:' | sed 's/\s\+inet addr:\([^ ]\+\)  Bcast:.\+/\1/')
    COUNTER=$(($COUNTER + 1))
    return $([ -z $CURRENT_ADDR ] && [ $COUNTER -lt $MAX_ATTEMPTS ])
}

case "$1" in
    start)
        while getip; do
            sleep 1
        done
        if [ -z $CURRENT_ADDR ]; then
            CURRENT_ADDR='Unable to Show IP after' $COUNTER 'attempts'
        fi
        echo '-- Your IP is:' $CURRENT_ADDR
        ;;
esac
