ComboMatrices = Ext.extend(Ext.form.ComboBox, {

    constructor : function(config) {
      ComboMatrices.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Matriz',
        allowBlank: true, 
        width: 100, 
        xtype: 'combo',
        loadingText: recursosInter.buscando,
        typeAhead: false, 
        forceSelecion: true, 
        store: getDsMatrices(), 
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

Ext.reg('combomatrices', ComboMatrices);