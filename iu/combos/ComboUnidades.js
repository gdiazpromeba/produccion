ComboUnidades = Ext.extend(Ext.form.ComboBox, {

    constructor : function(config) {
      ComboUnidades.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Unidad',
        allowBlank: true, 
        width: 300, 
        xtype: 'combo',
        loadingText: recursosInter.unidad,
        typeAhead: false, 
        forceSelecion: true, 
        store: dsUnidades, 
        displayField: 'nombre', 
        valueField: 'id',
        minListWidth: 150, 
        pageSize:15, 
        hideTrigger: true, 
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{texto}</h4>", '</div></tpl>'),
        minChars: 1, 
        itemSelector: 'div.search-item'
    }, config));
  } //constructor
  
});

Ext.reg('combounidades', ComboUnidades);