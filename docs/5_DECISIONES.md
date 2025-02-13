# Estructura
He dividido el proyecto en 3 partes:
 - Shop: que contiene el comando de symfony para crear los orders
 - backend: donde está alojado el consumidor del proceso del order
 - shared: piezas varias compartidas en los dos bounded-context anteriores.
# Comandos
Suelo utilizar el comando MAKE de linux para automatizar ciertos procesos que
veo utiles en el desarrollo. En este [enlace](docs/4_MAKEFILE.md) hay más información al respecto de los comandos disponibles.
# Testing
Tenemos una parte de cobertura para Application y Domain del bounded context SHOP.
Si bien falta para la parte de backend y shared, podemos ver dicha información con el informe de cobertura
que se genera al ejecutar los test unitarios:

```
$ make run-tests

PHPUnit 11.5.7 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.4.1 with Xdebug 3.4.1
Configuration: /api/phpunit.xml.dist

.....                                                               5 / 5 (100%)

Time: 00:00.774, Memory: 192.00 MB

OK, but there were issues!
Tests: 5, Assertions: 6, PHPUnit Deprecations: 1.

Generating code coverage report in HTML format ... done [00:00.184]

```

El informe HTML de cobertura se puede encontrar en el directorio /var/cache/coverage.

# Creacion y procesado del ORDER
Debido a que la entidad ORDER tiene relacion con USER y PRODUCT, he decidido que en la
ejecucion del comando se evalue la existencia del user y del product. Si esto es correcto
entonces se crea en bbdd con el status PENDING, y se lanza el mensaje a rabbitmq. 

Cuando el consumer lee el mensaje, este se procesa evaluando si la cantidad de elementos 
del producto está disponible, cambiando el estado a REJECTED o APPROVED.

# Errores
pueden producirse varios errores en el proceso:
## En el productor:
 - evaluamos si el userId existe en bbdd. Sino lanzamos error y NO se genera el mensaje de rabbitmq.
 - evaluamos tambien el productID. si no existe avisamos y tampoco enviamos el mensaje.
## En el consumidor:
 - se comprueba que la cantidad del producto esta disponible. Si no es asi, se lanza error.

# Simulacion de proceso:
Hay un metodo en la clase **ProcessOrder** llamado *simulateTimeProcess()* que simula un tiempo de espera
aleatorio. No es util en el proyecto, solo detiene la ejecucion para simular.

# rabbitmq y failed-transport:
He querido probar el sistema de Messenger de symfony para la gestión de los mensajes. Y una de las 
cosas interesantes que se puede ver es que se puede generar una cola de mensajes `failed` directamente en bbdd.
Si bien suele implementarse en rabbitmq un proceso de dead-letters, me ha parecido más interesante este método,
puesto que los comandos de consola de **messenger** permiten gestionar (listar, procesar, eliminar) los mensajes
fallidos. 

Esto se puede ver en el archivo de configuracion **messenger.yaml** en el transport *failed*.
```
framework:
  messenger:
    failure_transport: failed
    transports:
      async:
        dsn: "%env(MESSENGER_TRANSPORT_DSN)%"
        ...
        ...
      failed: 'doctrine://default?queue_name=failed'  <--- failed.
```

