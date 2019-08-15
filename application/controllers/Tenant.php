<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tenant extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->library(array('session','form_validation','upload'));
        $this->load->helper(array('form', 'url'));

        $config['upload_path'] = 'uploads/TenantImage';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
    }
    
    /***default function, redirects to login page if no tenant logged in yet***/
    public function index()
    {
        if ($this->session->userdata('tenant_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('tenant_login') == 1)
            redirect(base_url() . 'index.php?tenant/dashboard', 'refresh');
    }
    
    /***TENANT DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('tenant_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('tenant_dashboard');
        $this->load->view('backend/index', $page_data);
    }
    
    
    /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('tenant_login') != 1)
            redirect(base_url(), 'refresh');
    
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('manage_noticeboard');
        $page_data['notices']    = $this->db->get('noticeboard')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    /* private messaging */
    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('tenant_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?tenant/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?tenant/message/message_read/' . $param2, 'refresh');
        }

        if ($param1 == 'message_read') {
            $page_data['current_message_thread_code'] = $param2;  // $param2 = message_thread_code
            $this->crud_model->mark_thread_messages_read($param2);
        }

        $page_data['message_inner_page_name']   = $param1;
        $page_data['page_name']                 = 'message';
        $page_data['page_title']                = get_phrase('private_messaging');
        $this->load->view('backend/index', $page_data);
    }

    /**Maintenace Request Processing**/
    function maintenance($param1='',$param2='',$param3='')
    {
        if ($this->session->userdata('tenant_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        $send_by_me=$this->crud_model->sent_by_me($this->session->userdata('tenant_id'));

            if($param1=='request')
            {
                $maintenance_type=$this->input->post('maintenance_type');

                $maintenance_request=array(
                    'tenant_name'=>$this->session->userdata('name'),
                    'tenant_id'=>$this->session->userdata('tenant_id'),
                    'room_number'=>$this->session->userdata('my_room'),
                    'floor_number'=>$this->session->userdata('my_floor'),
                    'maintenance_type'=>$maintenance_type
                );

                $this->db->insert('maintenance_request',$maintenance_request);
                $this->session->set_flashdata('flash_message','Request Sent Successfully');
                redirect(base_url() . 'index.php?tenant/maintenance/', 'refresh');
            }

            if ($param1=='pending' && $param2=='cancel')
            {
               $this->db->where('id',$param3);
               $this->db->delete('maintenance_request');
               $this->session->set_flashdata('flash_message','Request Canceled');
                redirect(base_url() . 'index.php?tenant/maintenance/', 'refresh');
            }


        $page_data['page_name']  = 'maintenance';
        $page_data['tenant_id']=$this->session->userdata('tenant_id');
        $page_data['room']=$this->db->get_where('room',array('id'=>$this->session->userdata('my_room')))->row()->room_number;
        $page_data['floor']=$this->session->userdata('my_floor');
        $page_data['name']=$this->session->userdata('name');
        $page_data['sent_by_me']=$send_by_me;
        $page_data['page_title'] = get_phrase('request_maintenance');
        $this->load->view('backend/index', $page_data);

    }

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('tenant_login') != 1)
        {
            redirect(base_url() . 'index.php?login', 'refresh');
        }

        if ($param1 == 'update_profile_info')
        {


            if ( ! $this->upload->do_upload('userfile'))
            {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('upload_error',$error['error']);
                $data['profile_image']=$this->upload->data('file_name');
            }
            else
            {
                $this->upload->do_upload('userfile');
            }
            $data['email'] = $this->input->post('email');
            $data['phoneNumber'] = $this->input->post('phone_number');
            $data['alternatePhoneNumber'] = $this->input->post('other_number');
            $data['company_description']=$this->input->post('comp_description');

            $this->db->where('id', $this->session->userdata('tenant_id'));
            $this->db->update('tenant', $data);

            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?tenant/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');

            $current_password = $this->db->get_where('tenant', array(
                'id' => $this->session->userdata('tenant_id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('id', $this->session->userdata('tenant_id'));
                $this->db->update('tenant', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?tenant/manage_profile/', 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('tenant', array(
            'id' => $this->session->userdata('tenant_id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }





}


