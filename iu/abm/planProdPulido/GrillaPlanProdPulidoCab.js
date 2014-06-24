GrillaPlanProdPulidoCab = Ext.extend(Grilla, {
	constructor : function(config) {
	  GrillaPlanProdPulidoCab.superclass.constructor.call(this, Ext.apply({
	  store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/planProdPulidoCabecera.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'planProdPulidoCabId',
							fields : [
                {name : 'planProdPulidoCabId', type : 'string'},
                {name : 'planillaFecha', type : 'date', dateFormat: 'Y-m-d H:i:s'},
                {name : 'empleadoId', type : 'string'},
                {name : 'empleadoApellido', type : 'string'},
                {name : 'empleadoNombre', type : 'string'},
                {name : 'tarjetaNumero', type : 'string'},
                {name : 'observacionesCab', type : 'string'}
              ]
						}),
				autoDestroy : true
		}),
		columns : [
          {header : 'id', dataIndex : 'planProdPulidoCabId', hidden : true},
          {header : 'Fecha', dataIndex : 'planillaFecha', width : 90, sortable : true, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
          {header : 'Apellido', dataIndex : 'empleadoApellido', width : 100, sortable : true},
          {header : 'Nombre', dataIndex : 'empleadoNombre', width : 180, sortable : true}
        ],
		height : 250,
		id : 'grillaPlanProdPulidoCab',
      
        tituloHijo : function (){
          var registro=this.obtieneSeleccionado();
          var titulo=registro.get('empleadoApellido') + ', '  + registro.get('empleadoNombre') + ' ' + Ext.util.Format.date(registro.get('planillaFecha'), 'd/m/Y');
          return titulo;
        }

	  }, config));
	} //constructor
});
