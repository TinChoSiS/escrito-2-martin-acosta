
![Laravel 8.6.12](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white) ![PHP 8.1](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![GitHub](https://img.shields.io/badge/github-%23121011.svg?style=for-the-badge&logo=github&logoColor=white)
<p align="center">
    <a href="http://sis.uy" target="_blank">
  <img src="https://sis.uy/assets/icon-a3d44dc0.svg" width="350" alt="sis.uy">
    </a>
</p>


# Programación Web - Segundo Escrito 2024

> [!IMPORTANT]
> ## Preparación de entorno
> - Clonar el repositorio 
> - `git clone git@github.com:TinChoSiS/escrito-2-martin-acosta.git`
> - `cd escrito-2-martin-acosta`
> - ingresar a la carpeta `./docker` para desplegar la base de datos mysql en un contendor, el mismo carga el SQL con la creación de la BD y la tabla correspondiente para el correcto funcionamiento.
      `docker compose up -d`
> - `cd ..` volver al directorio principal.

## Iniciar el servidor de desarrollo con php
- `composer install` para instalar las dependencias necesarias.
- `php artisan serve` para levantar el servidor de desarrollo en localhost:8000

## API Urls
### Alta 
##### URL - Método: POST
``` ruby
http://localhost:8000/api/v1/alta
```
``` json5
    {
     "nombre": "string",
     "apellido": "string",
     "telefono": "string"
    }
```
### Listar
##### URL - Método: GET
``` ruby
http://localhost:8000/api/v1/listar
```
``` json5
    {
     "nombre": "string",
     "apellido": "string",
     "telefono": "string"
    }
    // parametros de filtrado (like %string%), son opcionales, se puede enviar la solicitud vacia, con 1 o todos.
```
### Buscar
##### URL - Método: GET
``` ruby
    http://localhost:8000/api/v1/buscar/{id}
```
### Modificar
##### URL - Método: PUT
``` ruby
    http://localhost:8000/api/v1/modificar/{id}
```
``` json5
    {
     "nombre": "string",
     "apellido": "string",
     "telefono": "string"
    }
    // Es necesario al menos un parametro para modificar.
```
### Eliminar
##### URL - Método: DELETE
``` ruby
    http://localhost:8000/api/v1/eliminar/{id}
```
##
### Letra

#### Segundo Escrito
Crear una API que permita realizar Alta, baja, modificacion, listado y busqueda de Personas, con los siguientes campos (3 puntos)
- ID
- Nombre
- Apellido
- Telefono

Implementar Test en la API, para el caso de exito y el caso de error de los endpoints de la API (3 puntos)

Versionar con git, y subir a Github. Se deben tener al menos 8 commits que versionen paso a paso el desarrollo de la aplicacion. (3 puntos)

Trabajar con ramas para cada tarea (Alta, Baja, Modificacion, listado y busqueda, ademas de los tests) (3 puntos) 

Se debe utilizar PHP 8, Laravel 8.6.12, y principios de codigo limpio para todo

