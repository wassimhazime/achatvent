



<?php
echo "<h1><center>" . $title . "</center></h1>";

?>

<div class ="container">
    <div class="row">
      
        <div id="wform" class="cadre">
            <form  action="#"  method='POST'  enctype="multipart/form-data">
                <?php
                echo $form;
                ?>
                <div class="form-group">
                    <label for="ok"> AJOUTER </label>            <input type="submit" name="ajout_data" class="btn btn-primary btn-lg" >
                    <label for="reset"> VIDE </label>            <input type="reset" name="reset"  class="btn btn-success btn-lg"></div> 
            </form>
       
         </div>      
    </div>
</div>






