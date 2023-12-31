<?php
session_start();
if (isset($_SESSION['id'])) {
    require_once('menu_superior.php');
    require_once('menu_lateral.php');
    require_once('conexiondb.php');


    $stmt = $conn->prepare("SELECT solicitud.id, motivo_solicitud.nombre AS nombre_motivo, solicitud.fecha_registro, estado.nombre FROM ((solicitud 
        INNER JOIN motivo_solicitud ON solicitud.id_motivo = motivo_solicitud.id) 
        INNER JOIN estado ON solicitud.id_estado = estado.id) WHERE estado.id=1");

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);


    ?>
    <br><br><br>
    <!-- leyenda inicio-->
    <div class="height-100 bg-light container">
        <div class="row">
            <h2>Pendientes</h2>
        </div>

        <div class="d-flex bd-highlight mb-3">
            <div class="p-2 bd-highlight">
            </div>
        </div>
        <!--visual tabla -->
        <div class="row">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">No. Solicitud</th>
                        <th scope="col">Motivo</th>
                        <th scope="col">Fecha Solicitud</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Visualizar</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($rows as $row) {
                        ?>
                        <tr>
                            <td>
                                <?= $row->id ?>
                            </td>
                            <td>
                                <?= $row->nombre_motivo ?>
                            </td>
                            <td>
                                <?= $row->fecha_registro ?>
                            </td>
                            <td>
                                <?= $row->nombre ?>
                            </td>

                            <td>
                                <a href="pendientesGG.php?id=<?= $row->id ?>" class="btn btn-secondary">Gestionar</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
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