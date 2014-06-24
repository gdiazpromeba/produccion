function getDsTiposPata(){

  var ds = new Ext.data.JsonStore({
	    url: '/produccion/svc/conector/tiposPata.php/selecciona',
	    root: 'data',
	    fields: ['id', 'nombre']
  });
  return ds;
}
