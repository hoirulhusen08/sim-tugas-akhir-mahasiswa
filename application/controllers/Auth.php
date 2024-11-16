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

	// Cek NBM atau NPM
	public function checkNbmNpm()
	{
		// Validasi input NBM/NPM
		$this->form_validation->set_rules('nbm_npm', 'NBM/NPM', 'required|trim', [
			'required' => 'Inputan ini tidak boleh kosong!'
		]);

		if ($this->form_validation->run() == false) {
			$data['title'] = 'Halaman Registrasi';
			$this->load->view('auth/register', $data);
		} else {
			// Proses pengecekan NBM/NPM di database
			$inputNbmNpm = $this->input->post('nbm_npm');

			// Cek di tabel mahasiswa
			$this->db->where('npm', $inputNbmNpm);
			$mahasiswa = $this->db->get('mahasiswa')->row_array();

			// Cek di tabel dosen
			$this->db->where('nbm', $inputNbmNpm);
			$dosen = $this->db->get('dosen')->row_array();

			if ($mahasiswa || $dosen) {
				$id_mhs_dosen = $mahasiswa ? $mahasiswa['id'] : $dosen['id'];
				$field_id = $mahasiswa ? 'id_mhs' : 'id_dosen';

				// Cek di tabel users apakah id_mhs atau id_dosen sudah digunakan
				$this->db->where($field_id, $id_mhs_dosen);
				$user = $this->db->get('users')->row_array();

				if (!empty($user['email'])) {
					// Jika sudah pernah membuat akun dan email sudah terisi, beri pesan error
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
						Maaf, <strong>"NBM/NPM"</strong> ini sudah digunakan untuk membuat akun. Anda tidak dapat mendaftar lagi, silahkan Login!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
					$this->session->set_flashdata('nbm_npm_invalid', true);
					$this->session->set_flashdata('input_nbm_npm_exist', $inputNbmNpm); // Mengisi inputan tetap ada
					$this->session->set_userdata('input_nbm_npm', $inputNbmNpm); // Menyimpan NBM/NPM agar tetap ada
					redirect('auth/register');
				} else {
					$name = $mahasiswa ? $mahasiswa['nama'] : $dosen['nama'];

					// Jika NBM/NPM valid dan belum digunakan, simpan status ke session
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
						NBM/NPM berhasil diverifikasi, Anda terdaftar sebagai <strong><u>' . $name . '</u></strong>. Silakan lanjutkan Pendaftaran!
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>');
					$this->session->set_flashdata('nbm_npm_valid', true);
					$this->session->set_flashdata('input_nbm_npm_exist', $inputNbmNpm); // Mengisi inputan tetap ada
					$this->session->set_userdata('input_nbm_npm', $inputNbmNpm); // Menyimpan NBM/NPM agar tetap ada
					redirect('auth/register');
				}
			} else {
				// Jika NBM/NPM tidak valid, beri pesan error
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
					Maaf <strong>"NBM/NPM"</strong> terkait belum didaftarkan Admin!
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>');
				$this->session->set_flashdata('nbm_npm_invalid', true);
				$this->session->set_flashdata('input_nbm_npm_exist', $inputNbmNpm); // Mengisi inputan tetap ada
				$this->session->set_userdata('input_nbm_npm', $inputNbmNpm); // Menyimpan NBM/NPM agar tetap ada
				redirect('auth/register');
			}
		}
	}

	// Halaman Register
	public function register()
	{
		// Validasi form input email dan password
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim', [
			'required' => 'Inputan ini tidak boleh kosong!',
			'valid_email' => 'Email yang dimasukan tidak valid!'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|trim', [
			'required' => 'Inputan ini tidak boleh kosong!',
			'min_length' => 'Panjang minimal 6 Karakter!'
		]);
		$this->form_validation->set_rules('password2', 'Konfirmasi Password', 'required|matches[password]|trim', [
			'required' => 'Inputan ini tidak boleh kosong!',
			'matches' => 'Konfirmasi tidak cocok!'
		]);

		if ($this->form_validation->run() == false) {
			// Jika validasi gagal, tampilkan form kembali dengan pesan error
			$this->load->view('auth/register');
			return;
		}

		// Ambil inputan email dan password
		$email = $this->input->post('email');
		$password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);

		// Ambil NBM/NPM dari sesi
		$nbm_npm = $this->session->userdata('input_nbm_npm');

		// Cek di tabel mahasiswa dan dosen, kemudian dapatkan ID yang sesuai
		$mahasiswa = $this->db->get_where('mahasiswa', ['npm' => $nbm_npm])->row_array();
		$dosen = $this->db->get_where('dosen', ['nbm' => $nbm_npm])->row_array();
		$userEmail = $this->db->get_where('users', ['email' => $email])->row_array();

		$user_id = null;
		if (!empty($mahasiswa) && isset($mahasiswa['id'])) {
			$user_id = $mahasiswa['id']; // ID mahasiswa yang sesuai
		} elseif (!empty($dosen) && isset($dosen['id'])) {
			$user_id = $dosen['id']; // ID dosen yang sesuai
		}

		if ($user_id === null) {
			// Jika data tidak ditemukan, tampilkan pesan error
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
				<strong>Upss...</strong> Data NBM/NPM tidak ditemukan, pastikan sudah didaftarkan oleh Admin dan cek kembali!
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			$this->load->view('auth/register');
			return;
		}

		if ($userEmail['email'] == $email) {
			// Jika email sudah ada di database, tampilkan pesan error
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
				<strong>Upss...</strong> Email terkait sudah terdaftar di database!
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			$this->load->view('auth/register');
			return;
		}

		// Perbarui data di tabel users berdasarkan ID
		$this->db->set('email', $email);
		$this->db->set('password', $password);
		$this->db->where('id_mhs', $user_id); // Sesuaikan dengan nama kolom ID di tabel users
		$this->db->or_where('id_dosen', $user_id); // Sesuaikan dengan nama kolom ID di tabel users
		$this->db->update('users');

		if ($this->db->affected_rows() > 0) {
			$name = $mahasiswa ? $mahasiswa['nama'] : $dosen['nama'];

			// Set pesan sukses untuk flashdata
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
				Akun <strong>'. $name .'</strong> berhasil dibuat. Silahkan login disini!
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			$this->session->unset_userdata('input_nbm_npm'); // Hapus session input_nbm_npm setelah berhasil
			redirect('auth'); // Redirect ke halaman login setelah pendaftaran berhasil
		} else {
			// Tampilkan pesan error jika gagal memperbarui data
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
				<strong>Upss...</strong> Gagal memperbarui data. Ada yang salah, coba lagi!
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>');
			$this->load->view('auth/register');
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
