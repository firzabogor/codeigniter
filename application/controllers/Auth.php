<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
        parent::__construct();
        $this->load->model('user_model');
	}

    public function register(){
        $this->form_validation->set_rules('email', 'Email', 'required|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password]');

        if($this->form_validation->run() === FALSE){
            $this->load->view('layouts/header');
            $this->load->view('auth/register');
        } else {
            $this->user_model->register();
            $this->send_email_verification($this->input->post('email'), $_SESSION['token']);
            redirect('login');
        }
    }

    public function send_email_verification($email, $token){
        $this->load->library('email');
        $this->email->from('firza@unsia.ac.id', 'Firzatullah');
        $this->email->to($email);
        $this->email->subject('register aplikasi auth localhost');
        $this->email->message("
        Klik untuk konfigurasi pendaftaran
        <a href='http://localhost/codeigniter/verify/$email/$token'/>Konfirmasi Email</a>
        ");
        $this->email->set_mailtype('html');
        $this->email->send();
    }

    public function verify($email, $token){
        $user = $this->user_model->get_user('email', $email);

        if($user == FALSE){
            die('Email tidak ditemukan!');
        }

        if($user['token'] !== $token){
            die('Token tidak cocok!');
        }

        $this->user_model->update_role($user['id'], 1);

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['logged_in'] = TRUE;

        redirect('profile');
    }

    public function login(){
        if($this->user_model->is_LoggedIn()){
            redirect('profile');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|callback_checkEmail|callback_checkRole');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_checkPassword');

        if($this->form_validation->run() === FALSE){
            $this->load->view('layouts/header');
            $this->load->view('auth/login');
        } else {
            $user = $this->user_model->get_user('email', $this->input->post('email'));
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['logged_in'] = TRUE;

            redirect('profile');
        }
    }

    public function logout(){
        session_destroy();
        redirect('login');
    }

    public function checkEmail($email){
        if(!$this->user_model->get_user('email',$email)){
            $this->form_validation->set_message('checkEmail', 'Email belum terdaftar');
            return FALSE;
        }

        return TRUE;
    }

    public function checkPassword($password){
        $user = $this->user_model->get_user('email', $this->input->post('email'));
        if(!$this->user_model->check_password($user['email'], $password)){
            $this->form_validation->set_message('checkPassword', 'Password yang dimasukan salah!');
            return FALSE;
        }

        return TRUE;
    }

    public function checkRole($email){
        $user = $this->user_model->get_user('email', $this->input->post('email'));
        if($user['role'] == 0){
            $this->form_validation->set_message('checkRole', 'Email belum aktif!');
            return FALSE;
        }

        return TRUE;
    }
}
