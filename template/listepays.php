<?php
function  get_pays($name, $value)
{

    return '

<select name="' . $name . '"  size="1" style="width:270px;" class="form-control" id="' . $name . '" value="' . $value . '">
        <option selected disabled>Choisir le Pays</option>

        <option value="AF"' . ($value = "AF" ? "Selected" : "") . '>Afghanistan</option>



 </select>';
}
?>

 
  
 
