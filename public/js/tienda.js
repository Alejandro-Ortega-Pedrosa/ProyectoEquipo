$(function(){

    var productos=[];
    var productos=JSON.parse(localStorage.getItem('producto'));

    //CARGA EL NUMERO DE PRODUCTOS EN EL CARRITO
    var numero=productos.length;
    $(".totalCarrito").text(numero+" Artículos en el Carrito");

    //PRODUCTO
    $(".productoTienda").draggable({ 
        helper: "clone",
        revert: false,
        start: function(ev,ui){
            ui.helper.attr("data-mensaje", "HOLA PEDRO");
            var producto=ui.helper;
            producto.css('width', '100px');
            producto.css('height', 'auto');
        }
    });
    
    //CARRITO
    $(".carrito").droppable({
        accept: ".productoTienda",
          
        drop: function(ev, ui) {
            var producto=ui.draggable;
            actualizarCarrito(producto.attr("id"));
          },
          over: function(ev, ui){
            $(this).css({border:"2px solid #3c1352"})
            this.css('width', '450px');
            this.css('height', 'auto');
           

          },
          out: function(ev, ui){
            $(this).css({border:"none"})
          }
    });

    //PARA VER LOS ELEMENTOS DEL CARRITO
    $(".carrito").click(function(){
        
        //GUARDA LOS PRODUCTOS
        localStorage.setItem('producto', JSON.stringify(productos));


    })


    //VER DETALLES DEL PRODUCTO
    $(".detalles").click(function(ev){
        ev.preventDefault();
        
        var id=this.name;

    
        $.ajax( "http://localhost:8000/api/producto/"+id, 
        {
            method:"GET",
            dataType:"json",

        }).done(function(data){

            var plantilla=`
            <div class="producto_detalle">
				<div class="info">
                    <div class="foto"><img width="100" height="100"/></div>
                    <p class="nombre"></p>
                    <div class="precio"></div>
                    <p class="stock text-danger"></p>
                    <p class="descripcion"></p>
				</div>
			</div>`

            var jqPlantilla=$(plantilla);
            jqPlantilla.find(".nombre").text(data.nombre);
            jqPlantilla.find(".precio").text("Precio: "+data.precio+" €");
            jqPlantilla.find(".stock").text("Stock: "+data.stock+"uds");
            jqPlantilla.find(".descripcion").text(data.descripcion);
            jqPlantilla.find("img").attr("src", "imagenes/producto/"+data.foto);
            jqPlantilla.find("a").attr("href", "/producto/"+id);
        

            jqPlantilla.dialog({title:data.nombre,modal:true,witdh:"500px"});
                
        }).fail(function(){
            alert("ERROR")
        })
    })

    $(".logout").click(function(){
        const vaciar=[];

        localStorage.setItem('producto', JSON.stringify(vaciar));
    })

    function actualizarCarrito(id){
        $.ajax( "http://localhost:8000/api/producto/"+id, 
        {
            method:"GET",
            dataType:"json",

        }).done(function(data){

            //GUARDAR EN CARRO
            productos.push(data);

            //ACTUALIZA EL NÚMERO DE PRODUCTOS EN EL CARRITO
            numero=productos.length;

            $(".totalCarrito").text(numero+" Artículos en el Carrito");

        })
    }


})