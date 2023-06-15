$(function(){

    //COJO EL ID DEL PRODUCTO CON EL QUE SE VA A TRBAJAR
    var id=$(".boton").attr("id");

    $.ajax( "http://localhost:8000/api/producto/"+id, 
    {
        method:"GET",
        dataType:"json",

    }).done(function(data){

        //CREO EL PRODUCTO
        var producto=new Producto(data.id,data.nombre,data.precio,data.stock,data.descripcion,data.foto);

        //COJO LOS ELEMENTOS HTML
        $(".apartado").text(data.nombre);

        var nombre=$(".nombre");
        var precio=$(".precio");
        var stock=$(".stock");

        var select=$("[name='talla']");
        rellenarTallas(select);

        var descripcion=$(".descripcion");
        var foto=$(".foto");

        //RELLENO LOS ELEMENTOS HTML EN FUNCION DE LAS PROPIEDADES DEL PRODUCTO
        producto.pinta(nombre, precio, stock, descripcion, foto);

        $(".boton").click(function(){

            $.ajax( "http://localhost:8000/api/talla/"+select.val(), 
            {
                method:"GET",
                dataType:"json",

            }).done(function(data){

                //LLAMO A LA API DE COMPRA Y SE REALIZA LA COMPRA
                $.ajax( "http://localhost:8000/api/compra", 
                {
                    method:"GET",
                    dataType:"json",
                    data:{
                        producto: id,
                        talla: data.identificador
                    }

                }).done(function(data){

                    alert("Has comprado "+id+" de la talla "+data.identificador);
                
                }).fail(function(){
                    alert("ERROR")
                })
            
            }).fail(function(){
                alert("ERROR")
            })
    
        })
        
            
    }).fail(function(){
        alert("ERROR")
    })


})

//RELLENO EL SELECT CON LOS TRAMOS 
function rellenarTallas(select){
    $.ajax( "http://localhost:8000/api/tallas", 
    {
        method:"GET",
        dataType:"json"
    }).done(function(data){

        //RECORRO LA DISPOSICION SEGUN EL DIA SELECCIONADO Y PINTA LAS MESAS EN SU NUEVA POSICION
        $.each(data, function(i,v){
            
            select.append('<option value='+data[i].id+'>'+data[i].identificador+'</option>');
        })

    }).fail(function(){
        alert("ERROR")
    })
}