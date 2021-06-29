<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
  include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Respuestas",true,"Autoevaluacion");
  $id_respuesta=$_REQUEST['idsiq_Apreguntarespuesta'];
  $id_pregunta=$_REQUEST['idsiq_Apregunta'];
  $veri=$_REQUEST['verificada'];
 // echo $tipo_pregunta.'xxx';
   if (!empty($id_pregunta)){
    $entity = new ManagerEntity("Apreguntarespuesta");
     $entity->sql_where = "idsiq_Apregunta =".$id_pregunta." and codigoestado='100' ";
    //$entity->debug = true;
    $data = $entity->getData();
    $data_aux =$data[0];
    //print_r($data);
       
   }

?>
<style>
  p { margin: 8px; font-size:16px; }
  .selected { color:blue; }
  .highlight { background:yellow; }
 </style>

<link rel="stylesheet" href="../../css/styleAutoevaluacion.css" />
 <form action="save.php" method="post" id="form_test">
<div id="container">   
		<div class="demo_jui">
                    <input type="hidden" name="idsiq_Apregunta" id="idsiq_Apregunta" value="<?php echo $id_pregunta ?>">
                    <input type="hidden" name="entity" id="entity" value="Apreguntarespuesta">
                    <input type="hidden" name="codigoestado" id="codigoestado" value="100" />
                     Valor Inicial <input type="text" name="texto_inicio" id="texto_inicio" value="<?php echo $data[0]['texto_inicio'] ?>" />
                      <input type="hidden" name="multiple_respuesta" id="multiple_respuesta" value="0" />
                      <input type="hidden" name="unica_respuesta" id="unica_respuesta" value="1" />
                      <input type="hidden" name="maximo_caracteres" id="maximo_caracteres" value="0" />
                      <input type="hidden" name="analisis" id="analisis" value="0" />
                      <input type="hidden" name="aparejamiento" id="aparejamiento" value="0" />
                      
                     
                      
                            <table align="center" width="80%" border="0">
                                    <thead>
                                            <tr>
                                                    <th>#</th>
                                                    <th>Valor</th>
                                                    <th width="22">&nbsp;</th>
                                            </tr>
                                    </thead>
                                    <tbody>
                                            <tr id="0"> 
                                                    <td width="10%" >
                                                        <input type="text" name="num[0]" id="num_0" style="width: 50px;border:0;text-align:right;cursor:default" value="1" readonly >
                                                        <input type="hidden" name="idsiq_Arespuesta1[0]" id="idsiq_Arespuesta1_0" style="width: 50px" value="<?php if(!empty($data[0]['idsiq_Apreguntarespuesta'])){ echo $data[0]['idsiq_Apreguntarespuesta']; } ?>" >
                                                        <input type="hidden" name="respuesta1[0]" id="respuesta1_0" style="width: 400px" value="<?php if(!empty($data[0]['respuesta'])){ echo $data[0]['respuesta']; } ?>" >
                                                    </td>
                                                    
                                                    <td><input type="text" name="valor1[0]" id="valor1_0" style="width: 400px" value="<?php echo $data[0]['valor'] ?>" ></td>
                                                    <td align="right"><input type="button" value="" class="button medium clsEliminarFilaL"></td>
                                            </tr>
                                            <?php
                                                $can=count($data)-1;
                                                //$can=count($data);
                                                //echo $can.'ok';
                                                   if ($can>=$i){
                                                     for($i=1;$i<=$can;$i++){
                                                        ?>
                                                            <tr id="<?php echo $i ?>"> 
                                                                    <td width="10%" >
                                                                        <input type="text" name="num[<?php echo $i ?>]" id="num_<?php echo $i ?>" style="width: 50px;border:0;text-align:right;cursor:default" value="<?php echo $i+1 ?>" readonly >
                                                                        <input type="hidden" name="idsiq_Arespuesta1[<?php echo $i ?>]" id="idsiq_Arespuesta1_<?php echo $i ?>" style="width: 50px" value="<?php if(!empty($data[$i]['idsiq_Apreguntarespuesta'])){ echo $data[$i]['idsiq_Apreguntarespuesta']; } ?>" >
                                                                        <input type="hidden" name="respuesta1[<?php echo $i ?>]" id="respuesta1_<?php echo $i ?>" style="width: 400px" value="<?php if(!empty($data[$i]['respuesta'])){ echo $data[$i]['respuesta']; } ?>" >
                                                                    </td>
                                                                    <td><input type="text" name="valor1[<?php echo $i ?>]" id="valor1_<?php echo $i ?>" style="width: 400px" value="<?php echo $data[$i]['valor']; ?>" ></td>
                                                                    <td align="right"><input type="button" value="" class="button medium clsEliminarFilaL"></td>
                                                            </tr>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                    </tbody>
                                    <tfoot>
                                            <tr>
                                                    <td colspan="4" align="right">
                                                            <input type="hidden" name="total" id="total" style="width: 50px" value="<?php if($can<=0){ echo "1"; }else{ echo $can+1; } ?>">
                                                            <input type="button" value="Agregar Respuesta" class="button medium clsAgregarFilaL">
                                                    </td>
                                            </tr>
                                    </tfoot>
                            </table>
		</div>
                Valor Final <input type="text" name="texto_final" id="texto_final" value="<?php echo $data[0]['texto_final'] ?>" />
    
	</div>
        <div class="demo">
            <?php
                if ($veri==2){
            ?>
                <button class="submit" type="submit">Guardar</button>
                <?php
                }
            ?>  
                <input type="reset" class="submit" value="Cancelar">
                
            </div>
 </form>
	<script type="text/javascript" src="../../js/jquery.min.js"></script>
        <script type="text/javascript" src="../../js/jquery.numeric.js"></script>
	<script>
            //var i=1;
            $(document).ready(function(){
                 // $("#valor1_0").numeric();
                  var i=parseInt($("#total").val());
                  //alert($("#total").val());
                    $(document).on('click','.clsAgregarFilaL',function(){
                            var strNueva_FilaL='<tr id="'+i+'">'+
                                    '<td width="10%"><input type="text" name="num['+i+']" id="num_'+i+'" style="width: 50px;border:0;text-align:right;cursor:default" value="'+(i+1)+'" readonly >\n\
                                   <input type="hidden" name="idsiq_Arespuesta1['+i+']" id="idsiq_Arespuesta1_'+i+'" style="width: 50px" ><input type="hidden" name="respuesta1['+i+']" id="respuesta1_'+i+'" style="width: 400px"></td>'+
                                    '<td><input type="text" name="valor1['+i+']" id="valor1_'+i+'" style="width: 400px"  ></td>'+
                                    '<td align="right"><input type="button" value="" class="button medium clsEliminarFilaL" ></td>'+
                            '</tr>';
                        //onkeypress=\'$("#valor1_'+i+'").numeric()\'
                             i=i+1;
                             $("#total").val(i);
                            var objTabla=$(this).parents().get(3);
                            $(objTabla).find('tbody').append(strNueva_FilaL);
                            if(!$(objTabla).find('tbody').is(':visible')){
                                    $(objTabla).find('caption').click();
                                    
                            }
                    });

                    $(document).on('click','.clsEliminarFilaL',function(){
                            
                            var objCuerpo=$(this).parents().get(2);
                                    if($(objCuerpo).find('tr').length==1){
                                            if(!confirm('Esta es el única fila de la lista ¿Desea eliminarla?')){
                                                    return;
                                            }
                                    }
                            var objFila=$(this).parents().get(1);
                            var $this = $(this);
                            var $tr = $this.closest('tr');
                            var idtr=$tr.attr('id');
                            $("#valor1_"+idtr).val('99');
                            $("#num_"+idtr).attr('readonly', 'readonly');
                            $("#respuesta1_"+idtr).attr('readonly', 'readonly');
                             $("#valor1_"+idtr).attr('readonly', 'readonly');
                            $(objFila).addClass("highlight");
                            

                            // alert($tr.attr('id'));
                                   //alert($(objCuerpo).find('tr').id())
                                   
                                    //$(objFila).remove();
                    });


            });
            
             $(':submit').click(function(event) {
                    var CantItems=parseInt($("#total").val());
                    j=0; jc=0;
                    z=0; zc=0;
                    for (var i=0;i<CantItems;i++){
                       //var value=$("#valor1_"+i).val();
                       var resp=$("#valor1_"+i).val();
                       if (resp!=''){
                            j++
                       }
                       
                    }
                   // alert(jc+'->'+zc+' val')
                    event.preventDefault();
                    var valido= validateForm("#form_test");
                    if(!$.trim($("#texto_inicio").val())){
                         alert("Debe tener un valor de inicio");
                         $("#texto_inicio").focus();
                         return false;
                    }else if(!$.trim($("#texto_final").val())){
                         alert("Debe tener un valor final");
                         $("#texto_final").focus();
                         return false;
                    }else if (j==0){
                       alert("Debe Tener minimo un valor");
                       return false;
                   }else{
                      sendForm();
                     // alert('Proceso realizado satisfactoriamente');
                   }
                });
                
                function sendForm(){
                     $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: 'process.php',
                        data: $('#form_test').serialize(),                
                        success:function(data){
                            if (data.success == true){
                                alert(data.message);
                                total=data.id;
                                //i=0;
                                $.each(total, function(key, value) { 
                                   $("#idsiq_Arespuesta1_"+key).val(value);
                                   //i=i+1;
                                   // alert(key + ': ' + value); 
                                });

                            }
                            else{                        
                                $('#msg-error').html('<p>' + data.message + '</p>');
                                $('#msg-error').addClass('msg-error');
                            }
                        },
                        error: function(data,error,errorThrown){alert(error + errorThrown);}
                    }); 
             }
        
    </script>
