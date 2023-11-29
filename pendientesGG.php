<?php
session_start();
if (isset($_SESSION['id'])) {
    require_once('menu_superior.php');
    require_once('menu_lateral.php');
    require_once('conexiondb.php');

    if (empty($_GET['id'])) {
    } else {
        $id = $_GET['id'];
        $_SESSION['id_soli_r'] = $id;

        $stmt = $conn->prepare("SELECT empleado.nombre AS nombre_empleado, solicitud.lugar, area.nombre AS nombre_area, cargo.nombre AS nombre_cargo, solicitud.fecha_registro, solicitud.fecha_final, solicitud.numero_horas, cargo.salario, motivo_solicitud.id AS id_motivo, motivo_solicitud.nombre AS nombre_motivo, solicitud.observaciones FROM ((((solicitud 
                                INNER JOIN motivo_solicitud ON solicitud.id_motivo = motivo_solicitud.id) 
                                INNER JOIN empleado ON solicitud.id_empleado = empleado.id)
                                INNER JOIN cargo ON empleado.id_cargo = cargo.id)
                                INNER JOIN area ON cargo.id_area = area.id) WHERE solicitud.id= $id");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);
    }

    $numero_horas = $row->numero_horas;
    $salariomes = $row->salario;
    $salariodia = $salariomes / 30;
    $salariohora = $salariodia / 8;


    $importe = $salariohora * $numero_horas;

    ?>
    <br><br><br>
    <div class="height-100 bg-light container">
        <div class="row">
            <h2>Gestionar Solicitud</h2>
        </div>


        <div class="row g-5">
            <div>
                <br>
                <form action="accion_autorizar.php" method="post" class="needs-validation" novalidate>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="nombre" class="form-label">Nombre </label>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre"
                                value="<?= $row->nombre_empleado ?>" required disabled>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>


                        <div class="col-6">
                            <label for="area" class="form-label">Area o Dependencia</label>
                            <input type="text" class="form-control" id="area" name="area" placeholder="Area o Dependencia"
                                value="<?= $row->nombre_area ?>" required disabled>
                        </div>

                        <div class="col-6">
                            <label for="cargo" class="form-label">Cargo</label>
                            <!--div class="input-group has-validation"-->
                            <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo"
                                value="<?= $row->nombre_cargo ?>" required disabled>
                            <!--div-->
                        </div>

                        <div class="col-sm-4">
                            <label for="fecha_inicio" class="form-label">Fecha registro</label>
                            <input id="fecha_inicio" class="form-control" type="datetime-local" name="fecha_inicio"
                                min="<?= date('Y-m-d h:i') ?>" value="<?= $row->fecha_registro ?>" required disabled />
                        </div>


                        <div class="col-sm-4">
                            <label for="motivo" class="form-label">Motivo</label>
                            <select class="form-select" id="motivo" required disabled>
                                <option value="<?= $row->id_motivo ?>">
                                    <?= $row->nombre_motivo ?>
                                </option>
                            </select>
                        </div>

                        <div class="col-sm-4">
                            <label for="lugar" class="form-label">Lugar</label>
                            <input id="lugar" class="form-control" name="lugar" value="<?= $row->lugar ?>" required
                                disabled />
                        </div>

                    </div>

                    <br class="my-4">
                    <div class="row gy-6">
                        <div class="col-md-12">
                            <label for="observaciones" class="form-label">Observaciones </label>
                            <textarea class="form-control" rows="2" id="observaciones"
                                name="observaciones"><?= $row->observaciones ?></textarea>
                        </div>

                    </div>


                    <br>
                    <br>
                    <div class="row">
                        <div class="col-md-6"></div>
                        <!-- boton negar -->
                        <div class="col-md-3">
                            <button type="button" class="w-100 btn btn-danger btn-lg" data-bs-toggle="modal"
                                data-bs-target="#staticBackdropnegar">
                                Denegar solicitud
                            </button>
                        </div>
                        <!-- boton autorizar -->
                        <div class="col-md-3">
                            <button type="button" class="w-100 btn btn-success btn-lg" data-bs-toggle="modal"
                                data-bs-target="#staticBackdropautorizar">
                                Completar solicitud
                            </button>
                        </div>
                    </div>

                    <!-- Modal autorizar -->
                    <div class="modal fade" id="staticBackdropautorizar" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><b>Autorizar solicitud ?</b></h5>
                                    <a href="#">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    Para Autorizar solicitud presione "Enviar" de lo contrario presione "Cerrar".
                                </div>
                                <div class="modal-footer">
                                    <a href="#">
                                        <button type="subbmit" name="autorizar" value="1" class="btn btn-success"
                                            data-bs-toggle="modal">Enviar</button>
                                    </a>
                                    <a href="#"> <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>


                    <!-- Modal negar -->
                    <div class="modal fade" id="staticBackdropnegar" data-bs-backdrop="static" data-bs-keyboard="false"
                        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel"><b>Negar solicitud ?</b></h5>
                                    <a href="#">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </a>
                                </div>
                                <div class="modal-body">
                                    Para Negar solicitud presione "Enviar" de lo contrario presione "Cerrar".
                                </div>
                                <div class="modal-footer">
                                    <a href="#">
                                        <button type="subbmit" name="negar" value="2" class="btn btn-success"
                                            data-bs-toggle="modal">Enviar</button>
                                    </a>
                                    <a href="#"> <button type="button" class="btn btn-danger"
                                        data-bs-dismiss="modal">Cerrar</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <?php
    $conn = null;
    require_once('piedepagina.php');
} else {
    header('Location: log_in.php');
}
?>