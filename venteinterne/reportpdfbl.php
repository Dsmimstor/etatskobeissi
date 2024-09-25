<?php
session_start();
require_once "../configs.php";
require_once "../dompdf/autoload.inc.php";

use Dompdf\Dompdf;
use Dompdf\Options;

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
    $tht = 0;
    $frais = 0;
    $transport = 0;
    $tauxechange = filter_input(INPUT_GET, 'tauxechange', FILTER_VALIDATE_FLOAT);
    $datefacture = $_GET['datefacture'];
    $nfacture = $_GET['nfacture'];
    $client = $_GET['client'];
    $email = $_GET['email'];
    $telephone = $_GET['telephone'];
    $adresse = $_GET['adresse'];
   
     
    $sqlcmd = "SELECT d.*, c.* FROM `tdocuments` d INNER JOIN `tclients` c ON d.id_client = c.id WHERE d.`id` = '$idc' ";
    $querycmd = $conn->prepare($sqlcmd);
    $querycmd->execute();
    $resultcmd = $querycmd->fetch(PDO::FETCH_ASSOC);
    $idproforma =  $resultcmd["numeros"];
    $datecmd = isset($_POST["dateproforma"]) ? htmlspecialchars($_POST["dateproforma"]) : date('d-m-Y');

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

$imagePath = '../img/SALS1.png';
$imageData = base64_encode(file_get_contents($imagePath));
$src = 'data:image/png;base64,' . $imageData;

$imagePath1 = '../img/Cachet.png';
$imageData1 = base64_encode(file_get_contents($imagePath1));
$srcs = 'data:image/png;base64,' . $imageData1;

// Génération du contenu HTML pour le PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        @page {
            margin-top: 5px;
             margin: 10px;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 10px;
        }
        .content {
            flex: 1;
        }
        table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
            font-size: 20px;
        }
        td {
            padding: 3px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 15px;
        }
        thead tr:first-child td:first-child {
            border-top-left-radius: 10px;
        }
        thead tr:first-child td:last-child {
            border-top-right-radius: 10px;
        }
        thead tr:last-child td:first-child {
            border-bottom-left-radius: 10px;
        }
        thead tr:last-child td:last-child {
            border-bottom-right-radius: 10px;
        }
        .invoice-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .invoice-header img {
            max-width: 150px;
            height: auto;
        }
        .invoice-header .invoice-details {
            flex: 1;
            text-align: right;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 8px;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
            .facture {
            border: 1px solid #676363;
            box-shadow: 10px 20px 3px green inset;
            padding: 5px;
            margin: 5px;
        }
        .facture h2 {
            margin: 0;
            text-align: center;
        }
         .invoice-header img {
            height: 20px; 
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <p class="logo" style=" display: flex; margin: 0;">
            <img src="' . $src . '" alt="Logo" style=" margin: 0; width: 100px;height: 100px;">
            <div style="margin: 2px; padding-bottom: 2px; text-align: right;">
                Date : '." " . $datecmd . '
            </div>
             <div class="facture">
                <h2 style="margin: 0; text-align: center";>
                    Bon de Livraison N° : '." " . $nfacture . '
                </h2>
            </div>
        </p>
    </div>
    <div class="content">
        <div style="display: flex; justify-content: space-between;">
            <div style="margin: 2; text-align: right;">Facture Client</div>
        </div>
        <table>
            <thead>
                <tr>
                    <td colspan="2" style="text-align: left; border-bottom: none;border-right: none;font-size: 15px;">Client  : '." " . $client . '</td>
                    <td style="text-align: left;border-bottom: none; border-left: none;font-size: 15px;">Telephone : '." " . $telephone . ' </td>
                </tr>
                <tr>
                    <td colspan="2"  style="text-align: left;border-top: none; border-right: none;font-size: 15px; ">Email  : '." " . $email . '</td>
                    <td style="text-align: left;border-top: none;border-left: none;font-size: 15px;">Adresse  : '." " . $adresse . '</td>
                </tr>
            </thead>
        </table>
        <div  style="height: 5px;"></div>
        <table>
            <thead>
                <tr>
                    <th>Designation</th>
                    <th>Quantité</th>
                    <th>Unité</th>
                </tr>
            </thead>
            <tbody>';

foreach ($servers as $server) {
    $html .= '
                <tr style="font-size: 15px;">
                    <td style="border-bottom: none; border-top: none;">' . $server["articles"] . '</td>
                    <td style="border-bottom: none; border-top: none;">' . number_format($server["quantite"], 2, ',', ' ') . '</td>
                    <td style="border-bottom: none; border-top: none;">' . $server["unites"] . '</td>
                </tr>';
    $total += $server["prix"] * $server["quantite"];
}
$html .= '
            </tbody>
        </table>
        <h4 style="border: 0px solid black; font-size: 15px;">Arretée la presente facture à la sommes de : ' . nombreEnLettres((($total * $frais / 100) + $total + $transport)*$tauxechange) . " " . "FCFA" . '</h4>
    <p style="margin: 2;"></p>
    <p style="margin: 2;"></p>
    <p style="margin-right: 60; text-align: right;text-decoration: underline;">VISA & CACHET</p>
    <p style="margin-right: 60; text-align: right;text-decoration: underline;">
     <img src="' . $srcs . '" alt="Logo" style=" margin: 0;height: 100px;">
    </p>
        </div>
    <div class="footer" style="font-size: 10px; line-height: 1; margin: 0;">
        <p style="margin: 4;"> LE PALAIS DU CHOCOLAT </p>
        <p style="margin: 2;"> Deux Plateau Rue des Vallons, 18 Bp 109 Abj 18 Côte d Ivoire - Tel : 27 21 354 292 Tél / Whats App : 07 77 728 887 </p>
        <p style="margin: 2;"> Compte Contribuable N° 21 76519U - Régistre de Commerce N° CI-ABJ-03-2024 - Compte Bancaire : BACI N° : CI 034 01039 1475149600012 39 </p>
       <p style="margin: 2;">-</p>
        Page {PAGE_NUM} sur {PAGE_COUNT}
    </div>
</body>
</html>';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);

// Configuration de la taille et de l'orientation de la page
$dompdf->setPaper('A4', 'portrait');

// Réduire les marges


// Rendu du PDF
$dompdf->render();

// Envoi du PDF au navigateur
$dompdf->stream("facture.pdf", array("Attachment" => false));
?>