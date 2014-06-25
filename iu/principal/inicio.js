

Ext.state.Manager.setProvider(new Ext.state.CookieProvider({
  expires: new Date(new Date().getTime()+(1000*60*60*24*30)) //30 days
}));





/**

 * el panel del área de la derecha, que contiene las distintas pantallas operativas

 */

var panelCentral= new Ext.Container({
  id: 'panelCentral',
  name: 'panelCentral',
  region: 'center',
  layout: 'fit',
  margins: '5 5 5 0',
  cls:'empty',
  bodyStyle:'background:#f1f1f1'
});



var dirIconos='/produccion/recursos/iconos/';



/**

 * variable que almacena el último panel mostrado en el panel central

 */

var idUltimoPanel=null;



function quitaDePanel(){
    if (idUltimoPanel!=null){
        var up=panelCentral.findById(idUltimoPanel);
        if (up!=null){
          panelCentral.doLayout();
          panelCentral.remove(idUltimoPanel, true);
        }
        idUltimoPanel=null;
    }
}



function muestraEnPanel(componente){
  var el=componente.getEl();
  if (el!=null){
    el.setVisible(true);
  }
  panelCentral.add(componente);
  panelCentral.doLayout();
  idUltimoPanel=componente.getId();
}




var itemsMenu=new Array();

Ext.onReady(function(){



var panelMenuAbms = new PanelMenu({
   title: 'Menú principal',
   store:  new Ext.data.SimpleStore({
   fields:['columna1', 'columna2'],
   data:  [
       [['clientes.png', 'Clientes', creaPanAbmClientes], ['piezas.png', 'Artículos', creaPanAbmPiezas]],
       [['clientes.png', 'Bancos', creaPanelBancos]],
   ]
})

  });

var panelEgresos = new PanelMenu({
	   title: 'Egresos',
	   store:  new Ext.data.SimpleStore({
	   fields:['columna1', 'columna2'],
	   data:  [
	       [['materiales.png', 'Materiales', creaPanAbmMateriales], ['costos.png', 'Costos', creaPanCostos]],
	       [['facturas.png', 'Proveedores', creaPanAbmProveedores]]
	   ]
	})

	  });



  var panelMenuEmpleados = new PanelMenu({

	    title: 'Recursos Humanos',

	    store:  new Ext.data.SimpleStore({

	      fields:['columna1', 'columna2'],

	      data:  [

	        [['empleados.png', 'Empleados', creaPanAbmEmpleados], ['datosReloj.png', 'Reloj', creaPanAbmDatosReloj]]

	      ]

	    })

	  });



  var panelPedidos = new PanelMenu({

    title: 'Pedidos',

    store:  new Ext.data.SimpleStore({

      fields:['columna1', 'columna2'],

      data:  [
        [['pedidos.png', 'Pedidos', creaPanPedidos], ['pedidosPendientes.png', 'Patas Pendientes', creaTiposPataPendientes]],
        [['pedidosPendientes.png', 'Señas y pendientes', creaSeñasYPendientes], ['remitos.png', 'Pedido Rápido', creaPanPedidoRapido]],

      ]

    })

  });



  var panelRemitos = new PanelMenu({
	    title: 'Remitos',
	    store:  new Ext.data.SimpleStore({
	      fields:['columna1', 'columna2'],
	      data:  [
	         [['remitos.png', 'Remitos', creaPanRemitos], ['facturas.png', 'Facturas', creaPanFacturas], ]
	      ]
	    })
	  });



  var panelSeguridad = new PanelMenu({
    title: 'Seguridad',
	store:  new Ext.data.SimpleStore({
    fields:['columna1', 'columna2'],
	      data:  [
	         [['seguridad.png', 'Remitos', creaCambioDeClave]]
	      ]
	    })
	  });


  var panelEstadisticas = new PanelMenu({
    title: 'Estadísticas',
    store:  new Ext.data.SimpleStore({
      fields:['columna1', 'columna2'],
      data:  [
        [['estadisticas.png', 'Estadísticas', creaPanEstadisticas], ['facturacion.png', 'Facturación', creaPanEstadisticasFacturacion]],
        [['remitidos.png', 'Remitido', creaPanEstadisticasRemitido], ['precios.png', 'Precios', creaPanEstadisticasPrecios]]
      ]
    })
  });




  var panelPrecios = new PanelMenu({

    title: 'Precios',

    store:  new Ext.data.SimpleStore({

      fields:['columna1', 'columna2'],

      data:  [

        [['cotizaciones.png', 'Cotizaciones', creaPanCotizaciones], ['lista_precios.png', 'Lista general', creaPanAbmPrecios]],

        [['efectivosActuales.png', 'Efectivos actuales', creaPanEfectivosActuales], ['lista_precios.png', 'Listados', creaPanReportePrecios]]

      ]

    })

  });



  var panelIngenieria = new PanelMenu({

    title: 'Planta',

    store:  new Ext.data.SimpleStore({

      fields:['columna1', 'columna2'],

      data:  [

        [['matrices.png', 'Matrices', creaPanMatrices], ['fichas.png', 'Fichas', creaPanAbmFichas]],

        [['lineas.png', 'Líneas', creaPanAbmLineas], ['altaOrdenesProduccion.png', 'Ord.Prod.', creaPanOrdenesProduccion]],

        [['altaOrdenesProduccion.png', 'Ord.Term', creaPanOrdenesTerminacion]]

      ]

    })

  });



  var planillasProd = new PanelMenu({

	    title: 'Planillas de Producción',

	    store:  new Ext.data.SimpleStore({

	      fields:['columna1', 'columna2'],

	      data:  [

	        [['planillaProduccion.png', 'Pl.Pr.Prensa', creaPanPlanillasProduccion], ['planillaProduccion.png', 'Pl.Pr.Pulido', creaPanPlanProdPulido]],

	        [['planillaProduccion.png', 'Pl.Pr.Chapa', creaPlanProdChap]]

	      ]

	    })

	  });





  var acordeon=new MenuAcordeon({

	items:[panelMenuAbms, panelEgresos, panelEstadisticas, panelMenuEmpleados, panelPedidos, panelPrecios, panelIngenieria, panelSeguridad, panelRemitos, planillasProd]

  });





    var viewport = new Ext.Viewport({

        layout:'border',

        items:[

            acordeon,

            panelCentral

        ]

    });





  /**

   * muestra la ventana de ingreso de usuario y clave

   */

  var win = new Ext.Window({

    layout:'form',

    modal: true,

    closable: debug,

    plain: true,

    items: [
      {fieldLabel: 'Usuario', xtype: 'textfield', itemId: 'login', ref: '../login', value:'diazg'},
      {fieldLabel: 'Clave', xtype: 'textfield', itemId: 'clave', inputType: 'password', enableKeyEvents: true}
    ],

    buttons: [
      {text: 'Aceptar', itemId: 'botAceptar', ref: '../botAceptar', listeners: {scope: this,  'click' :  function(){
        var panForm=this;
        Ext.Ajax.request({
          url:  '/produccion/svc/conector/usuarios.php/verifica',
          method: 'POST',
          params: { login : win.getComponent('login').getValue(),  clave : win.getComponent('clave').getValue()},
          failure: function (response, options) {
            Ext.Msg.show({ title:'Ingreso', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
          },

          success: function (response, options) {
            var objRespuesta=Ext.util.JSON.decode(response.responseText);
                    if (objRespuesta.success || debug){
                      acordeon.evaluaOcultamiento(objRespuesta);
                      acordeon.setVisible(true);
                      win.destroy();
                    }else{
                      Ext.Msg.show({ title:'Ingreso', msg: 'Usuario o clave incorrectos', buttons: Ext.Msg.OK});
                    }

        }

        });

        }}

      }

    ]

  });

  acordeon.setVisible(false);

  win.show();

  var map = new Ext.KeyMap(win.id, [

    {

      key: [10,13],

      fn: function(){

        win.botAceptar.fireEvent('click');

      }

    }

  ]);





});





