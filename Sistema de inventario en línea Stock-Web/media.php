<?php
$titulo_pagina = 'Lista de imagenes';
require_once('incluye/cargar.php');
pagina_requiere_nivel(2);
$media_files = encontrar_todos('media');
if(isset($_POST['submit'])) {
    $foto = new Media();
    $foto->subir($_FILES['file_upload']);
    if($foto->proceso_media()){
        $sesion->mensaje('s','Imagen subida al servidor.');
        redirigir('media.php');
    } else{
        $sesion->mensaje('d',join($foto->errors));
        redirigir('media.php');
    }
}
include_once('disenos/cabecera.php'); 
?>
<div class='row'>
    <div class="col-md-12">
        <?php echo mostrar_mensaje($mensaje); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <span style="vertical-align:middle" class="glyphicon glyphicon-camera"></span>
                <span style="vertical-align:middle">Imagenes</span>
                <div class="pull-right">
                    <form class="form-inline" action="media.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group" style='padding-left:10px;padding-right:10px'>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <input type="file" name="file_upload" multiple="multiple" class="btn btn-primary btn-file btn-xs" required=""/>
                                </span>
                                <button style="padding-bottom:3px" type="submit" name="submit" class="btn btn-default btn-xs">Subir</button>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="vertical-align:middle;" class="text-center" style="width: 50px;">#</th>
                            <th style="vertical-align:middle;" class="text-center">Imagen</th>
                            <th style="vertical-align:middle;" class="text-center">Descripción</th>
                            <th style="vertical-align:middle;" class="text-center" style="width: 20%;">Tipo</th>
                            <th style="vertical-align:middle;" class="text-center" style="width: 50px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($media_files as $media_file): ?>
                        <?php if($media_file['nombre_archivo'] != "no_image.jpg"): ?>
                        <tr class="list-inline">
                            <td style="vertical-align:middle;" class="text-center"><?php echo contar_id();?></td>
                            <td class="text-center">
                                <img src="cargas/productos/<?php echo $media_file['nombre_archivo'];?>" class="img-thumbnail" />
                            </td>
                            <td style="vertical-align:middle;" class="text-center">
                                <?php echo $media_file['nombre_archivo'];?>
                            </td>
                            <td style="vertical-align:middle;" class="text-center">
                                <?php echo $media_file['tipo_archivo'];?>
                            </td>
                            <td style="vertical-align:middle;" class="text-center">
                                <a href="borrar_media.php?id=<?php echo (int) $media_file['id'];?>" class="btn btn-danger btn-xs"  title="Eliminar">
                                    <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php endforeach;?>
                </tbody>
            </div>
        </div>
    </div>
</div>
<?php include_once('disenos/pie.php'); 
