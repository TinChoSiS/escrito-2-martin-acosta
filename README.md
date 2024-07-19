# Programación Web - Segundo Escrito 2024

``` 
## Segundo Escrito
Crear una API que permita realizar Alta, baja, modificacion, listado y busqueda de Personas, con los siguientes campos (3 puntos)
- ID
- Nombre
- Apellido
- Telefono

Implementar Test en la API, para el caso de exito y el caso de error de los endpoints de la API (3 puntos)

Versionar con git, y subir a Github. Se deben tener al menos 8 commits que versionen paso a paso el desarrollo de la aplicacion. (3 puntos)

Trabajar con ramas para cada tarea (Alta, Baja, Modificacion, listado y busqueda, ademas de los tests) (3 puntos) 

Se debe utilizar PHP 8, Laravel 8.6.12, y principios de codigo limpio para todo
```

## Preparación de entorno
- Clonar el repositorio 
  - ```git clone git@github.com:TinChoSiS/escrito-2-martin-acosta.git```
  - ```cd escrito-2-martin-acosta```
- ingresar a la carpeta ```./docker``` para desplegar la base de datos mysql en un contendor, el mismo carga el SQL con la creación de la BD y la tabla correspondiente para el correcto funcionamiento. ```docker compose up -d``` 

## Iniciar el servidor de desarrollo con php
- ```composer install``` para instalar las dependencias necesarias.
- ```php artisan serve``` para levantar el servidor de desarrollo en localhost:8000

## API Urls
### Alta
``` python
    * POST: http://localhost:8000/api/v1/alta
        {
         "nombre": "string",
         "apellido": "string",
         "telefono": "string"
        }
```
### Listar
``` python
    * GET: http://localhost:8000/api/v1/listar
        {
         "nombre": "string", // opcional
         "apellido": "string", // opcional
         "telefono": "string" // opcional
        }
        // parametros de filtrado (like %string%), es opcional, se puede enviar la solicitud vacia, con 1 o todos.
```
### Buscar
``` python
    * GET: http://localhost:8000/api/v1/buscar/{id}
```
### Modificar
``` python
    * PUT: http://localhost:8000/api/v1/modificar/{id}
        {
         "nombre": "string",
         "apellido": "string",
         "telefono": "string"
        }
        // Es necesario al menos un parametro para modificar.
```
### Eliminar
``` python
    * DELETE: http://localhost:8000/api/v1/eliminar/{id}
```