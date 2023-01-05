var tabla;

function init()
{
	mostrarform(false);
	listar();

}



function mostrarform(flag)
{
	//limpiar();
	
}

	function cancelarform()
	{
		//limpiar();
		//mostrarform(false);
	}

	function listar()
	{
		tabla=$('#tbllistado').dataTable(
		{
			"aProcessing":true,
			"aServerSide":true,
			dom: 'Bfrtip',
			buttons: [
				'copyHtml5',
		            'excelHtml5'	
				
			],
			"ajax":
			{
				url: '../ajax/listacompromisos.php?op=listar',
				type: "get",
				dataType: "json",
				error: function(e){
					console.log(e.responseText);
				}
			},
			"dDestroy": true,
			"iDisplayLength":20,
			"order": [[11, "DESC"]]
		}).DataTable();
	}

	
init();