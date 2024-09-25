<?php
session_start();
require_once "../configs.php";
require_once "../dompdf/autoload.inc.php";

use Dompdf\Dompdf;

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
    exit();
} else {
    $total = 0;
    $RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
    $queryste = $conn->prepare($RSqlste);
    $queryste->execute();
    $resultste = $queryste->fetch(PDO::FETCH_ASSOC);

    $idc = $_GET["id"];
    $sqlcmd = "SELECT d.*, c.* FROM `tdocuments` d INNER JOIN `tclients` c ON d.id_client = c.id WHERE d.`id` = '$idc' ";
    $querycmd = $conn->prepare($sqlcmd);
    $querycmd->execute();
    $resultcmd = $querycmd->fetch(PDO::FETCH_ASSOC);
    $idproforma =  $resultcmd["numeros"];
    $datecmd = isset($_POST["dateproforma"]) ? htmlspecialchars($_POST["dateproforma"]) : date('Y-m-d');
}

// Récupération des données du tableau
$RSql = "SELECT * FROM `tdetail_document` WHERE `id_document`= '" .  $idc . "' ";
$stmt = $conn->prepare($RSql);
$stmt->execute();
$servers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Génération du contenu HTML pour le PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>

<body>
    <h1>' . $resultste["designation"] . '</h1>
    <h2>Facture</h2>
    <table>
        <thead>
            <tr>
                <th>Designation</th>
                <th>Prix</th>
                <th>Quantité</th>
                <th>Unité</th>
                <th>Total Ht</th>
            </tr>
        </thead>
        <tbody>';

foreach ($servers as $server) {
    $html .= '
            <tr>
                <td>' . $server["articles"] . '</td>
                <td>' . number_format($server["prix"], 2, '.', ',') . '</td>
                <td>' . number_format($server["quantite"], 2, '.', ',') . '</td>
                <td>' . $server["unites"] . '</td>
                <td>' . number_format($server["prix"] * $server["quantite"], 2, '.', ',') . '</td>
            </tr>';


    $total += $server["prix"] * $server["quantite"];
}

// $html .= '
//         </tbody>
//     </table>

$html .= '
            <tr class="total">
                <td></td>
                <td></td>
                <td></td>
                <td>Total: </td>
                <td>' . number_format($total, 2, '.', ',') . '</td>
            </tr>
        </table>
    <h3>Total: ' . number_format($total, 2, '.', ',') . '</h3>
</body>
</html>';

// Initialisation de Dompdf
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optionnel) Configuration de la taille et de l'orientation de la page
$dompdf->setPaper('A4', 'portrait');

// Rendu du PDF
$dompdf->render();

// Envoi du PDF au navigateur
$dompdf->stream("facture.pdf", array("Attachment" => false));
