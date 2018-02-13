<?php

namespace TicketSystem;

class ListingsController extends Controller {
    public function index() {
        $query = '';
        if(isset($this->get['q']) && is_string($this->get['q'])) {
            $query = $this->get['q'];
        }

        $sorting = isset($this->get['sort']) ? $this->get['sort'] : 'date-desc';

        $tickets = $this->getModel('Ticket')->getAllVisible($query, $sorting);

        

        $this->renderTemplate('listings/index.php', ['tickets' => $tickets,
            'query' => $query,
            'sorting' => $sorting
                                                    ]);
    }

    public function ticket() {
        # check for existence & format of input params
        $this->accessDeniedUnless(isset($this->get['code']) && is_string($this->get['code']));
        $ticket = $this->getModel('Ticket')->getTicket($this->get['code']);
        $comments = $this->getModel('Ticket')->getComments($ticket);
        $users = $this->getModel('Ticket')->getAllUsers();
        $this->notFoundUnless($ticket);
        

        $this->renderTemplate('listings/ticket.php', ['ticket' => $ticket, 'comments'=>$comments, 'users'=>$users]);
    }



}