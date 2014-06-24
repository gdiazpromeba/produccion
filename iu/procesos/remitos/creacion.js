function creaInterfazPanRemitos(){
  
  var formCabecera = generaPanFormRemitosCab();
  var busquedaCabecera = generaPanBusquedaRemitosCab();
 
  var panSuperiorCabecera =new Ext.Container({
      layout: 'border',
      region: 'north',
      height: 270,
      items: [formCabecera, busquedaCabecera]
  }); 	

  var grillaCabecera = generaGrillaRemitosCab();
    
  var panelCabecera=new Ext.Panel({
	  title: 'Remitos [Cabecera]',
	  frame: true,
      id: 'panRemitosCabecera',
      name: 'panRemitosCabecera',
      layout: 'border',
      items: [ panSuperiorCabecera, grillaCabecera]
    });  
  

   var formDetalle= new RemitosDetalleForm();
   var grillaDetalle = generaGrillaRemitosDet();


   var panelDetalle=new Ext.Panel({
	     frame: true,
	     width: 400,
	     height: 500,
	     id: 'panRemitosDetalle',
	     name: 'panRemitosDetalle',
	     title: 'Remitos [Detalle]',
//	     height: 700,
	     layout: 'hbox',
	     layoutConfig: {
	    	    align : 'stretch',
	    	    pack  : 'start'
	     },
	     items: [ formDetalle, grillaDetalle]
   });  
   
  var panelHojas=new Ext.TabPanel({
    id: 'panelRemitosSolapas',
    region: 'center',
    activeItem: 0, 
    deferredRender : false, 
    hideMode: 'offsets',
    items:[panelCabecera, panelDetalle]
  });
  
  
  return panelHojas;

}