<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Profil Saya';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        // Get the logged-in user ID from the session
        $logged_in_user_id = $this->session->userdata('role_id');
        // Join tables users and users_role
        $this->db->select('users.*, users_role.role');
        $this->db->from('users');
        $this->db->join('users_role', 'users.role_id = users_role.id', 'left');
        $this->db->where('users.id', $logged_in_user_id);
        $data['users'] = $this->db->get()->row_array();

        $this->load->view('backend/user/index', $data);
    }

    public function editUser()
    {
        $data['title'] = 'Ubah Profil';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        // Rule validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim', [
            'required' => 'Inputan Nama harus diisi.'
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('backend/user/editUser', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // Cek jika ada gambar yg diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types']    = 'gif|jpg|jpeg|png';
                $config['max_size']         = '2048'; // maksimal ukuran file dalam KB
                $config['upload_path']      = './assets/image/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/image/profile/' . $old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    $error = $this->upload->display_errors();

                    if (strpos($error, 'The uploaded file exceeds the maximum allowed size in your PHP configuration file') !== false) {
                        $error = 'Ukuran gambar maksimum 2MB';
                    } else if (strpos($error, 'The filetype you are attempting to upload is not allowed') !== false) {
                        $error = 'Format gambar harus (GIF, JPG, PNG)';
                    }
                    $this->session->set_flashdata('swal_icon', 'error');
                    $this->session->set_flashdata('swal_title', 'Gagal Mengunggah Gambar');
                    $this->session->set_flashdata('swal_text', $error);
                    redirect('user/editUser');
                    return;
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('users');

            if ($this->db->affected_rows() > 0) {
                // Jika berhasil, set pesan sukses
                $this->session->set_flashdata('swal_icon', 'success');
                $this->session->set_flashdata('swal_title', 'Berhasil');
                $this->session->set_flashdata('swal_text', 'Profil berhasil diperbarui!');
            } else {
                // Jika tidak ada baris yang terpengaruh, set pesan error
                $this->session->set_flashdata('swal_icon', 'error');
                $this->session->set_flashdata('swal_title', 'Oops...');
                $this->session->set_flashdata('swal_text', 'Gagal memperbarui data profil!');
            }

            redirect('user');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Ubah Password';
        $data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

        // Rule validation
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim', [
            'required' => 'Password saat ini harus diisi.'
        ]);
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[8]|matches[new_password2]', [
            'required' => 'Password baru harus diisi.',
            'min_length' => 'Password minimal 8 karakter.',
            'matches' => 'Password tidak sesuai dengan konfirmasi password.',
        ]);
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[8]|matches[new_password1]', [
            'required' => 'Konfirmasi Password baru harus diisi.',
            'min_length' => 'Password minimal 8 karakter.',
            'matches' => 'Konfirmasi Password tidak sesuai dengan password.',
        ]);

        if ($this->form_validation->run() == false) {
            $this->load->view('backend/user/changePassword', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['user']['password'])) {
                // set pesan
                $this->session->set_flashdata('swal_icon', 'error');
                $this->session->set_flashdata('swal_title', 'Oops...');
                $this->session->set_flashdata('swal_text', 'Password saat ini salah!');

                redirect('user/changePassword');
            } else {
                if ($current_password == $new_password) {
                    // set pesan
                    $this->session->set_flashdata('swal_icon', 'error');
                    $this->session->set_flashdata('swal_title', 'Oops...');
                    $this->session->set_flashdata('swal_text', 'Password baru tidak boleh sama dengan password saat ini!');

                    redirect('user/changePassword');
                } else {
                    // Password OK
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('users');

                    // set pesan
                    $this->session->set_flashdata('swal_icon', 'success');
                    $this->session->set_flashdata('swal_title', 'Berhasil');
                    $this->session->set_flashdata('swal_text', 'Password telah diperbarui!');

                    redirect('user');
                }
            }
        }
    }
}
