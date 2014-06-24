ComboEstadosLaqueado = Ext.extend(Ext.form.ComboBox, {

    constructor : function(config) {
      ComboEstadosLaqueado.superclass.constructor.call(this, Ext.apply({
        fieldLabel: 'Est.laqueado',
        width: 110, 
        store: new Ext.data.SimpleStore({
            fields: ['descripcionEstado'],
            data: [["En taller"],["En laqueador"],["Laqueado"]]
          }), 
        displayField: 'descripcionEstado', 
        valueField: 'descripcionEstado',
        selectOnFocus: true, 
        mode: 'local', 
        typeAhead: false, 
        editable: true,
        triggerAction: 'all'
    }, config));
  } //constructor
  
});

Ext.reg('comboestadoslaqueado', ComboEstadosLaqueado);
