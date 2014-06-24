ComboTerminaciones = Ext.extend(Ext.form.ComboBox, {

    constructor : function(config) {
      ComboTerminaciones.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Terminación',
        allowBlank: true,
        width: 500,
        xtype: 'combo',
        loadingText: recursosInter.buscando,
        typeAhead: false,
        forceSelecion: true,
        store: getDsTerminaciones(),
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

Ext.reg('comboterminaciones', ComboTerminaciones);