<?php
session_start();
if (isset($_SESSION['id'])) {
    require_once('menu_superior.php');
    require_once('menu_lateral.php');
    require_once('conexiondb.php');


    if (empty($_GET['id'])) {
    } else {
        $id = $_GET['id'];

        $stmt = $conn->prepare("SELECT empleado.nombre AS nombre_empleado, area.nombre AS nombre_area, cargo.nombre AS nombre_cargo, solicitud.numero_horas,
        solicitud.fecha_inicio, solicitud.fecha_final, motivo_solicitud.id AS id_motivo, motivo_solicitud.nombre AS nombre_motivo, solicitud.observaciones, estado.id AS id_estado FROM (((((solicitud 
                INNER JOIN motivo_solicitud ON solicitud.id_motivo = motivo_solicitud.id) 
                INNER JOIN empleado ON solicitud.id_empleado = empleado.id)
                INNER JOIN cargo ON empleado.id_cargo = cargo.id)
                INNER JOIN estado ON solicitud.id_estado = estado.id)
                INNER JOIN area ON cargo.id_area = area.id) WHERE solicitud.id= $id");
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_OBJ);

        $sql9 = $conn->prepare("SELECT solicitud.id, observaciones.usuario_empleado, observaciones.fecha_registro, observaciones.estado_1, observaciones.usuario_jefe_d, observaciones.fecha_radicado, observaciones.estado_2, observaciones.usuario_adm, observaciones.fecha_autorizado, observaciones.estado_3, empleado.nombre AS nombre_empleado, empleado.correo, cargo.nombre AS nombre_cargo FROM (((solicitud 
        INNER JOIN empleado ON empleado.id = solicitud.id_empleado) 
        INNER JOIN cargo ON cargo.id = empleado.id_cargo) 
        INNER JOIN observaciones ON observaciones.id_solicitud = solicitud.id) WHERE solicitud.id = $id");

        $sql9->execute();

        $resul = $sql9->fetch(PDO::FETCH_OBJ);

        $usuariojd = $resul->usuario_jefe_d;
        $usuarioad = $resul->usuario_adm;

        $sql10 = $conn->prepare("SELECT empleado.nombre, empleado.correo, cargo.nombre AS nombre_cargo FROM (empleado
        INNER JOIN cargo ON cargo.id = empleado.id_cargo) WHERE empleado.usuario = '$usuariojd'");

        $sql10->execute();

        $resul2 = $sql10->fetch(PDO::FETCH_OBJ);

        $sql11 = $conn->prepare("SELECT empleado.nombre, empleado.correo, cargo.nombre AS nombre_cargo FROM (empleado
        INNER JOIN cargo ON cargo.id = empleado.id_cargo) WHERE empleado.usuario = '$usuarioad'");

        $sql11->execute();

        $resul3 = $sql11->fetch(PDO::FETCH_OBJ);
    }



    ?>
    <br>
    <!-- <div id="whatToPrint" style="width: 500px;"> -->
    <div id="whatToPrint" style="width: 1020px; height:auto; " class=" height-100 bg-light container">
        <div>
            <div class="row g-3">
                <div class=" row g-3">
                    <div class="col-sm-3">
                        <a class="bg-light d-flex d-flex justify-content-center align-items-center">
                            <img src="public/img/logo.png" alt="2px">
                        </a>
                    </div>
                    <div class="col-sm-6 ">
                        <br>
                        <hx class=" bg-light d-flex d-flex justify-content-center align-items-center">Seguridad y Salud en
                            el Trabajo</hx>
                        <br>
                        <h5 class="d-flex d-flex justify-content-center align-items-center">SOLICITUD DE PERMISO</h5>
                    </div>
                    <div class="col-sm-3">
                        <br>
                        <h6 class="text-gray-600 small d-flex d-flex justify-content-right  align-items-right"> Código:
                            SST-PL-FR-016</h6>
                        <h6 class="text-gray-600 small d-flex d-flex justify-content-right  align-items-right ">Versión: 02
                        </h6>
                        <h6 class="text-gray-600 small d-flex d-flex justify-content-right  align-items-right ">Fecha:
                            19-abril-2021</h6>
                        <h6 class="text-gray-600 small d-flex d-flex justify-content-right  align-items-right ">Hoja 1 de 1
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class=" row g-3">
                <div class="row g-3">

                    <div class="col-sm-12">
                        <label for="nombre" class="form-label">Nombre </label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?= $row->nombre_empleado ?>" required disabled>
                        <div class="invalid-feedback">
                            Valid first name is required.
                        </div>
                    </div>


                    <div class="col-6">
                        <label for="area" class="form-label">Area o Dependencia</label>
                        <input type="text" class="form-control" id="area" name="area" value="<?= $row->nombre_area ?>"
                            required disabled>
                    </div>

                    <div class="col-6">
                        <label for="cargo" class="form-label">Cargo</label>
                        <!--div class="input-group has-validation"-->
                        <input type="text" class="form-control" id="cargo" name="cargo" value="<?= $row->nombre_cargo ?>"
                            required disabled>
                        <!--div-->
                    </div>

                    <div class="col-sm-6">
                        <label for="fecha_inicio" class="form-label">Fecha y Hora de salida</label>
                        <input id="fecha_inicio" class="form-control" name="fecha_inicio" min="<?= date('Y-m-d H:i') ?>"
                            value="<?= $row->fecha_inicio ?>" required disabled />
                    </div>
                    <div class="col-sm-6">
                        <label for="fecha_final" class="form-label">Fecha y Hora de Regreso</label>
                        <input id="fecha_final" class="form-control" name="fecha_final" min="<?= date('Y-m-d H:i') ?>"
                            value="<?= $row->fecha_final ?>" required disabled />
                    </div>


                    <div class="col-sm-6">
                        <label for="motivo" class="form-label">Motivo</label>
                        <select class="form-select" id="motivo" required disabled>
                            <option value="<?= $row->id_motivo ?>">
                                <?= $row->nombre_motivo ?>
                            </option>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label for="importe" class="form-label">Horas Permiso</label>
                        <input type="number" class="form-control" id="importe" name="importe"
                            value="<?= $row->numero_horas ?>" readonly="readonly" required disabled>
                    </div>
                    <div class="col-md-12">
                        <label for="observaciones" class="form-label">Observaciones </label>
                        <textarea class="form-control" rows="2" id="observaciones" name="observaciones" required
                            disabled><?= $row->observaciones ?></textarea>

                    </div>

                </div>
            </div>
        </div>
        <div>
            <div>
                <div class=" row g-3">
                    <div class=" row g-3">
                        <h6>NOTA: En cada uno de estos permisos solicitados por el empleado se debe anexar soporte.</h6>

                        <hx>Yo
                            <?= $row->nombre_empleado ?>, Reconozco que por medio de esta solicitud de permiso en horarios
                            laborales existe el
                            riesgo de peligros, daños, lesiones y enfermedades que pudieran ocasionarme cualquier tipo de
                            perturbación funcional, psiquiátrica, una
                            invalidez o la muerte, y estoy de acuerdo en asumirlos, exonerando de toda responsabilidad a la
                            empresa SERVICREDITO S.A
                        </hx>
                        <br><br><br>
                        <div class=" row g-3">
                            <div class="col-sm-4">
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Nombre:
                                    <?= $resul->nombre_empleado ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Usuario:
                                    <?= $resul->usuario_empleado ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Fecha:
                                    <?= $resul->fecha_registro ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Estado:
                                    <?= $resul->estado_1 ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Cargo:
                                    <?= $resul->nombre_cargo ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Correo:
                                    <?= $resul->correo ?>
                                </hx>
                                <hx>____________________________</hx>
                                <h6>EMPLEADO</h6>
                            </div>
                            <div class="col-sm-4">
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Nombre:
                                    <?= $resul2->nombre ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Usuario:
                                    <?= $resul->usuario_jefe_d ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Fecha:
                                    <?= $resul->fecha_radicado ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Estado:
                                    <?= $resul->estado_2 ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Cargo:
                                    <?= $resul2->nombre_cargo ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Correo:
                                    <?= $resul2->correo ?>
                                </hx>
                                <hx>____________________________</hx>
                                <h6>GERENTE DE AREA</h6>
                            </div>
                            <div class="col-sm-4">
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Nombre:
                                    <?= $resul3->nombre ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Usuario:
                                    <?= $resul->usuario_adm ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Fecha:
                                    <?= $resul->fecha_radicado ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Estado:
                                    <?= $resul->estado_3 ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Cargo:
                                    <?= $resul3->nombre_cargo ?>
                                </hx>
                                <hx class="bg-light d-flex d-flex justify-content-left align-items-right">Correo:
                                    <?= $resul3->correo ?>
                                </hx>
                                <hx>____________________________</hx>
                                <h6>AREA ADMINISTRATIVA</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <a type="button" class="btn btn-info" href="javascript:generatePDF()" id="downloadButton">Generar PDF</a>
    </div>





    <script>
        async function generatePDF() {
            document.getElementById("downloadButton").innerHTML = "Descargando, por favor espere...";

            //Downloading
            var downloading = document.getElementById("whatToPrint");
            var doc = new jsPDF('p', 'mm');

            await html2canvas(downloading, {
                allowTaint: true,
                useCORS: true,
                width: 3800,

            }).then((canvas) => {
                //Canvas (convert to JPG)
                doc.addImage(canvas.toDataURL("image/png"), 'png', 0, 10, 750, 200);
            })

            doc.save("Document.pdf");

            //End of downloading

            document.getElementById("downloadButton").innerHTML = "Generar PDF";
        }
    </script>


    <!--

HTML + CSS -> PNG (html2canvas)
PNG -> Add to PDF (jsPDF)
Download PDF (jsPDF)

-->

    <?php
    $conn = null;
    require_once('piedepagina.php');
} else {
    header('Location: log_in.php');
}
?>