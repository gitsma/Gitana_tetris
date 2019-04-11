<?php 

class LoginModel extends Model
{
  public function __construct()
  {
    parent::__construct();
  }

  public function login($data)
  {
    $query = "SELECT u.id, u.role, r.name, r.surname, r.email, r.phone 
                FROM mvc.`user` as u
           LEFT JOIN mvc.`reader` as r
                  ON r.id = u.reader
               WHERE u.login = :user AND u.pass = :pass;";

    $pdoStatement = $this->db->prepare($query); // suformuok query
    $pdoStatement->execute([ //paruosk query
      ':user' => $data['user'],
      ':pass' => $data['pass']
    ]);
    $result = ($pdoStatement->fetchAll(PDO::FETCH_ASSOC));
    return (count($result) > 0) ? $result[0] : false; // ivykdyk query
  }

  public function createUser($data){

    $query = "INSERT INTO `user`( `login`, `pass`, `role`) VALUES 
      (:login, :pass, :role);";
    $pdoStatement = $this->db->prepare($query);
    $result = $pdoStatement->execute([
      ':login' => $data['login'],
      ':pass' => $data['pass'],
      ':role' => $data['role']
    ]);
    return $result ? $this->db->lastInsertId() : false;
  }
}