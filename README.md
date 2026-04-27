Integrantes:
•	Juan Ignacio Arballo – 46825856 - jiarballo6@gmail.com

Temática:
•	Sistema de gestión de Equipos y Jugadores de futbol.

Descripción:
El sistema permite administrar equipos de futbol y jugadores, cada equipo puede tener varios jugadores, mientras que cada jugador pertenece a un único equipo.
Se almacenan datos relevantes tanto de los equipos (nombre, descripción, fecha de creación) como de los jugadores (nombre, rol, precio y posición).
Modelo de Datos
El modelo implementa una relación de tipo 1 a N entre las entidades:
- Equipo (1)
- Jugador (N)
Esto implica que un equipo puede tener varios jugadores, pero cada jugador solo puede pertenecer a un equipo.
Además, se incorpora la entidad Posición, generando una segunda relación de tipo 1 a N:
- Posición (1)
- Jugador (N)
Esto permite normalizar los datos y evitar inconsistencias en la carga de posiciones.

Decisiones de Diseño
-	Se utilizaron claves primarias autoincrementales en las columnas `id` para garantizar la unicidad de cada registro.
-	Se implementaron claves foráneas en la tabla jugador para mantener la integridad referencial con equipo y posición y así obtener la relación 1: N.
-	Se utilizó la restricción ON UPDATE CASCADE para mantener la consistencia en caso de modificaciones en las claves.
-	Se evitó el uso de valores de texto libre para las posiciones, optando por una tabla independiente para mejorar la normalización.
-	La entidad `posicion` se modela como tabla independiente para permitir su reutilización y facilitar la escalabilidad del sistema.

El modelo está diseñado para ser escalable, permitiendo la incorporación futura de nuevas entidades com
