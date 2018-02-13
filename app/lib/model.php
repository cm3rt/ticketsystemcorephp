<?php

namespace TicketSystem;

/**
 * Class Model
 * @package TicketSystem
 * @author Matthias Winzeler <matthias.winzeler@gmail.com>
 *
 * Base class for all application models (see app/model).
 * Models are used in controllers and provide access to the database.
 */
class Model {

    protected $db = null;

    public function __construct($db) {
        $this->db = $db;
    }

    protected function getModel($modelName) {
        require_once '../app/model/' . lcfirst($modelName) . '.php';
        $className = 'TicketSystem\\' . $modelName . 'Model';
        return new $className($this->db);
    }

    /* returns a secure random 32 char hex string (128 bit), assuming that /dev/urandom returns proper random values
    (case on unix derivates */
    public function getRandomStr() {
        return rand(3481, 92291);
    }

}