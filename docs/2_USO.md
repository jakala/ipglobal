# Uso de la Aplicacion
## estados del Order:
Hay tres estados para la entidad order, que se pueden ver en la bbdd:
 -  **PENDING**: cuando se crea el order y todavia no se ha procesado (antes de enviar el mensaje)
 -  **ACCEPTED**: se ha podido procesar el order y se ha descontado la cantidad de stock del producto.
 -  **REJECTED**: se ha producido un error (cantidad insuficiente en stock, pago erroneo...). No hay cambios en stock.
## Ejecución de comando
```
make create-order userId={int} productId={int} amount={int}
```
Esto intentará crear un order con el user, product y amount requeridos.

en las primeras ejecuciones, para la peticion:
```
make create-order userId=1 productId=1 amount=1
```

nos da una linea como:
```
order: "647718" quantity '1' not available for product '1'
```
podemos llegar a ver una tabla como esta:

|id|product_id_id|user_id_id|amount|status|
|--|--|--|--|--|
|1635|3|1|3|REJECTED|
|471461|3|1|3|APPROVED|
|844841|4|1|3|APPROVED|

A medida que se van procesando *orders* de tipo "Approved", se reduce la cantidad de
elementos del producto. Por lo tanto, en un momento podemos hacer un order con una cantidad,
respondiendo APPROVED, y en otro momento, al no tener disponible stock nos devolvera un REJECTED.

si queremos ver que sucede, podemos ver un log del consumer:
```
$ docker logs api_consumer -f

 [OK] Consuming messages from transport "async".                                

 // The worker will automatically exit once it has received a stop signal via   
 // the messenger:stop-workers command.                                         

 // Quit the worker with CONTROL-C.                                             

 // Re-run the command with a -vv option to see logs about consumed messages.   

order: "647718" quantity '3' not available for product '2
order: "66373" quantity '3' not available for product '2
```
