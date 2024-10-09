        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="nk-sidebar" id="notprint">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label">Dashboard</li>
                    <li>
                        <a href="<?= base_url('/dashboard')?>" aria-expanded="false">
                            <i class="icon-speedometer menu-icon"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-grid menu-icon"></i><span class="nav-text">Master Data</span>
                        </a>
                        <ul aria-expanded="false">
                            <?php if($_SESSION['level'] == 3) {?>
                            <li id="step6"><a href="<?= base_url('master/users/list')?>">Users</a></li>
                            <?php } ?>
                            <li id="step4"><a href="<?= base_url('master/school/list')?>">Schools</a></li>
                        </ul>
                    </li>
                    <?php if($_SESSION['level'] == 3) {?>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="icon-settings menu-icon"></i><span class="nav-text">Settings</span>
                        </a>
                        <ul aria-expanded="false">
                            <li id="step7"><a href="<?= base_url('setting/question/list')?>">Questions</a></li>
                            <!-- <li><a href="<?= base_url('setting/criteria/list')?>">Criterias</a></li> -->
                        </ul>
                    </li>
                    <?php } ?>
                    <li class="nav-label">Apps</li>
                    <li id="step5">
                        <a href="<?= base_url('evaluation/list')?>" aria-expanded="false">
                            <i class="icon-note menu-icon"></i><span class="nav-text">Evaluation</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
