ComboBancos = Ext.extend(ComboFijo, {

    constructor : function(config) {
      ComboBancos.superclass.constructor.call(this, Ext.apply({
        pageSize: 0,
        fieldLabel: 'Banco',
        width: 280, 
        store: new Ext.data.JsonStore({
          url: '/produccion/svc/conector/bancos.php/selecciona',
          root: 'data',
          fields: ['bancoId', 'bancoNombre']
        }), 
        displayField: 'bancoNombre', 
        valueField: 'bancoId',
        minListWidth: 150, 
        editable: false,
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{bancoNombre}</h4>", '</div></tpl>')
    }, config));
  } //constructor
  
});

Ext.reg('combobancos', ComboBancos);