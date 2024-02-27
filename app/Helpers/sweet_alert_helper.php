<?php

if (!function_exists('flash_swal')) {
    function flash_swal($type, $title, $message)
    {
        echo "
            <script>
                Swal.fire({
                    icon: '{$type}',
                    title: '{$title}',
                    text: '{$message}',
                });
            </script>
        ";
    }
}
