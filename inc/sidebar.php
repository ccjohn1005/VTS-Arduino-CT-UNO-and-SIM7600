<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
        <div class="sidebar-brand-icon ">
            <i class="fas fa-map-marked-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">VTS <sup>1.0</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="home.php">

            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="vehiclestatus.php">Vehicle Status</a>
                <a class="collapse-item" href="vehicleinfo.php">Vehicle Info List</a>
                <a class="collapse-item" href="servicerecord.php">Service Records</a>
                <a class="collapse-item" href="fueltrack.php">Fuel Tracker</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <?php
    require_once "./config/config.php";

    ?>
    <?php
    if ($_SESSION['username'] == 'admin') {

        echo "<li class='nav-item'>";
        echo "    <a class='nav-link collapsed' href='#' data-toggle='collapse' data-target='#collapseUtilities'";
        echo "        aria-expanded='true' aria-controls='collapseUtilities'>";
        echo "        <i class='fas fa-fw fa-wrench'></i>";
        echo "        <span>Administrators</span>";
        echo "    </a>";
        echo "    <div id='collapseUtilities' class='collapse' aria-labelledby='headingUtilities'";
        echo "        data-parent='#accordionSidebar'>";
        echo "       <div class='bg-white py-2 collapse-inner rounded'>";
        echo "            <a class='collapse-item' href='manageuser.php'>Manage user</a>";
        echo "</div>";
        echo "</div>";
        echo "</li>";
    }
    ?>
    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- Nav Item - resetpasswd -->
    <li class="nav-item">
        <a class="nav-link" href="reset-password.php">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Change Password</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>