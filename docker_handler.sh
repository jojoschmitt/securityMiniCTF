#! /bin/bash

#This bash script restarts the webserver every 15 minutes. This way it cares for a clean database.

set -o xtrace

while true; do
    docker rmf $(docker ps -a -q)
    docker volume rm $(docker volume ls -q)
    
    #copy clear database (only containing the admin as user)
    cp -r webserver/database/clean_backup/* webserver/database/live/
    
    docker-compose up & docker_compose_pid=$!
    
    sleep 900 #15 minutes
    
    kill -2 $docker_compose_pid
    wait $docker_compose_pid
done
