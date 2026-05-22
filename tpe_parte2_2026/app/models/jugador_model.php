<?php
require_once __DIR__ . '/database_model.php';

class JugadorModel extends DatabaseModel{

    public function getById($id){
        $query = $this->db->prepare(
        "SELECT 
            jugador.*,
            equipo.nombre AS equipo,
            posicion.nombre AS posicion

        FROM jugador

        JOIN equipo
        ON jugador.id_equipo = equipo.id

        JOIN posicion
        ON jugador.id_posicion = posicion.id

        WHERE jugador.id = ?");

        $query -> execute([$id]);

        return $query->fetch();
    }

    public function getAll(){
        $query = $this->db->prepare("SELECT 
            jugador.*,
            equipo.nombre AS equipo,
            posicion.nombre AS posicion
            
        FROM jugador

        JOIN equipo
        ON jugador.id_equipo = equipo.id

        JOIN posicion
        ON jugador.id_posicion = posicion.id

        ORDER BY jugador.id DESC");
        
        $query->execute();
        
        return $query->fetchAll();
    }
    
    public function getByEquipo($id_equipo){
        $query = $this->db->prepare(
        "SELECT
            jugador.*,
            equipo.nombre AS equipo,
            posicion.nombre AS posicion

        FROM jugador

        JOIN equipo
        ON jugador.id_equipo = equipo.id

        JOIN posicion
        ON jugador.id_posicion = posicion.id

        WHERE jugador.id_equipo = ?

        ORDER BY jugador.nombre ASC
        ");

        $query->execute([$id_equipo]);

        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getByPosicion($id_posicion){
        $query = $this->db->prepare(
        "SELECT
            jugador.*,
            equipo.nombre AS equipo,
            posicion.nombre AS posicion

        FROM jugador

        JOIN equipo
        ON jugador.id_equipo = equipo.id

        JOIN posicion
        ON jugador.id_posicion = posicion.id

        WHERE jugador.id_posicion = ?

        ORDER BY jugador.nombre ASC
        ");

        $query->execute([$id_posicion]);

        return $query->fetchAll();
    }

    public function create($data){
        $query = $this->db->prepare("INSERT INTO jugador(nombre, precio, id_equipo, id_posicion, foto) VALUES (?, ?, ?, ?, ?)");
        $query->execute([
            $data['nombre'],
            $data['precio'],
            $data['id_equipo'],
            $data['id_posicion'],
            $data['foto'] ?? null
        ]); 
        return $this->db->lastInsertId();
    }

    public function delete($id){
        $query = $this->db->prepare("DELETE FROM jugador WHERE id = ?");
        return $query->execute([$id]);
    }

    public function update($id, $data){
        $query = $this->db->prepare("UPDATE jugador SET nombre = ?, precio = ?, id_equipo = ?, id_posicion = ?, foto = ? WHERE id = ?");
        
        return $query->execute([
            $data['nombre'],
            $data['precio'],
            $data['id_equipo'],
            $data['id_posicion'],
            $data['foto'] ?? null,
            $id
        ]);    
    }
}
?>