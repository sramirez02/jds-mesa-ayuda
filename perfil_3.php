    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="Inicio.php" class="nav_logo">
                    <img src="public/img/Captura.png" alt="">
                </a>
                <hr>
                <div class="nav_list">
                    <a href="solicitudes.php" class="nav_link active">
                        <i class='bx bx-spreadsheet nav_icon'></i>
                        <span class="nav_name"> Solicitudes </span>
                    </a>
                    <hr>
                    <div id="accordion">
                        <a class="nav_link active" data-bs-toggle="collapse" href="#collapseOne">
                            <i class='bx bx-user-check nav_icon'></i>
                            <span class="nav_name"> Gestionar </span>
                        </a>
                    </div>
                    <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
                        <a href="gestionar.php" class="nav_link  pl-3">
                            <i class='bx bx-folder nav_icon'></i>
                            <span class="nav_name"> Por gestionar </span>
                        </a>
                    </div>
                    <hr>
                    <div>
                        <a class="nav_link active" data-bs-toggle="collapse" href="#collapseTwo">
                            <i class='bx bx-folder nav_icon'></i>
                            <span class="nav_name"> Gestion Admin </span>
                        </a>
                    </div>
                    <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                        <a href="pendientesG.php" class="nav_link">
                            <i class='bx bx-spreadsheet nav_icon'></i>
                            <span class="nav_name"> Pendientes </span>
                        </a>
                    </div>
                </div>
                <hr>
                <a href="" class="nav_link active">
                    <i class='bx bx-cog nav_icon'></i>
                    <span class="nav_name"> Consultar Doc </span>
                </a>
            </div>
            <a href="log_out.php" class="nav_link active"> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Cerrar sesión</span> </a>
        </nav>    
    </div>