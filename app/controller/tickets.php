<?php

namespace TicketSystem;

class TicketsController extends Controller {
    public function __construct($db) {
        # make sure only admins can access this controller
        parent::__construct($db);

        $this->accessDeniedUnless($this->user->is_admin);
    }

    public function index() {
        $tickets = $this->getModel('Ticket')->getAllOfUser($this->user->id);
                $users = $this->getModel('Ticket')->getAllUsers();


        $this->renderTemplate('tickets/index.php', ['tickets' => $tickets, 'users' => $users]);
    }

    public function build() {
        $ticket = (object)['name' => '', 'description' => '', 'price' => '0.0', 'tags' => '', 'is_hidden' => 0];
        

        $this->renderTemplate('tickets/build.php', ['ticket' => $ticket, 'shippingOptions' => '']);
    }

    public function create() {
        

        # check for existence & format of input params
        $this->accessDeniedUnless(isset($this->post['name']) && is_string($this->post['name']) && mb_strlen($this->post['name']) >= 3);
        $this->accessDeniedUnless(isset($this->post['description']) && is_string($this->post['description']) && mb_strlen($this->post['description']) >= 0);
        

        # verify shipping options
        $validShippingOptions = [];
        

        $ticket = (object)['name' => $this->post['name'],
            'description' => $this->post['description']];


        $errorMessage = '';


        $success = false;

        if(empty($errorMessage)){
                $ticketModel = $this->getModel('Ticket');

                if ($ticketModel->createForUser($this->user->id, $ticket)) {
                    $success = true;
                } else {
                    $errorMessage = 'Could not create ticket due to unknown error.';
                }
        }

        if($success) {
            $this->setFlash('success', 'Successfully created ticket.');
            $this->redirectTo('?c=tickets');
        }
        else {
            $this->renderTemplate('tickets/build.php', ['ticket' => $ticket,
                'error' => $errorMessage ]);
        }
    }

    public function edit() {
        # check for existence & format of input params
        $this->accessDeniedUnless(isset($this->get['code']) && is_string($this->get['code']));

        # check that ticket belongs to user
        $ticketModel = $this->getModel('Ticket');
        $ticket = $ticketModel->getOneOfUser($this->user->id, $this->get['code']);
        $this->notFoundUnless($ticket);


        $this->renderTemplate('tickets/edit.php', ['ticket' => $ticket]);
    }

    public function update() {
        # check for existence & format of input params
        $this->accessDeniedUnless(isset($this->post['code']) && is_string($this->post['code']));
        $this->accessDeniedUnless(isset($this->post['name']) && is_string($this->post['name']) && mb_strlen($this->post['name']) >= 3);
        $this->accessDeniedUnless(isset($this->post['description']) && is_string($this->post['description']) && mb_strlen($this->post['description']) >= 0);

        # check that ticket belongs to user
        $ticketModel = $this->getModel('Ticket');
        $ticket = $ticketModel->getOneOfUser($this->user->id, $this->post['code']);
        $this->notFoundUnless($ticket);



        $ticket->name = $this->post['name'];
        $ticket->description = $this->post['description'];

        $errorMessage = '';


        $success = false;

        if(empty($errorMessage)) {
                $ticketModel = $this->getModel('Ticket');

                if ($ticketModel->update($ticket)) {
                    $success = true;
                } else {
                    $errorMessage = 'Could not update ticket due to unknown error.';
                }
            
        }

        if($success) {
            $this->setFlash('success', 'Successfully updated ticket.');
            $this->redirectTo('?c=tickets');
        }
        else {
            $this->renderTemplate('tickets/edit.php', ['ticket' => $ticket,
                'error' => $errorMessage ]);
        }
    }


    public function destroy() {
        # check for existence & format of input params
        $this->accessDeniedUnless(isset($this->post['code']) && is_string($this->post['code']));

        # check that ticket belongs to user
        $ticketModel = $this->getModel('Ticket');
        $ticket = $ticketModel->getOneOfUser($this->user->id, $this->post['code']);
        $this->notFoundUnless($ticket);

        if($ticketModel->delete($ticket->id)) {
            $this->setFlash('success', 'Successfully deleted ticket.');
        }
        else {
            $this->setFlash('error', 'Unknown error, could not delete ticket.');
        }

        $this->redirectTo('?c=tickets');
    }

}