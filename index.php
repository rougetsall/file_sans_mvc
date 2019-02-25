<?php

session_start();
function list_dir($name) {
	 $tab = array();
  
  $d = dir($name);

  if ($dir = opendir($name)) {
    while (false !== ($entry = $d->read())) {
       if (is_dir($name.'/'.$entry)) {
        array_push($tab,$entry);
       }
         
      }
      }
    
  return $tab;

}
function list_file($name) {
   $tab = array();
  
  $d = dir($name);

  if ($dir = opendir($name)) {
    while (false !== ($entry = $d->read())) {
       if (is_file($name.'/'.$entry)) {
        array_push($tab,$entry);
       }
         
      }
      }
  
 
 
  return $tab;
}

  $_SESSION["dossier"]=$_POST['dossier'];
 
  
  if (isset($_POST['Créer'])) {
   
   $nom=$_POST['dossier'];
   $dossier = '../storage'.'/'.$nom.'/';

     if(mkdir($dossier, 0777, true)) {
       echo "dossier cree";
     }

    }


    if (isset($_POST['Enregistrer'])) {
       $fiche=$_POST['fichier'];
       $messager=$_POST['messager'];
       $nom=$_SESSION["dossier"];
     if (strlen($nom)==0) {
     $dossier = '/storage'.'/'.$fiche;

     if(touch($dossier, 0777, true)) {
       echo "ficher cree";
       $file = fopen($dossier,"w");
     echo fprintf($file,$messager);
   
     }

    }else{
     
       $dossier2 = '/storage'.'/'.$nom.'/'.$fiche;
    
         if(touch($dossier2, 0777, true)){
          $file = fopen($dossier2,"w");
     echo fprintf($file,$messager);
       echo "dossier et fiche  cree";
     }
     

    }


     }
     if (isset($_POST['Créer'])) {
   
   $nom=$_POST['dossier'];
   $dossier = '/storage'.'/'.$nom.'/';

     if(mkdir($dossier, 0777, true)) {
       echo "dossier cree";
     }

    }
   if (isset($_POST['suprime'])) {

    
   $supfiche=$_POST["doc"];

    unlink($supfiche) ;
   }
    if (isset($_POST['supdoc'])) {

    
   $supfiche=$_POST["doc"];

    rmdir($supfiche) ;
   }
     

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Filer</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.2/css/bulma.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>
<body>
  <section class="section">


  <div class="container">
    <h1 class="title">Mon filer</h1>
    <div class="columns">
      <div class="column">
        <table class="table is-fullwidth is-hoverable">
         
            <?php 
           
            $doc="../storage";
            $tab=list_dir($doc);
            $tabs=list_file($doc);
              
	        foreach ($tab as $key => $value) {
              
                $docs=$doc."/".$value;
                if ($value!="." && $value!="..") {
                                    
                  ?>
                      <tr>
                       <td><form method="POST" action="affiche.php">
                        <input type="hidden" name="doc" value=<?php echo "'".$docs."'"; ?>>
                        <input type="hidden" name="fiche" value=<?php echo "'".$value."'"; ?>>
                        <button type="submit" class="fas fa-folder" style="border: 0; " name=<?php echo "'".$value."'"; ?>></button>
                        </form>
                      </td>
                         <td><?php echo " - ". $value."<br>\n"; ?></td>
                         <td>
                        <form method="POST">
                           <input type="hidden" name="doc" value=<?php echo "'".$docs."'"; ?>>
                         
                          <button name="supdoc" class="button is-light is-small" type="submit"><i class="fas fa-trash-alt"></i></button>
                        </form>
                      </td>
                       </tr>
                   
                 
                 <?php } }
                 foreach ($tabs as $key => $value) {
                    $fic=$doc."/".$value;
                  ?>
                     <tr>
                        <td><a href="<?php echo $fic ; ?>"><i class="fas fa-file"> </i></a></td>
                        <td><?php echo $value."<br>\n";
                             ?></td>
                         <td>
                <form method="POST">
                   <input type="hidden" name="doc" value=<?php echo "'".$fic."'"; ?>>
                 
                  <button name="suprime" class="button is-light is-small" type="submit"><i class="fas fa-trash-alt"></i></button>
                </form>
              </td>
              
                      </tr>
                      <?php } ?>
          </table>
        </div>
        <div class="column">
          <form method="POST">
            <div class="field">
              <label class="label">Nouveau dossier</label>
              <div class="control">
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
                <input class="input" type="text" name="fichier" placeholder="Nom du fichier">
              </div>
            </div>
            <div class="field">
              <label class="label">Contenu</label>
              <div class="control">
                <textarea name="messager" class="textarea" placeholder="Textarea"></textarea>
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