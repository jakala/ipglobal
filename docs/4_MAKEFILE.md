# Makefile y comandos utiles
En mis proyectos utilizo el comando Make para automatizar ciertos procesos.
Estos comandos son accesibles mediante la consola, ejecutando:
```
make <target>
```
En este proyecto estan definidos los siguientes:
 - **help**                       muestra ayuda de comandos
 - **run-tests**                  ejecuta test de phpunit
 - **run-infection**              ejecuta test de infection
 - **check-style**                revisa formato PSR12 del proyecto
 - **fix-style**                  corrige automaticamente varios puntos de PSR12.
 - **metrics**                    generador de metricas del proyecto
 - **docker-admin**               consola para gestion de dockers
 - **top-modified**               muestra los 10 archivos mas modificados del proyecto
 - **init-database**              inicializa la bbdd ejecutando las migraciones
