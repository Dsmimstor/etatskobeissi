<?php
session_start();
$date = new DateTime();
$datemy = $date->format('Y-m');
$date_actuel = $date->format("Y-m-d");
$from_date = $date->format($datemy . "-01");
$to_date = $date_actuel;
$typefactures = "T";
$currentPage = 1;
$premier = 0;
$nbenregistrement = 0;


require_once "../configs.php";

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {

    $RSqlste = "SELECT * FROM `tsociete` WHERE `id`  = '1' ";
    $queryste = $conn->prepare($RSqlste);
    $queryste->execute();
    $resultste = $queryste->fetch(PDO::FETCH_ASSOC);

    if (isset($_GET['page'])) {
        $currentPage = intval($_GET['page']);
    }
    if (isset($_GET['from_date'])) {
        $from_date = $_GET["from_date"];
    }
    if (isset($_GET['to_date'])) {
        $to_date = $_GET["to_date"];
    }
    if (isset($_GET['typefactures'])) {
        $typefactures = $_GET["typefactures"];
    }
    if ($typefactures == "T") {
        $TSql = "SELECT COUNT(*) AS nb_enregistrement FROM `tdocuments` d INNER JOIN `tclients` c ON d.id_client = c.id WHERE dates BETWEEN '$from_date' AND '$to_date'";
        $stmt = $conn->prepare($TSql);
        $stmt->execute();
        //on recupere le nombre d'element
        $result = $stmt->fetch();

        $nbenregistrement = (int) $result['nb_enregistrement'];

        //Determiner le nombre d'element par page
        $parPage = 10;

        //on calcul le nombre de page total
        $pages = ceil($nbenregistrement / $parPage);

        //calcul du premier element de la page
        $premier = ($currentPage * $parPage) - $parPage;
        //    $RSql = "SELECT coalesce(SUM(dd.prix*dd.quantite), 0) HT, coalesce(SUM(dd.trans), 0) trans, coalesce(SUM(dd.frais), 0) frais,  c.designations as client,f.id, f.dates, f.type, f.id_client, f.observation, f.numero, f.etat FROM `tdocuments` f INNER JOIN `tclients` c ON f.id_client = c.id LEFT JOIN tdetail_document dd ON dd.id_document=f.id WHERE dates BETWEEN '$from_date' AND '$to_date' GROUP BY  c.designations, c.designations, f.id, f.dates, f.type, f.id_client, f.observation, f.numero, f.etat ORDER BY dates  LIMIT :premier, :parpage ";
        $RSql = "SELECT  c.designations as client,f.id, f.dates, f.types, f.id_client, f.observation, f.numeros, f.typesavoir, f.totalht, f.tfrais, f.ttransport, f.etatcmd FROM `tdocuments` f INNER JOIN `tclients` c ON f.id_client = c.id  WHERE dates BETWEEN '$from_date' AND '$to_date' GROUP BY  c.designations, c.designations, f.id, f.dates, f.types, f.id_client, f.observation, f.numeros, f.typesavoir, f.totalht, f.tfrais, f.ttransport, f.etatcmd ORDER BY dates  LIMIT :premier, :parpage ";

        $stmt = $conn->prepare($RSql);
        $stmt->bindValue(':premier', $premier, PDO::PARAM_INT);
        $stmt->bindValue(':parpage', $parPage, PDO::PARAM_INT);


        $stmt->execute();
        $servers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $typefactures = $_GET["typefactures"];
        $TSql = "SELECT COUNT(*) AS nb_enregistrement FROM `tdocuments` d INNER JOIN `tclients` c ON d.id_client = c.id WHERE d.dates BETWEEN '$from_date' AND '$to_date' AND d.types='$typefactures'";
        // $TSql = "SELECT COUNT(*) AS nb_enregistrement FROM `tdocuments` d INNER JOIN `tclients` c ON d.id_client = c.id WHERE dates BETWEEN '$from_date' AND '$to_date'";

        $stmt = $conn->prepare($TSql);
        $stmt->execute();
        //on recupere le nombre d'element
        $result = $stmt->fetch();

        $nbenregistrement = (int) $result['nb_enregistrement'];

        //Determiner le nombre d'element par page
        $parPage = 10;

        //on calcul le nombre de page total
        $pages = ceil($nbenregistrement / $parPage);

        //calcul du premier element de la page
        $premier = ($currentPage * $parPage) - $parPage;
        $RSql = "SELECT  c.designations as client,f.id, f.dates, f.types, f.id_client, f.observation, f.numeros, f.typesavoir, f.totalht, f.tfrais, f.ttransport FROM `tdocuments` f INNER JOIN `tclients` c ON f.id_client = c.id  WHERE dates BETWEEN '$from_date' AND '$to_date' AND types='$typefactures' GROUP BY  c.designations, c.designations, f.id, f.dates, f.types, f.id_client, f.observation, f.numeros, f.totalht, f.tfrais, f.ttransport ORDER BY dates  LIMIT :premier, :parpage ";
        $stmt = $conn->prepare($RSql);
        $stmt->bindValue(':premier', $premier, PDO::PARAM_INT);
        $stmt->bindValue(':parpage', $parPage, PDO::PARAM_INT);
        $stmt->execute();
        $servers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/img/Iconadc.jpg" />
    <title>SALS EXPRESS</title>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">-->


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">


    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">

    <link rel="stylesheet" href="/css/Stylelisteventes.css" />
    <script>
        function confirmer(id) {
            if (confirm("Voulez-vous supprimer cet article ?")) {
                location.href = "delete.php?id=" + id;
            }
        }
    </script>
</head>

<body>
    <header class="nav1">
        <!-- Logo-->
        <p class="slogan" href="#">
            <img src="/img/SALS1L.png" alt="logoAtelier" />
            <a><?php echo htmlspecialchars($resultste["designation"], ENT_QUOTES, 'UTF-8'); ?> </a>
        </p>

    </header>
    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <center>
                <div style="border: 1px solid black; margin: 5px;">
                    <h1 style="text-shadow: -2px -2px white,2px 2px #0F0604; color:#504846;">Liste des Commandes</h1>
                </div>
                <div class="card-body " style="border: 1px solid black;">
                    <form method="GET">

                        <div class="row input-group ">
                            <div class="col-md-4">
                                <div class="form-group input-group" style="margin: 5px;">
                                    <span class="input-group-addon" style="width:240px;"> Designation :</span name="etat">
                                    <select id="typefacture" name="typefactures" size="1" style="width:180px;" class="form-control">
                                        <option value="T">Tous</option>
                                        <option value="PR">Proforma</option>
                                        <option value="BL">Bon de Livraison</option>
                                        <option value="FA">Facture</option>
                                        <option value="F*">Facture*</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group input-group" style="margin: 5px;">
                                    <span class="input-group-addon" style="width:70px;"> DU :</span>
                                    <input type="date" name="from_date" value='<?= $from_date  ?>' class="form-control" placeholder="From Date" style="width:150px;">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group input-group" style="margin: 5px;">
                                    <span class="input-group-addon" style="width:70px;">AU :</span>
                                    <input type="date" name="to_date" value='<?= $to_date ?>' class="form-control" placeholder="to Date" style="width:150px;">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" style="margin: 5px;">
                                    <label for=""></label>
                                    <button type="submit" class="btn btn-primary" name="btn_recherche">Rechercher</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </center>
            <div style=" height:10px;">
            </div>
            <table width="100%" class="table table-bordered border-primary table-hover" id="tfacture">
                <thead>
                    <th scope="col" class="T1" style="width: 100px; ">N° </th>
                    <th scope="col" class="T2" style="width: 90px;">Date</th>
                    <th scope="col" class="T7" style="width: 350px;">Client</th>
                    <th scope="col" class="T4" style="width: 90px;">Mont HT</th>
                    <th scope="col" class="T4" style="width: 90px;">Frais Gestion</th>
                    <th scope="col" class="T4" style="width: 90px;">Transport</th>
                    <th scope="col" class="T4" style="width: 90px;">Mont TTC</th>
                    <th scope="col" class="T4" style="width: 90px;">Etat Cmd</th>
                    <th scope="col" class="T8" style="width: 90px; ">Actions</th>
                </thead>
                <tbody>
                    <?php
                    foreach ($servers as $server) :
                    ?>
                        <tr>
                            <td scope="row" style="text-align: center; font-family: sans-serif; padding: 3px;">
                                <span class="border border-primary" id="codefour">
                                    <?= $server["numeros"] ?>
                                </span>
                            </td>
                            <td style="text-align: center; font-family: sans-serif; padding: 3px; ">
                                <span class="border border-primary" id="dates">
                                    <?= date('d-m-Y', strtotime($server["dates"])); ?>
                                </span>
                            </td>
                            <td style="font-family: sans-serif ; text-align: center; padding: 3px; ">
                                <span class="border border-primary" id="client">
                                    <?= $server["client"] ?>
                                </span>
                            </td>
                            <td style="font-family: sans-serif ; text-align: center; padding: 3px; ">
                                <span class="border border-primary" id="ht">
                                    <?= number_format($server["totalht"], 2, '.', ','); ?>
                                </span>
                            </td>
                            <td style="font-family: sans-serif ; text-align: center; padding: 3px; ">
                                <span class="border border-primary" id="tva">
                                    <?= number_format($server["tfrais"], 2, '.', ','); ?>
                                </span>
                            </td>
                            <td style="font-family: sans-serif ; text-align: center; padding: 3px; ">
                                <span class="border border-primary" id="trans">
                                    <?= number_format($server["ttransport"], 2, '.', ','); ?>
                                </span>
                            </td>
                            <td style="font-family: sans-serif ; text-align: center; padding: 3px; ">
                                <span class="border border-primary" id="ttc">
                                    <?= number_format($server["totalht"] + $server["ttransport"] + $server["tfrais"], 2, '.', ','); ?>
                                </span>
                            </td>
                            <td style="font-family: sans-serif ; text-align: center; padding: 3px; ">
                                <span class="border border-primary" id="ttc">
                                    <?= $server["etatcmd"] ?>
                                </span>
                            </td>
                            <td style="font-family: sans-serif; text-align: center; padding: 3px;">
                                <?php
                                if ($server["etatcmd"] == "Terminé") {
                                    $tooltipText = "Voir la Facture";
                                    $serverId = htmlspecialchars($server['id'], ENT_QUOTES, 'UTF-8');
                                    echo '<a type="button" onclick="test(' . $serverId . ')"  data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><i class="fa fa-search fa-2x" style="font-size:20px; color:green;"></i></a>';
                                } else {
                                    $tooltipText = "Annuler la Commande";
                                    $tooltipText1 = "Voir la Commande";
                                    $serverId = htmlspecialchars($server['id'], ENT_QUOTES, 'UTF-8');
                                    $serverEtatcmd = htmlspecialchars($server['etatcmd'], ENT_QUOTES, 'UTF-8');
                                    echo '<a type="button" onclick="test1(' . $serverId . ', \'' . $serverEtatcmd . '\')"  data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText1, ENT_QUOTES, 'UTF-8') . '"><i class="fa fa-pencil fa-2x" style="font-size:20px;"></i></a>';
                                    echo '<a type="button" onclick="confirmer(' . $serverId . ')" class="supp"  data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><i class="fa fa-trash fa-2x" style="font-size:20px; color:red;"></i></a>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <nav>
                <ul class="pagination">
                    <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                        <a href="/venteinterne/listevente.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                    </li>
                    <?php for ($i = 1; $i <= $pages; $i++) : ?>
                        <li class="page-item <?= ($currentPage == $i) ? "active" : "" ?>">
                            <a href="/venteinterne/listevente.php?page=<?= $i ?>&typefactures=<?= $typefactures ?>&from_date=<?= $from_date ?>&to_date=<?= $to_date ?>" class="page-link"><?= $i ?></a>
                        </li>
                    <?php endfor ?>
                    <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                        <a href="/venteinterne/listevente.php?page=<?= $currentPage + 1 ?>&typefactures=<?= $typefactures ?>&from_date=<?= $from_date ?>&to_date=<?= $to_date ?>" class="page-link">Suivante</a>
                    </li>
                </ul>
            </nav>
            <div class="modal-footer">
                <?php
                $tooltipText = "Ajouter une nouvelle proforma";
                echo '<a  href="/venteinterne/commandes.php" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:magenta"></span> Ajouter une Proforma</a>';
                ?>
                <?php
                $tooltipText = "Liste des Proformas";
                echo '<a  href="/venteinterne/listeproforma.php" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:green"></span> Proforma</a>';
                ?>
                <?php
                $tooltipText = "Liste des Commandes en Attentes";
                echo '<a  href="/venteinterne/listecommande.php" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:yellow"></span> Commande</a>';
                ?>
                <?php
                $tooltipText = "Liste des Bons de Libraisons";
                echo '<a  href="/venteinterne/listebl.php" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:blue"></span> Bon Liv</a>';
                ?>
                <?php
                $tooltipText = "Liste des Factures";
                echo '<a  href="/venteinterne/listefacture.php" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:white"></span> FACTURE</a>';
                ?>
                <?php
                $tooltipText = "Liste des Factures Avoir";
                echo '<a  href="/venteinterne/listeavoir.php" type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:red"></span> AVOIR</a>';
                ?>
                <a href="/Accueil.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Accueil</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" href="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

    <scripthttps: src="process.js"></scripthttps:>
    <script>
        $(function() {
            $('#typefacture').change(function recid() {
                var idtypefacture = $(this).find('option:selected').val();

            });
        })

        function test(idt, etatcmd) {
            if (etatcmd === "Emis") {
                location.href = "detailventeproforma.php?id=" + idt; detailcmd
            } else {
                location.href = "detailfacture.php?id=" + idt;
            }
        }

        function test1(idt, etatcmd) {
            if (etatcmd === "Emis") {
                location.href = "detailventeproforma.php?id=" + idt; 
            } else {
                location.href = "detailcmd.php?id=" + idt;
            }
        }
        
    </script>
</body>

</html>