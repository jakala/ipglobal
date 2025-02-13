# Prueba tecnica IPGLOBAL
## ejercicio
Se trata de una simulacion de Tienda en la que se genera un mensaje para la creacion de un 
pedido. Dicho pedido puede tardar en procesarse (debido a ciertos calculos), por lo que es 
necesario separar la application con un consumidor y una gestion de mensajes con rabbitmq.

El enunciado completo de la práctica está [aqui](docs/3_PRUEBA.md).

## Solucion con DDD
La solución aquí planteada trata de simular en tres apartados la tienda descrita anteriormente.
En dichos apartados (bounded-context) están separadas las logicas DDD correspondientes. Para no 
complicar mucho la anidación de los directorios, he optado por esta estructura:
```
src/
├── Backend
│   └── OrderConsumer
│       └── Application
├── Shared
│   ├── Application
│   ├── Domain
│   └── Infrastructure
│       └── Entity
└── Shop
    └── OrderProducer
        ├── Application
        ├── Domain
        └── Infrastructure
```
si la aplicacion creciera más, podriamos aumentar los detalles (Por ej, en Shared/Domain se podria crear una 
carpeta por cada agregado y sus componentes), pero por la actual situacion creo que con esto es suficiente
## Instalacion y uso
Esta basada en el uso de contenedores docker y comandos Make. 

Podemos seguir el proceso de instalacion [aqui](docs/1_INSTALACION.md)

Los comandos make utilizados se pueden ver [aqui](docs/4_MAKEFILE.md)

Hay ejemplos de uso de la aplicacion [aqui](2_USO.md)

## Base de datos
![schema](docs/schema.png)
despues de ejecutar el comando
```
make init-database
```
se crea el schema anterior y se añaden unos cuantos valores a las tablas de product y user.

### Product

| id | name | amount |
 |----|------|--------| 
|  1 | ipad | 0 |
| 2 | pc | 10 |
| 3 | blackberry | 4 |
| 4 | nokia | 6 |
| 5 | android | 80 |

donde: 
 - id: el identificador del producto
 - name: nombre del producto
 - amount: representa el stock que tiene ese producto

### User
| id | name  |
 |----|------| 
|  1 | jesus |
| 2 | marcos |
| 3 | pablo  |
| 4 | jose   |

donde:
 - id: el identificador de usuario
 - name: nombre del usuario.

Estos seran los ids que podamos utilizar.

## Decisiones de desarrollo
He apuntado en [este documento](docs/5_DECISIONES.md) ciertas decisiones que he tomado a la hora de desarrollar
la aplicacion. 
## Mejoras
 - aumentar cobertura de tests
