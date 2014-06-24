ComboTiposPata = Ext.extend(ComboFijo, {

    constructor : function(config) {
      ComboTiposPata.superclass.constructor.call(this, Ext.apply({
        pageSize: 0,
        fieldLabel: 'Patas',
        width: 280, 
        store: getDsTiposPata(),
        displayField: 'nombre', 
        valueField: 'id',
        minListWidth: 150, 
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombre}</h4>", '</div></tpl>')
    }, config));
  } //constructor
  
});

Ext.reg('combotipospata', ComboTiposPata);