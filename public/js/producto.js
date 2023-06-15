function Producto(id, nombre, precio, stock, descripcion, foto){
    this.id=id;
    this.nombre=nombre;
    this.precio=precio;
    this.stock=stock; 
    this.descripcion=descripcion; 
    this.foto=foto;
};

Producto.prototype.pinta=function(nombre, precio, stock, descripcion, foto){
   
    //PONERLE TEXTO A NOMBRE
    nombre.text(this.nombre);
    //PONERLE TEXTO A PRECIO
    precio.text("Precio: "+this.precio+"€");
    //PONERLE TEXTO A STOCK
    stock.text("Stock: "+this.stock+"uds");
    //PONERLE TEXTO A DESCRIPCION
    descripcion.text(this.descripcion);
    //PONERLE SRC A FOTO
    foto.attr("src", "/imagenes/producto/"+this.foto);


}