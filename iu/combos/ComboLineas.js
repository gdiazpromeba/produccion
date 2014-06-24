ComboLineas = Ext.extend(Ext.form.ComboBox, {
  
    constructor : function(config) {
      ComboFichas.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Línea',
        allowBlank: true, 
        width: 300, 
        xtype: 'combo',
        loadingText: recursosInter.buscando,
        typeAhead: false, 
        forceSelecion: true, 
        store: getDsLineas(), 
        displayField: 'lineaDescripcion', 
        valueField: 'lineaId',
        minListWidth: 150, 
        pageSize:15, 
        hideTrigger: true, 
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{lineaDescripcion}</h4>", '</div></tpl>'),
        minChars: 1, 
        itemSelector: 'div.search-item'
    }, config));
  } //constructor
});

Ext.reg('combolineas', ComboLineas);