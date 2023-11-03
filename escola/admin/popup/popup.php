<?php
    class Popup {
        private $redirect;

        public function __construct($redirect) {
            $this->redirect = $redirect;
        }

        public function mostrarPopup() {
            if (isset($_GET['popup'])) {
                echo '<script>';
                echo 'const box = document.getElementById("box");
                const popup = document.getElementById("popup");
                const confirmar = document.getElementById("confirmar");
                const nav = document.getElementById("navbar");
                const cancelar = document.getElementById("cancelar");

                popup.style.display = "flex";
                box.style.display = "none";
                nav.style.display = "none";
                
                confirmar.onclick = () =>{
                    var url = window.location.href;
                    window.location.href = url + "&confirm=true";
                };';
                echo 'cancelar.onclick = () =>{
                    window.location.href = "' . $this->redirect . '";
                }';
                echo '</script>';
            }
        }
    }
?>
