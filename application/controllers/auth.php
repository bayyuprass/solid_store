<?php
class Auth extends CI_Controller
{
    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required', ['required' => 'Username Wajib diisi!']);

        $this->form_validation->set_rules('password', 'Password', 'required', ['required' => 'Password Wajib diisi!']);

        // Membuat form validation
        // Ini artinya apabila form validation nya gk berjalan / salah maka akan kek bawah ini
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('templates/header');
            $this->load->view('form_login');
            $this->load->view('templates/footer');
        } else {
            // else ini apabila berhasil
            $auth = $this->model_auth->cek_login();

            if ($auth == FALSE) {
                // Untuk ngasih tau kalau gagal login
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
                <strong>Username atau Password</strong> anda salah!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
               
                </button>
                </button>
              </div>');
                redirect('auth/login');
            } else {
                // =============================== 
                $this->session->set_userdata('username', $auth->username);
                $this->session->set_userdata('role_id', $auth->role_id); // role_id yang tadi dibuat di table

                switch ($auth->role_id) {
                        // jadi disini role_id 1 = admin
                        // jadi disini role_id 2 = user
                    case 1:

                        redirect('admin/dashboard_admin');
                        break;
                    case 2:
                        redirect('welcome');
                        break;
                    default:
                        break;
                }
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message','kamu berhasil LOGOUT');
        redirect('auth/login');
    }
}
