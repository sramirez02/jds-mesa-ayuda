<?php
session_start();
if (isset($_SESSION['id'])) {
    date_default_timezone_set('America/Bogota');
    $id_empleado = $_SESSION['id'];
    require_once('menu_superior.php');
    require_once('menu_lateral.php');
    require_once('conexiondb.php');

    if (empty($_GET['id'])) {
    } else {
        $id = $_GET['id'];

        $_SESSION['id_soli'] = $id;

        $stmt = $conn->prepare("SELECT empleado.nombre AS nombre_empleado, area.nombre AS nombre_area, cargo.nombre AS nombre_cargo, solicitud.fecha_inicio, solicitud.fecha_final, solicitud.numero_horas AS horas_p, cargo.salario, motivo_solicitud.id AS id_motivo, motivo_solicitud.nombre AS nombre_motivo, solicitud.observaciones FROM ((((solicitud 
                                INNER JOIN motivo_solicitud ON solicitud.id_motivo = motivo_solicitud.id) 
                                INNER JOIN empleado ON solicitud.id_empleado = empleado.id)
                                INNER JOIN cargo ON empleado.id_cargo = cargo.id)
                                INNER JOIN area ON cargo.id_area = area.id) WHERE solicitud.id= $id");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);
    }



    ?>

    <!--Container Main start-->
    <br><br><br>
    <div class="height-100 bg-light container">
        <div class="row">
            <h2>Gestionar Solicitud</h2>
        </div>
        <br>
        <div class="row g-5">
            <div>
                <form action="accion_radicar.php" method="post" class="needs-validation" novalidate>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="firstName" class="form-label">Nombre </label>
                            <input type="text" class="form-control" id="nombre" value="<?= $row->nombre_empleado ?>"
                                required disabled>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="email" class="form-label">Area o Dependencia</label>
                            <input type="email" class="form-control" id="email" value="<?= $row->nombre_area ?>" required
                                disabled>
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="username" class="form-label">Cargo</label>
                            <div class="input-group has-validation">
                                <input type="text" class="form-control" id="cargo" value="<?= $row->nombre_cargo ?>"
                                    required disabled>
                                <div class="invalid-feedback">
                                    Your username is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="fecha_inicio" class="form-label">Fecha y Hora de salida</label>
                            <input id="fecha_inicio" class="form-control" type="datetime-local"
                                value="<?= $row->fecha_inicio ?>" required disabled />
                        </div>
                        <div class="col-sm-6">
                            <label for="fecha_final" class="form-label">Fecha y Hora de Regreso</label>
                            <input id="fecha_final" class="form-control" type="datetime-local"
                                value="<?= $row->fecha_final ?>" required disabled />
                        </div>

                        <div class="col-sm-3">
                            <label for="country" class="form-label">Horas de permiso</label>
                            <input type="text" class="form-control" value="<?= $row->horas_p ?>" required disabled>
                        </div>


                        <div class="col-md-6">
                            <label for="motivo" class="form-label">Motivo</label>
                            <select class="form-select" id="motivo" required disabled>
                                <option value="<?= $row->id_motivo ?>">
                                    <?= $row->nombre_motivo ?>
                                </option>

                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>
                    </div>

                    <br class="my-4">
                    <div class="row gy-6">
                        <div class="col-md-12">
                            <label for="observaciones" class="form-label">Observaciones <span
                                    class="text-muted">(Opcional)</span></label>
                            <textarea class="form-control" rows="2" id="observaciones"
                                name="observaciones"><?= $row->observaciones ?></textarea>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4">
                                <button type="button" class="w-100 btn btn-success btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdropradicarsolicitud">
                                    Radicar solicitud
                                </button>
                            </div>
                            <!-- Modal radicar-->
                            <div class="modal fade" id="staticBackdropradicarsolicitud" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel"><b>Radicar solicitud?</b></h5>
                                            <a href="#">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            Para radicar solicitud presione "Enviar" de lo contrario presione "Cerrar".
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#">
                                                <button type="subbmit" name="radicar" value="1"
                                                    class="btn btn-success">Enviar</button>
                                            </a>
                                            <a href="#">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <button type="button" class="w-100 btn btn-danger btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdropnegar">
                                    Negar solicitud
                                </button>
                            </div>
                            <!-- Modal negar-->
                            <div class="modal fade" id="staticBackdropnegar" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel"><b>Negar solicitu?</b></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Para negar solicitud presione "Enviar" de lo contrario presione "Cerrar".
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#">
                                                <button type="subbmit" name="negar" value="2" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Enviar</button>
                                            </a>
                                            <a href="#">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <button type="button" class="w-100 btn btn-warning btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#staticBackdrop3">
                                    Pendiente
                                </button>
                            </div>
                            <!-- Modal pendientes-->
                            <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel"><b> Enviar a pendiente?</b>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Para enviar a pendiente presione "Enviar" de lo contrario presione "Cerrar".
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#">
                                                <button type="subbmit" name="pendiente" value="3"
                                                    class="btn btn-secondary">Enviar</button>
                                            </a>
                                            <a href="#">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <hr>
    <?php

    $conn = null;
    require_once('piedepagina.php');
} else {
    header('Location: log_in.php');
}
?>