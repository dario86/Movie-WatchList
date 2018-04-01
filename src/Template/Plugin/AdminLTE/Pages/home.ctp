<?php $this->set('title', 'Home - Test Soisy');

$this->set('heading', [
    'title' => 'Home',
    'description' => __('Homepage di Test Soisy'),
    'breadcrumbs' => [
        [
            'text' => '<i class="fa fa-dashboard"></i>Home',
            'url' => '/',
            'options' => [
                'escape' => false
            ]
        ],
    ]
]);
?>