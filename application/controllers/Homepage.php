<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Homepage extends CI_Controller
{
	public function index()
	{
		$data['title'] = 'Halaman Beranda';
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('frontend/landing-page/beranda', $data);

		// Rules validation
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
			'required' => 'Inputan Email harus diisi.',
			'valid_email' => 'Email tidak sesuai.'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|trim', [
			'required' => 'Inputan Password harus diisi.'
		]);

		if ($this->form_validation->run() == false) {
			// Redirect error page
		} else {
			// Validasi Success
			$this->_login();
		}
	}

	private function _login()
	{
		$email = $this->input->post('email');
		$password = $this->input->post('password');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		// Jika user ada
		if ($user !== null) {
			// Jika user aktif by email
			if ($user['is_active'] == 1) {
				// Cek password
				if (password_verify($password, $user['password'])) {
					$data = [
						'email' => $user['email'],
						'role_id' => $user['role_id']
					];
					$this->session->set_userdata($data);

					// Cek remember me
					// if (!empty($this->input->post('remember'))) {
					//     setcookie('loginId', $data['role_id'], time() + (10 * 365 * 24 * 60 * 60));
					//     setcookie('loginKey', $data['email'], time() + (10 * 365 * 24 * 60 * 60));
					// } else {
					//     setcookie('loginId', '');
					//     setcookie('loginKey', '');
					// }

					if ($user['role_id'] == 1) {
						redirect('admin');
					} else if ($user['role_id'] == 2) {
						redirect('/');
					} else {
						redirect('user');
					}
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        <strong>Upss...</strong> password tidak sesuai!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');

					redirect('/');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <strong>Upss...</strong> email terkait belum diaktivasi!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');

				redirect('/');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Upss...</strong> email terkait belum pernah terdaftar!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>');

			redirect('/');
		}
	}

	public function logout()
	{
		// Hapus session 'email' dan 'role_id'
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('role_id');

		// Set pesan sukses untuk flashdata
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        <strong>Berhasil...</strong> kamu telah keluar!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>');

		// Redirect ke halaman login atau halaman lain yang sesuai
		redirect('/');
	}
}
