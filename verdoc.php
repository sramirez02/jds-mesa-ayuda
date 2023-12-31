<br>
<br>
<br>
<?php

session_start();
if (isset($_SESSION['id'])) {
    require_once('menu_superior.php');
    require_once('menu_lateral.php');
    require_once('conexiondb.php');

    $motivo_solicitud = $conn->prepare("SELECT id, nombre FROM motivo_solicitud");
    $motivo_solicitud->execute();
    $rows1 = $motivo_solicitud->fetchAll(PDO::FETCH_OBJ);


    if (empty($_GET['id'])) {
    } else {
        $id = $_GET['id'];
        $_SESSION['id_solicitud_actualizar'] = $id;

        $stmt = $conn->prepare("SELECT empleado.nombre AS nombre_empleado, area.nombre AS nombre_area, cargo.nombre AS nombre_cargo, 
        solicitud.fecha_registro, solicitud.fecha_final, solicitud.lugar, motivo_solicitud.id AS id_motivo, motivo_solicitud.nombre AS nombre_motivo, solicitud.observaciones, estado.id AS id_estado FROM (((((solicitud 
                INNER JOIN motivo_solicitud ON solicitud.id_motivo = motivo_solicitud.id) 
                INNER JOIN empleado ON solicitud.id_empleado = empleado.id)
                INNER JOIN cargo ON empleado.id_cargo = cargo.id)
                INNER JOIN estado ON solicitud.id_estado = estado.id)
                INNER JOIN area ON cargo.id_area = area.id) WHERE solicitud.id= $id");
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
    }

?>

    <?php
    foreach ($rows as $row);
    if ($row->id_estado == 1) {
    ?>

        <br><br><br>
        <div class="height-100 bg-light container">
            <div class="row">
                <h2>Solicitud En Proceso</h2>
            </div>


            <div class="row g-5">
                <div>
                    <br>
                    <form action="accion_modificar_s.php" method="post" class="needs-validation" novalidate onsubmit="this.querySelectorAll('.required-element').forEach(i => i.disabled = false)">
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <label for="nombre" class="form-label">Nombre </label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $row->nombre_empleado ?>" required disabled>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>

                            <div class="col-6">
                                <label for="area" class="form-label">Area o Dependencia</label>
                                <input type="text" class="form-control" id="area" name="area" placeholder="Area o Dependencia" value="<?= $row->nombre_area ?>" required disabled>
                            </div>

                            <div class="col-6">
                                <label for="cargo" class="form-label">Cargo</label>
                                <!--div class="input-group has-validation"-->
                                <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" value="<?= $row->nombre_cargo ?>" required disabled>
                                <!--div-->
                            </div>

                            <div class="col-sm-4">
                                <label for="fecha_inicio" class="form-label">Fecha registro</label>
                                <input id="fecha_inicio" class="form-control" type="datetime-local" name="fecha_inicio" min="<?= date('Y-m-d h:i') ?>" value="<?= $row->fecha_registro ?>" required disabled />
                            </div>

                            <div class="col-sm-4">
                                <label for="motivo" class="form-label">Motivo</label>
                                <select class="form-select required-element" name="motivo_solicitud" required disabled>
                                    <option value="<?= $row->id_motivo ?>">
                                        <?= $row->nombre_motivo ?>
                                    </option>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="lugar" class="form-label">Lugar</label>
                                <input id="lugar" class="form-control required-element" name="lugar" value="<?= $row->lugar ?>" required disabled/>
                            </div>

                            <br>
                            <br class="my-4">
                            <div class="row gy-6">
                                <div class="col-md-12">
                                    <label for="observaciones" class="form-label ">Observaciones </label>
                                    <textarea class="form-control required-element" rows="2" id="observaciones" name="observaciones" required disabled><?= $row->observaciones ?></textarea>
                                </div>
                            </div>


                            <br>
                            <hr>
                            <!-- boton cancelar -->
                            <div class="row g-">
                                <button type="button" class="w-100 btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdropcancelar">
                                    Cancelar solicitud
                                </button>
                            </div>
                            <!-- Modal cancelar -->
                            <div class="modal fade" id="staticBackdropcancelar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel"><b>Cancelar solicitud ?</b></h5>
                                            <a href="#">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            Para cancelar la solicitud presione "Enviar" de lo contrario presione "Cerrar".
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#">
                                                <button type="subbmit" name="cancelar" value="6" class="btn btn-success" data-bs-toggle="modal">Enviar</button>
                                            </a>
                                            <a href="#"> <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    </form>
                </div>
            </div>
            < <?php } elseif ($row->id_estado == 2) {
                ?> <br><br><br>
                <div class="height-100 bg-light container">
                    <div class="row">
                        <h2>Solicitud en proceso</h2>
                    </div>


                    <div class="row g-5">
                        <div>
                            <br>
                            <form action="accion_modificar_s.php" method="post" class="needs-validation" novalidate>
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label for="nombre" class="form-label">Nombre </label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $row->nombre_empleado ?>" required disabled>
                                        <div class="invalid-feedback">
                                            Valid first name is required.
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label for="area" class="form-label">Area o Dependencia</label>
                                        <input type="text" class="form-control" id="area" name="area" placeholder="Area o Dependencia" value="<?= $row->nombre_area ?>" required disabled>
                                    </div>

                                    <div class="col-6">
                                        <label for="cargo" class="form-label">Cargo</label>
                                        <!--div class="input-group has-validation"-->
                                        <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" value="<?= $row->nombre_cargo ?>" required disabled>
                                        <!--div-->
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="fecha_inicio" class="form-label">Fecha registro</label>
                                        <input id="fecha_inicio" class="form-control" type="datetime-local" name="fecha_inicio" min="<?= date('Y-m-d h:i') ?>" value="<?= $row->fecha_registro ?>" required disabled />
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
                                        <input id="lugar" class="form-control" name="lugar" value="<?= $row->lugar ?>" required disabled />
                                    </div>

                                    <br>
                                    <br class="my-4">
                                    <div class="row gy-6">
                                        <div class="col-md-12">
                                            <label for="observaciones" class="form-label">Observaciones </label>
                                            <textarea class="form-control" rows="2" id="observaciones" name="observaciones" required disabled><?= $row->observaciones ?></textarea>
                                        </div>
                                    </div>

                                    <!-- boton cancelar -->
                                    <div class="row g-">
                                        <button type="button" class="w-100 btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdropcancelar">
                                            Cancelar solicitud
                                        </button>
                                    </div>
                                    <!-- Modal cancelar -->
                                    <div class="modal fade" id="staticBackdropcancelar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel"><b>Cancelar solicitud ?</b></h5>
                                                    <a href="#">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </a>
                                                </div>
                                                <div class="modal-body">
                                                    Para cancelar la solicitud presione "Enviar" de lo contrario presione "Cerrar".
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="#">
                                                        <button type="subbmit" name="cancelar" value="1" class="btn btn-success" data-bs-toggle="modal">Enviar</button>
                                                    </a>
                                                    <a href="#"> <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                            </form>
                        </div>
                    </div>
                    < <?php } elseif ($row->id_estado == 3) {
                        ?> <br><br><br>
                        <div class="height-100 bg-light container">
                            <div class="row">
                                <h2>Solicitud Pendiente</h2>
                            </div>


                            <div class="row g-5">
                                <div>
                                    <br>
                                    <form action="accion_modificar_s.php" method="post" class="needs-validation" novalidate>
                                        <div class="row g-3">
                                            <div class="col-sm-12">
                                                <label for="nombre" class="form-label">Nombre </label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $row->nombre_empleado ?>" required disabled>
                                                <div class="invalid-feedback">
                                                    Valid first name is required.
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label for="area" class="form-label">Area o Dependencia</label>
                                                <input type="text" class="form-control" id="area" name="area" placeholder="Area o Dependencia" value="<?= $row->nombre_area ?>" required disabled>
                                            </div>

                                            <div class="col-12">
                                                <label for="cargo" class="form-label">Cargo</label>
                                                <!--div class="input-group has-validation"-->
                                                <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" value="<?= $row->nombre_cargo ?>" required disabled>
                                                <!--div-->
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fecha_inicio" class="form-label">Fecha y Hora de salida</label>
                                                <input id="fecha_inicio" class="form-control" type="datetime-local" min="<?= date('Y-m-d h:i') ?>" name="fecha_inicio" value="<?= $row->fecha_inicio ?>" required />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="fecha_final" class="form-label">Fecha y Hora de Regreso</label>
                                                <input id="fecha_final" class="form-control" type="datetime-local" min="<?= date('Y-m-d h:i') ?>" name="fecha_final" value="<?= $row->fecha_final ?>" required />
                                            </div>

                                            <div class="col-md-6">
                                                <label for="motivo" class="form-label">Motivo</label>
                                                <select class="form-select" id="motivo" name="motivo" required disabled>
                                                    <?php
                                                    foreach ($rows1 as $row1) {
                                                        $select = null;
                                                        if ($row1->id == $rows->id_motivo) {
                                                            $select = 'select';
                                                        } ?>

                                                        <option <?= $select ?> value="<?= $row1->id ?>">
                                                            <?= $row1->nombre ?>
                                                        </option>
                                                    <?php }; ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Please select a valid country.
                                                </div>
                                            </div>
                                        </div>

                                        <br class="my-4">
                                        <div class="row gy-6">
                                            <div class="col-md-12">
                                                <label for="observaciones" class="form-label">Observaciones </label>
                                                <textarea class="form-control" rows="2" id="observaciones" name="observaciones"><?= $row->observaciones ?></textarea>
                                            </div>
                                        </div>

                                        <!-- boton modificar -->
                                        <div class="row g-">
                                            <button type="button" class="w-100 btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdropmodificar">
                                                Modificar solicitud
                                            </button>
                                        </div>

                                        <!-- Modal modificar -->
                                        <div class="modal fade" id="staticBackdropmodificar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel"><b>Modificar solicitud ?</b></h5>
                                                        <a href="#">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        Para modificar solicitud presione "Enviar" de lo contrario presione "Cerrar".
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="#">
                                                            <button type="subbmit" name="modificar" value="3" class="btn btn-success" data-bs-toggle="modal">Enviar</button>
                                                        </a>
                                                        <a href="#"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>

                                        <!-- boton cancelar -->
                                        <div class="row g-">
                                            <button type="button" class="w-100 btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#staticBackdropcancelar">
                                                Cancelar solicitud
                                            </button>
                                        </div>
                                        <!-- Modal cancelar -->
                                        <div class="modal fade" id="staticBackdropcancelar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="staticBackdropLabel"><b>Cancelar solicitud ?</b></h5>
                                                        <a href="#">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        Para cancelar solicitud presione "Enviar" de lo contrario presione "Cerrar".
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="#">
                                                            <button type="subbmit" name="cancelar" value="6" class="btn btn-success" data-bs-toggle="modal">Enviar</button>
                                                        </a>
                                                        <a href="#"> <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            
                            < <?php } elseif ($row->id_estado == 4) {
                                ?> <br><br><br>
                                <div class="height-100 bg-light container">
                                    <div class="row">
                                        <h2>Solicitud Autorizada</h2>
                                    </div>


                                    <div class="row g-5">
                                        <div>
                                            <br>
                                            <form action="accion_modificar_s.php" method="post" class="needs-validation" novalidate>
                                                <div class="row g-3">
                                                    <div class="col-sm-12">
                                                        <label for="nombre" class="form-label">Nombre </label>
                                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $row->nombre_empleado ?>" required disabled>
                                                        <div class="invalid-feedback">
                                                            Valid first name is required.
                                                        </div>
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="area" class="form-label">Area o Dependencia</label>
                                                        <input type="text" class="form-control" id="area" name="area" placeholder="Area o Dependencia" value="<?= $row->nombre_area ?>" required disabled>
                                                    </div>

                                                    <div class="col-6">
                                                        <label for="cargo" class="form-label">Cargo</label>
                                                        <!--div class="input-group has-validation"-->
                                                        <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" value="<?= $row->nombre_cargo ?>" required disabled>
                                                        <!--div-->
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <label for="fecha_inicio" class="form-label">Fecha registro</label>
                                                        <input id="fecha_inicio" class="form-control" type="datetime-local" name="fecha_inicio" min="<?= date('Y-m-d h:i') ?>" value="<?= $row->fecha_registro ?>" required disabled />
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
                                                        <input id="lugar" class="form-control" name="lugar" value="<?= $row->lugar ?>" required disabled />
                                                    </div>

                                                    <br>
                                                    <br class="my-4">
                                                    <div class="row gy-6">
                                                        <div class="col-md-12">
                                                            <label for="observaciones" class="form-label">Observaciones </label>
                                                            <textarea class="form-control" rows="2" id="observaciones" name="observaciones" required disabled><?= $row->observaciones ?></textarea>
                                                        </div>
                                                    </div>


                                <?php } elseif ($row->id_estado == 5) {
                                                ?>

                                                    <br><br><br>
                                                    <div class="height-100 bg-light container">
                                                        <div class="row">
                                                            <h2>Solicitud Denegada</h2>
                                                        </div>


                                                        <div class="row g-5">
                                                            <div>
                                                                <br>
                                                                <form action="accion_modificar_s.php" method="post" class="needs-validation" novalidate>
                                                                    <div class="row g-3">
                                                                        <div class="col-sm-12">
                                                                            <label for="nombre" class="form-label">Nombre </label>
                                                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $row->nombre_empleado ?>" required disabled>
                                                                            <div class="invalid-feedback">
                                                                                Valid first name is required.
                                                                            </div>
                                                                        </div>


                                                                        <div class="col-6">
                                                                            <label for="area" class="form-label">Area o Dependencia</label>
                                                                            <input type="text" class="form-control" id="area" name="area" placeholder="Area o Dependencia" value="<?= $row->nombre_area ?>" required disabled>
                                                                        </div>

                                                                        <div class="col-6">
                                                                            <label for="cargo" class="form-label">Cargo</label>
                                                                            <!--div class="input-group has-validation"-->
                                                                            <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" value="<?= $row->nombre_cargo ?>" required disabled>
                                                                            <!--div-->
                                                                        </div>


                                                                        <div class="col-sm-4">
                                                                            <label for="fecha_inicio" class="form-label">Fecha registro</label>
                                                                            <input id="fecha_inicio" class="form-control" type="datetime-local" name="fecha_inicio" min="<?= date('Y-m-d h:i') ?>" value="<?= $row->fecha_registro ?>" required disabled />
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
                                                                            <input id="lugar" class="form-control" name="lugar" value="<?= $row->lugar ?>" required disabled />
                                                                        </div>


                                                                        <br>
                                                                        <br class="my-4">
                                                                        <div class="row gy-6">
                                                                            <div class="col-md-12">
                                                                                <label for="observaciones" class="form-label">Observaciones </label>
                                                                                <textarea class="form-control" rows="2" id="observaciones" name="observaciones" required disabled><?= $row->observaciones ?></textarea>
                                                                            </div>
                                                                        </div>


                                                                    <?php } elseif ($row->id_estado == 6) {
                                                                    ?>

                                                                        <br><br><br>
                                                                        <div class="height-100 bg-light container">
                                                                            <div class="row">
                                                                                <h2>Solicitud Cancelada</h2>
                                                                            </div>


                                                                            <div class="row g-5">
                                                                                <div>
                                                                                    <br>
                                                                                    <form action="accion_modificar_s.php" method="post" class="needs-validation" novalidate>
                                                                                        <div class="row g-3">
                                                                                            <div class="col-sm-12">
                                                                                                <label for="nombre" class="form-label">Nombre </label>
                                                                                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?= $row->nombre_empleado ?>" required disabled>
                                                                                                <div class="invalid-feedback">
                                                                                                    Valid first name is required.
                                                                                                </div>
                                                                                            </div>


                                                                                            <div class="col-6">
                                                                                                <label for="area" class="form-label">Area o Dependencia</label>
                                                                                                <input type="text" class="form-control" id="area" name="area" placeholder="Area o Dependencia" value="<?= $row->nombre_area ?>" required disabled>
                                                                                            </div>

                                                                                            <div class="col-6">
                                                                                                <label for="cargo" class="form-label">Cargo</label>
                                                                                                <!--div class="input-group has-validation"-->
                                                                                                <input type="text" class="form-control" id="cargo" name="cargo" placeholder="Cargo" value="<?= $row->nombre_cargo ?>" required disabled>
                                                                                                <!--div-->
                                                                                            </div>


                                                                                            <div class="col-sm-4">
                                                                                                <label for="fecha_inicio" class="form-label">Fecha registro</label>
                                                                                                <input id="fecha_inicio" class="form-control" type="datetime-local" name="fecha_inicio" min="<?= date('Y-m-d h:i') ?>" value="<?= $row->fecha_registro ?>" required disabled />
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
                                                                                                <input id="lugar" class="form-control" name="lugar" value="<?= $row->lugar ?>" required disabled />
                                                                                            </div>

                                                                                            <br>
                                                                                            <br class="my-4">
                                                                                            <div class="row gy-6">
                                                                                                <div class="col-md-12">
                                                                                                    <label for="observaciones" class="form-label">Observaciones </label>
                                                                                                    <textarea class="form-control" rows="2" id="observaciones" name="observaciones" required disabled><?= $row->observaciones ?></textarea>
                                                                                                </div>
                                                                                            </div>
                                                                                        <?php }; ?>

                                                                                    <?php
                                                                                    $conn = null;
                                                                                    require_once('piedepagina.php');
                                                                                } else {
                                                                                    header('Location: log_in.php');
                                                                                }
                                                                                    ?>