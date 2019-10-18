<html>
<head>
<meta charset="UTF-8">
<title>Guardar imágenes</title>
</head>

<?php 
$total = 0;

    /*  NUMEROS DE LOS ERRORES
     *  1  El fichero seleccionado excede el tamaño máximo permitido en php.ini (podemos saber el tamaño máximo permitido usando la función ini_get(‘upload_max_filesize’)).
     *  2  El archivo subido excede la directiva MAX_FILE_SIZE, si se especificó en el formulario.
     *  3  El archivo subido fue sólo parcialmente cargado.
     *  4  No se ha subido ningún archivo.
     *  6  Falta el directorio de almacenamiento temporal.
     *  7  No se puede escribir el archivo (posible problema relacionado con los permisos de escritura).ç
     *  8  Una extensión PHP detuvo la subida del archivo.
     *   
     */

if(isset($_POST['enviar']) && $_POST['enviar'] == 'Enviar'){ 
	foreach ($_FILES["foto"]["error"] as $key => $error) { 
		$nombre_archivo = $_FILES["foto"]["name"][$key];   
		$tipo_archivo = $_FILES["foto"]["type"][$key];   
		$tamano_archivo = $_FILES["foto"]["size"][$key]; 
		$temp_archivo = $_FILES["foto"]["tmp_name"][$key];
		
		$total = $total + $tamano_archivo;
        
		if (!((strpos($tipo_archivo, "jpeg")) || strpos($tipo_archivo, "png")))  
		{   
		    echo "Error numero: ".$error,".-No ha seleccionado nada o error en extension de la imagen<br>"; 
		}else if(($tamano_archivo > 200000) || ($total > 300000)){
		    echo "Error numero: ".$error,".-Error en el tamaño del archivo o en el total<br>";
		    //No se publica la segunda foto en el caso de que el total sea > 300Kb, la primera si
		}else {   
    		$nom_img = $nombre_archivo;      
    		$directorio = '/home/alummo2019-20/imgusers'; // Direccion
    		if(file_exists($directorio . "/" . $nom_img)){
    		    echo "La foto <i>".$nom_img,"</i> ya existe en el directorio<br>";
    		}else{
        		if (move_uploaded_file($temp_archivo,$directorio . "/" . $nom_img))  
        		{  
     			echo "La foto <i>".$nom_img,"</i> se ha publicado correctamente<br>"; 
    			}
    		}
		}
	} // Fin Foreach 
} 
?> 
<body> 
    <form name="evento" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data"> 
    Inserta imagenes<br /> 
    	<input type="file" name="foto[]" size="50" /><br>
    	<input type="file" name="foto[]" size="50" /><br>
    	<input type="submit" name="enviar" value="Enviar" /> 
	</form>
</body>
</html>
