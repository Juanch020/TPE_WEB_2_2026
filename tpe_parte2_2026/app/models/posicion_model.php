<?php
require_once __DIR__ . '/database_model.php';

class PosicionModel extends DatabaseModel{

    public function __construct() {
        parent::__construct();
    }

    public function getById($id){
        $query = $this->db->prepare("SELECT * FROM posicion WHERE id = ?");
        $query->execute([$id]);
        return $query->fetch();
    }
    public function getAll(){
        $query = $this->db->prepare("SELECT * FROM posicion ORDER BY id DESC");
        $query->execute();
        return $query->fetchAll();
    }
    
    public function create($nombre) {
        $query = $this->db->prepare("INSERT INTO posicion(nombre) VALUES (?)");

        $query->execute([$nombre]);
    }

    public function update($id, $nombre) {
        $query = $this->db->prepare("UPDATE posicion SET nombre = ? WHERE id = ?");

        $query->execute([$nombre, $id]);
    }

    public function delete($id) {
        $query = $this->db->prepare("DELETE FROM posicion WHERE id = ?");

        $query->execute([$id]);
    }
}
?>