<!DOCTYPE html>
<html>
    <head>

        <title>Clare</title>
        <meta charset="utf-8">
         <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="shortcut icon" href=""> 
        <?php
        echo link_tag(array('href' => 'assets/plugins/bootstrap/css/bootstrap.min.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
        echo link_tag(array('href' => 'assets/plugins/datatables/datatables_bootstrap.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
        echo link_tag(array('href' => 'assets/css/layout.css', 'rel' => 'stylesheet', 'type' => 'text/css'));
        echo "<script src='" . base_url('assets/plugins/bootstrap/js/jquery.js') . "'></script>";
        echo "<script src='" . base_url('assets/plugins/bootstrap/js/bootstrap.min.js') . "'></script>";
        echo "<script src='" . base_url('assets/plugins/datatables/datatables.js') . "'></script>";
        echo "<script src='" . base_url('assets/plugins/datatables/datatables_bootstrap.js') . "'></script>";
        echo "<script src='" . base_url('assets/plugins/datatables/datetime-moment.js') . "'></script>";
        echo "<script src='" . base_url('assets/plugins/script.js') . "'></script>"; //incluir scripts dentro de scripts
        echo "<script src='" . base_url('assets/js/script_geral.js') . "'></script>"; 
        ?>	

        <script>
            var base_url = '<?php echo base_url() ?>';
            function include(file_path) {
                var j = document.createElement("script");
                j.type = "text/javascript";
                j.src = file_path;
                document.head.appendChild(j);
            }



            function include_once(file_path) {
                var sc = document.getElementsByTagName("script");
                for (var x in sc){
                        if (sc[x].src != undefined && sc[x].src.indexOf(file_path) != -1) return;
                }
                    include(file_path);
            }
            
            function include_css(file_path) {
                var j = document.createElement("link");
                j.type = "text/css";
                j.rel= "stylesheet";
                j.href = file_path;
                document.head.appendChild(j);
            }

        </script>

    </head>
    <body>

