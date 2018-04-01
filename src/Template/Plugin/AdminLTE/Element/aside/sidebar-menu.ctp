<?php

use Cake\Routing\Router; ?>

<ul class="sidebar-menu" style="cursor: pointer">

    <li><a href="<?php echo Router::url(['controller' => 'Pages', 'action' => 'home']) ?>"><i class="fa fa-book"></i> <span>Home</span></a></li>

    <?php if ($authUser): ?>
        <li><a id="movie_list"><i class="fa fa-book"></i> <span>Lista</span></a></li>
        <li><a id="movie_add"><i class="fa fa-book"></i> <span>Aggiungi</span></a></li>
        <?php endif; ?>
</ul>