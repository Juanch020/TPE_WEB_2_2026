Integrantes:

Juan Ignacio Arballo – 46825856 - jiarballo6@gmail.com
Temática

Sistema de gestión de Equipos y Jugadores de fútbol.

Descripción

El sistema permite administrar equipos de fútbol y jugadores. Cada equipo puede tener varios jugadores, mientras que cada jugador pertenece a un único equipo.

Se almacenan datos relevantes tanto de los equipos (nombre, descripción y fecha de creación) como de los jugadores (nombre, rol, precio y posición).

Además, el sistema incorpora autenticación de usuarios administradores para restringir el acceso a las funcionalidades de gestión y modificación de datos.

Modelo de Datos

El modelo implementa una relación de tipo 1 a N entre las entidades:

Equipo (1)
Jugador (N)

Esto implica que un equipo puede tener varios jugadores, pero cada jugador solo puede pertenecer a un equipo.

Además, se incorpora la entidad Posición, generando una segunda relación de tipo 1 a N:

Posición (1)
Jugador (N)

Esto permite normalizar los datos y evitar inconsistencias en la carga de posiciones.

También se agregó la entidad Usuario para implementar el sistema de autenticación requerido por la aplicación:

Usuario (1)
Sesión de administración

La tabla usuario almacena las credenciales necesarias para permitir el acceso a las rutas privadas del sistema mediante login y logout.

Decisiones de Diseño
Se utilizaron claves primarias autoincrementales en las columnas id para garantizar la unicidad de cada registro.
Se implementaron claves foráneas en la tabla jugador para mantener la integridad referencial con equipo y posicion, estableciendo correctamente las relaciones 1:N.
Se utilizó la restricción ON UPDATE CASCADE para mantener la consistencia en caso de modificaciones en las claves relacionadas.
Se evitó el uso de valores de texto libre para las posiciones, optando por una tabla independiente para mejorar la normalización de los datos.
La entidad posicion se modeló como una tabla independiente para permitir su reutilización y facilitar la escalabilidad del sistema.
Se incorporó la tabla usuario para gestionar la autenticación de administradores y restringir el acceso a las funcionalidades privadas mediante sesiones.
Se definió un usuario administrador inicial (webadmin) para cumplir con los requisitos de autenticación del sistema.

El modelo fue diseñado para ser escalable, permitiendo incorporar futuras entidades como entrenadores, partidos, estadísticas o ligas sin necesidad de modificar la estructura principal.

Gracias a la normalización aplicada y al uso de claves foráneas, se garantiza la integridad de los datos y se facilita la expansión del sistema, manteniendo un diseño claro, consistente y mantenible.
