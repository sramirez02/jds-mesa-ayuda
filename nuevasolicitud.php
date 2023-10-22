<?php
session_start();
if (isset($_SESSION['id'])) {
    date_default_timezone_set('America/Bogota');
    $id_empleado = $_SESSION['id'];
    require_once('menu_superior.php');
    require_once('menu_lateral.php');
    require_once('conexiondb.php');

    $stmt = $conn->prepare("SELECT empleado.nombre AS nombre_empleado, cargo.nombre AS nombre_cargo, cargo.salario, area.nombre AS nombre_area FROM (empleado 
        INNER JOIN cargo ON empleado.id_cargo = cargo.id 
        INNER JOIN area ON cargo.id_area = area.id) WHERE empleado.id = $id_empleado");
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt2 = $conn->prepare("SELECT id AS id_motivo, nombre AS nombre_motivo FROM motivo_solicitud");
    $stmt2->execute();

    $rows2 = $stmt2->fetchAll(PDO::FETCH_OBJ);




    ?>
    <br><br>
    <br><br><br>
    <!--Container Main start-->
    <div class="height-100 bg-light container">
        <div class="row g-5">
            <div>
                <h4 class="mb-3">Solicitud</h4>
                <hr>
                <form action="crear_solicitud.php" method="post" class="needs-validation" novalidate>
                    <div class="row g-3">


                        <div class="col-md-6">
                            <label for="motivo_solicitud" class="form-label">Motivo</label>
                            <select class="form-select" name="motivo_solicitud" id="motivo_solicitud" required>
                                <?php foreach ($rows2 as $row2) { ?>
                                    <option value="<?= $row2->id_motivo ?>">
                                        <?= $row2->nombre_motivo ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="lugar" class="form-label">Lugar de la solicitud</label>
                            <input class="form-control" rows="2" id="lugar" name="lugar" spellcheck="true" required></input>
                        </div>


                        <br>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" rows="2" id="observaciones" name="observaciones"
                                    spellcheck="true" required></textarea>
                            </div>

                            <div class="col-md-12">
                                <h6 class="mb-1 mt-3">
                                    <hx4>
                                        Su solicitud será procesada y atendida lo más pronto posible. Recuerde verificar el
                                        estado de la solicitud y las indicaciones que se le brindaran durante el proceso por
                                        medio de su correo electronico
                                    </hx4>
                                </h6>
                            </div>
                            <br>

                            <!-- boton enviar -->
                            <br>
                            <br>
                            <br>


                            <button type="button" class="w-100 btn btn-success btn-lg" data-bs-toggle="modal"
                                data-bs-target="#staticBackdropenviosolictud">
                                Enviar solicitud
                            </button>

                            <!-- Modal alerta envio solicitud-->
                            <div class="modal fade" id="staticBackdropenviosolictud" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel"><b>Enviar solicitud?</b></h5>
                                            <a href="#">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </a>
                                        </div>
                                        <div class="modal-body">
                                            Para enviar solicitud presione "Enviar" de lo contrario presione "Cerrar".
                                        </div>
                                        <div class="modal-footer">
                                            <a href="#">
                                                <button type="subbmit" class="btn btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#staticBackdrop7">Enviar</button>
                                            </a>
                                            <a href="solicitudes.php">
                                                <button type="button" class="btn btn-danger"
                                                    data-bs-dismiss="modal">Cerrar</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                </form>


                <br>
            </div>

            <div>
                <h6 class="my-4">Al presionar enviar solictud
                    <a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdropterminos">
                        <hx4 type="text" class="form-check-label">*Acepto terminos y condiciones.</hx4>
                    </a>
                    <hr>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal enviar solicitud -->
    <div class="modal fade" id="staticBackdrop7" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><b>Envio exitoso</b></h5>
                    <a href="solicitudes.php">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </a>
                </div>
                <div class="modal-body">
                    La solicitud se ha enviado exitosamente
                </div>
                <div class="modal-footer">
                    <a href="solicitudes.php">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal terminos y condiciones -->
    <div class="modal fade" id="staticBackdropterminos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><b>Terminos y Condiciones</b></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Reconozco que por medio de esta solicitud de permiso en
                    horarios laborales existe el riesgo de peligros, daños, lesiones y enfermedades que pudieran ocasionarme
                    cualquier
                    tipo de perturbación funcional, psiquiátrica, una invalidez o la muerte, y estoy de acuerdo en
                    asumirlos,
                    exonerando de toda responsabilidad a la empresa SERVICREDITO S.A.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <?php
    $conn = null;
    require_once('piedepagina.php');
} else {
    header('Location: log_in.php');
}
?>