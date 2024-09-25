<?php
session_start();
require_once "../configs.php";

// Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
if (!isset($_SESSION["users"])) {
    header("Location: /Login.php");
} else {
}
?>;


!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="/img/Iconadc.jpg" />
    <title>L'Atelier du Chocolat</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&family=Montserrat:wght@100&family=Yellowtail&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

    <link rel="stylesheet" href="/css/Stylefournisseurs1.css" />


    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.0.1/morph/bootstrap.min.css">

    <script>
        function confirmer(id) {
            if (confirm("Voulez-vous supprimer cet article ?")) {
                location.href = "delete.php?id=" + id;
            }
        }
    </script>

    <style>
        table.basic-table td {
            height: 2em;
            background-color: white;
        }
    </style>

<body>
    <header class="nav1">
        <!-- Logo-->
        <p class="slogan" href="#">
            <img src="/img/LOGO%20ATELIER%20DE%20CHOCOLATAE.jpg" alt="logoAtelier" />
            <a>L'Atelier du Chocolat</a>
        </p>
    </header>


    <div class="container">
        <div style="height:50px;"></div>
        <div class="well">
            <center>
                <!--    <h2>Liste des Fournisseurs</h2>-->
                <h2>
                    COMMANDE VENTE</h2>
            </center>
            <div style="height:10px;"></div>

            <div id="jquery-script-menu">
                <div class="jquery-script-center">
                     <div id="carbon-block"></div>
                    <div class="jquery-script-ads">
                        <script type="text/javascript">
                            //<!--
                            google_ad_client = "ca-pub-2783044520727903";

                            google_ad_slot = "2780937993";
                            google_ad_width = 728;
                            google_ad_height = 90;
                            //-->
                        </script>
                        <script type="text/javascript" src="https://pagead2.googlesyndication.com/pagead/show_ads.js">
                        </script>
                    </div>
                    <div class="jquery-script-clear"></div>
                </div>
            </div>

            <div class="container" style="margin:150px auto">

                <table id="sample-table" class="basic-table table table-bordered table-striped">
                    <thead>
                        <thead>
                            <th scope="col" class="T1" style="width: 30px;">N°</th>
                            <th scope="col" class="T2" style="width: 100px;">Code</th>
                            <th scope="col" class="T3" style="width: 110px;">Designation</th>
                            <th scope="col" class="T4" style="width: 110px;">Quantité</th>
                            <th scope="col" class="T5" style="width: 60px;">Prix</th>
                            <th scope="col" class="T6" style="width: 50px;">Unité</th>
                            <th scope="col" class="T7" style="width: 60px;">Total</th>
                            <th scope="col" class="T8" style="width: 90px;">Actions</th>
                        </thead>
                    <tbody>

                    </tbody>
                </table>


                <div class="modal-footer">
                    <p class="my-3">
                        <a id="sample-table-add-button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Ajouter</a>
                    </p>
                    <a href="../Accueil.php" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> Quitter</a>
                </div>



            </div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script src="/js/table.js"></script>
            <script>
                let lightOrDark = function(color) {

                    // Vérifier le format de la couleur, HEX ou RVB ?
                    if (color.match(/^rgb/)) {

                        // Si HEX -> stocker les valeurs rouge, vert et bleu dans des variables séparées
                        color = color.match(/^rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*(\d+(?:\.\d+)?))?\)$/);

                        r = color[1];
                        g = color[2];
                        b = color[3];
                    } else {

                        // If RGB --> Convert it to HEX: http://gist.github.com/983661
                        color = +("0x" + color.slice(1).replace(
                            color.length < 5 && /./g, '$&$&'
                        ));

                        r = color >> 16;
                        g = color >> 8 & 255;
                        b = color & 255;
                    }

                    // HSP (Highly Sensitive Poo) equation from http://alienryderflex.com/hsp.html
                    hsp = Math.sqrt(
                        0.299 * (r * r) +
                        0.587 * (g * g) +
                        0.114 * (b * b)
                    );

                    // À l'aide de la valeur HSP, déterminez si la couleur est claire ou foncée
                    if (hsp > 127.5) {

                        return 'light';
                    } else {

                        return 'dark';
                    }
                }
                // Définir le style d'une cellule de tableau en fonction de la couleur
                let setCellColor = function(color, cell) {
                    // Définir la couleur d'arrière-plan
                    $(cell).css('background-color', color);

                    // Définir la couleur du texte
                    let lightOrDarkVal = lightOrDark(color);
                    if (lightOrDarkVal == 'light')
                        $(cell).css('color', 'black');
                    else
                        $(cell).css('color', 'white');
                };

                let tableConfig = {
                    columns: [
                        // Exemple de champ qui doit être unique
                        {
                            index: 0,
                            name: 'id',
                            removeRowIfCleared: true,
                            isValid: (newVal, data) => {
                                // Ensure the id number is unique
                                let allIds = data.map(p => p.id);
                                return !allIds.includes(newVal);
                            }
                        },

                        {
                            index: 1,
                            name: 'color',
                            classes: ['text-center'],
                            isValid: (val) => {
                                // Valider si code couleur hexadécimal
                                return /^#+([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/i.test(val);
                            },
                            afterAdd: function(addedColor, cell) {
                                setCellColor(addedColor, cell);

                                let newColorPicker = $(`<input type="color" value="${addedColor}">`);
                                newColorPicker.hide();
                                cell.parent().append(newColorPicker);
                                cell.on('click', function() {
                                    newColorPicker.click();
                                });
                                newColorPicker.on('change', function(e) {
                                    let newColorFromInput = e.target.value;
                                    setCellColor(newColorFromInput, cell);
                                    cell.text(newColorFromInput);
                                });
                            },
                            afterChange: function(newColor, cell) {
                                // Faites quelque chose avec la nouvelle valeur de couleur
                            },
                            convertOut: (outgoingVal) => {
                                // Convertir en int lors de la sortie des données
                                return outgoingVal.toUpperCase();
                            },
                        },
                        // Exemple de nombre validé comme un entier
                        {
                            index: 2,
                            name: 'number',
                            classes: ['text-end'],
                            isValid: (val) => {
                                val = parseInt(val);
                                return !isNaN(val) && Number.isInteger(val);
                            },
                            convertOut: (outgoingVal) => {
                                // Convertir en nombre
                                return Number(outgoingVal);
                            },
                        },
                        {
                            index: 3,
                            name: 'number',
                            classes: ['text-end'],
                            isValid: (val) => {
                                val = parseInt(val);
                                return !isNaN(val) && Number.isInteger(val);
                            },
                            convertOut: (outgoingVal) => {
                                // Convertir en nombre
                                return Number(outgoingVal);
                            },
                        },
                        {
                            index: 4,
                            name: 'number',
                            classes: ['text-end'],
                            isValid: (val) => {
                                val = parseInt(val);
                                return !isNaN(val) && Number.isInteger(val);
                            },
                            convertOut: (outgoingVal) => {
                                // Convertir en nombre
                                return Number(outgoingVal);
                            },
                        },
                        {
                            index: 5,
                            name: 'number',
                            classes: ['text-end'],
                            isValid: (val) => {
                                val = parseInt(val);
                                return !isNaN(val) && Number.isInteger(val);
                            },
                            convertOut: (outgoingVal) => {
                                // Convertir en nombre
                                return Number(outgoingVal);
                            },
                        },
                        {
                            index: 6,
                            name: 'number',
                            classes: ['text-end'],
                            isValid: (val) => {
                                val = parseInt(val);
                                return !isNaN(val) && Number.isInteger(val);
                            },
                            convertOut: (outgoingVal) => {
                                // Convertir en nombre
                                return Number(outgoingVal);
                            },
                        }
                    ],
                    actions: [{
                        label: '<button>Delete</button>',
                        action: (e, row) => {
                            // Supprimer la ligne du tableau
                            row.remove();
                        }
                    }, ]
                };

                let editablTableRef = $('#sample-table').editableTable(tableConfig);

                //Bouton Lier une nouvelle ligne
                $('#sample-table-add-button').click((e) => {
                    let currentData = editablTableRef.getData();
                    let maxId = Math.max(...currentData.map(p => parseInt(p.id)));
                    if (isNaN(maxId) || maxId === -Infinity) maxId = 0;
                    editablTableRef.addRow({
                        id: maxId + 1,
                        color: '#FFFFFF',
                        number: 0,
                        secretValue: 'secretNewwwww'
                    });
                });

                // Bouton Lier les données de vidage
                $('#sample-table-dump-button').click((e) => {
                    console.log(editablTableRef.getData());
                });

                // Ajouter les données initiales
                editablTableRef.setData([

                ]);
            </script>
            
            <script type="text/javascript">
                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-36251023-1']);
                _gaq.push(['_setDomainName', 'jqueryscript.net']);
                _gaq.push(['_trackPageview']);

                (function() {
                    var ga = document.createElement('script');
                    ga.type = 'text/javascript';
                    ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(ga, s);
                })();
            </script>
            <script>
                try {
                    fetch(new Request("https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js", {
                        method: 'HEAD',
                        mode: 'no-cors'
                    })).then(function(response) {
                        return true;
                    }).catch(function(e) {
                        var carbonScript = document.createElement("script");
                        carbonScript.src = "//cdn.carbonads.com/carbon.js?serve=CK7DKKQU&placement=wwwjqueryscriptnet";
                        carbonScript.id = "_carbonads_js";
                        document.getElementById("carbon-block").appendChild(carbonScript);
                    });
                } catch (error) {
                    console.log(error);
                }
            </script>
</body>

</html>