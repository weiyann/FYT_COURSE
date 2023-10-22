<?php 
if(! isset($pageName)){
  $pageName = '';
}
?>
<style>
  nav.navbar ul.navbar-nav .nav-link.active {
    background-color: blue;
    color: white;
    border-radius: 6px;
    font-weight: 600;
  }
</style>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>



            <!-- Topbar Navbar -->
            <ul class="navbar-nav mr-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                <li class="nav-item dropdown no-arrow d-sm-none">
                    <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-search fa-fw"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $pageName=='gym_list' ? 'active' : '' ?>" href="./gym_list.php">列表</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $pageName=='gym_add' ? 'active' : '' ?>" href="./gym_add.php">新增</a>
                </li>

                <div class="topbar-divider d-none d-sm-block"></div>

                

            </ul>

        </nav>
        <!-- End of Topbar -->