#!/bin/bash

#This bash script restarts the webserver every 15 minutes. This way it cares for a clean database and a clean service. Should one container crash unexpectedly, the webserver is restarted immediately.

set -o xtrace

while true; do
    docker rm -f $(docker ps -a -q)
    docker volume rm $(docker volume ls -q)
    
    #copy clear database (only containing the admin as user)
    cp -r private/webserver/database/clean_backup/* private/webserver/database/live/
    
    docker-compose up & docker_compose_pid=$!
    
    sleep 4
    #900 cycles each sleeps 1 equivalent* to sleep 900 0> 15min
    cycles=1
    while [ $cycles -le 900 ]
    do
        #get number of running container
        processes=$(docker ps -q)
        numProcesses=$(echo $processes|wc -w)
        #if not all containers are running anymore, restart early
        if [ $numProcesses -eq 3 ]
        then
            cycles=$(($cycles+1))
            sleep 1
        else
            break
        fi
    done

    
    

    kill -2 $docker_compose_pid
    wait $docker_compose_pid
done
