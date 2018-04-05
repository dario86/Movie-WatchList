<?php
use Cake\Core\Configure;

if (isset($heading) && !empty($heading)):

    ?>

    <h1><?php echo $heading['title']; ?></h1>
    <?php if (!empty($heading['small'])): ?>
        <small><?php echo $heading['small']; ?></small>
    <?php endif; ?>


    <?php
    if (!empty($heading['breadcrumbs'])) {

        foreach ($heading['breadcrumbs'] as $breadcrumb) {
            $this->Html->addCrumb($breadcrumb['text'], $breadcrumb['url'], $breadcrumb['options']);
        }

        echo $this->Html->getCrumbList([
            'firstClass' => false,
            'lastClass' => 'active',
            'class' => 'breadcrumb'
            ], false);
    }

    endif; ?>