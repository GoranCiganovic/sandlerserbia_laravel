<?php

return array(


    'pdf' => array(
        'enabled' => true,
		'binary' => base_path('vendor/wkhtmltox/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
		'binary' => base_path('vendor/wkhtmltox/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);

