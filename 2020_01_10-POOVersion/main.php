<?php
require_once dirname(__DIR__).'/DHunterPOO/clases/Bruter.class.php';
require_once dirname(__DIR__).'/DHunterPOO/clases/BruterDirectory.class.php';
//require_once dirname(__DIR__).'/DHunterPOO/clases/Directory.class.php';
require_once dirname(__DIR__).'/DHunterPOO/clases/File.class.php';
require_once dirname(__DIR__).'/DHunterPOO/clases/Request.class.php';
require_once dirname(__DIR__).'/DHunterPOO/clases/Functions.class.php';
 ?>
 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
     <title>Hunting dirs...</title>
   </head>
   <body>
     <?php
        $list = file_get_contents('lista.txt');
        $directorios = explode("\n", $list);
        $rawReq = file_get_contents('php://input');
        $datos = Request::getRequest($rawReq);
        $opciones = $datos[0];
        $domains = $datos[1];
        $i = 0;
        foreach($domains as $domain)
        {
            if(!Functions::isWellTypedDomain($domain))
                $domains[$i] = $domain."/";
            $i++;
        }
        $urls = [];
        foreach ($domains as $domain)
        {
            foreach($directorios as $dir)
            {
                $urls[] = $domain.$dir;
            }
        }
        foreach($opciones as $opcion)
        {
            $bruterDir = new BruterDirectory($domains[0] , $urls);
            $dirs = array();
            if($opcion == "FuerzaBruta")
            {
                echo "<strong style='color:green;'>Starting  Brute Force </strong><br>";
                $dirs = $bruterDir -> doBruterDir();
            }
            elseif($opcion == "dic")
            {
                echo "<strong style='color:green;'><h1>Seeking dirs </strong></h1><br>";
                $dirs = $bruterDir -> doSearch();
            }
            //SHOWING RESULTS
            foreach($dirs as $dir)
            {
                echo "<strong style='color:green;'>[ * ]Directory found in </strong><a href='$dir'>$dir</a><br>";
            }
        }
      ?>
   </body>
 </html>
