<?php
namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model {
  protected $table = 'usuario';
  protected $primaryKey = 'id';
  protected $allowedFields = ['nombre', 'apellido', 'dni', 'email', 'contraseña', 'rol'];

  public function guardarYObtener(array $data) {
    $this->insert($data);
    $id = $this->getInsertID();
    return $this->find($id);
  }
}
?>

