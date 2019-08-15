<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('crud_model');
        $this->load->database();
        $this->load->library('session');
        /* cache control */
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 2040 05:00:00 GMT");
    }

    //Default function, redirects to logged in user area
    public function index() {

        if ($this->session->userdata('admin_login') == 1)
            redirect(base_url() . 'index.php?admin/dashboard', 'refresh');


        else if($this->session->userdata('manager_login')==1)
            redirect(base_url().'index.php?manager/dashboard', 'refresh');


       else if($this->session->userdata('maintenance_login')==1)
            redirect(base_url().'index.php?maintenance/dashboard', 'refresh');

       else if($this->session->userdata('cashier_login')==1)
            redirect(base_url().'index.php?cashier/dashboard', 'refresh');

       else if($this->session->userdata('tenant_login')==1)
            redirect(base_url().'index.php?tenant/dashboard', 'refresh');


       else $this->load->view('backend/login');

    }

    //Ajax login function 
    function ajax_login() {
        $response = array();

        //Recieving post input of email, password from ajax request
        $email = $_POST["email"];
        $password = $_POST["password"];
        $response['submitted_data'] = $_POST;

        //Validating login
        $login_status = $this->validate_login($email, $password);
        $response['login_status'] = $login_status;
        if ($login_status == 'success') {
            $response['redirect_url'] = '';
        }

        //Replying ajax request with validation response
        echo json_encode($response);
    }

    //Validating login from ajax request
    function validate_login($email = '', $password = '')
    {

        $credential = array('email' => $email, 'password' => $password,'status'=>'active');


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
            $this->session->set_userdata('admin_login', '1');
            $this->session->set_userdata('id', $row->id);
            $this->session->set_userdata('login_user_id', $row->id);
            $this->session->set_userdata(array('name'=>$row->firstname.' '.$row->lastname));
            $this->session->set_userdata('login_type', 'admin');
            return 'success';
        }

       elseif($manger_query->num_rows()>0)
        {
            $row = $manger_query->row();
            $this->session->set_userdata(array('manager_login'=>'1'));
            $this->session->set_userdata(array('manager_id'=>$row->id));
            $this->session->set_userdata(array('login_user_id'=>$row->id));
            $this->session->set_userdata(array('name'=>$row->firstname.' '.$row->lastname));
            $this->session->set_userdata(array('login_type'=>'manager'));
            return 'success';
        }

        elseif($maintenance_query->num_rows()>0)
        {
            $row = $maintenance_query->row();
            $this->session->set_userdata(array('maintenance_login'=>'1'));
            $this->session->set_userdata(array('maintenance_id'=>$row->id));
            $this->session->set_userdata(array('login_user_id'=>$row->id));
            $this->session->set_userdata(array('name'=>$row->firstname.' '.$row->lastname));
            $this->session->set_userdata(array('login_type'=>'maintenance'));
            return 'success';

        }

        elseif($cashier_query->num_rows()>0)
        {
            $row = $cashier_query->row();
            $this->session->set_userdata(array('cashier_login'=>'1'));
            $this->session->set_userdata(array('cashier_id'=>$row->id));
            $this->session->set_userdata(array('login_user_id'=>$row->id));
            $this->session->set_userdata(array('name'=>$row->firstname.' '.$row->lastname));
            $this->session->set_userdata(array('login_type'=>'cashier'));
            return 'success';

        }



        elseif ($tenant_query->num_rows()>0)
        {
            $row = $tenant_query->row();
            $this->session->set_userdata(array('tenant_login'=>'1'));
            $this->session->set_userdata(array('tenant_id'=>$row->id));
            $this->session->set_userdata(array('login_user_id'=>$row->id));
            $this->session->set_userdata(array('name'=>$row->firstname.' '.$row->middlename));
            $this->session->set_userdata(array('login_type'=>'tenant'));
            $this->session->set_userdata(array('my_room'=>$row->room_number));
            $this->session->set_userdata(array('my_floor'=>$row->floor_number));

            return 'success';
        }


        //check confirmation for cashier

        return 'invalid';
    }

    /*     * *DEFAULT NOR FOUND PAGE**** */

    function four_zero_four() {
        $this->load->view('four_zero_four');
    }

    /*     * *****LOGOUT FUNCTION ****** */

    function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('logout_notification', 'logged_out');
        redirect(base_url(), 'refresh');
    }

}
?>