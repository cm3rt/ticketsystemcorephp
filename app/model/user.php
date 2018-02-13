<?php
#New Version messsages incl
namespace TicketSystem;

class UserModel extends Model {
    public function getUser($userId) {
        
        $q = $this->db->prepare('SELECT * FROM users WHERE id = :user_id LIMIT 1');
        $q->execute([':user_id' => $userId]);
        $user = $q->fetch();
        return $user ? $user : null;
    }


    public function checkLogin($name, $password) {
        

        $q = $this->db->prepare('SELECT * FROM users WHERE name = :name LIMIT 1');
        $q->execute([':name' => $name]);
        $user = $q->fetch();
        
        if(!$user) {
            return false;
        }

        $verify = $this->password_verify($name, $password);

        return $verify ? $user : false;
    }
    
    public function password_verify($name, $password){
        
        $q = $this->db->prepare('SELECT * FROM users WHERE name = :name AND password_hash = :password LIMIT 1');
        $q->execute([':name' => $name, ':password' => $password]);
        $user = $q->fetch();

        if(!$user) {
            return false;
        }
        return true;
    }

    public function isNameFree($name) {
        $q = $this->db->prepare('SELECT * FROM users WHERE name = :name LIMIT 1');
        $q->execute([':name' => $name]);
        return $q->fetch() === false;
    }

    public function register($name, $password) {
        

        $sql = 'INSERT INTO users (name, password_hash) VALUES (:name, :password_hash)';
        $query = $this->db->prepare($sql);
        return $query->execute([':name' => $name,
            ':password_hash' => $password]);
    }

    public function checkPassword($userId, $password) {
        

        $q = $this->db->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
        $q->execute([':id' => $userId]);
        $user = $q->fetch();

        if(!$user) {
            return false;
        }

        return password_verify($name, $password);
    }

    public function updatePassword($userId, $password) {
        

        $sql = 'UPDATE users SET password_hash = :password_hash WHERE id = :id';
        $query = $this->db->prepare($sql);
        return $query->execute([':id' => $userId,
            ':password_hash' => $password]);
    }


}
