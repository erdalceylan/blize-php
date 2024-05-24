## PHP Social Media and Chat APP - endpoint

### Run with Docker

create docker network 
```sh
docker network create --driver bridge blize-network
```

run for up project
```sh
docker-compose up -d
```

connect php container
```sh
ddocker exec -ti blize-php bash
```

create tabes
```sh
bin/console d:s:u --dump-sql
```

fill dummy users
```sh
bin/console doctrine:fixtures:load
```

fill dummy messages
```sh
bin/console fill:mongo-messages
```

fill dummy stories
```sh
bin/console fill:mongo-messages
```


Blize Social Media  Websocket [https://github.com/erdalceylan/blize-socket](https://github.com/erdalceylan/blize-socket)

Blize Social Media Angular frontend [https://github.com/erdalceylan/blize-angular](https://github.com/erdalceylan/blize-angular)


![](./public/images/blize_pages.jpg)
