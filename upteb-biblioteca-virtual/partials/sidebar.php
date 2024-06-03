 <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav nav-content" id="sidebar-nav">
<li class="nav-item">
    <div>
<a href="dashboard.php" class="nav-link <?php if ($title != "Dashboard") { echo "collapsed"; }?>"> <i class="bi bi-grid"></i><span>  Dashboard</span></a><i class="bi ms-auto"></i>
    </div>  
    </li>
    <?php if ($_SESSION["user_type"] == "admin") { ?>
    <li class="nav-item">
        <div>
    <a href="pub-lending-tickets.php" class="nav-link <?php if ($title != "Préstamos") { echo "collapsed"; }?>"> <i class="bi bi-calendar-range"></i><span>  Préstamos</span></a><i class="bi ms-auto"></i>
        </div>  
        </li>     
    <?php } ?>
<!--Publicaciones -->
    <div>
        <li class="nav-item">
                <a class="nav-link " data-bs-target="#publications-nav" data-bs-toggle="collapse" href="#" >
                  <i class="bi bi-journal-text"></i><span>Publicaciones</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="publications-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                <li>
                <a href="main.php" class="nav-link <?php if ($title != "Lista de Libros") { echo "collapsed"; }?>"><i class="bi bi-circle"></i><span>  Libros</span></a><i class="bi ms-auto"></i>
                </li>
                <li>
                <a href="thesis.php" class="nav-link <?php if ($title != "Lista de Tesis") { echo "collapsed"; }?>"><i class="bi bi-circle"></i><span>  Tesis</span></a><i class="bi ms-auto"></i>
                </li>
            </ul>
            </li>
    </div>

<!--Categorias -->
    <div>
        <li class="nav-item">
                <a class="nav-link " data-bs-target="#category-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-bookmark-plus"></i><span>Categorías</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="category-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                <li>
                 <a href="tags.php" class="nav-link <?php if ($title != "Lista de PNF") { echo "collapsed"; }?>"><i class="bi bi-circle"></i><span>  PNF</span></a><i class="bi ms-auto"></i>
                </li>
                <li>
                 <a href="sedes.php" class="nav-link <?php if ($title != "Lista de Sedes") { echo "collapsed"; }?>"><i class="bi bi-circle"></i><span> Sedes</span></a><i class="bi ms-auto"></i>
                </li>
            </ul>
            </li>
    </div>
<!--Administración -->
    <?php if ($_SESSION["user_type"] == "admin") { ?>
    <div>
        <li class="nav-item">
                <a class="nav-link " data-bs-target="#admin-nav" data-bs-toggle="collapse" href="#">
                  <i class="ri-admin-fill"></i><span>Administración</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="admin-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                <li>
                <a href="users.php" class="nav-link <?php if ($title != "Lista de Usuarios") { echo "collapsed"; }?>"><i class="bi bi-circle"></i><span>  Usuarios</span></a><i class="bi ms-auto"></i>
                </li>
                <li>
                <a href="audit-log.php" class="nav-link <?php if ($title != "Registro de Movimientos") { echo "collapsed"; }?>"><i class="bi bi-circle"></i><span>  Movimientos</span></a><i class="bi ms-auto"></i>
                </li>
                <li>
                <a href="backups.php" class="nav-link <?php if ($title != "Respaldos") { echo "collapsed"; }?>"><i class="bi bi-circle"></i><span>  Respaldos</span></a><i class="bi ms-auto"></i>
                </li>
            </ul>
            </li>
    </div>
    <?php } ?>

 </ul>
  </aside>