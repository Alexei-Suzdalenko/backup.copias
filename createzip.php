<?php

echo '<br> start <br>';


function convertFileToZip($fileName){
   $zip = new ZipArchive();
   $filePath = "copias/$fileName.zip";

   $zip->open( $filePath, ZIPARCHIVE::CREATE );
   $fileIsCreated = $zip->addFile("copias/$fileName.sql", "$fileName.sql");
   $zip->close();
   
   if($fileIsCreated){
      rename("copias/$fileName.zip", "copias/$fileName.php");
      unlink("copias/$fileName.sql");
   };
};



$files = scandir("copias");

foreach($files as $file) {
   $fileName =  basename($file);
   $arrayName = explode('.', $fileName);

   if(end($arrayName) == 'sql'){
      convertFileToZip(reset($arrayName));
      break;
   }
}

   
echo '<br> end <br>';
