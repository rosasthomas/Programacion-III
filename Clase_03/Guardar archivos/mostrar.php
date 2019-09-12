<?php
    class Subir{
        public function validarTipo(){
            
            $upload = TRUE;
            $destino = "archivos/" . $_FILES["archivo"]["name"];
            if (file_exists($destino)) {
                echo "El archivo ya existe. Verifique!!!";
                $upload = FALSE;
            }

            if ($upload === FALSE) {

                echo "<br/>NO SE PUDO SUBIR EL ARCHIVO.";
            
            } else {
                if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $destino)) {
                    echo "Se ha sido subido exitosamente.";
                } 
                else {
                    echo "No se pudo subir el archivo.";
                }
            }
            return $destino;
        }        
    }  