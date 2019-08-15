<?php
/**
 * Created by PhpStorm.
 * User: Million
 * Date: 9/11/2018
 * Time: 12:56 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
    class Cashier extends CI_Controller
    {
        function __construct()
            {
                parent::__construct();
                $this->load->database();
                $this->load->library(array('session','form_validation','upload'));
                $this->load->helper(array('form', 'url'));

                /*cache control*/
                $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
                $this->output->set_header('Pragma: no-cache');

            }

        public function index()
        {
            if ($this->session->userdata('cashier_login') != 1)
                redirect(base_url() . 'index.php?login', 'refresh');

            if ($this->session->userdata('cashier_login') == 1)
                redirect(base_url() . 'index.php?cashier/dashboard', 'refresh');
        }

        /***Maintenance DASHBOARD***/
        function dashboard()
    {
        if ($this->session->userdata('cashier_login') != 1)
        {
            redirect(base_url(), 'refresh');
        }
        $page_data['page_name']  = 'dashboard';
        $page_data['page_title'] = get_phrase('Cashier_dashboard');//TODO Add to Language
        $this->load->view('backend/index', $page_data);
    }

        /**Payment + User**/
        function payment($param1='',$param2='')
        {
            if ($this->session->userdata('cashier_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }


           if($param1=='add_tenant')
            {

                $first_name=$this->input->post('f_name');
                $middle_name=$this->input->post('m_name');
                $last_name=$this->input->post('l_name');

                $national_id=$this->input->post('national_id');
                $gender=$this->input->post('gender');

                $floor=$this->input->post('floor');
                $room=$this->input->post('room');

                $phone_number=$this->input->post('phone_number');
                $other_number=$this->input->post('other_number');
                $email=$this->input->post('email');

                $tenant_type=$this->input->post('tenant_type');
                $company_name=$this->input->post('company_name');
                $business_type=$this->input->post('business_type');

                $contract_end=$this->input->post('contract_end');

                   $config['upload_path'] = 'uploads/TenantImage';
                   $config['allowed_types'] = 'jpg|png|jpeg';
                   $this->load->library('upload', $config);
                   $this->upload->initialize($config);

                   if (!$this->upload->do_upload('tenant_photo'))
                   {
                       $error = array('error' => $this->upload->display_errors());
                       $this->session->set_flashdata('id_upload_error', $error['error']);
                   }
                   else {
                       $this->upload->do_upload('tenant_photo');
                       $tenant_photo_upload =array('tenant_pic'=>$this->upload->data('file_name'));

                       $this->upload->initialize();

                       $config['upload_path'] = 'uploads/NationalIdImages';
                       $config['allowed_types'] = 'jpg|png|jpeg';
                       $this->load->library('upload', $config);
                       $this->upload->initialize($config);
                   }

                    if (!$this->upload->do_upload('nationalId_photo'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('nationalId_image_upload_error', $error['error']);
                    }
                    else {
                        $this->upload->do_upload('id_photo');
                        $national_id_photo_upload=array('nationalId_pic'=>$this->upload->data('file_name'));

                    }



                $this->form_validation->set_rules('room','Room Number','required');

                $national_id_query=$this->db->get_where('tenant',array('national_id'=>$national_id));

                if($national_id_query->num_rows()>0)
                {
                    $this->session->set_flashdata('national_id_error',"National Id Must Be Unique");
                }
                else if ($this->form_validation->run() == false)
                {
                    $error=array('error'=>validation_errors());
                    $this->session->set_flashdata('room_error',$error['error']);

                }
                else if($contract_end <=date('Y-m-d'))
                {
                    $this->session->set_flashdata('contract_error',"Change Contract Ending Year");
                }
                else
                {
                    $data=array(
                        'firstname'=>$first_name,
                        'middlename'=>$middle_name,
                        'lastname'=>$last_name,
                        'profile_image'=>$tenant_photo_upload['tenant_pic'],
                        'national_id'=>$national_id,
                        'nationalId_card'=> $national_id_photo_upload['nationalId_pic'],
                        'gender'=>$gender,
                        'phone_number'=>$phone_number,
                        'Tenant_type'=>$tenant_type,
                        'room_number'=>$room,
                        'floor_number'=>$floor,
                        'email'=>$email,
                        'alternatePhoneNumber'=>$other_number,
                        'password'=>$phone_number,
                        'company_name'=>$company_name,
                        'company_description'=>$business_type,
                        'contract_endDate'=>$contract_end
                    );

                    $this->db->insert('tenant',$data);
                    $this->db->where('id',$room);
                    $this->db->update('room',array('available'=>false));

                    $this->session->set_flashdata('flash_message', 'Registration Successful'); //TODO add phrase

                }
                redirect(base_url() . 'index.php?cashier/payment/', 'refresh');
            }

           if($param1=='process_payment')
           {

               $tenant_id=$this->input->post('tenant_name');

                $payment_type=$this->input->post('payment_type');

               $payment_term=$this->input->post('payment_term');

               if($payment_term=='other')
               {
                  $payment_term=$this->input->post('other_term');
               }

               if($payment_type=='inCash')

                {
                    $amount_paid = $this->input->post('cash_amount');
                    $amount_remain = $this->input->post('cash_remain');

                    $data = array(
                        'tenant_id' => $tenant_id,
                        'payment_term' => $payment_term,
                        'payment_type' => 'inCash',
                        'amount_paid' => $amount_paid,
                        'amount_remain' => $amount_remain
                    );


                    $this->db->insert('payment', $data);
                    $this->session->set_flashdata('flash_message', 'Payment Successful'); //TODO add phrase
                }

                if($payment_type=='onAccount')
                    {
                        $config['upload_path'] = 'uploads/';
                       $config['allowed_types'] = 'jpg|png|jpeg';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);

                    $deposit_amount = $this->input->post('deposit_amount');
                    $deposit_remain = $this->input->post('deposit_remain');
                    $receipt_number = $this->input->post('receipt_number');

                    if (!$this->upload->do_upload('receipt_photo'))
                    {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('upload_error', $error['error']);
                    }
                    else
                    {
                        $this->upload->do_upload('receipt_photo');

                        $data = array(
                            'tenant_id' => $tenant_id,
                            'payment_term' => $payment_term,
                            'payment_type' => 'onAccount',
                            'amount_paid' => $deposit_amount,
                            'amount_remain' => $deposit_remain,
                            'receipt_number'=>$receipt_number,
                            'reciept_file'=>$this->upload->data('file_name')
                        );
                        $this->db->insert('payment', $data);
                        $this->session->set_flashdata('flash_message', 'Payment Successful'); //TODO add phrase
                    }
                }

               redirect(base_url() . 'index.php?cashier/payment/', 'refresh');
           }

           if($param1=='delete_tenant')
           {
               $room_number=$this->db->get_where('tenant',array('id'=>$param2))->row()->room_number;
               $room_data=array('available'=>true);
               $this->db->where('room_number',$room_number);
               $this->db->update('room',$room_data);

               $data=array('status'=>'inactive','room_number'=>0,'floor_number'=>0);
               $this->db->where('id', $param2);
               $this->db->update('tenant',$data);
               $this->session->set_flashdata('flash_message', 'Deleted Tenant'); //TODO add phrase
               redirect(base_url() . 'index.php?cashier/payment/', 'refresh');
           }

            $page_data['page_name']  = 'payment';
            $page_data['page_title'] ='Payment';//TODO Add to Language
            $page_data['floor']=$this->crud_model->floor();
            $page_data['tenant']=$this->db->get_where('tenant',array('status'=>'active'))->result_array();
            $this->load->view('backend/index', $page_data);
        }

        function tenantUpdate($param1='')
        {
            if ($this->session->userdata('cashier_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }
            $page_data['tenant_info']=$this->db->get_where('tenant',array('id'=>$param1))->result_array();
            $page_data['page_name']  = 'model_edit_tenant';
            $page_data['floor']=$this->crud_model->floor();
            $page_data['page_title'] = get_phrase('Edit Tenant');//TODO Add to Language
            $this->load->view('backend/index', $page_data);
        }

        function updated($param1='')
        {
            if ($this->session->userdata('cashier_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }
            $data=array();
            $id=$this->input->post('id');
                $first_name=$this->input->post('f_name');
                $middle_name=$this->input->post('m_name');
                $last_name=$this->input->post('l_name');

                $national_id=$this->input->post('national_id');
                $gender=$this->input->post('gender');

                $floor=$this->input->post('floor');
                $room=$this->input->post('room');

                $phone_number=$this->input->post('phone_number');
                $other_number=$this->input->post('other_number');
                $email=$this->input->post('email');

                $tenant_type=$this->input->post('tenant_type');
                $company_name=$this->input->post('company_name');
                $business_type=$this->input->post('business_type');

                $contract_end=$this->input->post('contract_end');

            $this->upload->initialize();
            $config['upload_path'] = 'uploads/NationalIdImages';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('nationalId_photo'))
            {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('nationalId_image_upload_error', $error['error']);
            }
            else {
                $this->upload->do_upload('nationalId_photo');
                $data=array('nationalId_card'=>$this->upload->data('file_name'));
            }

            $this->form_validation->set_rules('room','Room Number','required');

            $national_id_query=$this->db->get('tenant',array('id'=>$id))->row()->national_id;

            $national_table_id_query=$this->db->get_where('tenant',array('national_id'=>$national_id));

            if($national_id_query== $national_table_id_query->num_rows())
            {
                $this->session->set_flashdata('national_id_error',"National Id Must Be Unique");
            }
            else if ($this->form_validation->run() == false)
            {
                $error=array('error'=>validation_errors());
                $this->session->set_flashdata('room_error',$error['error']);

            }
            else if($contract_end <=date('Y-m-d'))
            {
                $this->session->set_flashdata('contract_error',"Change Contract Ending Year");
            }
            else
            {
               $data = array(
                   'firstname' => $first_name,
                   'middlename' => $middle_name,
                   'lastname' => $last_name,
                   'national_id' => $national_id,
                   'gender' => $gender,
                   'phone_number' => $phone_number,
                   'Tenant_type' => $tenant_type,
                   'room_number' => $room,
                   'floor_number' => $floor,
                   'email' => $email,
                   'alternatePhoneNumber' => $other_number,
                   'company_name' => $company_name,
                   'company_description' => $business_type,
                   'contract_endDate' => $contract_end
               );
               $this->db->where('id', $id);
               $this->db->update('tenant', $data);

               if($room!=$this->input->post('prevRoom'))
               {
                   $this->db->where('id', $room);
                   $this->db->update('room', array('status' => 'rented'));
                   $this->db->where('id', $this->input->post('prevRoom'));
                   $this->db->update('room', array('available' => 'not_rented'));
               }

               $this->session->set_flashdata('flash_message', 'Update Successful'); //TODO add phraser
                redirect(base_url() . 'index.php?cashier/updated/', 'refresh');
            }

            $this->tenantUpdate();
        }

        function accounting($param1='')
        {
            if ($this->session->userdata('cashier_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }

            $page_data['page_name']  = 'accounting';
            $page_data['page_title'] = get_phrase('Accounting');//TODO Add to Language
            $this->load->view('backend/index', $page_data);
        }

        function fetch_room()
        {
           if($this->input->post('floor_id'))
           {
               echo  $this->crud_model->room_available($this->input->post('floor_id'));
           }
        }

        function fetch_paymentAmount()
        {
            if($this->input->post('tenant_id'))
            {
                 echo $this->crud_model->roomCost($this->input->post('tenant_id'));
            }
        }

        /**Cashier Noticeboard**/
        function noticeboard($param1 = '', $param2 = '', $param3 = '')
        {
            if ($this->session->userdata('cashier_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }


            if ($param1 == 'create') {
                $data['notice_title']     = $this->input->post('notice_title');
                $data['notice']           = $this->input->post('notice');
                $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
                $this->db->insert('noticeboard', $data);

                $this->session->set_flashdata('flash_message' , get_phrase('data_added_successfully'));
                redirect(base_url() . 'index.php?cashier/noticeboard/', 'refresh');
            }
            if ($param1 == 'do_update') {
                $data['notice_title']     = $this->input->post('notice_title');
                $data['notice']           = $this->input->post('notice');
                $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
                $this->db->where('notice_id', $param2);
                $this->db->update('noticeboard', $data);

                $this->session->set_flashdata('flash_message' , get_phrase('data_updated'));
                redirect(base_url() . 'index.php?cashier/noticeboard/', 'refresh');
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
                redirect(base_url() . 'index.php?cashier/noticeboard/', 'refresh');
            }
            $page_data['page_name']  = 'noticeboard';
            $page_data['page_title'] = get_phrase('manage_noticeboard');
            $page_data['notices']    = $this->db->get('noticeboard')->result_array();
            $this->load->view('backend/index', $page_data);

        }

        /****Message****/
        function message($param1 = 'message_home', $param2 = '', $param3 = '')
        {
            if ($this->session->userdata('cashier_login') != 1)
            {
                redirect(base_url(), 'refresh');
            }

            if ($param1 == 'send_new')
            {
                $message_thread_code = $this->crud_model->send_new_private_message();
                $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
                redirect(base_url() . 'index.php?cashier/message/message_read/' . $message_thread_code, 'refresh');
            }

            if ($param1 == 'send_reply')
            {
                $this->crud_model->send_reply_message($param2);  //$param2 = message_thread_code
                $this->session->set_flashdata('flash_message', get_phrase('message_sent!'));
                redirect(base_url() . 'index.php?cashier/message/message_read/' . $param2, 'refresh');
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
            if ($this->session->userdata('cashier_login') != 1)
            {
                redirect(base_url() . 'index.php?login', 'refresh');
            }

            $config['upload_path'] = 'uploads/CashierImage';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

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

                $data['firstname']  = $this->input->post('fname');
                $data['lastname']  = $this->input->post('lname');
                $data['email'] = $this->input->post('email');
                $data['phone_number'] = $this->input->post('p_number');
                $data['other_number'] = $this->input->post('o_number');
                $this->db->where('id', $this->session->userdata('cashier_id'));

                $this->db->update('cashier', $data);

                $this->session->set_flashdata('flash_message', get_phrase('account_updated'));

                redirect(base_url() . 'index.php?cashier/manage_profile/', 'refresh');
            }
            if ($param1 == 'change_password')
            {
                $data['password']             = $this->input->post('password');
                $data['new_password']         = $this->input->post('new_password');
                $data['confirm_new_password'] = $this->input->post('confirm_new_password');

                $current_password = $this->db->get_where('cashier', array(
                    'id' => $this->session->userdata('cashier_id')
                ))->row()->password;

                if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password'])
                {
                    $this->db->where('id', $this->session->userdata('cashier_id'));
                    $this->db->update('cashier', array(
                        'password' => $data['new_password']
                    ));
                    $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
                } else {
                    $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
                }
                redirect(base_url() . 'index.php?cashier/manage_profile/', 'refresh');
            }
            $page_data['page_name']  = 'manage_profile';

            $page_data['page_title'] = get_phrase('manage_profile');

            $page_data['edit_data']  = $this->db->get_where('cashier', array(
                'id' => $this->session->userdata('cashier_id')
            ))->result_array();

            $this->load->view('backend/index', $page_data);

        }
}