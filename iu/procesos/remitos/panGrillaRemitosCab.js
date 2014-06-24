 function generaGrillaRemitosCab(){

   var diseñoRegistro = new Ext.data.Record.create([
        {name: 'remitoCabeceraId', type: 'string'},
        {name: 'clienteId', type: 'string'},
        {name: 'clienteNombre', type: 'string'},
        {name: 'remitoFecha', type: 'date', dateFormat: 'Y-m-d H:i:s'},
        {name: 'remitoEstado', type: 'string'},
        {name: 'remitoNumero', type: 'int'},
        {name: 'observaciones', type: 'string'}
    ]);
    
    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        idProperty: 'remitoCabeceraId'},
        diseñoRegistro
    );
    
    var fuenteDeDatos = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/remitosCabecera.php/selecciona'
    });
    
    var modeloDeDatos = new Ext.data.Store({
        proxy: fuenteDeDatos,
        reader: lectorJson,
        autoDestroy: true,
        sortInfo: {
          field: 'remitoFecha',
          direction: 'DESC' 
        },
        remoteSort: true
    });    
    
    var barraPaginacion = new Ext.PagingToolbar({
        pageSize: 15, 
        store: modeloDeDatos,
        displayInfo: true
    });    
    
    var modeloDeColumnas = new Ext.grid.ColumnModel([
      {header: 'remitoCabeceraId', dataIndex: 'remitoCabeceraId', hidden: true},
      {header: 'Cliente', dataIndex: 'clienteNombre', width: 150, sortable: false},
      {header: 'Fecha', dataIndex: 'remitoFecha', width: 150, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
      {header: 'Número', dataIndex: 'remitoNumero', width: 150, sortable: true, align: 'right'},
      {header: 'Estado', dataIndex: 'remitoEstado', width: 90, sortable: false}
    ]);
    
    var panGrilla = new Ext.grid.GridPanel({
    	region: 'center', 
        id: 'grillaCabRemitos',
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        bbar: barraPaginacion,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
        height: 250,
        listeners: {render : function(){
    	    var store=this.getStore();
    	    store.on('load', function(){
    		  this.getSelectionModel().selectFirstRow();
    	    }, this);
    	   }
        },
        
        tituloHijo : function (){
          var registro=this.getSelectionModel().getSelected();
          var titulo=registro.get('clienteNombre') + ' - ' + Ext.util.Format.date(registro.get('remitoFecha'), 'd/m/Y');
          return titulo;
        }        
      
    });  
    
    return panGrilla;
 }
 
