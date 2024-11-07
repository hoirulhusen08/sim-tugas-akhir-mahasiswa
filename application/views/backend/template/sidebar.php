<aside class="main-sidebar my-sidebar-dark-primary elevation-4">

    <a href="javascript:void(0)" class="brand-link">
        <img src="<?= base_url('assets/image/logo.png'); ?>" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"> Panel
            <!-- Info Panel -->
            <?php
            if ($this->session->userdata('role_id') == 1) {
                echo "Staff";
            } else if ($this->session->userdata('role_id') == 2) {
                echo "Mahasiswa";
            } else if ($this->session->userdata('role_id') == 3) {
                echo "PA";
            } else if ($this->session->userdata('role_id') == 4) {
                echo "Kaprodi";
            } else if ($this->session->userdata('role_id') == 5) {
                echo "Dekan";
            }
            ?>
        </span>
    </a>

    <div class="sidebar">

        <div class="user-panel my-user-panel-sidebar p-2 mb-3 w-100 d-flex">
            <div class="image">
                <img src="<?= base_url('assets/image/profile/') . $user['image']; ?>" class="img-circle elevation-2" alt="Image">
            </div>
            <div class="info">
                <span class="text-white">
                    <!-- Fullname logged -->
                    <?= $user['name']; ?>
                </span>
            </div>
        </div>


        <nav style="margin-top: 65px;">

            <!-- Search element in Sidebar -->
            <!-- <div class="form-inline mb-3">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Pencarian..." aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div> -->

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <!-- QUERY MENU -->
                <?php
                $role_id = $this->session->userdata('role_id');
                $queryMenu = "SELECT `user_menus`.`id`, `menu`
                    FROM `user_menus` JOIN `user_access_menus`
                    ON `user_menus`.`id` = `user_access_menus`.`menu_id`
                    WHERE `user_access_menus`.`role_id` = $role_id
                    ORDER BY `user_access_menus`.`menu_id` ASC
                    ";
                $menus = $this->db->query($queryMenu)->result_array();
                ?>

                <!-- LOOPING MENU -->
                <?php foreach ($menus as $menu) : ?>
                    <small class="text-white text-uppercase">
                        <!-- <?= $menu['menu']; ?> --> <!-- Kode Default -->
                        
                        <?php 
                            if ($menu['menu'] == "Admin") {
                                echo "Staff";
                            } else {
                                echo $menu['menu'];
                            }
                        ?>
                    </small>

                    <!-- SIAPKAN SUB-MENU sesuai MENU -->
                    <?php
                    $menuId = $menu['id'];
                    $querySubMenu = "SELECT * FROM `user_sub_menus`
                                WHERE `menu_id` = $menuId
                                AND `is_active` = 1
                                ";
                    $subMenus = $this->db->query($querySubMenu)->result_array();
                    ?>

                    <?php foreach ($subMenus as $subMenu) : ?>
                        <!-- Jika mainTitle kosong kasih nilai default -->
                        <?php
                        if (empty($mainTitle)) {
                            $mainTitle = 'Main Title';
                        }
                        ?>

                        <?php if ($title == $subMenu['title'] || $mainTitle == $subMenu['title']) : ?>
                            <li class="nav-item">
                                <a href="<?= base_url($subMenu['url']); ?>" class="nav-link active">
                                <?php else : ?>
                            <li class="nav-item">
                                <a href="<?= base_url($subMenu['url']); ?>" class="nav-link">
                                <?php endif; ?>
                                <i class="<?= $subMenu['icon']; ?>"></i>
                                <p>
                                    <?= $subMenu['title']; ?>
                                </p>
                                </a>
                            </li>
                        <?php endforeach; ?>

                        <hr class="mt-2 w-100 hr-sidebar">

                    <?php endforeach; ?>

            </ul>
        </nav>

    </div>

</aside>