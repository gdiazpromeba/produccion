 function generaGrillaRemitosDet(){

   var diseñoRegistro = new Ext.data.Record.create([
        {name: 'remitoDetalleId', type: 'string', allowBlank: false},
        {name: 'remitoCabeceraId', type: 'string', allowBlank: false},
        {name: 'pedidoNumero', type: 'int', allowBlank: false},
        {name: 'piezaId', type: 'string', allowBlank: false},
        {name: 'piezaNombre', type: 'string', allowBlank: false},
        {name: 'cantidad', type: 'float', allowBlank: false},
        {name: 'pedidoDetalleId', type: 'string', allowBlank: false}
    ]);
    
    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        idProperty: 'remitoDetalleId'},
        diseñoRegistro
    );
    
    var escritorJson = new Ext.data.JsonWriter({
       encode: true,
       writeAllFields: true
    });
    
    var fuenteDeDatos = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/remitosDetalle.php/selecciona'
    });  
    
    var modeloDeDatos = new Ext.data.Store({
        proxy: fuenteDeDatos,
        reader: lectorJson,
        autoDestroy: true
    });  
    
    var barraPaginacion = new Ext.PagingToolbar({
        pageSize: 15,
        store: modeloDeDatos,
        displayInfo: true
    });    
    
    var modeloDeColumnas = new Ext.grid.ColumnModel([
//    {header: 'id', dataIndex: 'remitoDetalleId', hidden: true, sortable: false},
      {header: 'Pedido', dataIndex: 'pedidoNumero', width: 50, hidden: false, sortable: false},
      {header: 'Artículo', dataIndex: 'piezaNombre', width: 350, sortable: true},
      {header: 'Cantidad', dataIndex: 'cantidad', width: 60, sortable: true, align: 'right'}
    ]);
    
    var panGrilla = new Ext.grid.GridPanel({
    	region: 'center',
        id: 'grillaDetRemitos',
        flex: 1,
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        bbar: barraPaginacion,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
        height: 250
      }
    );  
    
    return panGrilla;
 }
 
