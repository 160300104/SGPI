# Sistema de gestión de préstamos e inventarios de los laboratorios del DCBeI de la Universidad del Caribe (SGPI) 📖

## Participantes ✒️
* José Manuel Cazan Segura (170300768@ucaribe.edu.mx)
* Mauricio De Leon Mercado (170300104@ucaribe.edu.mx)
* Ángel Eduardo Zaldívar Rodríguez (160300104@ucaribe.edu.mx)

## Resumen
El presente proyecto terminal consiste en la implementación de un sistema web que permite gestionar los préstamos de materiales y los inventarios de los laboratorios y, con base en los datos recopilados, generar informes estadísticos con gráficas y métricas que sean útiles para el personal encargado. Además de lo anteriormente mencionado, el sistema contempla un apartado para consultar los diferentes proveedores de materiales así como un panel de control para que los administradores puedan gestionar adecuadamente las categorías de los inventarios, roles de usuario y asignación de laboratorios. Este sistema ha sido desarrollado con la intención de ser implementado dentro de todos los laboratorios del departamento de ingenierías con la ventaja que es un sistema escalable en el cual se pueden dar de alta nuevos laboratorios que surjan en un futuro.

## Información de la Universidad del Caribe
* Dirección: Esquina Fraccionamiento, Tabachines, 77528 Cancún, Q.R.
* Teléfono: 998 881 4400

## Requisitos del sistema
* Node.js 16.13 en adelante
* Composer 2.2.7
* Laravel 9 en adelante
* XAMPP

Los paquetes de Laravel que se deben instalar por medio de la línea de comandos son:
* composer require spatie/laravel-permission
* composer require laravel/legacy-factories
* composer require yajra/laravel-datatables-oracle:"~9.0"
* composer require laravelcollective/html
* composer require yajra/laravel-datatables:^1.5
* composer require fideloper/proxy:*
* composer require athari/yalinqo

## Instrucciones
Primero debemos de crear nuestro proyecto con Laravel desde la terminal de comandos. Escribimos lo siguiente:
* laravel new *nombre_proyecto* --jet

Nos aparecerá el siguiente mensaje: *Which jetstream stack do you prefer?*
Escogemos la opción que diga **livewire**

El siguiente mensaje es: *Will your application use teams?*
Escogemos la opción que diga **no** y comenzará la creación del proyecto

En caso de estar utilizando XAMPP de preferencia crearlo directamente en la carpeta **htdocs** ubicada en la carpeta donde se instaló xampp.

Al tener nuestra carpeta de laravel creada, ya podemos pasar todos los archivos que se encuentran dentro de este repositorio a la carpeta que acabamos de crear.

Una vez teniendo todas las tecnologías y paquetes necesarios, se debe ejecutar XAMPP e iniciar el servicio de Apache y MySQL ubicados en el panel de control de XAMPP. Posteriormente en nuestro editor de código debemos ejecutar el siguiente comando: **php artisan serve**, este comando mandará un enlace para que podamos acceder al sistema.



