ComboFichas = Ext.extend(Ext.form.ComboBox, {
  
    constructor : function(config) {
      ComboFichas.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Ficha',
        allowBlank: true, 
        width: 500, 
        xtype: 'combo',
        loadingText: recursosInter.buscando,
        typeAhead: false, 
        forceSelecion: true, 
        store: getDsFichas(), 
        displayField: 'piezaFicha', 
        valueField: 'piezaFicha',
        minListWidth: 150, 
        pageSize:15, 
        hideTrigger: true, 
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{piezaFicha}</h4>", '</div></tpl>'),
        minChars: 1, 
        itemSelector: 'div.search-item'
    }, config));
  } //constructor
});

Ext.reg('combofichas', ComboFichas);