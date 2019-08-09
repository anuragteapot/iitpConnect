# docker-lamp

Docker with Apache, MySql 8.0, PhpMyAdmin and Php

Command to start
```
docker-compose up -d --build
```

Open phpmyadmin at [http://localhost:8000](http://localhost:8000)
Open web browser to look at a simple php example at [http://localhost:8001](http://localhost:8001)

Run mysql client:

- `docker-compose exec db mysql -u root -p` 

Enjoy !
