ComboEnchapados = Ext.extend(Ext.form.ComboBox, {

    constructor : function(config) {
      ComboEnchapados.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Enchapado',
        allowBlank: true, 
        width: 300, 
        xtype: 'combo',
        loadingText: 'Cargando ...',
        typeAhead: false, 
        forceSelecion: true, 
        store: dsEnchapados, 
        displayField: 'nombre', 
        valueField: 'nombre',
        minListWidth: 150, 
        pageSize : 20, 
        hideTrigger: false, 
        lazyInit: false,
        triggerAction: 'all',        
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombre}</h4>", '</div></tpl>'),
        minChars: 1, 
        itemSelector: 'div.search-item'
    }, config));
  } //constructor
  
});

Ext.reg('comboenchapados', ComboEnchapados);