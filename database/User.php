<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "DBObject.php";
    require_once 'config.php';

    class User extends DataObject implements JSONSerializable {
        protected $data = array(
            "id" => "",
            "email" => "",
            "password" => "",
            "token" => "",
            "tokenExpire" => ""
        );



        // This will need to be updated for a full insert.
         public function insert() {
            $conn = DataObject::connect();
            $sql = "INSERT INTO " . TBL_USER . '(email, password) VALUES (:email, :password)';
            
            
                try {
                    $st = $conn->prepare($sql);
                    $st->bindValue(":email", $this->data["email"], PDO::PARAM_STR);
                    $st->bindValue(":password", $this->data["password"], PDO::PARAM_STR);
                    $st->execute();
                    $lastInsertId = $conn->lastInsertId();
                    DataObject::disconnect($conn);
                } catch(PDOException $e) {
                    die("Query failed: " . $e->getMessage());
                }
                
                return intval($lastInsertId);
            
            
        }

        // At the point of calling this, the password that's party of the user that this is called on is on raw form and unencrypted.
        public function authenticate() {
            $conn = parent::connect();

            


            $sql = 'SELECT * FROM ' . TBL_USER . ' WHERE email = :email';

            try {
                $st = $conn->prepare($sql);
                $st->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
                // $st->bindValue(':password', $this->data['password'], PDO::PARAM_STR);
                $st->execute();
                $row = $st->fetch();
                parent::disconnect($conn);

                

                if ($row) {

                    // First of all verify the password
                    $validPassword = password_verify($this->data['password'], $row['password']);

                    if ($validPassword)
                        return new User($row);
                }
            } catch (PDOException $e) {
                parent::disconnect($conn);
                die('Query failed: ' . $e->getMessage());
            }
        }

        public function update() {
            
            $conn = DataObject::connect();
            
            $sql = 'UPDATE ' . TBL_USER . ' 
                SET email = :email, 
                    password = :password,  
                    token = :token
                WHERE id = :id;';
            try {
                $st = $conn->prepare($sql);
                $st->bindValue(":id", $this->data['id']);
                $st->bindValue(":email", $this->data['email']);
                $st->bindValue(":password", $this->data['password']);
                $st->bindValue(":token", $this->data['token']);

                $st->execute();
                return true;
            } catch(PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public static function getAll() {
            $conn = parent::connect();

            $sql = 'SELECT * FROM ' . TBL_USER;

            try {
                $st = $conn->prepare($sql);
                $st->execute();

                $users = array();

                foreach($st->fetchAll() as $row) {
                    $users[] = new User($row);
                }
           
                parent::disconnect($conn);
                return $users;
            } catch(PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public static function getByEmail($email) {
            $conn = parent::connect();
            $sql = 'SELECT * FROM ' . TBL_USER .  ' WHERE email = :email';

            try {
                $st = $conn->prepare($sql);
                $st->bindValue(":email", $email);
                $st->execute();

                $users = array();

                foreach($st->fetchAll() as $row) {
                    $users[] = new User($row);
                }
           
                parent::disconnect($conn);
                return $users[0];
            } catch(PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
        }

        public static function userExists($email) {
            $conn = parent::connect();
            $sql = 'SELECT * FROM ' . TBL_USER . ' WHERE email = :email';

            try {
                $st = $conn->prepare($sql);
                $st->bindValue(":email", $email);
                $st->execute();
                $users = array();

                foreach($st->fetchAll() as $row) {
                    $users[] = new User($row);
                }
        
                parent::disconnect($conn);
                return count($users) > 0;
            } catch(PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
       }

       public function updateTokenExporeToOneHourAhead() {
        $conn = DataObject::connect();

        $sql = 'UPDATE ' . TBL_USER . ' SET tokenExpire = NOW() + INTERVAL 1 HOUR WHERE id = :id;';
            try {
                $st = $conn->prepare($sql);
                $st->bindValue(":id", $this->data['id']);
                $st->execute();
                return true;
            } catch(PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }
       }

        public static function userExistsWithEmailAndToken($email, $token) {
            


            $conn = parent::connect();
            $sql = 'SELECT id FROM ' . TBL_USER . ' WHERE email = :email AND token = :token AND token <> "" AND tokenExpire > NOW()';

            try {
                $st = $conn->prepare($sql);
                $st->bindValue(":email", $email);
                $st->bindValue(":token", $token);
                $st->execute();
                $users = array();

                foreach($st->fetchAll() as $row) {
                    $users[] = new User($row);
                }
        
                parent::disconnect($conn);
                return count($users) > 0;
            } catch(PDOException $e) {
                die("Query failed: " . $e->getMessage());
            }

       }

       
        public function delete() {
            $conn = DataObject::connect();
            $sql = 'DELETE FROM ' . TBL_USER . " WHERE id = :id";
        
            // if ($this->getValue('email') == 'ash.duckett@outlook.com') {
            if ($this->getValue('email') == 'admin@divingthailand.co.uk') {
                return json_encode([
                    'success' => '0',
                    'msg' => 'Deletion unsuccessful. This is the administrator\'s email address.'
                ]);
            } else {            
                try {
                    $st = $conn->prepare($sql);
                    $st->bindValue(":id", $this->getValue('id'));
                    $st->execute();
                    
                    return json_encode([
                        'success' => '1',
                        'msg' => 'Deletion successful.'
                    ]);
                } catch(PDOException $e) {
                    die("Query failed: " . $e->getMessage());
                }
            }
        }

        public function jsonSerialize() {
            return $this->data;
       }

        public static function findById($id) {
            $conn = DataObject::connect();
            $sql = "SELECT * FROM " . TBL_USER . " WHERE id = :id";
            $st = $conn->prepare($sql);
            $st->bindValue(":id", $id);
            $st->execute();
            $users = array();
                
        foreach($st->fetchAll() as $row) {
            $users[] = new User($row);
        }
        parent::disconnect($conn);
        
        return $users[0];
   }



    }


?>
