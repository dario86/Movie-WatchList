<?php

use Cake\Routing\Router; ?>

<ul class="sidebar-menu">

    <li><a href="<?php echo Router::url(['controller' => 'Movies', 'action' => 'home']) ?>"><i class="fa fa-book"></i> <span>Home</span></a></li>

    <?php if ($authUser): ?>
        <li><a href="<?php echo Router::url(['controller' => 'Movies', 'action' => 'show']) ?>" id="movie_list"><i class="fa fa-book"></i> <span>Lista</span></a></li>
        <li><a href="<?php echo Router::url(['controller' => 'Movies', 'action' => 'add']) ?>" id="movie_add"><i class="fa fa-book"></i> <span>Aggiungi</span></a></li>
    <?php endif; ?>
</ul>