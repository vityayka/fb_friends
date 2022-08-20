# INSTALLATION

0. Add your DB credentials to docker-compose.yml

1. Run `docker-compose build`

2. `docker-compose up -d`

# USAGE

1. `docker exec -it fb_friends_php /bin/bash`

# Inside the container: 

2. `cd /opt/fb_friends`; 
3. `composer install`; 
4. `php console.php findFbPath {user1} {user2}`