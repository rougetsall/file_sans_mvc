<?php


      $doc=$_POST["doc"];
       
        $ficher=$_POST["fiche"];
 
function list_dir($name) {
   $tab = array();
  
  $de = dir($name);

  if ($dir = opendir($name)) {
    while (false !== ($entry = $de->read())) {
       if (is_dir($name.'/'.$entry)) {
        array_push($tab,$entry);
       }
         
      }
      }
    
  return $tab;

}
function list_file($name) {
   $tab = array();
  
  $ds = dir($name);

  if ($dir = opendir($name)) {
    while (false !== ($entry = $ds->read())) {
       if (is_file($name.'/'.$entry)) {
        array_push($tab,$entry);
       }
         
      }
      }
    
 
 
  return $tab;
}
$_SESSION["dossie"]=$_POST['dossier'];
 
  if (isset($_POST['Créer'])) {
   $dossi=$_POST['doc'];
   $nom=$_POST['dossier'];
   $dossier = $dossi.'/'.$nom;
  
     if(mkdir($dossier, 0777, true)) {
       echo "dossier cree";
     }

    }


    if (isset($_POST['Enregistrer'])) {

       $fiche=$_POST['fichier'];
       $nom=$_SESSION["dossie"];
     if (strlen($nom)==0) {
     $dossier = $doc.'/'.$fiche;

     if(touch($dossier, 0777, true)) {
       echo "ficher cree";
     }

    }else{
     
       $dossier2 = $doc.'/'.$nom.'/'.$fiche;
    
         if(touch($dossier2, 0777, true)){
       echo "dossier et fiche  cree";
     }
     

    }


     }
     if (isset($_POST['suprime'])) {

    
   $supfiche=$_POST["efface"];

    unlink($supfiche) ;
   }
    if (isset($_POST['supdoc'])) {

    
   $supfiche=$_POST["efface"];

    rmdir($supfiche) ;
   }
    
     $sup=strlen($ficher)+1;
     $rest = substr($doc, 0, -$sup);

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>affiche</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>
<body>
  <section class="section">


  <div class="container">
    <h1 class="title"><?php echo $ficher ?></h1>
    <div class="columns">
      <div class="column">
        <table class="table is-fullwidth is-hoverable">
            <tr>
               <td><form method="POST" action="affiche.php">
                        <input type="hidden" name="doc" value=<?php echo "'".$rest."'"; ?>
                        <input type="hidden" name="fiche" value=<?php echo "'".$ficher."'"; ?>>
                        <button type="submit" class="fas fa-level-up-alt" style="border: 0; " name=<?php echo "'".$ficher."'"; ?>></button>
                        </form>
                </td>
              
              <td>Parent</td>
            </tr>
           
            
            
            <?php 
           
            
           $tab=list_dir($doc);
            $tabs=list_file($doc);
              
          foreach ($tab as $key => $value) {
              $docs=$doc."/".$value;
              $rov=$value;
            if ($value!="." && $value!="..") {
                                    
                  ?>
                      <tr>
                       <td><form method="POST" action="affiche.php">
                        <input type="hidden" name="doc" value=<?php echo "'".$docs."'"; ?>>
                        <input type="hidden" name="fiche" value=<?php echo "'". $rov."'"; ?>>
                        <button type="submit" class="fas fa-folder" style="border: 0; " name=<?php echo "'".$value."'"; ?>></button>
                        </form>
                      </td>
                         <td><?php echo " - ". $value."<br>\n"; ?></td>
                          <td>
                          <form method="POST">
                           <input type="hidden" name="efface" value=<?php echo "'".$docs."'"; ?>>
                          <input type="hidden" name="doc" value=<?php echo "'".$doc."'"; ?>>
                          <input type="hidden" name="fiche" value=<?php echo "'". $ficher."'"; ?>>
                       
                          <button name="supdoc" class="button is-light is-small" type="submit"><i class="fas fa-trash-alt"></i></button>
                          </form>
                      </td>
                       </tr>
                   
                 
                 <?php } }
                 foreach ($tabs as $key => $value) {
                      $fic=$doc."/".$value;
                  ?>
                     <tr>
                        <td><i class="fas fa-file"></i></td>
                        <td><?php echo $value."<br>\n";
                             ?></td>
                          <td>
                        <form method="POST">
                      <input type="hidden" name="efface" value=<?php echo "'".$fic."'"; ?>>
                     <input type="hidden" name="doc" value=<?php echo "'".$doc."'"; ?>>
                      <input type="hidden" name="fiche" value=<?php echo "'". $ficher."'"; ?>>
                       
                      <button name="suprime" class="button is-light is-small" type="submit"><i class="fas fa-trash-alt"></i></button>
                       </form>
                      </td>
              
                      </tr>
                      <?php } ?>
          </table>
        </div>
        <div class="column">
          <form method="POST" action="affiche.php">
            <div class="field">
              <label class="label">Nouveau dossier</label>
              <div class="control">
                <input type="hidden" name="doc" value=<?php echo "'".$doc."'"; ?>>
                <input type="hidden" name="fiche" value=<?php echo "'".$ficher."'"; ?>>
                      
                <input class="input" type="text" name="dossier" placeholder="Nom du dossier">
              </div>
            </div>
            <div class="field is-grouped">
              <div class="control">
                <input type='submit'class="button is-link" name="Créer" value="Créer">
              </div>
            </div>
          </form>
          <hr />
          <form method="POST">
            <div class="field">
              <label class="label">Nouveau fichier</label>
              <div class="control">
                <input type="hidden" name="doc" value=<?php echo "'".$doc."'"; ?>>
                <input type="hidden" name="fiche" value=<?php echo "'".$ficher."'"; ?>>
                  
                <input class="input" type="text" name="fichier" placeholder="Nom du fichier">
              </div>
            </div>
            <div class="field">
              <label class="label">Contenu</label>
              <div class="control">
                <textarea class="textarea" placeholder="Textarea"></textarea>
              </div>
            </div>
            <div class="field is-grouped">
              <div class="control">
              
                 <input type='submit'class="button is-link" name="Enregistrer" value="Enregistrer">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

      
</body>
</html>