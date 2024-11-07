<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
	// Halaman Login
	public function index()
	{
		// Jika sudah login tak boleh akses
		if ($this->session->userdata('email')) {
			redirect('/');
		}

		// Rules validation
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
			'required' => 'Inputan Email harus diisi.',
			'valid_email' => 'Email tidak sesuai.'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|trim', [
			'required' => 'Inputan Password harus diisi.'
		]);

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Halaman Login';
			$this->load->view('auth/login', $data);
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
						$this->session->set_flashdata('message', '<div class="alert my-alert-success alert-dismissible fade show text-center" role="alert">
							<strong>Selamat Datang</strong> Administrator di halaman Dashboard!
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>');

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

					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <strong>Upss...</strong> email terkait belum diaktivasi!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');

				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Upss...</strong> email terkait belum pernah terdaftar!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>');

			redirect('auth');
		}
	}

	// Halaman Register
	public function register()
	{
		// Jika sudah login tak boleh akses
		if ($this->session->userdata('email')) {
			redirect('/');
		}

		// Rules validation
		$this->form_validation->set_rules('name', 'Name', 'required|trim', [
			'required' => 'Inputan Nama harus diisi.'
		]);
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
			'required' => 'Inputan Email harus diisi.',
			'valid_email' => 'Email tidak sesuai.',
			'is_unique' => 'Email terkait sudah terdaftar.'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|matches[password2]', [
			'required' => 'Inputan Password harus diisi.',
			'min_length' => 'Password minimal 8 karakter.',
			'matches' => 'Kedua Password tidak sesuai.'
		]);
		$this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password]');

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Halaman Registrasi';
			$this->load->view('auth/register', $data);
		} else {

			// ========= SKEMA CREATE KODE USER =========
			// Lakukan query untuk mengambil nomor terakhir dari tabel
			$query = $this->db->query('SELECT MAX(id) AS last_id FROM users');
			$row = $query->row();
			$user_code = $row->last_id;

			// Pastikan untuk menangani kasus ketika tabel kosong
			if ($user_code === NULL) {
				$user_code = 0;
			}

			$kode_user = 'ID-' . date('d-m-Y') . '-' . $user_code;
			$email = $this->input->post('email', true);

			$data = [
				'kode_user' => $kode_user,
				'name' => htmlspecialchars($this->input->post('name', true)),
				'email' => htmlspecialchars($email),
				'image' => 'default.jpg',
				'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
				'role_id' => $_ENV['MEMBER_ROLE_DEFAULT_REGISTRED'],
				'is_active' => $_ENV['ACTIVE_MEMBER_DEFAULT'],
				'date_created' => time()
			];

			// Siapkan token untuk email
			$token = base64_encode(random_bytes(32));
			$user_token = [
				'email' => $email,
				'token' => $token,
				'date_created' => time()
			];

			$this->db->insert('users', $data);
			$this->db->insert('user_token', $user_token);

			$this->_sendEmail($token, 'verify');

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Berhasil...</strong> akun kamu telah didaftarkan, cek email untuk aktivasi akun! <a href="https://mail.google.com" target="_blank">Buka Gmail</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>');

			redirect('auth');
		}
	}

	private function _sendEmail($token, $type)
	{
		$config = [
			'protocol'  => $_ENV['EMAIL_PROTOCOL'],
			'smtp_host' => $_ENV['EMAIL_SMTP_HOST'],
			'smtp_user' => $_ENV['EMAIL_SMTP_USER'],
			'smtp_pass' => $_ENV['EMAIL_SMTP_PASS'],
			'smtp_port' => $_ENV['EMAIL_SMTP_PORT'],
			'mailtype'  => $_ENV['EMAIL_MAILTYPE'],
			'charset'   => $_ENV['EMAIL_CHARSET'],
			'newline'   => $_ENV['EMAIL_NEWLINE'],
		];

		$this->load->library('email', $config);
		$this->email->initialize($config);

		$this->email->from($_ENV['EMAIL_SENDER'], $_ENV['EMAIL_NAME']);

		if ($type == 'verify') {
			$this->email->to($this->input->post('email'));
			$this->email->subject('Verifikasi Akun Kamu');
			$this->email->message('Hi, ' . $this->input->post('name') . '.<br> Klik link ini untuk verifikasi akun kamu : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Link Aktivasi</a>');
		} else if ($type == 'forgot') {
			$this->email->to($this->input->post('forgot_password'));
			$this->email->subject('Atur Ulang Password');
			$this->email->message('Hi, ' . $this->input->post('forgot_password') . '.<br> Klik link ini untuk atur ulang password : <a href="' . base_url() . 'auth/resetPassword?email=' . $this->input->post('forgot_password') . '&token=' . urlencode($token) . '">Atur Ulang Password</a>');
		}

		if ($this->email->send()) {
			return true;
		} else {
			echo $this->email->print_debugger();
			die;
		}
	}

	// Verifikasi dari link email
	public function verify()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

			if ($user_token) {

				if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
					$this->db->set('is_active', 1);
					$this->db->where('email', $email);
					$this->db->update('users');

					$this->db->delete('user_token', ['email' => $email]);

					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                    <strong>' . $email . '</strong> berhasil diaktivasi, silahkan login!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');

					redirect('auth');
				} else {
					// Hapus user baru jika expired
					$this->db->delete('users', ['email' => $email]);
					$this->db->delete('user_token', ['token' => $token]);

					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                    <strong>Gagal...</strong> aktivasi gagal dilakukan, token kedaluwarsa karena sudah lebih dari 24 Jam! <a href="' . base_url('auth/register') . '">Daftar Ulang</a>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>');

					redirect('auth');
				}
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Gagal...</strong> aktivasi gagal dilakukan, token salah!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');

				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>Gagal...</strong> aktivasi gagal dilakukan, email salah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>');

			redirect('auth');
		}
	}

	// Halaman Forgot Password
	public function forgotPassword()
	{
		// Jika sudah login tak boleh akses
		if ($this->session->userdata('email')) {
			redirect('/');
		}

		// Rules validation
		$this->form_validation->set_rules('forgot_password', 'Forgot Password', 'required|trim|valid_email', [
			'required' => 'Inputan Email harus diisi.',
			'valid_email' => 'Memasukan email yang salah.'
		]);

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Halaman Lupa Password';
			$this->load->view('auth/forgot-password', $data);
		} else {
			// Validasi Success
			$email = $this->input->post('forgot_password');
			$user = $this->db->get_where('users', ['email' => $email, 'is_active' => 1])->row_array();

			if ($user) {
				$token = base64_encode(random_bytes(32));
				$user_token = [
					'email' => $email,
					'token' => $token,
					'date_created' => time()
				];

				$this->db->insert('user_token', $user_token);
				$this->_sendEmail($token, 'forgot');

				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <strong>Berhasil...</strong> cek email untuk atur ulang password!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');

				// Redirect ke halaman login atau halaman lain yang sesuai
				redirect('auth/forgotPassword');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Gagal...</strong> email terkait belum terdaftar atau teraktivasi!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');

				// Redirect ke halaman login atau halaman lain yang sesuai
				redirect('auth/forgotPassword');
			}
		}
	}

	public function resetPassword()
	{
		$email = $this->input->get('email');
		$token = $this->input->get('token');

		$user = $this->db->get_where('users', ['email' => $email])->row_array();

		if ($user) {
			$user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

			if ($user_token) {
				$this->session->set_userdata('reset_email', $email);
				$this->changePassword();
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>Gagal...</strong> mengatur ulang password, token salah!
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>');

				// Redirect ke halaman login atau halaman lain yang sesuai
				redirect('auth');
			}
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
            <strong>Gagal...</strong> mengatur ulang password, email salah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>');

			// Redirect ke halaman login atau halaman lain yang sesuai
			redirect('auth');
		}
	}

	public function changePassword()
	{
		if (!$this->session->userdata('reset_email')) {
			redirect('auth');
		}

		// Rules validation
		$this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[8]|matches[password2]', [
			'required' => 'Inputan Password harus diisi.',
			'min_length' => 'Minimal karakter password 8.',
			'matches' => 'Password tidak sama dengan konfirmasi password.'
		]);
		$this->form_validation->set_rules('password2', 'Confirm Password', 'required|trim|min_length[8]|matches[password]', [
			'required' => 'Inputan Konfirmasi Password harus diisi.',
			'min_length' => 'Minimal karakter password 8.',
			'matches' => 'Konfirmasi Password tidak sama dengan password.'
		]);

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Ubah Password';
			$this->load->view('auth/change-password', $data);
		} else {
			// Validasi Success
			$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			$email =  $this->session->userdata('reset_email');

			$this->db->set('password', $password);
			$this->db->where('email', $email);
			$this->db->update('users');

			$this->session->unset_userdata('reset_email');
			$this->db->delete('user_token', ['email' => $email]);

			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <strong>Berhasil...</strong> password anda telah diubah!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>');

			// Redirect ke halaman login atau halaman lain yang sesuai
			redirect('auth');
		}
	}

	// Fungsi Block Akses
	public function blocked()
	{
		$data['title'] = 'Akses Terlarang';
		$this->load->view('auth/blocked', $data);
	}

	// Fungsi Logout
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
		redirect('auth');
	}
}
