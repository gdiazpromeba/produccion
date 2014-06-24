ComboProcesos = Ext.extend(Ext.form.ComboBox, {

    constructor : function(config) {
	ComboProcesos.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Proceso',
        allowBlank: true, 
        width: 300, 
        xtype: 'combo',
        loadingText: recursosInter.piezaGenerica,
        typeAhead: false, 
        forceSelecion: true, 
        store: dsProcesos, 
        displayField: 'nombre', 
        valueField: 'id',
        minListWidth: 150, 
        pageSize:15, 
        hideTrigger: false, 
        lazyInit: false,
        triggerAction: 'all',
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombre}</h4>", '</div></tpl>'),
        itemSelector: 'div.search-item',
        mode: 'remote'
    }, config));
  } //constructor
  
});

Ext.reg('comboprocesos', ComboProcesos);