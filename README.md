# ConsultaDatosMedicos

Este proyecto sirve para consultar datos de Resultados de Exámenes médicos desde una base de datos MongoDB en la nube, desde el servicio mLab.  

-Para usar este proyecto, simplemente ubicar la carpeta ReportesResultados en el servidor.  
-En el index.html de la carpeta se encuentra el formulario para enviar el ID del resultado que se desea consultar.  
-La consulta de datos a mLab se hace en el archivo generarPdf.php.  
-La generación del pdf también se hace en el archivo generarPdf.php mediante la clase PDF.  
  
Nota Importante.  
-Para utilizar mongoDb con PHP en Windows se debe descargar un archivo .dll desde http://pecl.php.net/package/mongodb  
-De esta página se debe descargar la versión que necesite que dependerá de la versión de PHP y de la arquitectura de su sistema operativo.  
-Una vez descargado el .zip, copiar el archivo php_mongodb.dll a la carpeta ext donde esté instalado su PHP.  
-En el archivo php.ini agregar la siguiente linea sin comillas "extension=mongodb".  
-Confirmar si la extension fue agregada exitosamente revisando PHPinfo y buscando el nombre de la extensión.  
