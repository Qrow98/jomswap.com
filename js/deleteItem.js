$(document).ready(function(){
    $(".del").click(function(){
        if (!confirm("Adakah anda pasti untuk memadam barang ini?")){
            return false;
        }
    });
} );