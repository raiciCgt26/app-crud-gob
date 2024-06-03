 <script src="js/bootstrap.bundle.min.js"></script>

<header id="header" class="header fixed-top d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center justify-content-between">
        <a href="main.php" class="logo d-flex align-items-center">
            <img src="assets/upt_logo_transparent.png" alt="">
            <span class="d-none d-lg-block">Biblioteca UPTEB</span>
        </a>
    </div><!-- End Logo -->

    <div class="nav-item dropdown pe-3">
        <div class="dropdown">
            <button class="btn nav-link nav-profile dropdown-toggle d-flex align-items-center" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person"></i>
                <span class="d-none d-md-block ps-2"><?php echo $_SESSION["user_name"]; ?></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile" aria-labelledby="dropdownMenuButton">
                <li class="dropdown-header">
                    <h6><?php echo $_SESSION["user_name"]; ?></h6>
                    <span><?php echo get_role_name($_SESSION["user_type"]); ?></span>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="edit-user.php?id=<?php echo $_SESSION["user_id"]; ?>">
                        <i class="bi bi-gear"></i>
                        <span>Modificar Datos</span>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="logout.php">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Cerrar Sesión</span>
                    </a>
                </li>
            </ul><!-- End Profile Dropdown Items -->
        </div><!-- End Dropdown -->
    </div><!-- End Profile Nav -->
</header><!-- End Header -->





