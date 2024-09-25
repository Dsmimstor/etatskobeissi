<?php
session_start();


$date = new DateTime();
$datemy = $date->format('Y-m');

$date_actuel = $date->format("Y-m-d");
$from_date = $date->format($datemy . "-01");
$to_date = $date_actuel;
$typemtvs = "T";
$currentPage = 1;
$premier = 0;
$nbenregistrement = 0;

require_once "../configs.php";

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
    exit();
} else {

    // Récupération des informations de la société
    $RSqlste = "SELECT * FROM `tsociete` WHERE `id` = 1";
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
    // Définition du type de facture
    $typemtvs = "sortie";

    // Requête pour compter le nombre d'enregistrements
    $TSql = "SELECT COUNT(*) AS nb_enregistrement FROM `tstocks` WHERE mouvements = :typemtvs";
    if ($from_date && $to_date) {
        $TSql .= " AND dates BETWEEN :from_date AND :to_date";
    }
    $stmt = $conn->prepare($TSql);
    $stmt->bindValue(':typemtvs', $typemtvs, PDO::PARAM_STR);
    if ($from_date && $to_date) {
        $stmt->bindValue(':from_date', $from_date, PDO::PARAM_STR);
        $stmt->bindValue(':to_date', $to_date, PDO::PARAM_STR);
    }
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $nbenregistrement = (int) $result['nb_enregistrement'];

    // Déterminer le nombre d'éléments par page
    $parPage = 10;

    // Calcul du nombre de pages total
    $pages = ceil($nbenregistrement / $parPage);

    // Calcul du premier élément de la page
    $premier = ($currentPage - 1) * $parPage;

    // Requête pour récupérer les enregistrements avec pagination
    $RSql = "SELECT * FROM `tstocks` WHERE mouvements = :typemtvs";
    if ($from_date && $to_date) {
        $RSql .= " AND dates BETWEEN :from_date AND :to_date";
    }
    $RSql .= " ORDER BY designations ASC";


    $RSql .= " LIMIT :premier, :parpage";
    $stmt = $conn->prepare($RSql);
    $stmt->bindValue(':typemtvs', $typemtvs, PDO::PARAM_STR);
    if ($from_date && $to_date) {
        $stmt->bindValue(':from_date', $from_date, PDO::PARAM_STR);
        $stmt->bindValue(':to_date', $to_date, PDO::PARAM_STR);
    }
    $stmt->bindValue(':premier', $premier, PDO::PARAM_INT);
    $stmt->bindValue(':parpage', $parPage, PDO::PARAM_INT);
    $stmt->execute();
    $servers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Gestion de la soumission du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["validateBtn"])) {
        $designation = $_POST['designation'];
        $quantity = $_POST['quantity'];
        $movementType = $_POST['movementType'];
        $movementDate = $_POST['movementDate'];
        $operateur = $_POST['operateur'];

        // Validation des champs
        if (!empty($designation) && !empty($quantity) && !empty($movementType) && !empty($movementDate) && !empty($operateur)) {
            $sqle = "INSERT INTO tstocks (dates, designations, quantites, mouvements, operateur)
                    VALUES (:movementDate, :designation, :quantity, :movementType, :operateur)";
            $stmte = $conn->prepare($sqle);
            $stmte->bindValue(':designation', $designation, PDO::PARAM_STR);
            $stmte->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            $stmte->bindValue(':movementType', $movementType, PDO::PARAM_STR);
            $stmte->bindValue(':movementDate', $movementDate, PDO::PARAM_STR);
            $stmte->bindValue(':operateur', $operateur, PDO::PARAM_STR);

            if ($stmte->execute()) {
                //    href="/stock/sortiestocks.php";
                echo "La Sortie a été enregistrée";
                header("Location: sortiestocks.php");
            } else {
                echo "Erreur: " . $stmte->errorInfo()[2];
            }
        } else {
            echo "Tous les champs sont requis.";
        }
    }
    // Gestion de la soumission du formulaire
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["validateBtn1"])) {
        $id1 = $_POST['id1'];
        $designation1 = $_POST['designation1'];
        $quantity1 = $_POST['quantity1'];
        $movementType1 = $_POST['movementType1'];
        $movementDate1 = $_POST['movementDate1'];
        $operateur1 = $_POST['operateur1'];

        // Modification des champs
        if (!empty($designation1) && !empty($quantity1) && !empty($movementType1) && !empty($movementDate1) && !empty($operateur1)) {
            //  $sqle = "INSERT INTO tstocks (dates, designations, quantites, mouvements, operateur)
            $RSqls = "UPDATE `tstocks` SET
                    dates =:movementDate1,
                    designations=:designation1,
                    quantites =:quantity1,
                    mouvements =:movementType1,
                    operateur =:operateur1 WHERE `id`=$id1";

            $stmts = $conn->prepare($RSqls);
            $stmts->bindValue(':designation1', $designation1, PDO::PARAM_STR);
            $stmts->bindValue(':quantity1', $quantity1, PDO::PARAM_INT);
            $stmts->bindValue(':movementType1', $movementType1, PDO::PARAM_STR);
            $stmts->bindValue(':movementDate1', $movementDate1, PDO::PARAM_STR);
            $stmts->bindValue(':operateur1', $operateur1, PDO::PARAM_STR);

            if ($stmts->execute()) {
                //    href="/stock/sortiestocks.php";
                echo "La Sortie a été modifié";
                header("Location: sortiestocks.php");
            } else {
                echo "Erreur: " . $stmte->errorInfo()[2];
            }
        } else {
            echo "Tous les champs sont requis.";
        }
    }
}
?>
<script>
    function tris(id) {

        const datefin = document.getElementById('to_date').value;
        const datedebut = document.getElementById('from_date').value;
        const url = `entrestockud.php?id=${encodeURIComponent(id)}
                &to_date=${encodeURIComponent(datefin)}
                &from_date=${encodeURIComponent(datedebut)}`;
        // Rediriger vers la page PHP avec les paramètres
        window.location.href = url;
    }
</script>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/css/Stylelisteventes.css" />
    <title>Gestion des Mouvements</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 0.1px solid #8c8c8c;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .center {
            text-align: center;
        }

        .bordered-div {
            border: 1px solid black;
            margin: 5px;
        }

        .title {
            text-shadow: -2px -2px white, 2px 2px #0F0604;
            color: #504846;
        }

        .rotate--270 {
            transform: rotate(-270deg);
            transition: transform 0.3s ease-in-out;
            color: red;
        }

        .rotate-388 {
            transform: rotate(388deg);
            transition: transform 0.3s ease-in-out;
            color: green;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {

            $('.fa-play').click(function() {
                $(this).toggleClass('rotate-388 rotate-0');
            });
        });
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
        <div class="card">
            <div class="center">
                <div class="bordered-div">
                    <h1 class="title">Gestion des Mouvements</h1>
                </div>
            </div>
            <div class="search-form " style="margin:10px;">
                <div class="search-form">
                    <div class="bordered-div ">
                        <form action="#" method="GET" style="display: flex; margin:10px;">
                            <span class="input-group-addon" style="width:70px;">DU :</span>
                            <input type="date" name="from_date" id="from_date" value='<?= htmlspecialchars($from_date, ENT_QUOTES, 'UTF-8') ?>' class="form-control" placeholder="From Date" style="width:150px;">
                            &nbsp;&nbsp;&nbsp;
                            <span class="input-group-addon" style="width:70px;">AU :</span>
                            <input type="date" name="to_date" id="to_date" value='<?= htmlspecialchars($to_date, ENT_QUOTES, 'UTF-8') ?>' class="form-control" placeholder="To Date" style="width:150px;">
                            &nbsp;&nbsp;&nbsp;
                            <button type="submit" class="btn btn-primary" name="btn_recherche">Rechercher</button>
                        </form>
                    </div>
                </div>
                <!-- Table with data -->
                <table id="mouvementTable">
                    <thead>
                        <tr>
                            <form method="POST" action="">
                                <th scope="col" class="T2" style="width: 90px;">
                                    <a href="/stocksortie/sortiestockud.php" name="datebtn" class="fa fa-play fa-2x rotate--270" aria-hidden="true"></a> &nbsp;Date
                                </th>
                                <th scope="col" class="T7" style="width: 110px;">
                                    <a href="/stocksortie/sortiestockudf.php" name="datebtn" class="fa fa-play fa-2x rotate--270" aria-hidden="true"></a> &nbsp;N°Facture
                                </th>
                                <th scope="col" class="T7" style="width: 300px;">
                                <a href="/stocksortie/sortiestockdda.php" name="datebtn" class="fa fa-play fa-2x rotate-388" aria-hidden="true"></a>&nbsp;Designation
                                </th>
                                <th scope="col" class="T4" style="width: 90px;">Quantité</th>
                                <th scope="col" class="T4" style="width: 90px;">
                                    Mouvement
                                </th>
                                <th scope="col" class="T4" style="width: 200px;">
                                <a href="/stocksortie/sortiestockudo.php" name="datebtn" class="fa fa-play fa-2x rotate--270" aria-hidden="true"></a> &nbsp;Operateur
                                </th>
                                <th scope="col" class="T4" style="width: 70px;">Action</th>
                                <th scope="col" class="T4" style="width: 30px;" hidden>ID</th>
                        </tr>
                        </form>
                    </thead>
                    <tbody id="table-body">
                        <?php
                        foreach ($servers as $server) :
                        ?>
                            <tr>
                                <td style="text-align: center; font-family: sans-serif; padding: 3px;"><?= $server["dates"]; ?></td>
                                <td style="text-align: center; font-family: sans-serif; padding: 3px;"><?= $server["nfacture"] ?></td>
                                <td style="text-align: center; font-family: sans-serif; padding: 3px;"><?= $server["designations"] ?></td>
                                <td style="text-align: center; font-family: sans-serif; padding: 3px;"><?= $server["quantites"] ?></td>
                                <td style="text-align: center; font-family: sans-serif; padding: 3px;"><?= $server["mouvements"] ?></td>
                                <td style="text-align: center; font-family: sans-serif; padding: 3px;"><?= $server["operateur"] ?></td>
                                <td style=" font-family: sans-serif ; text-align: center; padding: 3px; "><i class="fa fa-pencil fa-2x modifyBtns3" style="font-size:20px;"></i> </td>
                                <td style="text-align: center; font-family: sans-serif; padding: 3px;" hidden><?= $server["id"]; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <!-- More rows as needed -->
                </table>
                <!-- The Modal -->
                <div id="modal" class="modal">
                    <div class="modal-content" style="width: 700px;">
                        <h2>Ajouté en Stock<span class="close">&times;</span></h2>
                        <div class="">
                            .
                        </div>
                        <form id="modalForm" method="POST">
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">N° Facture:</span>
                                <input type="text" style="width:450px;" onkeydown="upperCaseFun(this)" class="form-control" id="nfacture" name="nfacture">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">Désignation:</span>
                                <input type="text" style="width:450px;" onkeydown="upperCaseFun(this)" class="form-control" id="designation" name="designation">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">Quantité:</span>
                                <input type="number" style="width:450px;" class="form-control" id="quantity" name="quantity">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">Type de Mouvement:</span>
                                <input type="text" style="width:450px;" class="form-control" id="movementType" name="movementType">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">Date de Mouvement:</span>
                                <input type="date" style="width:450px;" class="form-control" id="movementDate" name="movementDate">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">Operateur:</span>
                                <input type="text" style="width:450px;" onkeydown="upperCaseFun(this)" class="form-control" id="operateur" name="operateur">
                            </div>
                            <div class="modal-footer">
                                <?php
                                $tooltipText = "Enregistrer la rentrée";
                                echo '<button type="submit" id="validateBtn" name="validateBtn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:blue"></span> VALIDER </button>';
                                ?>
                                <?php
                                $tooltipText = "Annuler l'enregistrement";
                                echo '<a type="button" id="cancelBtn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:white"></span> ANNULER </a>';
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- The Second Modal -->
                <div id="modal1" class="modal">
                    <div class="modal-content" style="width: 700px;">
                        <h2>Modifier en Stock<span class="close">&times;</span></h2>
                        <div>.</div>
                        <form id="modalForm1" method="POST">
                            <!-- Form content -->
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">ID:</span>
                                <input type="text" readonly style="width:450px;" class="form-control" id="id1" name="id1">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">N° Facture:</span>
                                <input type="text" style="width:450px;" onkeydown="upperCaseFun(this)" class="form-control" id="nfacture1" name="nfacture1">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">Désignation:</span>
                                <input type="text" style="width:450px;" onkeydown="upperCaseFun(this)" class="form-control" id="designation1" name="designation1">
                            </div>

                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">Quantité:</span>
                                <input type="number" style="width:450px;" class="form-control" id="quantity1" name="quantity1">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">Type de Mouvement:</span>
                                <input type="text" style="width:450px;" class="form-control" id="movementType1" name="movementType1">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" style="width:170px;">Date de Mouvement:</span>
                                <input type="date" style="width:450px;" class="form-control" id="movementDate1" name="movementDate1">
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon" onkeydown="upperCaseFun(this)" style="width:170px;">Operateur:</span>
                                <input type="text" style="width:450px;" class="form-control" id="operateur1" name="operateur1">
                            </div>
                            <div class="modal-footer">
                                <?php
                                $tooltipText = "Enregistrer la rentrée";
                                echo '<button type="submit" id="validateBtn1" name="validateBtn1" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:blue"></span> VALIDER </button>';
                                ?>
                                <?php
                                $tooltipText = "Annuler l'enregistrement";
                                echo '<a type="button" id="cancelBtn1" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:white"></span> ANNULER </a>';
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
                <nav>
                    <ul class="pagination" style="padding-top: 10px;">
                        <li class="page-item <?= ($currentPage == 1) ? "disabled" : "" ?>">
                            <a href="/stock/sortiestocks.php?page=<?= $currentPage - 1 ?>" class="page-link">Précédente</a>
                        </li>
                        <?php for ($i = 1; $i <= $pages; $i++) : ?>
                            <li class="page-item <?= ($currentPage == $i) ? "active" : "" ?>">
                                <a href="/stock/sortiestocks.php?page=<?= $i ?>&typemtvs=<?= $typemtvs ?>&from_date=<?= $from_date ?>&to_date=<?= $to_date ?>" class="page-link"><?= $i ?></a>
                            </li>
                        <?php endfor ?>
                        <li class="page-item <?= ($currentPage == $pages) ? "disabled" : "" ?>">
                            <a href="/stock/sortiestocks.php?page=<?= $currentPage + 1 ?>&typemtvs=<?= $typemtvs ?>&from_date=<?= $from_date ?>&to_date=<?= $to_date ?>" class="page-link">Suivante</a>
                        </li>
                    </ul>
                </nav>
                <div class="modal-footer">
                    <?php
                    $tooltipText = "Ajouter une Entrée";
                    echo '<button type="button" id="createBtn" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="' . htmlspecialchars($tooltipText, ENT_QUOTES, 'UTF-8') . '"><span class="glyphicon glyphicon-plus" style="color:blue"></span> AJOUTER UNE ENTREE </button>';
                    ?>
                    <a href="/Accueil.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Accueil</a>
                </div>
            </div>
            <!-- jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <!-- Your Script -->
            <script>
                // Get the modals
                var modal = document.getElementById("modal");
                var modal1 = document.getElementById("modal1");

                // Get the buttons that open the modals
                var createBtn = document.getElementById("createBtn");
                var modifyBtns3 = document.getElementsByClassName("modifyBtns3");

                // Get the <span> elements that close the modals
                var spans = document.getElementsByClassName("close");

                // Get the cancel buttons
                var cancelBtn = document.getElementById("cancelBtn");
                var cancelBtn1 = document.getElementById("cancelBtn1");

                // When the user clicks the button, open the modal
                createBtn.onclick = function() {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                for (var i = 0; i < spans.length; i++) {
                    spans[i].onclick = function() {
                        modal.style.display = "none";
                        modal1.style.display = "none";
                    }
                }

                // When the user clicks the cancel button, close the modal
                cancelBtn.onclick = function() {
                    modal.style.display = "none";
                }
                cancelBtn1.onclick = function() {
                    modal1.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                    if (event.target == modal1) {
                        modal1.style.display = "none";
                    }
                }

                // jQuery for filling the modal with data from the table row
                $(document).ready(function() {
                    $('.modifyBtns3').on('click', function() {
                        // Get the current row
                        var currentRow = $(this).closest('tr');

                        // Get data from the row
                        var movementDate1 = currentRow.find('td:eq(0)').text();
                        var nfacture1 = currentRow.find('td:eq(1)').text();
                        var designation1 = currentRow.find('td:eq(2)').text();
                        var quantity1 = currentRow.find('td:eq(3)').text();
                        var movementType1 = currentRow.find('td:eq(4)').text();
                        var operateur1 = currentRow.find('td:eq(5)').text();
                        var id1 = currentRow.find('td:eq(7)').text();

                        // Fill the modal with the data
                        $('#designation1').val(designation1);
                        $('#nfacture1').val(nfacture1);
                        $('#quantity1').val(quantity1);
                        $('#movementType1').val(movementType1);
                        $('#movementDate1').val(movementDate1);
                        $('#operateur1').val(operateur1);
                        $('#id1').val(id1);

                        // Open the modal
                        modal1.style.display = "block";
                    });
                });
            </script>
            <script>
                function upperCaseFun(a) {
                    setTimeout(function() {
                        a.value = a.value.toUpperCase();
                    }, 1);
                }
            </script>

</body>

</html>