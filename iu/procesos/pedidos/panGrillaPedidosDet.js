 function generaGrillaPedidosDet(){

   var diseñoRegistro = new Ext.data.Record.create([
        {name: 'pedidoDetalleId', type: 'string', allowBlank: false},
        {name: 'pedidoCabeceraId', type: 'string', allowBlank: false},
        {name: 'interno', type: 'int', allowblank: false},
        {name: 'piezaId', type: 'string', allowBlank: false},
        {name: 'piezaNombre', type: 'string', allowBlank: false},
        {name : 'sinPatas', type : 'bool'},
        {name: 'pedidoDetalleCantidad', type: 'float', allowBlank: false},
        {name: 'remitidos', type: 'float', allowBlank: false},
        {name: 'pedidoDetallePrecio', type: 'float', allowBlank: false},
        {name: 'pedidoDetalleObservaciones', type: 'string', allowBlank: true},
        {name: 'terminacionId', type: 'string', allowBlank: false},
        {name: 'terminacionNombre', type: 'string', allowBlank: false}
    ]);

    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        idProperty: 'pedidoDetalleId'},
        diseñoRegistro
    );

    var escritorJson = new Ext.data.JsonWriter({
       encode: true,
       writeAllFields: true
    });

    var fuenteDeDatos = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/pedidosDetalle.php/selecciona'
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
      {header: 'id', dataIndex: 'pedidoDetalleId', hidden: true, sortable: false},
      {header: 'Artículo', dataIndex: 'piezaNombre', width: 250, sortable: true},
      {header: 'Pedidos', dataIndex: 'pedidoDetalleCantidad', width: 80, sortable: true, align: 'right'},
      {header: 'Remitidos', dataIndex: 'remitidos', width: 80, sortable: true, align: 'right'},
      new Ext.grid.CheckColumn({header: 'Sin Patas', dataIndex: 'sinPatas', width: 55}),
      {header: 'Precio', dataIndex: 'pedidoDetallePrecio', width: 80, sortable: true, align: 'right', renderer: Ext.util.Format.usMoney},
      {header: 'terminacionId', dataIndex: 'terminacionId', hidden : true},
      {header: 'Terminacion', dataIndex: 'terminacionNombre', width: 100, sortable: true},
      {header: 'Observaciones', dataIndex: 'pedidoDetalleObservaciones', width: 280, sortable: true}
    ]);

    var panGrilla = new Ext.grid.GridPanel({
    	region: 'center',
        id: 'grillaDetPedidos',
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        bbar: barraPaginacion,
        autoLoad: false,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
        height: 250
      }
    );

    return panGrilla;
 }

