<?php
/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/
   include("../../templates/templateAutoevaluacion.php");
   $db =writeHeader("Preguntas",true,"Autoevaluacion");
   //print_r($_SESSION);
   /* include("./menu.php");
    writeMenu(0);*/
		$nombrecarrera="";
		$carrera = "";
		
       if($_REQUEST["cat_ins"]=="EDOCENTES"&&$_SESSION["codigofacultad"]!=1&&$_SESSION["codigofacultad"]!=156 ){
			$carrera = " AND p.codigocarrera = ".$_SESSION["codigofacultad"];
			$nombrecarrera = " - ".$_SESSION["nombrefacultad"];
	   } else if($_REQUEST["cat_ins"]=="EDOCENTES"&&($_SESSION["codigofacultad"]==1||$_SESSION["codigofacultad"]==156)){
			$nombrecarrera = " - ".$_SESSION["nombrefacultad"];
	   }
	    
    ?>
        <div id="container">
            <div class="full_width big">Preguntas</div>
            <h1>Administraci&oacute;n de Preguntas<?php echo $nombrecarrera; ?></h1>
            <div class="demo_jui">
                <div class="DTTT_container">
                <button id="ToolTables_example_0" class="DTTT_button DTTT_button_text">
                    <span>Nuevo</span>
                </button>
                <button id="ToolTables_example_1" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Editar</span>
                </button>
                <button id="ToolTables_example_2" class="DTTT_button DTTT_button_text DTTT_disabled">
                <span>Eliminar</span> 
                </button>
                </div>
                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                    <thead>
                        <tr>                            
                            <th>Titulo</th>
                            <th>Descripcion</th>
                            <th>Ayuda</th>
                            <th>Obligatoria</th>
                            <th>Categoria</th>
                            <th>Tipo de Pregunta</th>   
                        </tr>
                    </thead>
                    <tbody>                       
                    </tbody>
                </table>
            </div>
        </div>            
   <script type="text/javascript">
        var oTable;
        var aSelected = [];
        $(document).ready(function() {  
         var sql;
         sql="SELECT ";
         sql+='p.idsiq_Apregunta, p.titulo, p.descripcion, p.ayuda, p.obligatoria, p.categoriapregunta, ';
         sql+='tp.nombre as tipo_pregunta';
         sql+=' FROM siq_Apregunta p ';
         sql+='INNER JOIN  siq_Atipopregunta AS tp ON (p.idsiq_Atipopregunta=tp.idsiq_Atipopregunta)';
		 <?php if(isset($_REQUEST["cat_ins"])) { ?>
			sql+=' AND cat_ins = "<?php echo $_REQUEST["cat_ins"].'"'.$carrera; ?>';
		 <?php } ?>
         //alert(sql);
            oTable = $('#example').dataTable({         
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../../server_processing.php?active=true&table=siq_Apregunta&sql="+sql+"&wh=p.codigoestado&tableNickname=p&join=true",  
                "aoColumns": [
                { "sTitle": "Pregunta" },
                { "sTitle": "Descripción" },
                { "sTitle": "Ayuda" , "bVisible":false, "bSearchable": false },
                { "sTitle": "Obligatoria" , "bVisible":false, "bSearchable": false },
                { "sTitle": "Categoria" , "bVisible":false, "bSearchable": false },
                { "sTitle": "Tipo de Pregunta" }
                ], 
                "fnInitComplete": function() {
                            this.fnAdjustColumnSizing(true); 
                            var maxWidth = $('#container').width();  
                            this.width(maxWidth);
                        }
            });
            /* Click event handler */
           
             $('#example tbody tr').live('click', function () {
                var id = this.id;
                var index = jQuery.inArray(id, aSelected);
                 if ( $(this).hasClass('row_selected') && index === -1  ) {
                     aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
                   // alert(aSelected+' '+aSelected.length);
                    if (aSelected.length>1) aSelected.shift();
                   // alert(aSelected+' '+aSelected.length);
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                }
             } );
             $('#ToolTables_example_0').click( function () {  
                if(!$('#ToolTables_example_0').hasClass('DTTT_disabled'))
                {gotonuevo('pregunta.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>');  }
            } );
            
            $('#ToolTables_example_1').click( function () {  
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled'))
                {updateForm2('pregunta.php?cat_ins=<?php echo $_REQUEST["cat_ins"]; ?>'); }               
            } );
            $('#ToolTables_example_2').click( function () {  
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled'))
                {deleteForm("Apregunta");}                
            } );
            /*$('#ToolTables_example_3').click( function () {  
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled'))
                {deleteForm("aspecto");}                
            } );*/
      } );
        </script>
    
<?php    writeFooter();
        ?>  