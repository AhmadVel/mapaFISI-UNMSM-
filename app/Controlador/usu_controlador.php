<?php
// Verifica la acción que se debe realizar
if (isset($_GET['accion'])) {
    $accion = $_GET['accion'];
    switch ($accion) {
        case 'navegar_a_cursos':
            header("Location: ../vista/frm_eventos.php");
            break;
        case 'navegar_a_areas':
            header("Location: ../vista/frm_eventos.php");
            break;
        case 'navegar_a_login':
            header("Location: ../vista/frm_login.php");
            break;
        default:
            echo "Acción no válida";
    }
} else {
    echo "No se especificó ninguna acción";
}
?>