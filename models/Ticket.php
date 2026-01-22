<?php
class Ticket {

    private $id_ticket;
    private $ticket_number;
    private $client_id;
    private $device_id;
    private $status_id;
    private $priority_id;
    private $created_by;

    public function __construct($id_ticket=null, $ticket_number, $client_id, $device_id, $status_id, $priority_id, $created_by) {
        $this->id_ticket = $id_ticket;
        $this->ticket_number = $ticket_number;   
        $this->client_id = $client_id;
        $this->device_id = $device_id;
        $this->status_id = $status_id;
        $this->priority_id = $priority_id;
        $this->created_by = $created_by;
    }

    // Getters
    public function getIdTicket() {
        return $this->id_ticket;
    }
    public function getTicketNumber() {
        return $this->ticket_number;
    }
    public function getClientId() {
        return $this->client_id;
    }
    public function getDeviceId() {
        return $this->device_id;
    }
    public function getStatusId() {
        return $this->status_id;
    }
    public function getPriorityId() {
        return $this->priority_id;
    }
    public function getCreatedBy() {
        return $this->created_by;
    }
    public function __toString() {
        return sprintf(
            "Ticket [id_ticket=%s, ticket_number=%s, client_id=%s, device_id=%s, status_id=%s, priority_id=%s, created_by=%s]",
            $this->id_ticket ?? 'null',
            $this->ticket_number,
            $this->client_id,
            $this->device_id,
            $this->status_id,
            $this->priority_id,
            $this->created_by
        );
    }

}