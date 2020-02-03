# A mini security CTF challange focusing SQLi

**WARNING**:
If you would like to solve this challange for your own, be sure **not** to take a **look** into the **private folder**. The private folder contains the whole server setup as well as a possible solution to the challange which would obviously spoil the party.

## General usage:
1. sudo docker-compose build
2. sudo ./docker_handler.sh
    
    
For manual usage see docker commands below.


**Web and database access**:

Website: http://localhost:8080

Database management: http://localhost:8088

    
We are using docker and docker-compose to run our Apache2 webserver including Php and  a MySQL database.

A simple bash script "docker_handler.sh" allows to run the whole server cycle (See the script for further information).

*Handy information*: A shell script can also be run in detached mode using screen (apt install screen).


## Useful docker commands:
Start services:

```
sudo docker-compose up  [-d detached]
```

Stop services:
```
sudo docker-compose down
```

View running container:
```
sudo docker ps
```

Build docker image:
```
sudo docker build -t  IMAGE_NAME
```

Remove docker image (-f to force):
```
sudo docker rmi IMAGE_NAME
```

Enter shell from container:
```
sudo docker exec -it CONTAINER_ID /bin/bash
```

Copy files from a docker container to local:
```
sudo docker cp [OPTIONS] CONTAINER:SRC_PATH DEST_PATH
```

Copy files from local to docker container:
```
sudo docker cp [OPTIONS] SRC_PATH|- CONTAINER:DEST_PATH
```


## Useful screen commands:
Start a new shell:
```
screen -S SESSION_NAME
```

Detach shell:
```
Ctrl+A+D
```

List running shells:
```
screen -ls
```

Reattach shell:
```
screen -r SESSION_NAME
```     
        
        
## The database:
Persistent database parts:
- database: miniCTF
- table: users
- user: admin

To accomplish this, these parts are stored on the host machine in "webserver/database/clean_backup". The currently active container files can be found in "webserver/database/live".
    
