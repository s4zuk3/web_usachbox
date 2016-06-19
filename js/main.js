$(document).ready(function () {
    FTP.actualizarListaArchivos();
});

var FTP;
(function (FTP) {
    function actualizarListaArchivos() {
        var url = "ajax/ftp_obtenerarchivos_ajax.php";
        $.ajax({
            url: url,
            type: "POST",
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
                $('#archivos_ftp').html(response);
            },
            error: function (response) {
                $('#archivos_ftp').html("");
                $("#ftp_msg").html("Error al cargar los archivos");
            }
        });
    }
    FTP.actualizarListaArchivos = actualizarListaArchivos;
    function uploadAjax() {
        var inputFileImage = $("#ftp_file").get(0);
        var file = inputFileImage.files[0];
        var data = new FormData();
        var url = "ajax/ftp_ajax.php";
        data.append("filename", file);
        $.ajax({
            url: url,
            type: "POST",
            contentType: false,
            data: data,
            processData: false,
            cache: false,
            // Cuando el archivo se sube exitosamente
            success: function (response) {
                if (response == "1") {
                    actualizarListaArchivos();
                    $("#ftp_form")[0].reset();
                    $("#ftp_msg").html("<b>" + file.name + "</b> se ha subido correctamente.");
                }
                else {
                    $("#ftp_msg").html("Error al subir el archivo");
                }
            },
            error: function (response) {
                $("#ftp_msg").html("Error AJAX");
            }
        });
    }
    FTP.uploadAjax = uploadAjax;
})(FTP || (FTP = {}));