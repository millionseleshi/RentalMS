<?php
/**
 * Created by PhpStorm.
 * User: Million
 * Date: 10/8/2018
 * Time: 3:08 PM
 */
defined('BASEPATH') OR exit('No direct script access allowed');
class ResetPassword extends CI_Controller
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

    function index()
    {
        $this->load->view('backend/forgot_password');
    }

    function reset()
    {
        $email=$this->input->post('email');
        $phone=$this->input->post('p_number');

        $pass=$this->input->post('pass');
        $c_pass=$this->input->post('c_pass');

        if($email!=" " && $phone!=" " && $pass!=" " && $c_pass!=" " && $pass == $c_pass)
        {

        $credential = array('email' => $email,'phone_number'=>$phone,'status'=>'active');

        // Checking login credential for admin
        $query = $this->db->get_where('admin', $credential);

        //checking login credential for manager
        $manger_query=$this->db->get_where('manager',$credential);

        //check login credentials for maintenance
        $maintenance_query=$this->db->get_where('maintenance',$credential);

        //check login credentials for cashier
        $cashier_query=$this->db->get_where('cashier',$credential);

        //check login credentials for tenant
        $tenant_query=$this->db->get_where('tenant',$credential);


        if ($query->num_rows() > 0) {
            $row = $query->row();

            $this->db->set('password',$pass);
            $this->db->where('id',$row->id);
            $this->db->update('admin');
            $this->session->set_flashdata('flash_message', get_phrase('Password Reset Successfully'));
            redirect(base_url().'index?resetpassword/','refresh');

        }

        elseif($manger_query->num_rows()>0)
        {
            $row = $manger_query->row();
            $this->db->set('password',$pass);
            $this->db->where('id',$row->id);
            $this->db->update('manger');
            $this->session->set_flashdata('flash_message', get_phrase('Password Reset Successfully'));
            redirect(base_url().'index?resetpassword/','refresh');

        }

        elseif($maintenance_query->num_rows()>0)
        {
            $row = $maintenance_query->row();
            $this->db->set('password',$pass);
            $this->db->where('id',$row->id);
            $this->db->update('maintenance');
            $this->session->set_flashdata('flash_message', get_phrase('Password Reset Successfully'));
            redirect(base_url().'index?resetpassword/','refresh');

        }

        elseif($cashier_query->num_rows()>0)
        {
            $row = $cashier_query->row();
            $this->db->set('password',$pass);
            $this->db->where('id',$row->id);
            $this->db->update('cashier');
            $this->session->set_flashdata('flash_message', get_phrase('Password Reset Successfully'));
            redirect(base_url().'index?resetpassword/','refresh');

        }

        elseif ($tenant_query->num_rows()>0)
        {
            $row = $tenant_query->row();
            $this->db->set('password',$pass);
            $this->db->where('id',$row->id);
            $this->db->update('tenant');
            $this->session->set_flashdata('flash_message', get_phrase('Password Reset Successfully'));
            redirect(base_url().'index?resetpassword/','refresh');
        }

        else {
                $this->session->set_flashdata('account_error', get_phrase('No Account With This Email/Password!'));
                redirect(base_url().'index?resetpassword/','refresh');
        }

        }
        else
        {
            $this->session->set_flashdata('pass_error', get_phrase('password_mismatch'));
            redirect(base_url().'index?resetpassword/','refresh');
        }

      redirect(base_url().'index?resetpassword/','refresh');
        $this->load->view('backend/forgot_password');
    }
}