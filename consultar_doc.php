<?php
session_start();
if (isset($_SESSION['id'])) {
    require_once('menu_superior.php');
    require_once('menu_lateral.php');
    require_once('conexiondb.php');


    $area = $conn->prepare("SELECT id, nombre FROM area");

    $area->execute();
    $area_filtro = $area->fetchAll(PDO::FETCH_OBJ);

    if (!isset($_GET['filtro1'])) {
        $stmt = $conn->prepare("SELECT empleado.nombre AS nombre_empleado, empleado.usuario, area.nombre AS nombre_area, cargo.nombre AS nombre_cargo, solicitud.id AS id_solicitud, estado.nombre AS nombre_estado FROM ((((empleado  
        INNER JOIN cargo ON empleado.id_cargo = cargo.id) 
        INNER JOIN area ON cargo.id_area = area.id)
        INNER JOIN solicitud ON empleado.id = solicitud.id_empleado)
        INNER JOIN estado ON estado.id = solicitud.id_estado) WHERE estado.nombre = 'AUTORIZADO' ORDER BY solicitud.id");
    } else {
        $filtro1 = $_GET['filtro1'];
        $stmt = $conn->prepare("SELECT empleado.nombre AS nombre_empleado, empleado.usuario, area.nombre AS nombre_area, cargo.nombre AS nombre_cargo, solicitud.id AS id_solicitud, estado.nombre AS nombre_estado FROM ((((empleado  
        INNER JOIN cargo ON empleado.id_cargo = cargo.id) 
        INNER JOIN area ON cargo.id_area = area.id)
        INNER JOIN solicitud ON empleado.id = solicitud.id_empleado)
        INNER JOIN estado ON estado.id = solicitud.id_estado) WHERE estado.nombre = 'AUTORIZADO' AND area.id = $filtro1 ORDER BY solicitud.id");
    }

    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    $rango = $conn->prepare("SELECT id, nombre FROM rango");

    $rango->execute();
    $rows2 = $rango->fetchAll(PDO::FETCH_OBJ);

?>
    <br><br><br>
    <!-- leyenda inicio-->
    <div class="height-100 bg-light container">
        <div class="row">
            <h2> Ver Documentos </h2>
        </div>
        <hr>
        <div class="row g-5">
            <form action="" method="get" class="needs-validation" novalidate>
                <div class="row g-3">
                    <div class="col-sm-1">
                        <label for="inputPassword6" class="col-form-label">Area</label>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-select" aria-label="Default select example" name="filtro1">
                            <?php foreach ($area_filtro as $row1) { ?>
                                <option value="<?= $row1->id ?>"> <?= $row1->nombre ?> </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <button type="subbmit" class="btn btn-success">
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <!--visual tabla -->
        <div class="row">
            <form action="accion_modificar_p.php" method="POST">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col"> Id Solicitud </th>
                            <th scope="col"> Nombre </th>
                            <th scope="col"> Usuario </th>
                            <th scope="col"> Area </th>
                            <th scope="col"> Cargo </th>
                            <th scope="col"> Estado </th>
                            <th scope="col"> Guardar </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $row) { ?>
                            <tr>
                                <td><?= $row->id_solicitud ?></td>
                                <td><?= $row->nombre_empleado ?></td>
                                <td>
                                    <input class="form-control-plaintext" id="usuario" name="usuario" value="<?= $row->usuario ?>" />
                                </td>
                                <td><?= $row->nombre_area ?></td>
                                <td><?= $row->nombre_cargo ?></td>
                                <td><?= $row->nombre_estado ?></td>
                                <td>
                                    <a href="pdf.php?id=<?= $row->id_solicitud ?>" class="btn btn-warning">Ver Documento</a>
                                </td>
        </div>
        </tr>
    <?php } ?>
    </tbody>
    </table>
    </form>
    </div>
    </div>

    <hr>
<?php
    include('piedepagina.php');
} else {
    header('Location: log_in.php');
}
?>