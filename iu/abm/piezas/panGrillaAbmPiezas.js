  function generaGrillaAbmPiezas(){    

    var diseñoRegistro = new Ext.data.Record.create([
        {name: 'piezaId', type: 'string'},
        {name: 'piezaNombre', type: 'string'},
        {name: 'piezaFicha', type: 'string'},
        {name: 'piezaGenericaId', type: 'string'},
        {name: 'piezaGenericaNombre', type: 'string'},
        {name: 'tipoPataId', type: 'string'},
        {name: 'tipoPataNombre', type: 'string'},
        {name: 'atributos', type: 'string'}
    ]);
    
    var lectorJson = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        id: 'piezaId'},
        diseñoRegistro
    );
    
    var fuenteDeDatos = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/piezas.php/selecciona'
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
    
    var modeloDeColumnas = new Ext.grid.ColumnModel(
            [
              {header: '#', dataIndex: 'piezaId', width: 50, hidden: true, locked: true },
              {header: 'Nombre', dataIndex: 'piezaNombre', width: 360, sortable: true },
              {header: 'Género', dataIndex: 'piezaGenericaNombre', width: 180, sortable: true },
              {header: 'Tipo de pata', dataIndex: 'tipoPataNombre', width: 180, sortable: true }
            ]
        );
    
    var panGrilla = new Ext.grid.GridPanel({
    	region: 'center',
        id: 'grillaABMPiezas',
        store: modeloDeDatos,
        cm: modeloDeColumnas,
        enableColLock:false,
        bbar: barraPaginacion,
        selModel: new Ext.grid.RowSelectionModel({singleSelect:true}),
        
        tituloHijo : function (){
          var registro=this.obtieneSeleccionado();
          var titulo=registro.get('piezaNombre');
          return titulo;
        },
        
        obtieneSeleccionado : function() {
          var sm = this.getSelectionModel();
          if (sm.getSelected() != null) {
            return sm.getSelected();
          } else {
            return null;
          }
        }        
        
      }
      
    );
  
    return panGrilla;  
  }
  
