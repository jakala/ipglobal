# Prueba tecnica IPGlobal
## Objetivo
Evaluar tus conocimientos y habilidades en la gestión de colas en Symfony
utilizando RabbitMQ, implementando un sistema de colas bidireccional para
procesar y gestionar respuestas, utilizando Docker para la configuración del entorno.
## Contexto del Ejercicio
Tienes que desarrollar una funcionalidad en una aplicación Symfony que gestione el
procesamiento de pedidos en una tienda en línea. Los pedidos deben ser enviados a
un sistema de procesamiento asíncrono mediante RabbitMQ, y una vez procesados,
se debe recibir una respuesta con el resultado del procesamiento. Este resultado
debe ser manejado y almacenado adecuadamente en la base de datos.
## Escenario
En cuanto un cliente realiza un pedido, éste debe ser enviado a una cola para su
procesamiento. El sistema de procesamiento puede tardar un tiempo variable en
completar el pedido (por ejemplo, verificar inventario, calcular envíos, etc.). Una vez
que el pedido ha sido procesado, se debe enviar una respuesta con el estado del
procesamiento (por ejemplo, aprobado, rechazado, pendiente).

Se controlará un stock de algún producto, simulando que lanzando X procesos en
paralelo, con un stock de X-Y, se devuelvan Y respuestas de “Ya no hay productos
disponibles”.
## Tareas
### Instalación y configuracion de RabbitMQ con Docker
 -  Crea un archivo docker-compose.yml que contenga los servicios
    necesarios para ejecutar RabbitMQ y la aplicación Symfony.
 - Asegúrate de que RabbitMQ esté configurado y accesible desde la
    aplicación Symfony.
### Creacion del Productor
 - docker-compose.yml que contenga los servicios
   necesarios para ejecutar RabbitMQ y la aplicación Symfony.
   o Asegúrate de que RabbitMQ esté configurado y accesible desde la
   aplicación Symfony.
 - El mensaje debe contener la información relevante del pedido, como el
   ID del pedido, el ID del usuario y el timestamp de la creación.
### Creacion del Consumidor
 - Implementa un consumidor que procese los mensajes de la cola.
 - El consumidor debe realizar el procesamiento del pedido (por ejemplo,
   con un sleep para imitar un proceso complejo) cambiando el estado
   (aprobado, rechazado, pendiente) y creando los eventos necesarios
   que se consideren adecuados.
### Manejo de errores
 - Implementa una estrategia para manejar errores en el procesamiento
 de mensajes (por ejemplo, reintentos, almacenamiento de mensajes
 fallidos en una cola de errores, etc.).
### Documentación
 - Documenta todo el proceso de instalación, configuración e
 implementación.
 - La documentación debe incluir instrucciones claras para reproducir el
   entorno y ejemplos de uso.
## Criterios de Evaluación
 - Funcionalidad de envío y consumo de mensajes.
 - Integración del proceso asíncrono con el controlador Symfony.
 - Calidad del código y uso de buenas prácticas.
 - Manejo adecuado de errores.
 - Claridad de la documentación.
## Entregables
 - Código fuente del proyecto Symfony con la implementación solicitada.
 - Archivo docker-compose.yml y cualquier otro archivo de configuración necesario.
 - Documentación detallada en un archivo README.md.
 - Instrucciones para ejecutar el proyecto y reproducir el entorno usando Docker.
## Instrucciones Adicionales
 - Incluye todos los archivos necesarios en un repositorio de GitHub.
 - Asegúrate de que el repositorio tenga una estructura clara y organizada.