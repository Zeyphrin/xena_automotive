<?php

// Bersihkan cache jika ada yang tertinggal
if (is_dir('/tmp/views')) {
    array_map('unlink', glob("/tmp/views/*.*"));
}

require __DIR__ . '/../public/index.php';