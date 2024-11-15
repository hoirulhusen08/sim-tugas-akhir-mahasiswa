<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		is_logged_in();
	}

	public function index()
	{
		// Hitung total user
		$data['title'] = 'Dashboard';
		// $data['oneTitle'] = substr($data['title'], strrpos($data['title'], ' ') + 1);

		$data['users_count'] = $this->db->count_all('users');
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$this->load->view('backend/admin/index', $data);
	}

	// ============================= ROLE ======================================

	public function role()
	{
		$data['title'] = 'Peran';
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$data['roles'] = $this->db->order_by('id', 'DESC')->get('users_role')->result_array();

		// Rules validation
		$this->form_validation->set_rules('role', 'Role', 'required|trim|min_length[3]', [
			'required' => 'Inputan Peran tidak boleh kosong.',
			'min_length' => 'Nama Peran minimal 3 karakter.'
		]);

		// Add New Role
		if ($this->form_validation->run() == false) {
			$this->load->view('backend/admin/role', $data);
		} else {
			$this->db->insert('users_role', ['role' => $this->input->post('role')]);

			// Jika success
			$this->session->set_flashdata('swal_icon', 'success');
			$this->session->set_flashdata('swal_title', 'Berhasil');
			$this->session->set_flashdata('swal_text', 'Data peran telah ditambahkan!');

			redirect('admin/role');
		}
	}

	public function editRole()
	{
		$id = $this->input->post('id');
		$role = $this->input->post('role');

		$data = ['role' => $role];

		$this->db->where('id', $id);
		$this->db->update('users_role', $data);

		if ($this->db->affected_rows() > 0) {
			// Jika berhasil, set pesan sukses
			$this->session->set_flashdata('swal_icon', 'success');
			$this->session->set_flashdata('swal_title', 'Berhasil');
			$this->session->set_flashdata('swal_text', 'Data peran telah diperbarui!');
		} else {
			// Jika tidak ada baris yang terpengaruh, set pesan error
			$this->session->set_flashdata('swal_icon', 'error');
			$this->session->set_flashdata('swal_title', 'Oops...');
			$this->session->set_flashdata('swal_text', 'Data peran gagal diperbarui!');
		}

		redirect('admin/role');
	}

	public function deleteRole($id)
	{
		// Periksa apakah role adalah "Administrator" atau memiliki id "1"
		$role = $this->db->get_where('users_role', ['id' => $id])->row_array();
		if ($role['role'] === 'Administrator' || $id == 1) {
			// Jika ya, tampilkan pesan bahwa role tidak bisa dihapus
			$this->session->set_flashdata('swal_icon', 'error');
			$this->session->set_flashdata('swal_title', 'Oops...');
			$this->session->set_flashdata('swal_text', 'Peran Administrator tidak bisa dihapus!');
		} else {
			// Lakukan penghapusan data dari tabel
			$this->db->where('id', $id);
			$this->db->delete('users_role');

			// Periksa apakah penghapusan berhasil
			if ($this->db->affected_rows() > 0) {
				// Jika berhasil, set pesan sukses
				$this->session->set_flashdata('swal_icon', 'success');
				$this->session->set_flashdata('swal_title', 'Berhasil');
				$this->session->set_flashdata('swal_text', 'Data peran telah dihapus!');
			}
		}

		// Redirect ke halaman yang sesuai
		redirect('admin/role');
	}

	// ============================= ROLE ACCESS ======================================

	public function roleAccess($role_id)
	{
		$data['mainTitle'] = 'Peran';
		$data['title'] = 'Hak Akses';
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$data['role'] = $this->db->get_where('users_role', ['id' => $role_id])->row_array();

		$this->db->where('id !=', 1);
		$data['menus'] = $this->db->get('user_menus')->result_array();

		$this->load->view('backend/admin/roleAccess', $data);
	}

	public function changeAccess()
	{
		$menu_id = $this->input->post('menuId');
		$role_id = $this->input->post('roleId');

		$data = [
			'role_id' => $role_id,
			'menu_id' => $menu_id
		];

		$result = $this->db->get_where('user_access_menus', $data);

		if ($result->num_rows() < 1) {
			$this->db->insert('user_access_menus', $data);
		} else {
			$this->db->delete('user_access_menus', $data);
		}

		// Jika berhasil, set pesan sukses
		$this->session->set_flashdata('swal_icon', 'success');
		$this->session->set_flashdata('swal_title', 'Berhasil');
		$this->session->set_flashdata('swal_text', 'Hak akses telah diperbarui!');
	}


	// =============================== FOR ALL USER ===============================
	public function manageAllUser()
	{
		$data['title'] = 'Manajemen Pengguna';
		$data['user'] = $this->db->get_where('users', ['email' => $this->session->userdata('email')])->row_array();

		$data['roles'] = $this->db->get('users_role')->result_array();
		$data['allDosen'] = $this->db->get('dosen')->result_array();

		// Join tabel users dan users_role
		$this->db->select('users.*, users_role.role');
		$this->db->from('users');
		$this->db->join('users_role', 'users.role_id = users_role.id', 'left');
		$this->db->order_by('users.id', 'DESC');
		$data['users'] = $this->db->get()->result_array();

		// Rules validation
		$this->form_validation->set_rules('name', 'Name', 'required|trim', [
			'required' => 'Kolom nama wajib diisi.',
		]);
		$this->form_validation->set_rules('role', 'Role', 'required', [
			'required' => 'Kolom peran wajib diisi.',
		]);
		$this->form_validation->set_rules('nbm_npm', 'NBM/NPM', 'required', [
			'required' => 'Kolom peran wajib diisi.',
		]);

		if ($this->form_validation->run() == false) {
			// Simpan nama file yang diunggah pengguna ke dalam sesi jika validasi gagal
			if (validation_errors()) {
				$this->session->set_userdata('uploaded_image', $this->input->post('image'));
			}

			$this->load->view('backend/admin/manageAllUser', $data);
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
			$role_id = $this->input->post('role');
			// Tentukan jenis_pengguna berdasarkan role
			$jenis_pengguna = ($role_id == 2) ? 'Mahasiswa' : 'Dosen';

			// Proses insert ke tabel users
			$data = [
				'kode_user' => $kode_user,
				'id_mhs' => null, // Diisi nanti jika peran Mahasiswa
				'id_dosen' => null, // Diisi nanti jika peran Dosen
				'jenis_pengguna' => $jenis_pengguna, // Diisi dengan jenis pengguna
				'name' => htmlspecialchars($this->input->post('name', true)),
				'role_id' => $role_id,
				'is_active' => 1,
				'date_created' => time()
			];

			if ($role_id == 2) { // Peran Mahasiswa
				$dataMahasiswa = [
					'nama' => htmlspecialchars($this->input->post('name', true)),
					'npm' => htmlspecialchars($this->input->post('nbm_npm', true)),
					'nama_pa' => htmlspecialchars($this->input->post('nama_pa', true)),
				];
				$this->db->insert('mahasiswa', $dataMahasiswa);
				$data['id_mhs'] = $this->db->insert_id(); // Mendapatkan id terakhir yang diinsert
			} else { // Peran Dosen
				$dataDosen = [
					'nama' => htmlspecialchars($this->input->post('name', true)),
					'nbm' => htmlspecialchars($this->input->post('nbm_npm', true)),
				];
				$this->db->insert('dosen', $dataDosen);
				$data['id_dosen'] = $this->db->insert_id(); // Mendapatkan id terakhir yang diinsert
			}

			// Cek jika ada gambar yg diupload
			$upload_image = $_FILES['image']['name'];

			if ($upload_image) {
				$config['allowed_types']    = 'gif|jpg|jpeg|png';
				$config['max_size']         = '2048';
				$config['upload_path']      = './assets/image/profile/';

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					$data['image'] = $this->upload->data('file_name');
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
					redirect('admin/manageAllUser');
					return;
				}
			} else {
				$data['image'] = 'default.jpg';
			}

			// Insert data pengguna general
			$this->db->insert('users', $data);

			// Jika berhasil, set pesan sukses
			$this->session->set_flashdata('swal_icon', 'success');
			$this->session->set_flashdata('swal_title', 'Berhasil');
			$this->session->set_flashdata('swal_text', 'Pengguna baru berhasil didaftarkan!');

			redirect('admin/manageAllUser');
		}
	}

	public function editGeneralUser()
	{
		$user['user'] = $this->db->get_where('users', ['id' => $this->input->post('id')])->row_array();

		// Rule validation
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]|trim|matches[confirm_pass_edit_user]', [
			'min_length' => 'Password minimal 8 karakter.',
			'matches' => 'Password tidak sama dengan konfirmasi password.'
		]);
		$this->form_validation->set_rules('confirm_pass_edit_user', 'Confirm Password', 'min_length[8]|trim|matches[password]', [
			'min_length' => 'Konfirmasi password minimal 8 karakter.',
			'matches' => 'Konfirmasi password tidak sama dengan password.'
		]);

		if ($this->form_validation->run() == false) {
			// Simpan pesan validasi form ke dalam session
			$this->session->set_flashdata('validation_errors', validation_errors());
			redirect('admin/manageAllUser');
		} else {
			$id = $this->input->post('id');
			$is_active = $this->input->post('is_active');
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$role_id = $this->input->post('role_id');
			$password = $this->input->post('password');

			// Cek jika password diubah
			if (!empty($password)) {
				if (password_verify($password, $user['user']['password'])) {
					// Jika error, pass baru sama dengan pass lama
					$this->session->set_flashdata('swal_icon', 'error');
					$this->session->set_flashdata('swal_title', 'Oops...');
					$this->session->set_flashdata('swal_text', 'Password baru sama dengan password lama!');
					redirect('admin/manageAllUser');
				} else {
					$password = password_hash($password, PASSWORD_DEFAULT);
				}
			} else {
				// Gunakan password lama jika tidak ada perubahan
				$password = $user['user']['password'];
			}

			// Cek jika ada gambar yg diupload
			$upload_image = $_FILES['image']['name'];

			if ($upload_image) {
				$config['allowed_types']    = 'gif|jpg|jpeg|png';
				$config['max_size']         = '2048';
				$config['upload_path']      = './assets/image/profile/';

				$this->load->library('upload', $config);

				if ($this->upload->do_upload('image')) {
					$old_image = $user['user']['image'];
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
					redirect('admin/manageAllUser');
					return;
				}
			}
			// End upload image

			$data = [
				'is_active' => $is_active,
				'name' => $name,
				'email' => $email,
				'role_id' => $role_id,
				'password' => $password,
			];

			$this->db->where('id', $id);
			$this->db->update('users', $data);

			if ($this->db->affected_rows() > 0) {
				// Jika berhasil, set pesan sukses
				$this->session->set_flashdata('swal_icon', 'success');
				$this->session->set_flashdata('swal_title', 'Berhasil');
				$this->session->set_flashdata('swal_text', 'Pengguna berhasil diperbarui!');
			} else {
				// Jika tidak ada baris yang terpengaruh, set pesan error
				$this->session->set_flashdata('swal_icon', 'error');
				$this->session->set_flashdata('swal_title', 'Oops...');
				$this->session->set_flashdata('swal_text', 'Kesalahan dalam memperbarui data pengguna!');
			}

			redirect('admin/manageAllUser');
		}
	}

	public function deleteGeneralUser($id)
	{
		// Mengambil data user berdasarkan ID
		$user = $this->db->where('id', $id)->get('users')->row_array();

		// Pastikan data user ditemukan
		if ($user) {
			// Periksa apakah role adalah "Administrator" atau memiliki id "1"
			if ($user['role_id'] == 1) {
				// Jika ya, tampilkan pesan bahwa role tidak bisa dihapus
				$this->session->set_flashdata('swal_icon', 'error');
				$this->session->set_flashdata('swal_title', 'Oops...');
				$this->session->set_flashdata('swal_text', 'Peran administrator tidak bisa dihapus!');
			} else {
				$image = $user['image'];

				// Periksa apakah gambar bukan default.jpg sebelum menghapusnya
				if ($image != 'default.jpg') {
					// Hapus gambar dari direktori
					unlink(FCPATH . 'assets/image/profile/' . $image);
				}

				// Lakukan penghapusan data dari tabel
				$this->db->where('id', $id);
				$this->db->delete('users');

				// Periksa apakah penghapusan berhasil
				if ($this->db->affected_rows() > 0) {
					// Jika berhasil, set pesan sukses
					$this->session->set_flashdata('swal_icon', 'success');
					$this->session->set_flashdata('swal_title', 'Berhasil');
					$this->session->set_flashdata('swal_text', 'Pengguna berhasil dihapus!');
				} else {
					// Jika tidak ada baris yang terpengaruh, set pesan error
					$this->session->set_flashdata('swal_icon', 'error');
					$this->session->set_flashdata('swal_title', 'Oops...');
					$this->session->set_flashdata('swal_text', 'Pengguna gagal dihapus!');
				}
			}
		} else {
			// Jika data user tidak ditemukan, set pesan error
			$this->session->set_flashdata('swal_icon', 'error');
			$this->session->set_flashdata('swal_title', 'Oops...');
			$this->session->set_flashdata('swal_text', 'Pengguna tidak ditemukan!');
		}

		// Redirect ke halaman yang sesuai
		redirect('admin/manageAllUser');
	}
}
