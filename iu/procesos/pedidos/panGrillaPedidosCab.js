 function generaGrillaPedidosCab(){

   var diseñoRegistro = new Ext.data.Record.create([
        {name: 'pedidoCabeceraId', type: 'string'},
        {name: 'pedidoNumero', type: 'int'},
        {name: 'clienteId', type: 'string'},
        {name: 'clienteNombre', type: 'string'},
        {name: 'pedidoFecha', type: 'date', dateFormat: 'Y-m-d H:i:s'},
        {name: 'fechaPrometida', type: 'date', dateFormat: 'Y-m-d H:i:s'},
        {name: 'pedidoEstado', type: 'string'},
        {name: 'pedidoReferencia', type: 'string'}
    ]);

    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        idProperty: 'pedidoCabeceraId'},
        diseñoRegistro
    );

    var fuenteDeDatos = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/pedidosCabecera.php/selecciona'
    });

    var modeloDeDatos = new Ext.data.Store({
        proxy: fuenteDeDatos,
        reader: lectorJson,
        autoDestroy: true,
        sortInfo: {
          field: 'pedidoFecha',
          direction: 'ASC'
        },
        remoteSort: true,
        autoLoad: false
    });

    var barraPaginacion = new Ext.PagingToolbar({
        pageSize: 15,
        store: modeloDeDatos,
        displayInfo: true
    });

    var modeloDeColumnas = new Ext.grid.ColumnModel([
      {header: 'id', dataIndex: 'pedidoCabeceraId', hidden: true, sortable: false},
      {header: 'Número', dataIndex: 'pedidoNumero', width: 80, sortable: false},
      {header: 'Cliente', dataIndex: 'clienteNombre', width: 150, sortable: false},
      {header: 'Fecha', dataIndex: 'pedidoFecha', width: 150, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
      {header: 'Prometida', dataIndex: 'fechaPrometida', width: 150, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
      {header: 'Referencia / Contacto', dataIndex: 'pedidoReferencia', width: 150, sortable: false},
      {header: 'Estado', dataIndex: 'pedidoEstado', width: 90, sortable: false}
    ]);

    var panGrilla = new Ext.grid.GridPanel({
    	region: 'center',
        id: 'grillaCabPedidos',
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        bbar: barraPaginacion,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
        height: 250,

        tituloHijo : function (){
          var registro=this.getSelectionModel().getSelected();
          var titulo=registro.get('clienteNombre') + ' - ' + Ext.util.Format.date(registro.get('pedidoFecha'), 'd/m/Y');
          return titulo;
        }




    });

    return panGrilla;
 }

