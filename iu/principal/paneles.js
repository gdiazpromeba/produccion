function creaPanRemitos(){
      var panelAbm=creaInterfazPanRemitos();
      quitaDePanel();
      muestraEnPanel(panelAbm);

    var grillaCabecera=Ext.getCmp('grillaCabRemitos');
    var formCabecera=Ext.getCmp('panFormRemitosCabecera');
    var busquedaCabecera=Ext.getCmp('busquedaRemitosCab');
    abmIza(grillaCabecera, formCabecera, busquedaCabecera);


    var grillaDetalle=Ext.getCmp('grillaDetRemitos');
    var formDetalle=Ext.getCmp('panFormRemitosDetalle');
    cabeceraDetalle(grillaDetalle, formDetalle, grillaCabecera);
    eventosAdicionalesRemitos(formCabecera, grillaCabecera, formDetalle);
}

function creaPanEstadisticasPrecios(){
	  var panelGraficoPrecios=new PanelGraficoPrecios();
	  quitaDePanel();
	  muestraEnPanel(panelGraficoPrecios);
	}

function creaPanEstadisticasFacturacion(){
  var panelGraficoFacturacion=new PanelGraficoFacturacion();
  quitaDePanel();
  muestraEnPanel(panelGraficoFacturacion);
}

function creaPanEstadisticasRemitido(){
	  var panelGraficoRemitido=new PanelGraficoRemitido();
	  quitaDePanel();
	  muestraEnPanel(panelGraficoRemitido);
	}

function creaPanRemitidos(){
	  var panelGraficoRemitido=new PanelGraficoRemitido();
	  quitaDePanel();
	  muestraEnPanel(panelGraficoRemitido);
	}

function creaPanFacturas() {

	//cabecera
	var panForm = new FormFacturasCab();
	var panBusqueda = new BusquedaFacturasCab({
      width: 400
	});
    var panSuperior = new Ext.Container({
		layout : 'border',
		region : 'north',
		height : 345,
		items : [panForm, panBusqueda]
	});
	var panGrilla = new GrillaFacturasCab();
	var panelAbm = new Ext.Panel({
		title: '[Cabecera]',
		id : 'panFacturas',
		name : 'panFacturas',
		layout : 'border',
		items : [panSuperior, panGrilla]
	});

	//detalle
	var formDet=new FormFacturasDet({
	    region: 'north',
	    height: 270
	});
	var grillaDet = new GrillaFacturasDet({
	      region:'center'
	});
	var panelDet=new Ext.Panel({
	         title: '[Detalle]',
	         id: 'facturasDetalle',
	         name: 'facturasDetalle',
	         height: 500,
	         layout: 'border',
	         items: [
	           formDet,
	           grillaDet
	         ]
	});

	var panelHojas=new Ext.TabPanel({
	    id: 'panelFacturas',
	    region: 'center',
	    activeItem: 0,
	    deferredRender : false,
	    items:[panelAbm, panelDet]
	});

	quitaDePanel();
	muestraEnPanel(panelHojas);

	abmIza(panGrilla, panForm, panBusqueda);
	cabeceraDetalle(grillaDet, formDet, panGrilla);
}



  function creaPanCostos(){
      var panel=new PanelCostos();
      quitaDePanel();
      muestraEnPanel(panel);
      //Ext.getCmp('arbolCostos').expandAll();
      //panelArbolCostos.expandAll();
  }

  function creaPanPedidoRapido(){
	 var panel=new PanelPedidoRapido();
	 quitaDePanel();
     muestraEnPanel(panel);
  }

  function creaPanPedidos(){
     var panelAbm=creaInterfazPanPedidos();
     quitaDePanel();
     muestraEnPanel(panelAbm);

    var grillaCabecera=Ext.getCmp('grillaCabPedidos');
    var formCabecera=Ext.getCmp('panFormPedidosCabecera');
    var busquedaCabecera=Ext.getCmp('busquedaPedidosCab');
    abmIza(grillaCabecera, formCabecera, busquedaCabecera);


    //detalle de pedidos
    var grillaDetalle=Ext.getCmp('grillaDetPedidos');
    var formDetalle=Ext.getCmp('panFormPedidosDetalle');
    cabeceraDetalle(grillaDetalle, formDetalle, grillaCabecera);

    //pagos
    var grillaPagos=Ext.getCmp('grillaPagos');
    var formPagos=Ext.getCmp('formPagos');
    cabeceraDetalleConPrefijo(grillaPagos, formPagos, grillaCabecera);


    eventosAdicionalesPedidos(formCabecera, grillaCabecera, formDetalle);
  }

  function creaPanCotizaciones(){
     //comunicaciones cabecera
    var panComCab=getPanFormAbmComunicaciones();
    var panBusquedaCom= getPanBusquedaComunicaciones();
    var panGrillaCom = new GrillaComunicacionesPreciosCabecera({
      id: 'grillaCabComPrecios',
      region:'center'
    });
    var panComSuperior=new Ext.Container({
        layout: 'border',
        region: 'north',
        height: 350,
        items: [panComCab, panBusquedaCom]
     });

     var panelComunicaciones=new Ext.Panel({
         title: 'Cotizaciones [Cabecera]',
         id: 'comunicacionesCabecera',
         name: 'comunicacionesCabecera',
         height: 550,
         layout: 'border',
         items: [
           panComSuperior,
           panGrillaCom
         ]
     });
     abmIza(panGrillaCom, panComCab, panBusquedaCom);


    var panComDet=getPanFormAbmComunicacionesDetalle();
    var panGrillaComDet = new GrillaComunicacionesPreciosDetalle({
      id: 'grillaDetComPrecios',
      region:'center'
    });
     var panelComunicacionesDet=new Ext.Panel({
         title: 'Cotizaciones [Detallle]',
         id: 'comunicacionesDetalle',
         name: 'comunicacionesDetalle',
         height: 500,
         layout: 'border',
         items: [
           panComDet,
           panGrillaComDet
         ]
     });
     cabeceraDetalle(panGrillaComDet, panComDet, panGrillaCom);


     var panelHojas=new Ext.TabPanel({
       id: 'panelListaDePrecios',
       region: 'center',
       activeItem: 0,
       deferredRender : false,
       items:[panelComunicaciones, panelComunicacionesDet]
     });

     quitaDePanel();
     muestraEnPanel(panelHojas);

  }

  function creaPanEfectivosActuales(){

    //precios efectivos
     var efectivos=new PanelPreciosEfectivos({
       title: 'Efectivos actuales',
       id: 'preciosEfectivosActuales'
     });

     quitaDePanel();
     muestraEnPanel(efectivos);
  }


  function creaPanAbmPrecios(){
    //alta de precios
    var panForm=getPanFormAbmPrecios();
    var panBusqueda= getPanBusquedaAbmPrecios();
    var panSuperior=new Ext.Container({
        layout: 'border',
        region: 'north',
        height: 200,
        items: [panForm, panBusqueda]
     });
     var panGrilla = generaGrillaAbmPrecios();
     var panelAbm=new Ext.Panel({
         title: 'Todos',
         id: 'panAbmPrecios',
         name: 'panAbmPrecios',
         height: 500,
         layout: 'border',
         items: [
           panSuperior,
           panGrilla
         ]
     });

     quitaDePanel();
     muestraEnPanel(panelAbm);
     abmIza(panGrilla, panForm, panBusqueda);
  }


function creaPanAbmProveedores() {
	var panForm = new FormProveedores();
	var panBusqueda = getPanBusquedaAbmProveedores();
	var panSuperior = new Ext.Container({
				layout : 'border',
				region : 'north',
				height : 300,
				items : [panForm, panBusqueda]
			});
	var panGrilla = generaGrillaAbmProveedores();
	var panelAbm = new Ext.Panel({
				id : 'panAbmProveedores',
				name : 'panAbmProveedores',
				height : 500,
				layout : 'border',
				items : [panSuperior, panGrilla]
			});
	quitaDePanel();
	muestraEnPanel(panelAbm);
	abmIza(panGrilla, panForm, panBusqueda);
}

function creaPanAbmClientes() {
	var panForm = new FormClientes();
	var panBusqueda = getPanBusquedaAbmClientes();
	var panSuperior = new Ext.Container({
				layout : 'border',
				region : 'north',
				height : 400,
				items : [panForm, panBusqueda]
			});
	var panGrilla = generaGrillaAbmClientes();
	var panelAbm = new Ext.Panel({
				id : 'panAbmClientes',
				name : 'panAbmClientes',
				layout : 'border',
				items : [panSuperior, panGrilla]
			});
	quitaDePanel();
	muestraEnPanel(panelAbm);
	abmIza(panGrilla, panForm, panBusqueda);
}

function creaPanAbmEmpleados() {

	var panForm = new FormEmpleados();
	var panBusqueda = new BusquedaEmpleados();
	var panSuperior = new Ext.Container({
				layout : 'border',
				region : 'north',
				height : 230,
				items : [panForm, panBusqueda]
			});
	var panGrilla = new GrillaEmpleados();
	var panelAbm = new Ext.Panel({
				id : 'panEmpleados',
				name : 'panEmpleados',
				layout : 'border',
				items : [panSuperior, panGrilla]
			});
	quitaDePanel();
    muestraEnPanel(panelAbm);
	abmIza(panGrilla, panForm, panBusqueda);
}


function creaPanAbmDatosReloj() {

	var panForm = new FormDatosReloj();
	var panBusqueda = new BusquedaDatosReloj();
	var panSuperior = new Ext.Container({
				layout : 'border',
				region : 'north',
				height : 230,
				items : [panForm, panBusqueda]
			});
	var panGrilla = new GrillaDatosReloj();
	var panelAbm = new Ext.Panel({
				id : 'panDatosReloj',
				name : 'panDatosReloj',
				layout : 'border',
				items : [panSuperior, panGrilla]
			});
	quitaDePanel();
    muestraEnPanel(panelAbm);
	abmIza(panGrilla, panForm, panBusqueda);
}



function creaPanAbmFichas() {
  var panForm = new FormFichas({
    region: 'center'
  });
  var panBusqueda = new BusquedaFichas({
    height: 120,
    region: 'north',
    labelWidth: 160
  });
  var panOeste = new Ext.Container({
        layout : 'border',
        region : 'west',
        width : 900,
        items : [panForm, panBusqueda]
      });
  var panGrilla = new GrillaFichas({
    region: 'center'
  });
  var panelAbm = new Ext.Panel({
        id : 'panAbmFichas',
        name : 'panAbmFichas',
        layout : 'border',
        items : [panOeste, panGrilla]
      });
  quitaDePanel();
  muestraEnPanel(panelAbm);
  abmIza(panGrilla, panForm, panBusqueda);
}

function creaPanAbmLineas() {
  var form = new FormLineas();
  var busqueda = new BusquedaLineas();
  var panSuperior = new Ext.Container({
        layout : 'border',
        region : 'north',
        height : 270,
        items : [form, busqueda]
      });
  var grilla = new GrillaLineas();
  var panelAbm = new Ext.Panel({
    title: 'LÃ­neas de productos',
    id : 'panAbmLineas',
    name : 'panAbmLineas',
    height : 500,
    layout : 'border',
    items : [panSuperior, grilla]
  });

  //detalle
  var formDet=new FormFichasPorLinea({
    region: 'north'
  });
  var grillaDet = new GrillaFichasPorLinea({
      region:'center'
  });
  var panelDet=new Ext.Panel({
         title: 'Fichas comprendidas',
         id: 'fichasPorLinea',
         name: 'fichasPorLinea',
         height: 500,
         layout: 'border',
         items: [
           formDet,
           grillaDet
         ]
  });

  var panelHojas=new Ext.TabPanel({
    id: 'panelLineas',
    region: 'center',
    activeItem: 0,
    deferredRender : false,
    items:[panelAbm, panelDet]
  });

  quitaDePanel();
  muestraEnPanel(panelHojas);

  abmIza(grilla, form, busqueda);
  cabeceraDetalle(grillaDet, formDet, grilla);

}



function creaPanAbmPiezas() {

  //panel cabecera de piezas
  var panFormCab = getPanFormAbmPiezas();
  var panBusqueda = getPanBusquedaAbmPiezas();
  var panSuperiorCab = new Ext.Container({
        layout : 'border',
        region : 'north',
        height : 280,
        items : [panFormCab, panBusqueda]
      });
  var panGrillaCab = generaGrillaAbmPiezas();
  var panAbmCab = new Ext.Panel({
        title : recursosInter.articulos,
        id : 'panAbmPiezas',
        name : 'panAbmPiezas',
        region : 'center',
        height : 500,
        layout : 'border',
        items : [panSuperiorCab, panGrillaCab]
      });


  //chapasPorPieza
  var formChXPie=new FormChapasPorPieza({
    id: 'formChapasPorPieza',
    name: 'formChapasPorPieza',
    region: 'north'
  });


  var grillaChXPie = new GrillaChapasPorPieza({
      id: 'grillaChXPie',
      name: 'grillaChXPie',
      region:'center'
  });

  var panelChXPie=new Ext.Panel({
         title: 'Chapas',
         id: 'panChapasPorPieza',
         name: 'panChapas',
         height: 500,
         layout: 'border',
         region: 'center',
         items: [
           formChXPie,
           grillaChXPie
         ]
  });

  var panelHojas=new Ext.TabPanel({
    id: 'panePiezas',
    region: 'center',
    activeItem: 0,
    deferredRender : false,
    items:[panAbmCab, panelChXPie]
  });

  quitaDePanel();
  muestraEnPanel(panelHojas);

  abmIza(panGrillaCab, panFormCab, panBusqueda);
  cabeceraDetalle(grillaChXPie, formChXPie, panGrillaCab);

}

function creaPanAbmUsuarios() {
	var panForm = getPanFormAbmUsuarios();
	var panBusqueda = getPanBusquedaAbmUsuarios();
	var panSuperior = new Ext.Container({
				layout : 'border',
				region : 'north',
				height : 200,
				items : [panForm, panBusqueda]
			});
	var panGrilla = generaGrillaAbmUsuarios();
	var panelAbm = new Ext.Panel({
				id : 'panAbmUsuarios',
				name : 'panAbmUsuarios',
				height : 500,
				layout : 'border',
				items : [panSuperior, panGrilla]
			});
	quitaDePanel();
	muestraEnPanel(panelAbm);
	abmIza(panGrilla, panForm, panBusqueda);
}

function creaPanAbmMateriales() {
	var panFormMat = new FormAbmMateriales({
		region: 'center'
	});
	var panBusquedaMat = getPanBusquedaAbmMateriales();
	var panSuperiorMat = new Ext.Container({
				layout : 'border',
				region : 'north',
				height : 200,
				items : [panFormMat, panBusquedaMat]
			});
	var panGrillaMat = new GrillaMateriales({
		region: 'center'
	});
	var panelAbmMat = new Ext.Panel({
		        title: 'Materiales',
				id : 'panAbmMateriales',
				name : 'panAbmMateriales',
				height : 500,
				layout : 'border',
				items : [panSuperiorMat, panGrillaMat]
			});



	  //detalle
	  var formDet=new FormPreciosPorMaterial({
		height : 200,
	    region: 'north'
	  });
	  var grillaDet = new GrillaPreciosPorMaterial({
	      region:'center'
	  });

	  var panelDet=new Ext.Panel({
	         title: 'Precios por material',
	         name: 'panPreciosPorMaterial',
	         height: 500,
	         layout: 'border',
	         items: [
	           formDet,
	           grillaDet
	         ]
	  });

	  var panelHojas=new Ext.TabPanel({
	    activeItem: 0,
	    id: 'panelMateriales',
	    region: 'center',
	    items:[panelAbmMat, panelDet]
	  });
	  quitaDePanel();
	  muestraEnPanel(panelHojas);
	  abmIza(panGrillaMat, panFormMat, panBusquedaMat);
	  cabeceraDetalle(grillaDet, formDet, panGrillaMat);
}

/*
function creaPendientesPorLinea(){
  var ppl=new PendientesPorLinea();
  quitaDePanel();
  muestraEnPanel(ppl);
}
*/

function creaTiposPataPendientes(){
	  var ppl=new TiposPataPendientes();
	  quitaDePanel();
	  muestraEnPanel(ppl);
	}

function creaSeñasYPendientes(){
  var ppl=new SeñasYPendientes();
  quitaDePanel();
  muestraEnPanel(ppl);
}

function creaPanEstadisticas(){
  var panelGraficoMontos=new PanelGraficoMontos();
  var mejoresFichasEnMonto=new MejoresFichasEnMonto();
  var mejoresFichasEnUnidades=new MejoresFichasEnUnidades();
  var mejoresClientesEnMonto=new MejoresClientesEnMonto();

  var panelHojas=new Ext.TabPanel({
    activeItem: 0,
    id: 'panelEstadisticas',
    region: 'center',
    items:[panelGraficoMontos, mejoresFichasEnMonto,
    mejoresFichasEnUnidades, mejoresClientesEnMonto]
  });
  quitaDePanel();
  muestraEnPanel(panelHojas);
}

function creaCambioDeClave() {
  var cambioDeClave = new CambioClave();
  quitaDePanel();
  muestraEnPanel(cambioDeClave);
}

function creaPanMatrices() {
  //cabecera
  var form=new FormMatrices();
  var grilla=new GrillaMatrices();
  var busqueda=new BusquedaMatrices();
  var panSuperior = new Ext.Container({
        layout : 'border',
        region : 'north',
        height : 250,
        items : [busqueda, form]
  });

  var panelAbm = new Ext.Panel({
        id : 'panAbmMatrices',
        name : 'panAbmMatrices',
        title: 'Matrices [Cabecera]',
        layout : 'border',
        items : [panSuperior, grilla]
  });


  //detalle
  var formDet=new FormLineasPorMatriz({
    region: 'north'
  });
  var grillaDet = new GrillaLineasPorMatriz({
      region:'center'
  });
  var panelDet=new Ext.Panel({
         title: 'Líneas de la matriz',
         id: 'lineasPorMatriz',
         name: 'lineasPorMatriz',
         height: 500,
         layout: 'border',
         items: [
           formDet,
           grillaDet
         ]
  });

  var panelHojas=new Ext.TabPanel({
    activeItem: 0,
    id: 'panelMatrices',
    region: 'center',
    items:[panelAbm, panelDet]
  });
  quitaDePanel();
  muestraEnPanel(panelHojas);
  abmIza(grilla, form, busqueda);
  cabeceraDetalle(grillaDet, formDet, grilla);
}

function creaPanOrdenesTerminacion() {
  //cabecera
  var form=new FormOrdenesTerminacionCab();
  var grilla=new GrillaOrdenesTerminacionCab();
  var busqueda=new BusquedaOrdenesTerminacionCab();
  var panSuperior = new Ext.Container({
        layout : 'border',
        region : 'north',
        height : 250,
        items : [busqueda, form]
  });

  var panelAbm = new Ext.Panel({
        id : 'panAbmOrdenesTerminacionCab',
        name : 'panAbmOrdenesTerminacionCab',
        title: recursosInter.ordenes_terminacion_cabecera,
        layout : 'border',
        items : [panSuperior, grilla]
  });


  //detalle
  var formDet=new FormOrdenesTerminacionDet({
    region: 'north'
  });
  var grillaDet = new GrillaOrdenesTerminacionDet({
      region:'center'
  });
  var panelDet=new Ext.Panel({
         title: '[Detalle]',
         id: 'ordenesTerminacionDetalle',
         name: 'ordenesTerminacionDetalle',
         height: 500,
         layout: 'border',
         items: [
           formDet,
           grillaDet
         ]
  });

  var panelHojas=new Ext.TabPanel({
    id: 'panelOrdenesTerminacion',
    region: 'center',
    activeItem: 0,
    deferredRender : false,
    items:[panelAbm, panelDet]
  });

  quitaDePanel();
  muestraEnPanel(panelHojas);

  abmIza(grilla, form, busqueda);
  cabeceraDetalle(grillaDet, formDet, grilla);
}


function creaPanOrdenesProduccion() {
  //cabecera
  var form=new FormOrdenesProduccionCab();
  var grilla=new GrillaOrdenesProduccionCab({
    region: 'center'
  });
  var busqueda=new BusquedaOrdenesProduccionCab();
  var panSuperior = new Ext.Container({
        layout : 'border',
        region : 'north',
        height : 250,
        items : [busqueda, form]
  });

  var panelAbm = new Ext.Panel({
        id : 'panAbmOrdenesProduccionCab',
        name : 'panAbmOrdenesProduccionCab',
        title: recursosInter.produccion_prensa_cabecera,
        layout : 'border',
        items : [panSuperior, grilla]
  });


  //detalle
  var formDet=new FormOrdenesProduccionDet({
    region: 'north'
  });
  var grillaDet = new GrillaOrdenesProduccionDet({
      region:'center'
  });
  var panelDet=new Ext.Panel({
         title: recursosInter.detalle_corchetes,
         id: 'ordenesProduccionDetalle',
         name: 'ordenesProduccionDetalle',
         height: 500,
         layout: 'border',
         items: [
           formDet,
           grillaDet
         ]
  });

  var panelHojas=new Ext.TabPanel({
    id: 'panelOrdenesProduccion',
    region: 'center',
    activeItem: 0,
    deferredRender : false,
    items:[panelAbm, panelDet]
  });

  quitaDePanel();
  muestraEnPanel(panelHojas);

  abmIza(grilla, form, busqueda);
  cabeceraDetalle(grillaDet, formDet, grilla);
}

function creaPanPlanillasProduccion() {
  //cabecera
  var form=new FormPlanillasProduccionCab();
  var grilla=new GrillaPlanillasProduccionCab();
  var busqueda=new BusquedaPlanillasProduccionCab({
    width: 400,
    labelWidth: 120
  });
  var panSuperior = new Ext.Container({
        layout : 'border',
        region : 'north',
        height : 250,
        items : [busqueda, form]
  });

  var panelAbm = new Ext.Panel({
        id : 'panAbmPlanProdCab',
        name : 'panAbmPlanProdCab',
        title: recursosInter.produccion_prensa_cabecera,
        layout : 'border',
        items : [panSuperior, grilla]
  });


  //detalle
  var formDet=new FormPlanillasProduccionDet({
    region: 'north',
    height: 300
  });
  var grillaDet = new GrillaPlanillasProduccionDet({
      region:'center'
  });
  var panelDet=new Ext.Panel({
         title: '[Detalle]',
         id: 'panPlanProdDet',
         name: 'panPlanProdDet',
//         height: 500,
         layout: 'border',
         items: [
           formDet,
           grillaDet
         ]
  });

  var panelPlanas=new PanelPlanProdPrensaPlanas({
     title: 'Todos los items',
     id: 'pedidosPlanos'
   });

  var panelHojas=new Ext.TabPanel({
    activeItem: 0,
    id: 'panelPlanillasProduccion',
    region: 'center',
    items:[panelAbm, panelDet, panelPlanas]
  });

  quitaDePanel();
  muestraEnPanel(panelHojas);
  abmIza(grilla, form, busqueda);
  cabeceraDetalle(grillaDet, formDet, grilla);
}


function creaPanPlanProdPulido() {
	// cabecera
	var form = new FormPlanProdPulidoCab();
	var grilla = new GrillaPlanProdPulidoCab();
	var busqueda = new BusquedaPlanProdPulidoCab({
				width : 400,
				labelWidth : 120
			});
	var panSuperior = new Ext.Container({
				layout : 'border',
				region : 'north',
				height : 250,
				items : [busqueda, form]
			});

	var panelAbm = new Ext.Panel({
				id : 'panPlanProdPulidoCab',
				name : 'panPlanProdPulidoCab',
				title : recursosInter.produccion_pulido_cabecera,
				layout : 'border',
				items : [panSuperior, grilla]
			});

	// detalle
	var formDet = new FormPlanProdPulidoDet({
				region : 'north',
				height : 310
			});
	var grillaDet = new GrillaPlanProdPulidoDet({
				region : 'center'
			});
	var panelDet = new Ext.Panel({
				title : '[Detalle]',
				id : 'panPlanProdPulidoDet',
				name : 'panPlanProdPulidoDet',
				// height: 500,
				layout : 'border',
				items : [formDet, grillaDet]
			});

	var panelHojas = new Ext.TabPanel({
				activeItem : 0,
				id : 'panPlanProdPulido',
				region : 'center',
				items : [panelAbm, panelDet]
			});
	quitaDePanel();
	muestraEnPanel(panelHojas);
	abmIza(grilla, form, busqueda);
	cabeceraDetalle(grillaDet, formDet, grilla);
}



function creaPlanProdChap() {
  // cabecera
  var form=new FormPlanProdChapCab();
  var grilla=new GrillaPlanProdChapCab();
  var busqueda=new BusquedaPlanProdChap({
    width: 400,
    labelWidth: 120
  });
  var panSuperior = new Ext.Container({
        layout : 'border',
        region : 'north',
        height : 250,
        items : [busqueda, form]
  });

  var panelAbm = new Ext.Panel({
        id : 'panPlanProdChapa',
        name : 'panPlanProdChapa',
        title: recursosInter.produccion_chapa_cabecera,
        layout : 'border',
        items : [panSuperior, grilla]
  });


  //detalle
  var formDet=new FormPlanProdChapDet({
    region: 'north',
    height: 220
  });
  var grillaDet = new GrillaPlanProdChapDet({
      region:'center'
  });
  var panelDet=new Ext.Panel({
         title: '[Detalle]',
         id: 'panPlanProdChapDet',
         name: 'panPlanProdChapDet',
         height: 500,
         layout: 'border',
         items: [
           formDet,
           grillaDet
         ]
  });

  var panelHojas=new Ext.TabPanel({
    activeItem: 0,
    id: 'panelPlanillasChapa',
    region: 'center',
    items:[panelAbm, panelDet]
  });
  quitaDePanel();
  muestraEnPanel(panelHojas);
  abmIza(grilla, form, busqueda);
  cabeceraDetalle(grillaDet, formDet, grilla);
}

function creaPanelBancos() {
	var panel=new PanelBancos();
	quitaDePanel();
    muestraEnPanel(panel);
}



