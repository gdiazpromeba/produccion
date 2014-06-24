ComboClientes = Ext.extend(Ext.form.ComboBox, {

    constructor : function(config) {
      ComboClientes.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Cliente',
        allowBlank: true, 
        width: 300, 
        xtype: 'combo',
        loadingText: recursosInter.buscando,
        typeAhead: false, 
        forceSelecion: true, 
        store: getDsClientes(), 
        displayField: 'nombre', 
        valueField: 'id',
        minListWidth: 150, 
        pageSize:15, 
        hideTrigger: true, 
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombre}</h4>", '</div></tpl>'),
        minChars: 1, 
        itemSelector: 'div.search-item'
    }, config));
  } //constructor
  
});

Ext.reg('comboclientes', ComboClientes);