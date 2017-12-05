$(document).ready(function(){
    $(".del").click(function(){
        if (!confirm("Adakah anda pasti untuk memadam barang ini?")){
            return false;
        }
    });
} );

$(document).ready(function(){
    $(".tukar").click(function(){
        if (!confirm("Adakah anda pasti untuk membuat permintaan menukar barang ini?")){
            return false;
        }
    });
} );