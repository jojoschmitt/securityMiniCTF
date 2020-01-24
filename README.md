General usage:
sudo ./docker_handler.sh

For manual usage see docker commands below.


We are using docker and docker-compose to run our Apache2 webserver including Php and  a MySQL database.

A simple bash script "docker_handler.sh" allows to run the whole server cycle (See the script for further information).

Useful docker commands:
    Start services:
        sudo docker-compose up  [-d detached]

    Stop services:
        sudo docker-compose down

    View running container:
        sudo docker ps

    Enter shell from container:
        sudo docker exec -it CONTAINER_ID /bin/bash

    Copy files from a docker container to local:
        sudo docker cp [OPTIONS] CONTAINER:SRC_PATH DEST_PATH

    Copy files from local to docker container:
        sudo docker cp [OPTIONS] SRC_PATH|- CONTAINER:DEST_PATH
        
        
        
The database:
    Persistent database parts:
        - database miniCTF
        - table users
        - user admin
    To accomplish this, these parts are stored on the host machine in "webserver/database/clean_backup". The currently active container files can be found in "webserver/database/live".
    
