<?php
function  get_pays($name, $value){

    return '

<select name="'.$name.'" style="width:350px;" class="form-control" id="'.$name.'" value="'.$value.'">
    <optgroup label="A">
        <option selected disabled>Choisir le Pays</option>
        <option value="AF"'.($value="AF"?"Selected":"").'>Afghanistan</option>
        <option value="ZA">Afrique du Sud</option>
        <option value="AL">Albanie</option>
        <option value="DZ">Algérie</option>
        <option value="DE">Allemagne</option>
        <option value="MK">Ancienne République yougoslave de Macédoine</option>
        <option value="AD">Andorre</option>
        <option value="AO">Angola</option>
        <option value="AI">Anguilla</option>
        <option value="AQ">Antarctique</option>
        <option value="AG">Antigua-et-Barbuda</option>
        <option value="AN">Antilles néerlandaises</option>
        <option value="SA">Arabie saoudite</option>
        <option value="AR">Argentine</option>
        <option value="AM">Arménie</option>
        <option value="AW">Aruba</option>
        <option value="AU">Australie</option>
        <option value="AT">Autriche</option>
        <option value="AZ">Azerbaïdjan</option>
    </optgroup>
    <optgroup label="B">
        <option value="BS">Bahamas</option>
        <option value="BH">Bahreïn</option>
        <option value="BD">Bangladesh</option>
        <option value="BB">Barbade</option>
        <option value="BE">Belgique</option>
        <option value="BZ">Belize</option>
        <option value="BJ">Bénin</option>
        <option value="BM">Bermudes</option>
        <option value="BT">Bhoutan</option>
        <option value="BY">Biélorussie</option>
        <option value="BO">Bolivie</option>
        <option value="BA">Bosnie-et-Herzégovine</option>
        <option value="BW">Botswana</option>
        <option value="BR">Brésil</option>
        <option value="BN">Brunei Darussalam</option>
        <option value="BG">Bulgarie</option>
        <option value="BF">Burkina Faso</option>
        <option value="BI">Burundi</option>
    </optgroup>
    <optgroup label="C">
        <option value="KH">Cambodge</option>
        <option value="CM">Cameroun</option>
        <option value="CA">Canada</option>
        <option value="CV">Cap-Vert</option>
        <option value="CL">Chili</option>
        <option value="CN">Chine</option>
        <option value="CY">Chypre</option>
        <option value="CO">Colombie</option>
        <option value="KM">Comores</option>
        <option value="CG">Congo</option>
        <option value="CR">Costa Rica</option>
        <option value="CI"'.($value="CI"?"selected":"").'>Cote d\'Ivoire</option>
        <option value="HR">Croatie</option>
        <option value="CU">Cuba</option>
    </optgroup>
    <optgroup label="D">
        <option value="DK">Danemark</option>
        <option value="DJ">Djibouti</option>
        <option value="DM">Dominique</option>
    </optgroup>
    <optgroup label="E">
        <option value="EG">Égypte</option>
        <option value="SV">El Salvador</option>
        <option value="AE">Émirats arabes unis</option>
        <option value="EC">Équateur</option>
        <option value="ER">Érythrée</option>
        <option value="ES">Espagne</option>
        <option value="EE">Estonie</option>
        <option value="FM">États fédérés de Micronésie</option>
        <option value="US">États-Unis</option>
        <option value="ET">Éthiopie</option>
    </optgroup>
    <optgroup label="F">
        <option value="FJ">Fidji</option>
        <option value="FI">Finlande</option>
        <option value="FR">France</option>
    </optgroup>
    <optgroup label="G">
        <option value="GA">Gabon</option>
        <option value="GM">Gambie</option>
        <option value="GE">Géorgie</option>
        <option value="GS">Géorgie du Sud-et-les Îles Sandwich du Sud</option>
        <option value="GH">Ghana</option>
        <option value="GI">Gibraltar</option>
        <option value="GR">Grèce</option>
        <option value="GD">Grenade</option>
        <option value="GL">Groenland</option>
        <option value="GP">Guadeloupe</option>
        <option value="GU">Guam</option>
        <option value="GT">Guatemala</option>
        <option value="GN">Guinée</option>
        <option value="GQ">Guinée équatoriale</option>
        <option value="GW">Guinée-Bissau</option>
        <option value="GY">Guyane</option>
        <option value="GF">Guyane française</option>
    </optgroup>
    <optgroup label="H">
        <option value="HT">Haïti</option>
        <option value="HN">Honduras</option>
        <option value="HK">Hong Kong</option>
        <option value="HU">Hongrie</option>
    </optgroup>
    <optgroup label="I">
        <option value="BV">Ile Bouvet</option>
        <option value="CX">Ile Christmas</option>
        <option value="NF">Île Norfolk</option>
        <option value="PN">Île Pitcairn</option>
        <option value="AX">Iles Aland</option>
        <option value="KY">Iles Cayman</option>
        <option value="CC">Iles Cocos (Keeling)</option>
        <option value="CK">Iles Cook</option>
        <option value="FO">Îles Féroé</option>
        <option value="HM">Îles Heard-et-MacDonald</option>
        <option value="FK">Îles Malouines</option>
        <option value="MP">Îles Mariannes du Nord</option>
        <option value="MH">Îles Marshall</option>
        <option value="UM">Îles mineures éloignées des États-Unis</option>
        <option value="SB">Îles Salomon</option>
        <option value="TC">Îles Turques-et-Caïques</option>
        <option value="VG">Îles Vierges britanniques</option>
        <option value="VI">Îles Vierges des États-Unis</option>
        <option value="IN">Inde</option>
        <option value="ID">Indonésie</option>
        <option value="IQ">Iraq</option>
        <option value="IE">Irlande</option>
        <option value="IS">Islande</option>
        <option value="IL">Israël</option>
        <option value="IT">Italie</option>
    </optgroup>
    <optgroup label="J">
        <option value="LY">Jamahiriya arabe libyenne</option>
        <option value="JM">Jamaïque</option>
        <option value="JP">Japon</option>
        <option value="JO">Jordanie</option>
    </optgroup>
    <optgroup label="K">
        <option value="KZ">Kazakhstan</option>
        <option value="KE">Kenya</option>
        <option value="KG">Kirghizistan</option>
        <option value="KI">Kiribati</option>
        <option value="KW">Koweït</option>
    </optgroup>
    <optgroup label="L">
        <option value="LS">Lesotho</option>
        <option value="LV">Lettonie</option>
        <option value="LB">Liban</option>
        <option value="LR">Libéria</option>
        <option value="LI">Liechtenstein</option>
        <option value="LT">Lituanie</option>
        <option value="LU">Luxembourg</option>
    </optgroup>
    <optgroup label="M">
        <option value="MO">Macao</option>
        <option value="MG">Madagascar</option>
        <option value="MY">Malaisie</option>
        <option value="MW">Malawi</option>
        <option value="MV">Maldives</option>
        <option value="ML">Mali</option>
        <option value="MT">Malte</option>
        <option value="MA">Maroc</option>
        <option value="MQ">Martinique</option>
        <option value="MU">Maurice</option>
        <option value="MR">Mauritanie</option>
        <option value="YT">Mayotte</option>
        <option value="MX">Mexique</option>
        <option value="MC">Monaco</option>
        <option value="MN">Mongolie</option>
        <option value="MS">Montserrat</option>
        <option value="MZ">Mozambique</option>
        <option value="MM">Myanmar</option>
    </optgroup>
    <optgroup label="N">
        <option value="NA">Namibie</option>
        <option value="NR">Nauru</option>
        <option value="NP">Népal</option>
        <option value="NI">Nicaragua</option>
        <option value="NE">Niger</option>
        <option value="NG">Nigéria</option>
        <option value="NU">Niué</option>
        <option value="NO">Norvège</option>
        <option value="NC">Nouvelle-Calédonie</option>
        <option value="NZ">Nouvelle-Zélande</option>
    </optgroup>
    <optgroup label="O">
        <option value="OM">Oman</option>
        <option value="UG">Ouganda</option>
        <option value="UZ">Ouzbékistan</option>
    </optgroup>
    <optgroup label="P">
        <option value="PK">Pakistan</option>
        <option value="PW">Palaos</option>
        <option value="PA">Panama</option>
        <option value="PG">Papouasie-Nouvelle-Guinée</option>
        <option value="PY">Paraguay</option>
        <option value="NL">Pays-Bas</option>
        <option value="PE">Pérou</option>
        <option value="PH">Philippines</option>
        <option value="PL">Pologne</option>
        <option value="PF">Polynésie française</option>
        <option value="PR">Porto Rico</option>
        <option value="PT">Portugal</option>
        <option value="TW">Province chinoise de Taiwan</option>
    </optgroup>
    <optgroup label="Q">
        <option value="QA">Qatar</option>
    </optgroup>
    <optgroup label="R">
        <option value="SY">République arabe syrienne</option>
        <option value="CF">République centrafricaine</option>
        <option value="KR">République de Corée</option>
        <option value="MD">République de Moldavie</option>
        <option value="CD">République démocratique du Congo</option>
        <option value="DO">République dominicaine</option>
        <option value="IR">République islamique d\'Iran</option>
        <option value="KP">République populaire démocratique de Corée</option>
        <option value="LA">République Populaire du Laos</option>
        <option value="CZ">République tchèque</option>
        <option value="TZ">République-Unie de Tanzanie</option>
        <option value="RE">Réunion</option>
        <option value="RO">Roumanie</option>
        <option value="GB">Royaume-Uni</option>
        <option value="RU">Russie</option>
        <option value="RW">Rwanda</option>
    </optgroup>
    <optgroup label="S">
        <option value="EH">Sahara occidental</option>
        <option value="KN">Saint-Christophe-et-Niévès</option>
        <option value="SM">Saint-Marin</option>
        <option value="PM">Saint-Pierre-et-Miquelon</option>
        <option value="VA">Saint-Siège (Cité du Vatican)</option>
        <option value="VC">Saint-Vincent-et-les Grenadines</option>
        <option value="SH">Sainte-Hélène</option>
        <option value="LC">Sainte-Lucie</option>
        <option value="WS">Samoa</option>
        <option value="AS">Samoa américaines</option>
        <option value="ST">Sao Tomé-et-Principe</option>
        <option value="SN">Sénégal</option>
        <option value="CS">Serbie-et-Monténégro</option>
        <option value="SC">Seychelles</option>
        <option value="SL">Sierra Leone</option>
        <option value="SG">Singapour</option>
        <option value="SK">Slovaquie</option>
        <option value="SI">Slovénie</option>
        <option value="SO">Somalie</option>
        <option value="SD">Soudan</option>
        <option value="LK">Sri Lanka</option>
        <option value="SE">Suède</option>
        <option value="CH">Suisse</option>
        <option value="SR">Suriname</option>
        <option value="SJ">Svalbard et Jan Mayen</option>
        <option value="SZ">Swaziland</option>
    </optgroup>
    <optgroup label="T">
        <option value="TJ">Tadjikistan</option>
        <option value="TD">Tchad</option>
        <option value="IO">Territoire britannique de l\'océan Indien</option>
        <option value="TF">Territoire Francais du Sud</option>
        <option value="PS">Territoires palestiniens occupés</option>
        <option value="TH">Thaïlande</option>
        <option value="TL">Timor oriental</option>
        <option value="TG">Togo</option>
        <option value="TK">Tokelau</option>
        <option value="TO">Tonga</option>
        <option value="TT">Trinité-et-Tobago</option>
        <option value="TN">Tunisie</option>
        <option value="TM">Turkménistan</option>
        <option value="TR">Turquie</option>
        <option value="TV">Tuvalu</option>
    </optgroup>
    <optgroup label="U">
        <option value="UA">Ukraine</option>
        <option value="UY">Uruguay</option>
    </optgroup>
    <optgroup label="V">
        <option value="VU">Vanuatu</option>
        <option value="VE">Vénézuéla</option>
        <option value="VN">Vietnam</option>
    </optgroup>
    <optgroup label="W">
        <option value="WF">Wallis-et-Futuna</option>
    </optgroup>
    <optgroup label="Y">
        <option value="YE">Yémen</option>
    </optgroup>
    <optgroup label="Z">
        <option value="ZM">Zambie</option>
        <option value="ZW">Zimbabwe</option>
    </optgroup>
</select>';
}
?>