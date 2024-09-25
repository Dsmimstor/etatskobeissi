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
    $tht = filter_input(INPUT_GET, 'tht', FILTER_VALIDATE_FLOAT);
    $frais = filter_input(INPUT_GET, 'frais', FILTER_VALIDATE_FLOAT);
    $transport = filter_input(INPUT_GET, 'transport', FILTER_VALIDATE_FLOAT);
    $tauxechange = filter_input(INPUT_GET, 'tauxechange', FILTER_VALIDATE_FLOAT);
    $datefacture = $_GET['datefacture'];

    $sqlcmd = "SELECT d.*, c.* FROM `tdocuments` d INNER JOIN `tclients` c ON d.id_client = c.id WHERE d.`id` = '$idc' ";
    $querycmd = $conn->prepare($sqlcmd);
    $querycmd->execute();
    $resultcmd = $querycmd->fetch(PDO::FETCH_ASSOC);
    $idproforma =  $resultcmd["numeros"];
    $datecmd = isset($_POST["dateproforma"]) ? htmlspecialchars($_POST["dateproforma"]) : date('Y-m-d');

    function nombreEnLettres($n) {
        if ($n < 0) {
            return "moins " . nombreEnLettres(-$n);
        }
        $unités = ["", "un", "deux", "trois", "quatre", "cinq", "six", "sept", "huit", "neuf"];
        $dizaines = ["", "dix", "vingt", "trente", "quarante", "cinquante", "soixante", "soixante-dix", "quatre-vingt", "quatre-vingt-dix"];
        $exceptions = [
            11 => "onze", 12 => "douze", 13 => "treize", 14 => "quatorze", 15 => "quinze", 16 => "seize",
            71 => "soixante et onze", 72 => "soixante-douze", 73 => "soixante-treize", 74 => "soixante-quatorze",
            75 => "soixante-quinze", 76 => "soixante-seize", 91 => "quatre-vingt-onze", 92 => "quatre-vingt-douze",
            93 => "quatre-vingt-treize", 94 => "quatre-vingt-quatorze", 95 => "quatre-vingt-quinze", 96 => "quatre-vingt-seize"
        ];
        if ($n == 0) {
            return "zéro";
        } elseif ($n < 10) {
            return $unités[$n];
        } elseif (isset($exceptions[$n])) {
            return $exceptions[$n];
        } elseif ($n < 20) {
            return "dix-" . $unités[$n - 10];
        } elseif ($n < 100) {
            $dizaine = intdiv($n, 10);
            $unité = $n % 10;
            if ($dizaine == 7 || $dizaine == 9) {
                return $dizaines[$dizaine - 1] . "-" . $exceptions[10 + $unité];
            } elseif ($unité == 1 && ($dizaine == 1 || $dizaine == 7 || $dizaine == 9)) {
                return $dizaines[$dizaine] . "-et-un";
            } else {
                return $dizaines[$dizaine] . (($unité > 0) ? "-" . $unités[$unité] : "");
            }
        } elseif ($n < 1000) {
            $centaine = intdiv($n, 100);
            $reste = $n % 100;
            if ($centaine == 1) {
                return "cent" . (($reste > 0) ? " " . nombreEnLettres($reste) : "");
            } else {
                return $unités[$centaine] . " cent" . (($reste == 0) ? "s" : "") . (($reste > 0) ? " " . nombreEnLettres($reste) : "");
            }
        } elseif ($n < 1000000) {
            $mille = intdiv($n, 1000);
            $reste = $n % 1000;
            if ($mille == 1) {
                return "mille" . (($reste > 0) ? " " . nombreEnLettres($reste) : "");
            } else {
                return nombreEnLettres($mille) . " mille" . (($reste > 0) ? " " . nombreEnLettres($reste) : "");
            }
        } else {
            $million = intdiv($n, 1000000);
            $reste = $n % 1000000;
            if ($million == 1) {
                return "un million" . (($reste > 0) ? " " . nombreEnLettres($reste) : "");
            } else {
                return nombreEnLettres($million) . " millions" . (($reste > 0) ? " " . nombreEnLettres($reste) : "");
            }
        }
    }
    $nombre = (($total * $frais / 100) + $total + $transport)*$tauxechange;

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
       body { font-seize: 8; }
        table { width: 100%; border-collapse: collapse; }
        th { border: 1px solid black; padding: 5px; text-align: center; }
        td { border: 1px solid black; padding: 5px; text-align: center; }
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
                <th>Total</th>
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

$html .= '
            <tr class="total">
                <td colspan="4"style="text-align: right; border-top: none; border-bottom: none;">Total HT : </td>
                <td>' . number_format($total, 2, '.', ',') . '</td>
            </tr>
            <tr class="total">
                <td colspan="4"style="text-align: right; border-top: none; border-bottom: none;">Frais de gestion % : </td>
                <td>' . number_format($frais, 2, '.', ',') . '</td>
            </tr>
            <tr class="total">
                <td colspan="4"style="text-align: right;  border-top: none; border-bottom: none;">Transport € : </td>
                <td>' . number_format($transport, 2, '.', ',') . '</td>
            </tr>
            <tr class="total">
                <td colspan="4" style="text-align: right;  border-top: none; border-bottom: none;">Montant Total € : </td>
                <td>' . number_format((($total * $frais / 100) + $total + $transport), 2, '.', ',') . '</td>
            </tr>
                <tr class="total">
                <td colspan="4" style="text-align: right;  border-top: none; ">Montant Total FCFA : </td>
                <td>' . number_format((($total * $frais / 100) + $total + $transport)*$tauxechange, 0, '.', ',') . '</td>
            </tr>
        </table>
    <h4 style="border: 0px solid black; font-seize: 7;" >Arretée la presente facture à la sommes de : ' . nombreEnLettres((($total * $frais / 100) + $total + $transport)*$tauxechange) ." " . "FCFA" . '</h4>
    <h4
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
