<?php
/**
 * Created by PhpStorm.
 * User: Million
 * Date: 8/22/2018
 * Time: 11:13 AM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class Maintenance extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('session','form_validation','upload'));
        $this->load->helper(array('form', 'url'));

        $config['upload_path'] = 'uploads/MaintenanceImage/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');

    }

    public function index()
       {
           if ($this->session->userdata('maintenance_login') != 1)
               redirect(base_url() . 'index.php?login', 'refresh');

           if ($this->session->userdata('maintenance_login') == 1)
               redirect(base_url() . 'index.php?maintenance/dashboard', 'refresh');
       }

    /***Maintenance DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('maintenance_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('Maintenance_dashboard');//TODO Add to Language
        $this->load->view('backend/index', $page_data);
    }

    /**To be maintained And Spare Part**/
    function maintenance_request($param1='',$param2='')
    {
        if ($this->session->userdata('maintenance_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }

            if($param1=='spare_part')
            {
                     $data['part_name']=$this->input->post('spare_name');
                     $data['part_amount']=$this->input->post('spare_amount');
                     $data['room_number']=$this->input->post('room_number');
                     $data['floor_number']=$this->input->post('floor_number');


                    $this->db->insert('spare_part',$data);
                    $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                    redirect(base_url() . 'index.php?maintenance/maintenance_request/', 'refresh');


            }

            if($param1=='fixed')
            {
                $current_time=date('Y-m-d h:i:s',time());
                $this->db->set( array('status'=>'fixed','fixed_date'=>$current_time));
                $this->db->where('id', $param2);
                $this->db->update('maintenance_request');
                $this->session->set_flashdata('flash_message' , 'Fixed');
                redirect(base_url() . 'index.php?maintenance/maintenance_request/', 'refresh');
            }

        $page_data['page_name']  = 'm_request';
        $page_data['request']=$this->crud_model->all_maintenance_request();
        $page_data['page_title'] = 'Maintenance Request';//TODO Add to Language
        $this->load->view('backend/index', $page_data);

    }

     /**Maintenance report**/
     function maintenance_report()
    {
        if ($this->session->userdata('maintenance_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }


        $page_data['maintenance_request']=$this->crud_model->maintenace_request();

         $page_data['spare_part']=$this->crud_model->all_spare_part();

         $page_data['page_name']  = 'm_report';
        $page_data['page_title'] = 'Maintenance Report';//TODO Add to Language
        $this->load->view('backend/index', $page_data);
    }

    /**Maintenance Noticeboard**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('maintenance_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }


        if ($param1 == 'create')
        {
            $data['notice_title'] = $this->input->post('notice_title');
            $data['notice'] = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->insert('noticeboard', $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?maintenance/noticeboard/', 'refresh');

        }

        if ($param1 == 'do_update')
        {
            $data['notice_title'] = $this->input->post('notice_title');
            $data['notice'] = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?maintenance/noticeboard/', 'refresh');
        }
        else if ($param1 == 'edit')
        {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }

        if ($param1 == 'delete')
        {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?maintenance/noticeboard/', 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('maintenance_noticeboard');
        $page_data['notices']    = $this->db->get('noticeboard')->result_array();
        $this->load->view('backend/index', $page_data);

    }

    /****Message****/
    function message($param1 = 'message_home', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('maintenance_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if ($param1 == 'send_new')
        {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?maintenance/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply')
        {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?maintenance/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read')
        {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);

    }

    /****Manage Profile****/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('maintenance_login') != 1)
        {
            redirect(base_url() . 'index.php?login', 'refresh');
        }

        if ($param1 == 'update_profile_info')
        {
            if ( ! $this->upload->do_upload('userfile'))
            {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('upload_error',$error['error']);
            }

            else
            {
                $this->upload->do_upload('userfile');
                $data['profile_image']=$this->upload->data('file_name');
            }

            $data['firstname']=$this->input->post('fname');
            $data['lastname']  = $this->input->post('lname');
            $data['email'] = $this->input->post('email');
            $data['phone_number'] = $this->input->post('p_number');
            $data['other_number'] = $this->input->post('o_number');


            $this->db->where('id', $this->session->userdata('maintenance_id'));

            $this->db->update('maintenance', $data);

            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));

            redirect(base_url() . 'index.php?maintenance/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password')
        {
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');

            $current_password = $this->db->get_where('maintenance', array(
                'id' => $this->session->userdata('maintenance_id')
            ))->row()->password;

            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password'])
            {
                $this->db->where('id', $this->session->userdata('maintenance_id'));
                $this->db->update('maintenance', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?maintenance/manage_profile/', 'refresh');
        }


        $page_data['page_name']  = 'manage_profile';

        $page_data['page_title'] = get_phrase('manage_profile');

        $page_data['edit_data']  = $this->db->get_where('maintenance', array(
            'id' => $this->session->userdata('maintenance_id')
        ))->result_array();

        $this->load->view('backend/index', $page_data);

    }


}