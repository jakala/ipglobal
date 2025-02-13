# Requisitos
 - git
 - docker / docker-compose (o plugin compose)
# Instalacion:
## clonacion el repositorio
 - git clone del repositorio:
```
git clone https://github.com/jakala/ipglobal.git
```
 - instalacion de vendors:
```
composer install --ignore-platform-reqs
```
## crear infraestructura docker
 - docker compose up -d --build

Este comando ejecuta la creacion de los contenedores:
 - ipglobal-server: la aplicacion (donde ejecutaremos el comando de consola)
 - ipglobal-consumer: un contenedor con el comando *messenger:consume async* ejecutandose
 - db: base de datos local
 - rabbitmq: el servidor rabbitmq (user:guest, pass:guest)

## crear bbdd y poblar datos
 - **make init-database**: se encarga de crear el schema y unos datos iniciales de prueba
