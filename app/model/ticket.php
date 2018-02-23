<?php

namespace TicketSystem;

class TicketModel extends Model {

    public function getAllOfUser($userId, $withHidden = true) {
        $q = $this->db->prepare('SELECT id, name, code, assigned_to, status FROM tickets ' .
            'WHERE user_id = :user_id ORDER BY name ASC');

        $q->execute([':user_id' => $userId]);
        $tickets = $q->fetchAll();

        if(!$withHidden) {
            $tickets = array_filter($tickets, function($p) { return !$p->is_hidden; });
        }

        if($tickets) {
            # include shipping options
            
            return $tickets;
        }

        return [];
    }

    public function getAllVisible($query, $sorting) {
        $sql = 'SELECT p.id, p.name, p.user_id, p.code, p.assigned_to, p.status, u.name AS user '
            .'FROM tickets p JOIN users u ON p.user_id = u.id';

        $params = [];

        if(!empty($query)) {
            $sql .= ' AND (p.name LIKE :query OR u.name LIKE :query)';
            $params['query'] = "%$query%";
        }

        $sortingMap = [
            'date-asc' => 'p.id ASC',
            'date-desc' => 'p.id DESC',
            'name-asc' => 'p.name ASC',
            'name-desc' => 'p.name DESC',
        ];

        $sortSql = isset($sortingMap[$sorting]) ? $sortingMap[$sorting] : 'p.id DESC';

        $sql .= ' ORDER BY ' . $sortSql;

        $q = $this->db->prepare($sql);
        $q->execute($params);
        $tickets = $q->fetchAll();
        return $tickets ? $tickets : [];
    }

    private function getFreeCode() {
        $code = null;
        do {
            $try = substr($this->getRandomStr(), 0, 12);
            $q = $this->db->prepare('SELECT id FROM tickets WHERE code = :code');

            $q->execute([':code' => $try]);
            if(!$q->fetch()) {
                $code = $try;
            }
        } while($code == null);

        return $code;
    }

    public function createForUser($userId, $ticket) {
        $this->db->beginTransaction();

        try {
            $sql = 'INSERT INTO tickets (name, description, code,  user_id, assigned_to) ' .
                'VALUES (:name, :description,:code,:user_id, :assigned_to)';
            $query = $this->db->prepare($sql);
            $query->bindValue(':name', $ticket->name);
            $query->bindValue(':description', $ticket->description);
            $code = $this->getFreeCode();
            $query->bindValue(':code', $code);
            $query->bindValue(':user_id', $userId);
            $query->bindValue(':assigned_to', $ticket->assign_to);

            $result = $query->execute();

            # create shipping option links
            if($result) {
                $ticketId = $this->db->lastInsertId();
                
            }
            else {
                throw new \Exception('Ticket couldnt be saved');
            }

            $this->db->commit();
            return true;
        }
        catch(\Exception $e){
            $this->db->rollBack();
            return false;
        }
    }

    public function getOneOfUser($userId, $code) {
        $q = $this->db->prepare('SELECT id, name, description,  user_id,  code, assigned_to, status ' .
            'FROM tickets WHERE user_id = :user_id and code = :code LIMIT 1');
        $q->execute([':user_id' => $userId, ':code' => $code]);
        $ticket = $q->fetch();
        if($ticket) {
            return $ticket;
        }
        return null;

        return $ticket ? $ticket : null;
    }
    
    public function getAllUsers(){
         $q = $this->db->prepare('SELECT id, name  FROM users');
        $q->execute();
        $users = $q->fetchAll();
        if($users) {
            return $users;
        }
        return null;

        return $ticketMeta ? $ticketMeta : null;
    }
    
    public function getComments($ticket){

            
        $q = $this->db->prepare('SELECT u.name, c.id, c.userid, c.comment FROM ticket_meta c  '.
        'JOIN users u ON u.id = c.userid WHERE c.code = :code');
        $q->execute([':code' => $ticket->code]);
        $ticketMeta = $q->fetchAll();
        if($ticketMeta) {
            return $ticketMeta;
        }
        return null;

        return $ticketMeta ? $ticketMeta : null;
    }

    public function update($ticket) {
        $this->db->beginTransaction();
        print_r($ticket);

        try {
            # dont update image if not a new one is given
            $sql = 'UPDATE tickets SET name = :name, description = :description, assigned_to = :assigned_to  WHERE id = :id';
            if($ticket->image != null) {
                $sql = 'UPDATE tickets SET name = :name, description = :description, assigned_to = :assigned_to WHERE id = :id';
            }
            $query = $this->db->prepare($sql);
            $query->bindValue(':name', $ticket->name);
            $query->bindValue(':description', $ticket->description);
            $query->bindValue(':id', $ticket->id);
            $query->bindValue(':assigned_to', $ticket->assign_to);
            $result = $query->execute();



            $this->db->commit();
            return true;
        }
        catch(\Exception $e){
            $this->db->rollBack();
            return false;
        }
    }

    public function delete($id) {
        $q = $this->db->prepare('DELETE FROM tickets WHERE id = :id');
        return $q->execute([':id' => $id]);
    }

    public function getTicket($code) {
        $q = $this->db->prepare('SELECT p.id, p.name, p.description, p.user_id,p.code , p.assigned_to, p.status,  u.name AS user FROM tickets p '.
            'JOIN users u ON p.user_id = u.id WHERE p.code = :code LIMIT 1');
        $q->execute([':code' => $code]);
        $ticket = $q->fetch();
        if($ticket) {
            return $ticket;
        }
        return null;

        return $ticket ? $ticket : null;
    }


}