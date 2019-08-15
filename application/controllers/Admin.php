<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->database();
        $this->load->library(array('session','form_validation','upload'));
        $this->load->helper(array('form', 'url'));

        $config['upload_path'] = 'uploads/AdminImage/';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $this->load->library('upload', $config);
        $this->upload->initialize($config);
		
       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		
    }
    
    /***default function, redirects to login page if no admin logged in yet***/
    public function index()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        if ($this->session->userdata('admin_login') == 1)
        {
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');
        }

    }
    
    /***ADMIN DASHBOARD***/
    function dashboard()
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        $page_data['page_name']  = 'dashboard';
       $page_data['page_title'] = get_phrase('admin_dashboard');
        $this->load->view('backend/index', $page_data);
    }

    /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/
    function noticeboard($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($param1 == 'create') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->insert('noticeboard', $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['notice_title']     = $this->input->post('notice_title');
            $data['notice']           = $this->input->post('notice');
            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
            $this->db->where('notice_id', $param2);
            $this->db->update('noticeboard', $data);

            $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }

        else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(
                'notice_id' => $param2
            ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('notice_id', $param2);
            $this->db->delete('noticeboard');
            $this->session->set_flashdata('flash_message' , get_phrase('data_deleted'));
            redirect(base_url() . 'index.php?admin/noticeboard/', 'refresh');
        }
        $page_data['page_name']  = 'noticeboard';
        $page_data['page_title'] = get_phrase('manage_noticeboard');
        $page_data['notices']    = $this->db->get('noticeboard')->result_array();
        $this->load->view('backend/index', $page_data);
    }
    
    /*****private messaging ****/
    function message($param1 = 'message_home', $param2 = '', $param3 = '') {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'send_new') {
            $message_thread_code = $this->crud_model->send_new_private_message();
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $message_thread_code, 'refresh');
        }

        if ($param1 == 'send_reply') {
            $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
            $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
            redirect(base_url() . 'index.php?admin/message/message_read/' . $param2, 'refresh');
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
    
    /*****SITE/SYSTEM SETTINGS*********/
    function system_settings($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        
        if ($param1 == 'do_update') {
             
            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_title');
            $this->db->where('type' , 'system_title');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('address');
            $this->db->where('type' , 'address');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('phone');
            $this->db->where('type' , 'phone');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('paypal_email');
            $this->db->where('type' , 'paypal_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('currency');
            $this->db->where('type' , 'currency');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_email');
            $this->db->where('type' , 'system_email');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('system_name');
            $this->db->where('type' , 'system_name');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('language');
            $this->db->where('type' , 'language');
            $this->db->update('settings' , $data);

            $data['description'] = $this->input->post('text_align');
            $this->db->where('type' , 'text_align');
            $this->db->update('settings' , $data);
            
            $this->session->set_flashdata('flash_message' , get_phrase('data_updated')); 
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'upload_logo') {
            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/logo.png');
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh');
        }
        if ($param1 == 'change_skin') {
            $data['description'] = $param2;
            $this->db->where('type' , 'skin_colour');
            $this->db->update('settings' , $data);
            $this->session->set_flashdata('flash_message' , get_phrase('theme_selected')); 
            redirect(base_url() . 'index.php?admin/system_settings/', 'refresh'); 
        }
        $page_data['page_name']  = 'system_settings';
        $page_data['page_title'] = get_phrase('system_settings');
        $page_data['settings']   = $this->db->get('settings')->result_array();
        $this->load->view('backend/index', $page_data);
    }

    /**Manage Maintenance, Cashier,Tenant && Manager**/
    function manage_user($param1 = '', $param2 = '',$param3='')
    {
        if ($this->session->userdata('admin_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }

        if($param1=='add')
        {
            $config['upload_path'] = 'uploads/UsersNationalId/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if ( ! $this->upload->do_upload('national_id'))
            {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('upload_error',$error['error']);
            }
            else
            {
                $this->upload->do_upload('national_id');
            }

            $data['firstname']=$this->input->post('fname');
            $data['lastname']=$this->input->post('lname');
            $data['phone_number']=$this->input->post('p_number');
            $data['other_number']=$this->input->post('o_number');
            $data['email']=$this->input->post('email');
            $data['national_id']=$this->upload->data('file_name');
            $data['password']=$this->input->post('p_number');


            $account_type=$this->input->post('account_type');
            if($account_type!=null)
            {
                $this->db->insert($account_type,$data);
                $this->session->set_flashdata('flash_message', get_phrase('account_created'));
            }


            redirect(base_url() . 'index.php?admin/manage_user/', 'refresh');
        }

        if($param1=='floor')
        {
            $room_per_m=$this->input->post('room_per_m');

            $this->db->set('description',$room_per_m);
            $this->db->where('type','roompayemnt');
            $this->db->update('settings');

          $floor=$this->input->post('floor');
          if($floor>0)
          {
              $data=array();
              for ($con=0;$con<$floor; $con++)
              {
                  $this->db->set('id');
                  $this->db->insert('floor');
              }
              $this->session->set_flashdata('flash_message' , get_phrase('floor_added_successfully'));
          }
            $room=$this->db->get('room')->result_array();
            if(sizeof($room)>0)
            {
                foreach ($room as $r)
                {
                    $price=$this->db->get_where('settings',array('type'=>'roompayemnt'))->row()->description;
                    $new_price=$r['room_size']*$price;
                    $data=array('room_price'=>$new_price);
                    $this->db->where('id',$r['id']);
                    $this->db->update('room',$data);
                }
            }
            redirect(base_url() . 'index.php?admin/manage_user/', 'refresh');
        }

        if($param1=='room')
        {
            $floor=$this->input->post('floor_list');
            $room_number=$this->input->post('room_number');
            $room_size=$this->input->post('room_size');

            $price=$this->db->get_where('settings',array('type'=>'roompayemnt'))->row()->description;

            $room_cost=$price*$room_size;

            $previous_room_number=$this->db->get_where('room',array('room_number'=>$room_number))->result_array();
            if (sizeof($previous_room_number)>0)
            {
                    $this->session->set_flashdata('room_error','Room Number Must Be Unique');
            }
            else
            {
                $data['room_number']=$room_number;
                $data['room_size']=$room_size;
                $data['room_price']=$room_cost;
                $data['floor_id']=$floor;
                $this->db->insert('room',$data);
                $this->session->set_flashdata('flash_message' , get_phrase('room_added_successfully'));
            }

            redirect(base_url() . 'index.php?admin/manage_user/', 'refresh');
        }

        if($param1=='delete_manager')
        {
           $this->db->set('status','inactive');
           $this->db->where('id',$param2);
           $this->db->update('manager');
            $this->session->set_flashdata('flash_message' , get_phrase('delete_successfully'));
            redirect(base_url() . 'index.php?admin/manage_user/', 'refresh');
        }
        if($param1=='delete_mainten')
        {
           $this->db->set('status','inactive');
           $this->db->where('id',$param2);
           $this->db->update('maintenance');
            $this->session->set_flashdata('flash_message' , get_phrase('delete_successfully'));
            redirect(base_url() . 'index.php?admin/manage_user/', 'refresh');
        }
        if($param1=='delete_cashier')
        {
           $this->db->set('status','inactive');
           $this->db->where('id',$param2);
           $this->db->update('cashier');
            $this->session->set_flashdata('flash_message' , get_phrase('delete_successfully'));
            redirect(base_url() . 'index.php?admin/manage_user/', 'refresh');
        }

        $page_data['manager']=$this->db->get_where('manager',array('status'=>'active'))->result_array();
        $page_data['maintenance']=$this->db->get_where('maintenance',array('status'=>'active'))->result_array();
        $page_data['cashier']=$this->db->get_where('cashier',array('status'=>'active'))->result_array();
        $page_data['tenant']=$this->db->get('tenant')->result_array();
        $page_data['price']=$this->db->get_where('settings',array('type'=>'roompayemnt'))->row()->description;
        $page_data['floor']=$this->db->get('floor')->result_array();

        $page_data['page_name']  = 'manage_user';
        $page_data['page_title'] = get_phrase('Manage Users');
        $this->load->view('backend/index', $page_data);
    }


    /*****LANGUAGE SETTINGS*********/
    function manage_language($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url() . 'index.php?login', 'refresh');
        
        if ($param1 == 'edit_phrase') {
            $page_data['edit_profile']  = $param2;  
        }
        if ($param1 == 'update_phrase') {
            $language   =   $param2;
            $total_phrase   =   $this->input->post('total_phrase');
            for($i = 1 ; $i < $total_phrase ; $i++)
            {
                //$data[$language]  =   $this->input->post('phrase').$i;
                $this->db->where('phrase_id' , $i);
                $this->db->update('language' , array($language => $this->input->post('phrase'.$i)));
            }
            redirect(base_url() . 'index.php?admin/manage_language/edit_phrase/'.$language, 'refresh');
        }
        if ($param1 == 'do_update') {
            $language        = $this->input->post('language');
            $data[$language] = $this->input->post('phrase');
            $this->db->where('phrase_id', $param2);
            $this->db->update('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_phrase') {
            $data['phrase'] = $this->input->post('phrase');
            $this->db->insert('language', $data);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'add_language') {
            $language = $this->input->post('language');
            $this->load->dbforge();
            $fields = array(
                $language => array(
                    'type' => 'LONGTEXT'
                )
            );
            $this->dbforge->add_column('language', $fields);
            
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        if ($param1 == 'delete_language') {
            $language = $param2;
            $this->load->dbforge();
            $this->dbforge->drop_column('language', $language);
            $this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
            
            redirect(base_url() . 'index.php?admin/manage_language/', 'refresh');
        }
        $page_data['page_name']        = 'manage_language';
        $page_data['page_title']       = get_phrase('manage_language');
        //$page_data['language_phrases'] = $this->db->get('language')->result_array();
        $this->load->view('backend/index', $page_data); 
    }
    
    /*****BACKUP / RESTORE / DELETE DATA PAGE**********/
    function backup_restore($operation = '', $type = '')
    {
        if ($this->session->userdata('admin_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($operation == 'create') {
            $this->crud_model->create_backup($type);
        }
        if ($operation == 'restore') {
            $this->crud_model->restore_backup();
            $this->session->set_flashdata('backup_message', 'Backup Restored');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }
        if ($operation == 'delete') {
            $this->crud_model->truncate($type);
            $this->session->set_flashdata('backup_message', 'Data removed');
            redirect(base_url() . 'index.php?admin/backup_restore/', 'refresh');
        }
        
        $page_data['page_info']  = 'Create backup / restore from backup';
        $page_data['page_name']  = 'backup_restore';
        $page_data['page_title'] = get_phrase('manage_backup_restore');
        $this->load->view('backend/index', $page_data);
    }
    
    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/
    function manage_profile($param1 = '', $param2 = '', $param3 = '')
    {
        if ($this->session->userdata('admin_login') != 1)
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
        }

            $data['firstname']  = $this->input->post('fname');
            $data['lastname']  = $this->input->post('lname');
            $data['email'] = $this->input->post('email');
            $data['phone_number'] = $this->input->post('p_number');
            $data['other_number'] = $this->input->post('o_number');
            $data['profile_image']=$this->upload->data('file_name');

            $this->db->where('id', $this->session->userdata('id'));
            $this->db->update('admin', $data);
            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }
        if ($param1 == 'change_password') {
            $data['password']             = $this->input->post('password');
            $data['new_password']         = $this->input->post('new_password');
            $data['confirm_new_password'] = $this->input->post('confirm_new_password');
            
            $current_password = $this->db->get_where('admin', array(
                'id' => $this->session->userdata('id')
            ))->row()->password;
            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {
                $this->db->where('id', $this->session->userdata('id'));
                $this->db->update('admin', array(
                    'password' => $data['new_password']
                ));
                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {
                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }
            redirect(base_url() . 'index.php?admin/manage_profile/', 'refresh');
        }
        $page_data['page_name']  = 'manage_profile';
        $page_data['page_title'] = get_phrase('manage_profile');
        $page_data['edit_data']  = $this->db->get_where('admin', array(
            'id' => $this->session->userdata('id')
        ))->result_array();
        $this->load->view('backend/index', $page_data);
    }


}

