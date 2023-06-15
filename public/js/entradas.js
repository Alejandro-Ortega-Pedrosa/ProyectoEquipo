$(function(){

    //COJO LA ID DEL PARIDO
    var id=$(".cesped").attr("id");

    //VARIABLES
    var precio="";
    var zona="";
    var partido="";
    var fecha="";
    var hora="";
    var tribuna=$(".zonaE_tribuna");
    var preferencia=$(".zonaE_preferencia");
    var fondoN=$(".zonaE_fondoN");
    var fondoS=$(".zonaE_fondoS");

    //COJO LOS DATOS DEL PARTIDO
    $.ajax( "http://localhost:8000/api/partido/"+id, 
    {
        method:"GET",
        dataType:"json",

    }).done(function(data){

        $(".local").text(data.local);
        $(".visitante").text(data.visitante);
        partido=data.local+" - "+data.visitante;
        $(".fechaYhora").text(data.fecha+" "+data.hora);
        

    }).fail(function(){
        alert("ERROR")
    })

    //CUANDO HACE CLICK EN PREFERENCIA
    preferencia.click(function(){
        
        precio=preferencia.attr('name');
        zona="PREFERENCIA";

        $(".precio").text("Precio: "+precio+"€");
        $(".miZona").text("HAS SELECCIONADO "+zona);
        
    })

    //CUANDO HACE CLICK EN TRIBUNA
    tribuna.click(function(){
        
        precio=tribuna.attr('name');
        zona="TRIBUNA";

        //tribuna.css("opacity",".4");
        $(".precio").text("Precio: "+precio+"€");
        $(".miZona").text("HAS SELECCIONADO "+zona);
    })

    //CUANDO HACE CLICK EN EL FONDO NORTE
    fondoN.click(function(){
        
        precio=fondoN.attr('name');
        zona="FONDO NORTE";

        $(".precio").text("Precio: "+precio+"€");
        $(".miZona").text("HAS SELECCIONADO "+zona);
    })

    //CUANDO HACE CLICK EN EL FONDO SUR
    fondoS.click(function(){
        
        precio=fondoS.attr('name');
        zona="FONDO SUR";

        $(".precio").text("Precio: "+precio+"€");
        $(".miZona").text("HAS SELECCIONADO "+zona);

    })

    //CUANDO ENVÍA EL FORMULARIO SE CREA LA NUEVA ENTRADA LLAMA A LA API Y LA API MANDA LA ENTRADA EN PDF
    $("form[name='gesEntradas']").submit(function(ev){

        var form=$(this);
        ev.preventDefault();

        if(precio==""){
            alert("SELECCIONA UNA ZONA DEL ESTADIO")
        }else{

            var nombre=$(".nombre").val();
            var correo=$(".correo").val();

            /*SI HAY UNA ZONA DEL ESTADIO SELECCIONADA COMPRUEBA SI EL FORMULARIO ESTÁ RELLENO
            if (form!=null){

                const mensajesError = [];
                //COMPRUEBA EL NOMBRE
                if(nombre === null || nombre.val()===""){
                    $(".nombrelabel").css({"display": "block"});
                    mensajesError.push("Error");
                }
                //COMPRUEBA EL CORREO
                if(correo.val() === null || correo.val()==="" || correo.val().indexOf('@', 0) == -1 || correo.val().indexOf('.', 0) == -1){
                    $(".correolabel").css({"display": "block"});
                    mensajesError.push("Error");
                }
                if(mensajesError.length>0){
                    ev.preventDefault();
                }else{*/
    
                    //SI NO HAY MENSAJES DE ERROR MANDA LOS DATOS
                    $.ajax( "http://localhost:8000/api/entrada", 
                    {
                        method:"POST",
                        dataType:"json",
                        data:{
                            partido: id,
                            precio: precio,
                            zona: zona,
                            nombre: nombre,
                            correo: correo
                        }
                    }).fail(function(){
                        alert("ERROR");
                    })
                //} 
           // }
  
        }
        
    })

})