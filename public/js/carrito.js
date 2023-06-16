$(function(){

    //CREO LA TABLA CON LOS PRODUCTOS DEL CARRITO Y LA AÑADO AL CONTENEDOR
    var data=JSON.parse(localStorage.getItem('producto'));

    var tabla = $("<table></table>");
    tabla.attr({
    id:"idtabla"});

    tabla.addClass("table text-white text-center");

    var nuevoTr='<thead class=""><tr><th></th><th></th><th></th><th></th><th>TALLA</th><th>SELECCIONAR</th></tr></thead>';
    tabla.append(nuevoTr);

    $("#container").append(tabla);

    var tbody=$("<tbody>");
    tbody.addClass("bg-white text-dark");

    $.each(data, function(i,v){
        var nuevoTr="<tr><td>"+data[i].nombre+"</td><td>"+data[i].precio+"€</td><td>"+data[i].descripcion+"</td><td><img src='imagenes/producto/"+data[i].foto+"' height='100px' width='100px'/></td><td><select name='talla'></select></td><td><input type='checkbox' id="+i+"> </td></tr>";
        
        tbody.append(nuevoTr);
    })

    //UNA VEZ CREADO EL SELECT LO RELLENO DE LAS TALLAS
    rellenarTallas();
    
    //UNA VEZ Q TENGO LA TABLA COMPLETA LA AÑADO AL BODY
    tabla.append(tbody);

    //CREO EL ARRAY DE PRODUCTOS SELECCIONADOS
    var productosSeleccionados=[];
    var tallaProducto=[];

    //SI SE ELIGE UN PRODUCTO SE AÑADE AL ARRAY Y SE DESELECCIONA SE SACA DEL ARRAY
    $('input[type=checkbox]').on('change', function() {

        if ($(this).is(':checked') ) {
            //GUARDO EL ID DEL CHECK QUE ES EL INDICE
            productosSeleccionados.push($(this).prop("id"));


            tallaProducto.push($("[name='talla']").eq($(this).prop("id")).val());
        }else {
            productosSeleccionados=productosSeleccionados.filter(producto => producto != $(this).prop("id"));
        }
    });


    //BORRAR LOS PRODUCTOS SELECCIONADOS
    $(".borrar").click(function(){

        //RECORRE EL ARRAY DE SELECCIONADOS Y EL DE DATA SACANDO DE DATA LOS PRODUCTOS SELECCIONADOS
        data = data.filter((producto, index) => {
            return !productosSeleccionados.includes(String(index));
        });
    
        localStorage.setItem('producto', JSON.stringify(data));
        location.reload();
    })

    $(".comprar").click(function(){
        
        //RECORRE EL ARRAY DE SELECCIONADOS Y EL DE DATA SACANDO DE DATA LOS PRODUCTOS SELECCIONADOS
        data = data.filter((producto, index) => {
            return productosSeleccionados.includes(String(index));
        });

        //RECORRO EL ARRAY DE DATA Y VOY LLAMANDO A LA API Y COMPRANDO UN PRODUCTO
        for(let i=0;i<data.length;i++){
            console.log(data[i]);
            debugger;
            console.log(tallaProducto[i]);
        }

        //localStorage.setItem('producto', JSON.stringify(data));
        //location.reload();
    })

    //RELLENO EL SELECT CON LOS TRAMOS 
    function rellenarTallas(){
        $.ajax( "http://localhost:8000/api/tallas", 
        {
            method:"GET",
            dataType:"json"
        }).done(function(data){

            //RECORRO LA DISPOSICION SEGUN EL DIA SELECCIONADO Y PINTA LAS MESAS EN SU NUEVA POSICION
            $.each(data, function(i,v){
                
                $("[name='talla']").append('<option id='+i+' value='+data[i].id+'>'+data[i].identificador+'</option>');
            })

        }).fail(function(){
            alert("ERROR")
        })
    }


})

