# TPE WEB 2 - Sistema de Gestión de Equipos y Jugadores

## Integrante

- Juan Ignacio Arballo
- DNI: 46825856
- Email: jiarballo6@gmail.com

## Temática

- Sistema de gestión de equipos y jugadores de fútbol.

- El sistema permite administrar equipos, jugadores y posiciones mediante una aplicación web desarrollada en PHP utilizando arquitectura MVC.

# Funcionalidades

## Acceso público

Los usuarios pueden:

- Ver listado de jugadores
- Ver detalle de jugadores
- Ver listado de equipos
- Ver jugadores pertenecientes a un equipo
- Ver listado de posiciones
- Ver jugadores pertenecientes a una posición

## Administración

Los administradores autenticados pueden:

# Jugadores
- Agregar jugadores
- Editar jugadores
- Eliminar jugadores

# Equipos
- Agregar equipos
- Editar equipos
- Eliminar equipos

# Posiciones
- Agregar posiciones
- Editar posiciones
- Eliminar posiciones

# Autenticación

El sistema cuenta con autenticación mediante sesiones.

## Usuario administrador por defecto

- Usuario: webadmin

- Contraseña: admin


# Tecnologías utilizadas

- se utilizo php para el codigo (Back End), phtml para la visualización de la pagina (Front End) y css para el estilo de la pagina.

# Modelo de Datos

El sistema implementa las siguientes relaciones:

- Equipo (1) → Jugador (N)

Un equipo puede tener muchos jugadores.

Cada jugador pertenece a un único equipo.

- Posición (1) → Jugador (N)

Una posición puede estar asociada a muchos jugadores.

Cada jugador pertenece a una única posición.

- Usuario

La entidad usuario se utiliza para autenticación de administradores.

# Decisiones de diseño
- respetamos el modelo de diseño MVC
- Uso de claves primarias autoincrementales
- Uso de claves foráneas para mantener integridad referencial
- Uso de ON UPDATE CASCADE
- Normalización de posiciones mediante tabla independiente
- Manejo de sesiones para autenticación
- Separación completa mediante MVC
- Uso de plantillas phtml
- Router con URLs semánticas
- hicimos que el sistema impidiera eliminar equipos o posiciones que tengan jugadores asociados.
- Las imágenes se cargan mediante URL.

# Auto Deploy de Base de Datos

El sistema crea automáticamente la base de datos y las tablas al iniciarse por primera vez.

El archivo utilizado para el deploy es 'equipo_de_futbol.sql'

La lógica de creación automática se encuentra en 'app/models/database.model.php'
