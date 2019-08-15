<?php
header('Content-Type: application/json');

Class Chart_data extends CI_Controller{

    function maintenance(){
        $query = $this->crud_model->get_maintenance();

        $result = $query->result();

        $data = array();
        foreach ($result as $row)
        {
            $data[] = $row;
        }

        print json_encode($data);


    }

    function income(){
        $query = $this->crud_model->get_income();

        $result = $query->result();

        $data = array();
        foreach ($result as $row)
        {
            $data[] = $row;
        }

        print json_encode($data);
    }

    function room(){
        $query = $this->crud_model->get_room();

        $result = $query->result();

        $data = array();
        foreach ($result as $row)
        {
            $data[] = $row;
        }

        print json_encode($data);
    }



}