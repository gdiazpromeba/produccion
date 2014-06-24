ComboDepositos = Ext.extend(Ext.form.ComboBox, {

    constructor : function(config) {
      ComboDepositos.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Depósito',
        allowBlank: true, 
        width: 200, 
        xtype: 'combo',
        loadingText: 'Cargando ...',
        typeAhead: false, 
        forceSelecion: true, 
        store: dsDepositos, 
        displayField: 'nombre', 
        valueField: 'id',
        minListWidth: 150, 
        pageSize:15, 
        hideTrigger: false, 
        lazyInit: false,
        triggerAction: 'all',
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombre}</h4>", '</div></tpl>'),
        itemSelector: 'div.search-item',
        mode: 'remote',
        pageSize:0 //sin navegación por páginas
    }, config));
  } //constructor
  
});

Ext.reg('combodepositos', ComboDepositos);