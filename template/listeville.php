<?php
function  get_ville($name, $value){

    return '

<select name="'.$name.'" style="width:350px;" class="form-control" id="'.$name.'">
    <option selected disabled>Choisissez la Ville</option>
    <option value="Abj"'.($value="Abj"?"Selected":"").'>Abidjan</option>
    <option value="Bke"'.($value="Bke"?"Selected":"").'>Bouake</option>
    <option value="Man">Man</option>
    <option value="Kor">Korhogo</option>
    <option value="Dal">Daloa</option>
    <option value="Bin">Bingerville</option>

</select>';
}