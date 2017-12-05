$(document).ready(function() {
    $("#btnEdit").click(function() {
        $("input[type='text']").removeAttr("readonly");
        $("textarea").removeAttr("readonly");
        jQuery(".hid").css("display","block");
    });
    jQuery(".hid").css("display","none");
});