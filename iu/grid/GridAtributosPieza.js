/*   
var diseoRegistroxxx = new Ext.data.Record.create([
        {name: 'id', type: 'string'},
        {name: 'atributoId', type: 'string'},
        {name: 'atributoNombre', type: 'string'},
        {name: 'isNumerico', type: 'boolean'},
        {name: 'valor', type: 'string'}
    ]);
    
    var lectorJsonxxx = new Ext.data.JsonReader({
        root: 'data',
        totalProperty: 'total',
        idProperty: 'id'},
        diseoRegistroxxx
    );
    
    var fuenteDeDatosxxx = new Ext.data.HttpProxy({
    	url: '/produccion/svc/conector/piezas.php/selAtributosValor'
    });
    
    var modeloDeDatosxxx = new Ext.data.Store({
        proxy: fuenteDeDatosxxx,
        reader: lectorJsonxxx,
        autoDestroy: true,
        baseParams: {piezaId: 'c4a235622beb90d6204b68046ba6951f'}
    });  
    
    var storeComboAtributos = new Ext.data.ArrayStore({
        autoDestroy: true,
        idIndex: 0,  
          fields: [
             {name: 'atributoId', type: 'string'},
             {name: 'atributoNombre', type: 'string'},
          ],
        data:[
          ['48f52dbe1d04e44132c06c753c7f417b', 'Enchapado'],
          ['17fce7072cf309969a302cb271a00724', 'Presencia de Tacos'],
          ['ee8b7b1dd11ac129f99014fa1aede30c', 'Altura']
        ]
      });  
    
    var empCb = new Ext.form.ComboBox({
        typeAhead: true,
        mode: 'local',
        triggerAction: 'all',
        store: storeComboAtributos,
        displayField:'atributoNombre',
        valueField: 'atributoId'
      });  
    
    
    var modeloDeColumnasxxx = new Ext.grid.ColumnModel([
      {header: 'Atributo', width: 150, sortable: true, 
       dataIndex: 'atributoId', editor: new Ext.grid.GridEditor(empCb),
    	   renderer:function(value, p, record){
    	        return record.data['atributoNombre'];
    	   }
      },
      {header: 'Valor', dataIndex: 'valor', width: 150, sortable: false, 
    	   editor: {xtype: 'textfield'}
      },
    ]);    

    

    
  


    
    
    var editor = new Ext.ux.grid.RowEditor({
        saveText: 'Update'
    });


GridAtributosPieza=Ext.extend(Ext.grid.GridPanel, {
	piezaId : null,
	
	

    initComponent:function() {
	  this.initGrid();
	
      Ext.apply(this,{
        id: this.id,                           
        store: this.modeloDeDatosxxx,
        cm: modeloDeColumnasxxx, 
        
        tbar: [{
            iconCls: 'boton-agregar',
            text: 'Agregar atributo',
            handler: function(){
//                var e = new Employee({
//                    name: 'New Guy',
//                    email: 'new@exttest.com',
//                    start: (new Date()).clearTime(),
//                    salary: 50000,
//                    active: true
//                });
                editor.stopEditing();
                this.modeloDeDatosxxx.insert(0, [Ext.data.Record.create([{name: 'atributoId'}, {name: 'atributoNombre'}])] );
                this.getView().refresh();
                this.getSelectionModel().selectRow(0);
                editor.startEditing(0);
            }
        },{
//            ref: '../removeBtn',
            iconCls: 'boton-quitar',
            text: 'Quitar atributo',
            disabled: true,
            handler: function(){
//                editor.stopEditing();
//                var s = grid.getSelectionModel().getSelections();
//                for(var i = 0, r; r = s[i]; i++){
//                    store.remove(r);
//                }
            }
        }],
        
        
        
      });
	
      
      GridAtributosPieza.superclass.initComponent.apply(this);
    },
    
    setPiezaId : function(id){
    	this.piezaId=id;
    	this.modeloDeDatosxxx.load({params: { piezaId : id }});
    },

    initGrid: function(){
        
        this.modeloDeDatosxxx = new Ext.data.Store({
            proxy: fuenteDeDatosxxx,
            reader: lectorJsonxxx,
            autoDestroy: true
        }); 
       //this.modeloDeDatosxxx.load({params:{start:0, limit:50, piezaId: 'ca058a1ffdbf68b8db5cb7b1e7fd5898' }});
   }




});

Ext.reg('gridatributospieza', GridAtributosPieza);
*/

	