<?php
session_start();
if (isset($_SESSION['id'])) {
    $filtro = "";
    $id_empleado = $_SESSION['id'];
    require_once('menu_superior.php');
    require_once('menu_lateral.php');
    require_once('conexiondb.php');

    $mostrar = $conn->prepare("SELECT id AS id_estado, nombre AS nombre_estado FROM estado");
    $mostrar->execute();
    $filtro_mostrar = $mostrar->fetchAll(PDO::FETCH_OBJ);

    $sqlStmt = "SELECT solicitud.id, motivo_solicitud.nombre AS nombre_motivo, solicitud.fecha_registro, estado.nombre AS nombre_estado FROM ((solicitud 
        INNER JOIN motivo_solicitud ON solicitud.id_motivo = motivo_solicitud.id) 
        INNER JOIN estado ON solicitud.id_estado = estado.id) WHERE solicitud.id_empleado = $id_empleado ";

    if (isset($_GET['filtro']) and !empty($_GET['filtro'])) {
        $filtro = $_GET['filtro'];
        $sqlStmt = $sqlStmt . "AND estado.id = $filtro";
    }
    $stmt = $conn->prepare($sqlStmt);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);


    ?>
    <br><br><br><br>
    <div class="height-100 bg-light container">
        <div class="row">
            <h2>Solicitudes</h2>
        </div>
        <hr>

        <div class="row g-5">
            <form action="" method="get" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-sm-1">
                        <label for="inputPassword6" class="col-form-label">Mostrar</label>
                    </div>

                    <div class="col-sm-2">
                        <select class="form-select" aria-label="Default select example" name='filtro'>
                            <option value="">Todos</option>
                            <?php
                            foreach ($filtro_mostrar as $row1) { ?>
                                <option value="<?= $row1->id_estado ?>" <?= $row1->id_estado == $filtro ? "selected" : "" ?>>
                                    <?= $row1->nombre_estado ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-7">
                        <button type="submit" class="btn btn-success">filtrar</button>
                    </div>
                    <div class="col-sm-2">
                        <a href="nuevasolicitud.php">
                            <button type="button" class="btn btn-info">Crear Solicitud</button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
        <hr>

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
                                <?= $row->nombre_estado ?>
                            </td>

                            <td>
                                <a href="verdoc.php?id=<?= $row->id ?>" class="btn btn-secondary">Ver</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>


                </tbody>
            </table>
        </div>
    </div>


    <?php
    $conn = null;
    include('piedepagina.php');
} else {
    header('Location: log_in.php');
}
?>