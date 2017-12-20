$(document).ready(function() {
    $("#btnEdit").click(function() {
        $("input[type='text']").removeAttr("readonly");
        $("number").removeAttr("readonly");
        $("select").removeAttr("disabled");
        jQuery(".hid").css("display","inline");
    });
    jQuery(".hid").css("display","none");
});