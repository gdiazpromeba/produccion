ComboEmpleados = Ext.extend(Ext.form.ComboBox, {

    constructor : function(config) {
      ComboEmpleados.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Empleado',
        allowBlank: true, 
        width: 300, 
        xtype: 'combo',
        loadingText: recursosInter.buscando,
        typeAhead: false, 
        forceSelecion: true, 
        store: getDsEmpleados(), 
        displayField: 'nombreCompleto', 
        valueField: 'id',
        minListWidth: 150, 
        pageSize:15, 
        hideTrigger: true, 
        tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombreCompleto}</h4>", '</div></tpl>'),
        minChars: 1, 
        itemSelector: 'div.search-item'
    }, config));
  } //constructor
  
});

Ext.reg('comboempleados', ComboEmpleados);