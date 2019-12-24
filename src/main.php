<?php
    require_once "funciones.php";
 ?>
<?php
  if(isset($_POST["enviar"]))
  {
    if(!empty($_POST["url"]) && !empty($_POST["option"]))
    {
      $file = "resultado.txt";
      $url = $_POST["url"];
      $opcion = $_POST["option"];
      if($opcion == "fuerzaBruta")
      {
          doBruteForceDir($url);
      }
      else
      {
          echo getDirectories($url);
      }
     }
   }
 ?>
