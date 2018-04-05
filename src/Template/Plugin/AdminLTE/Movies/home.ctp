<?php $this->set('title', 'Home - Movies WatchList');

$this->set('heading', [
    'title' => 'Home',
    'description' => __('Homepage di Movies WatchList'),
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