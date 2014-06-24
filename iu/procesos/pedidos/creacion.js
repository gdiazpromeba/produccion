function creaInterfazPanPedidos(){

  var formCabecera = generaPanFormPedidosCab();
  var busquedaCabecera = generaPanBusquedaPedidosCab();

  var panSuperiorCabecera =new Ext.Container({
      layout: 'border',
      region: 'north',
      height: 230,
      items: [formCabecera, busquedaCabecera]
  });

  var grillaCabecera = generaGrillaPedidosCab();

  var panelCabecera=new Ext.Panel({
	  title: 'Pedidos [Cabecera]',
	  frame: true,
      id: 'panPedidosCabecera',
      name: 'panPedidosCabecera',
//      height: 500,
      layout: 'border',
      items: [ panSuperiorCabecera, grillaCabecera]
    });


   var formDetalle= generaPanFormPedidosDet();
   var grillaDetalle = generaGrillaPedidosDet();
   /*
   var grillaRemitosRelacionados=new GrillaRemitosRelacionados({
     id: 'grillaRemitosRelacionados',
     region: 'east',
     frame: true,
     title: 'Remitos relacionados',
     width: 225
   });
   */

   var panelDetalle=new Ext.Panel({
     title: 'Pedidos [Detalle]',
     frame: true,
     id: 'panPedidosDetalle',
     name: 'panPedidosDetalle',
     layout: 'border',
     items: [ formDetalle, grillaDetalle]
   });

   var panelTodos=new PanelPedidosPlanos({
     title: 'Todos los items',
     id: 'pedidosPlanos'
   });

   //pagos
   var formPagos= new FormPagos({
	  region: 'north',
	  id: 'formPagos'
   });
   var grillaPagos = new GrillaPagos({
	   region: 'center',
	   id: 'grillaPagos'
   });

   var panelPagos=new Ext.Panel({
     title: '[Pagos]',
     frame: true,
     id: 'panPagos',
     name: 'panPagos',
     layout: 'border',
     items: [ formPagos, grillaPagos]
   });

   var panelGeneraRemitoLaqueador = new PanelGeneraRemitoLaqueador ({
	  title: 'Asigna laqueador',
	  frame: true,
	  id: 'panGeneraRemitoLaqueador',
   });


   var busquedaRemLaq=new BusquedaRemLaq();
   var pantallaRemitosLaqueado = new PantallaRemitosLaqueado ({
	  title: 'Remitos a laqueadores',
	  frame: true,
	  id: 'pantallaRemitosLaqueado',
   });


  var panelHojas=new Ext.TabPanel({
    id: 'panelPedidosSolapas',
    region: 'center',
    activeItem: 0,
    deferredRender : false,
    hideMode: 'offsets',
    items:[panelCabecera, panelDetalle, panelTodos, panelPagos, panelGeneraRemitoLaqueador, pantallaRemitosLaqueado]
  });


  return panelHojas;

}