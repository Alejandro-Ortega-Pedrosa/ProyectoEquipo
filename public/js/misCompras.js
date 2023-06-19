$(function(){

    $.ajax( "http://localhost:8000/api/compras", 
    {
        method:"GET",
        dataType:"json",
    }).done(function(data){

        var tabla = $("<table></table>");
        tabla.attr({
        id:"idtabla"});

        tabla.addClass("table text-white text-center");

        var nuevoTr='<thead class"bg-secondary"><tr><th>PRODUCTO</th><th>TALLA</th><th>PRECIO</th></tr></thead>';
        tabla.append(nuevoTr);

        $("#container").append(tabla);

        var tbody=$("<tbody>");
        tbody.addClass("bg-white text-dark");

        $.each(data, function(i,v){
            var nuevoTr="<tr><td>"+data[i].producto+"</td><td>"+data[i].talla+"</td><td>"+data[i].precio+"€</td></tr>";
            tbody.append(nuevoTr);
        })
        tabla.append(tbody);
        tabla.DataTable();

        
    }).fail(function(){
            alert("ERROR")
    })

})

