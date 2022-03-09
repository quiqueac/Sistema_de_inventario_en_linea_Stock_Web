<?php
class Media {
    public $infoImagen;
    public $nombreArchivo;
    public $tipoArchivo;
    public $pathTempArchivo;
    public $pathUsuario = SITE_ROOT.DS.'..'.DS.'cargas/usuarios';
    public $pathProductos = SITE_ROOT.DS.'..'.DS.'cargas/productos';
    public $fondoPath = SITE_ROOT.DS.'..'.DS.'cargas/fondos';
    public $logoPath = SITE_ROOT.DS.'..'.DS.'cargas/logo';

    public $errores = array();
    public $subir_errores = array(
      0 => 'No hay error, el archivo se subio con exito.',
      1 => 'El archivo subido excede la carga máxima en php.ini.',
      2 => 'EL archivo subido excede la carga máxima especificada en el formulario HTML.',
      3 => 'EL archivo fue parcialmente subido.',
      4 => 'Ningún archivo fue subido.',
      6 => 'Folder temporal pérdido.',
      7 => 'Fallo al escribir en el disco.',
      8 => 'Una extensión PHP detuvo la subida.'
    );
    public $subir_extensiones = array(
     'gif',
     'jpg',
     'jpeg',
     'png',
    );
    
    public function ext_archivo($nombreArchivo) {
        $ext = strtolower(substr( $nombreArchivo, strrpos( $nombreArchivo, '.' ) + 1 ) );
        if(in_array($ext, $this->subir_extensiones)) {
            return true;
        }
    }

    public function subir($file) {
        if(!$file || empty($file) || !is_array($file)):
            $this->errors[] = "Ningún archivo subido.";
            return false;
        elseif($file['error'] != 0):
            $this->errors[] = $this->upload_errors[$file['error']];
            return false;
        elseif(!$this->ext_archivo($file['name'])):
            $this->errors[] = 'Formato de archivo incorrecto. ';
            return false;
        else:
            $this->imageInfo = getimagesize($file['tmp_name']);
            $this->fileName  = basename($file['name']);
            $this->fileType  = $this->imageInfo['mime'];
            $this->fileTempPath = $file['tmp_name'];
            return true;
        endif;
    }

    public function proceso() {
        if(!empty($this->errors)):
            return false;
        elseif(empty($this->fileName) || empty($this->fileTempPath)):
            $this->errors[] = "La ubicación del archivo no esta disponible.";
            return false;
        elseif(!is_writable($this->productPath)):
            $this->errors[] = $this->productPath." Debe tener permisos de escritura!!!.";
            return false;
        elseif(file_exists($this->productPath."/".$this->fileName)):
            $this->errors[] = "El archivo {$this->fileName} realmente existe.";
            return false;
        else:
            return true;
        endif;
    }

    public function proceso_media() {
        if(!empty($this->errors)) {
            return false;
        }

        if(empty($this->fileName) || empty($this->fileTempPath)) {
            $this->errors[] = "La ubicación del archivo no se encuenta disponible.";
            return false;
        }

        if(!is_writable($this->pathProductos)) {
            $this->errors[] = $this->pathProductos." Debe tener permisos de escritura.";
            return false;
        }

        if(file_exists($this->pathProductos."/".$this->fileName)) {
            $this->errors[] = "El archivo {$this->fileName} realmente existe.";
            return false;
        }

        if(move_uploaded_file($this->fileTempPath,$this->pathProductos.'/'.$this->fileName)) {
            if($this->insertar_media()) {
              unset($this->fileTempPath);
              return true;
            }

        } else {
            $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
            return false;
        }
    }

    public function proceso_usuario($id) {
        if(!empty($this->errors)) {
            return false;
        }
        if(empty($this->fileName) || empty($this->fileTempPath)) {
            $this->errors[] = "La ubicación del archivo no estaba disponible.";
            return false;
        }
        if(!is_writable($this->pathUsuario)) {
            $this->errors[] = $this->pathUsuario." Debe tener permisos de escritura";
            return false;
        }
        if(!$id) {
            $this->errors[] = " ID de usuario ausente.";
            return false;
        }
        $ext = explode(".",$this->fileName);
        $new_name = randString(8).$id.'.' . end($ext);
        $this->fileName = $new_name;
        if($this->destruir_imagen_usuario($id)) {
            if(move_uploaded_file($this->fileTempPath,$this->pathUsuario.'/'.$this->fileName)) {
                if($this->actualizar_imagenUsuario($id)) {
                    unset($this->fileTempPath);
                    return true;
                }
            } else {
                $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
                return false;
            }
        }
    }
    
    public function process_fondo($id) {
        if(!empty($this->errors)) {
            return false;
        }

        if(empty($this->fileName) || empty($this->fileTempPath)) {
            $this->errors[] = "la ubicación del archivo no se encuenta disponible.";
            return false;
        }

        if(!is_writable($this->fondoPath)) {
            $this->errors[] = $this->fondoPath." debe tener permisos de escritura!!!.";
            return false;
        }

        if(move_uploaded_file($this->fileTempPath,$this->fondoPath.'/'.$this->fileName)) {
            if($this->insertar_fondo($id)) {
              unset($this->fileTempPath);
              return true;
            }

        } else {
            $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
            return false;
        }
    }
    
    public function proceso_logo() {
        if(!empty($this->errors)) {
            return false;
        }

        if(empty($this->fileName) || empty($this->fileTempPath)) {
            $this->errors[] = "la ubicación del archivo no se encuentra disponible.";
            return false;
        }

        if(!is_writable($this->logoPath)) {
            $this->errors[] = $this->logoPath." debe tener permisos de escritura!!!.";
            return false;
        }
        
        /*
        if(file_exists($this->logoPath."/".$this->fileName)) {
            $this->errors[] = "El archivo {$this->fileName} realmente existe.";
            return false;
        }
        */
        
        if(move_uploaded_file($this->fileTempPath,$this->logoPath.'/'.$this->fileName)) {
            if($this->insertar_logo()) {
              unset($this->fileTempPath);
              return true;
            }

        } else {
            $this->errors[] = "Error en la carga del archivo, posiblemente debido a permisos incorrectos en la carpeta de carga.";
            return false;
        }
    }
    
    private function insertar_logo() {
        $image = encontrar_por_id('empresa',1);
        unlink($this->logoPath.'/'.$image['logo']);
        global $db;
        $sql = "UPDATE empresa SET";
        $sql .=" logo='{$db->escape($this->fileName)}'";
        $sql .=" WHERE empresa.id=1";
        $resultado = $db->query($sql);
        return ($resultado && $db->affected_rows() === 1 ? true : false);
    }
    
    public function borrar_fondo($id) {
        $image = encontrar_por_id('usuarios',$id);
        unlink($this->fondoPath.'/'.$image['imagen_fondo']);
    }
    
    public function borrar_logo() {
        $image = encontrar_por_id('empresa',1);
        unlink($this->logoPath.'/'.$image['logo']);
    }
    
    public function borrar_imagen($id) {
        $image = encontrar_por_id('usuarios',$id);
        unlink($this->userPath.'/'.$image['imagen']);
    }
    
    private function insertar_fondo($id) {
        global $db;
        $sql = "UPDATE usuario SET";
        $sql .=" imagen_fondo='{$db->escape($this->fileName)}'";
        $sql .=" WHERE id='{$db->escape($id)}'";
        $resultado = $db->query($sql);
        return ($resultado && $db->affected_rows() === 1 ? true : false);
    }

    private function actualizar_imagenUsuario($id) {
        global $db;
        $sql = "UPDATE usuario SET";
        $sql .=" imagen='{$db->escape($this->fileName)}'";
        $sql .=" WHERE id='{$db->escape($id)}'";
        $resultado = $db->query($sql);
        return ($resultado && $db->affected_rows() === 1 ? true : false);
    }

    public function destruir_imagen_usuario($id) {
        $image = encontrar_por_id('usuarios',$id);
        if($image['image'] === 'no_image.jpg') {
            return true;
        } else {
            unlink($this->userPath.'/'.$image['image']);
            return true;
        }
     }

    private function insertar_media() {
        global $db;
        $sql  = "INSERT INTO media (nombre_archivo,tipo_archivo)";
        $sql .=" VALUES ";
        $sql .="(
                 '{$db->escape($this->fileName)}',
                 '{$db->escape($this->fileType)}'
                 )";
        return ($db->query($sql) ? true : false);
    }

    public function destruir_media($id,$file_name) {
        $this->fileName = $file_name;
        if(empty($this->fileName)) {
            $this->errors[] = "Falta el archivo de foto.";
            return false;
        }
        if(!$id) {
            $this->errors[] = "ID de foto ausente.";
            return false;
        }
        if(borrar_por_id('media',$id)) {
            unlink($this->pathProductos.'/'.$this->fileName);
            return true;
        } else {
            $this->error[] = "Se ha producido un error en la eliminación de fotografías.";
            return false;
        }
    }
}
