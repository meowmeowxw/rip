# Ripperoni

Progetto di basi di dati 2022 gruppo 2092 giovanni.disanti@studio.unibo.it

## Run

### Dipendenze

```sh
docker run --rm \
      -v $(pwd):/opt \
      -w /opt \
      laravelsail/php81-composer:latest \
      composer install
```

o se si ha un ambiente di sviluppo PHP in locale

```
composer install
```

### Execute

```
cp .env.develop .env
./vendor/bin/sail up
./vendor/bin/sail php artisan key:generate
./vendor/bin/sail php artisan migrate:fresh # Crea migrazione (genera tabelle)
./vendor/bin/sail php artisan db:seed # Riempi tabelle
```

A volte capita che il container di mysql non sia raggiungibile con i permessi
giusti dal container di laravel (sembra non prenda le variabili d'ambiente nel
docker-compose.yml). Per sistemare:

```
docker exec -it <container id or container name di mysql> mysql
CREATE USER 'sail'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON *.* TO 'sail'@'%' WITH GRANT OPTION;
CREATE DATABASE example_app;
```

Per un'ambiente di sviluppo non siamo interessati a particolari misure di hardening
di sicurezza.

## Login

Seller login:

```
email: a@a.it
password: a
```

Customer login:

```
email: b@b.it
password: b
```


