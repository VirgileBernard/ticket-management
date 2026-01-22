<?php

class Device{
    private $id_device;
    private $model;
    private $serial_number;
    private $brand;
    private $type_id;
    private $client_id;
    private $submission_date;
    private $retrieve_date;

    function __construct($id_device=null, $model, $serial_number, $brand, $type_id, $client_id, $submission_date, $retrieve_date){
        $this->id_device=$id_device;
        $this->model=$model;
        $this->serial_number=$serial_number;
        $this->brand=$brand;
        $this->type_id=$type_id;
        $this->client_id=$client_id;
        $this->submission_date=$submission_date;
        $this->retrieve_date=$retrieve_date;
    }

    //getters
    public function getIdDevice(){
        return $this->id_device;
    }

    public function getModel(){
        return $this->model;
    }
    public function getSerialNumber(){
        return $this->serial_number;
    }
    public function getBrand(){
        return $this->brand;
    }
    public function getTypeId(){
        return $this->type_id;
    }
    public function getClientId(){
        return $this->client_id;
    }
    public function getSubmissionDate(){
        return $this->submission_date;
    }
    public function getRetrieveDate(){
        return $this->retrieve_date;
    }

    public function __toString() {
        return sprintf(
            "Device [id_device=%s, model=%s, serial_number=%s, brand=%s, type_id=%s, client_id=%s, submission_date=%s, retrieve_date=%s]",
            $this->id_device ?? 'null',
            $this->model,
            $this->serial_number,
            $this->brand,
            $this->type_id,
            $this->client_id,
            $this->submission_date,
            $this->retrieve_date
        );
    }

}