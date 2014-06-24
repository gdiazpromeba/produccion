PantallaRemitosLaqueado = Ext.extend(Ext.Panel, {
  constructor : function(config) {


		PantallaRemitosLaqueado.superclass.constructor.call(this, Ext.apply({
        iconCls:'chart',
        title: 'Unidades pendientes, por línea',
        frame:true,
        layout:'border',
        items: [
          {xtype: 'busquedaremlaq', itemId: 'busquedaRemLaq', height: 200, layout: 'hbox', region: 'north'},
          new PanRemitosCabecera({region: 'center'}),
          {xtype: 'grillaremlaqdet', itemId: 'grillaRemLaqDet', id: 'grillaRemLaqDet', height: 130, layout: 'hbox', region: 'south'}
        ],

		}, config));




	} //constructor
});