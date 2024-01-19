<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$plugins['datatables'] = [
  'css' => [
    'assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
    'assets/dist/css/custom.datatables.css',
  ],
  'js' => [
    'assets/plugins/datatables/jquery.dataTables.min.js',
    'assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
    'assets/dist/js/dtutils.js'
  ]
];

$plugins['datatables-buttons'] = [
  'css' => [
    'assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'
  ],
  'js' => [
    'assets/plugins/datatables-buttons/js/dataTables.buttons.min.js',
    'assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js',
    'assets/plugins/datatables-buttons/js/buttons.colVis.min.js',
    'assets/plugins/datatables-buttons/js/buttons.flash.min.js',
    'assets/plugins/datatables-buttons/js/buttons.html5.min.js',
    'assets/plugins/datatables-buttons/js/buttons.print.min.js',
  ]
];

$plugins['datatables-colreorder'] = [
  'css' => [
    'assets/plugins/datatables-colreorder/css/colReorder.bootstrap4.min.css'
  ],
  'js' => [
    'assets/plugins/datatables-buttons/js/dataTables.colReorder.min.js',
    'assets/plugins/datatables-buttons/js/colReorder.bootstrap4.min.js'
  ]
];

$config['plugins'] = $plugins;