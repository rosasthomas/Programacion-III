<?php
class Subir{
        public function validarTipo(){
            
            $upload = TRUE;
            $destino = "Archivos/" . $_FILES["imagen"]["name"];
            if (file_exists($destino)) {
                echo "El archivo ya existe.";
                $upload = FALSE;
            }

                if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $destino)) {
                    echo "Se ha sido subido exitosamente.";
                } 
                else {
                    echo "No se pudo subir el archivo.";
                }
            return $destino;
        }        
    }  