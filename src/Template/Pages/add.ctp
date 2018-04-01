<?php
$this->set('heading', [
    'title' => __('Aggiunti film'),
    'description' => __('Aggiungi nuovo film'),
    'breadcrumbs' => [
        [
            'text' => '<i class="fa fa-dashboard"></i>Home',
            'url' => '/',
            'options' => [
                'escape' => false
            ]
        ],
        [
            'text' => __('Nuovo film'),
            'url' => '',
            'options' => [
                'escape' => false,
                'class' => 'active'
            ]
        ],
    ]
]);

echo $this->Html->script('pipelines', ['block' => 'script']);

?>

<div class="row">
    <div class="col-xs-12">
        <?php echo $this->Flash->render('addPipeline'); ?>
    </div>
</div>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= __('Aggiungi Pipeline') ?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                <i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">

        <?php
        echo $this->Form->create($pipeline, [
            'id' => 'add-pipeline'
        ]);

        ?>

        <div class="form-group">
            <?php
            echo $this->Form->input('name', [
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => __('Nome'),
                'label' => __('Nome')
            ]);

            ?>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <label>Step</label>
            </div>
        </div>

        <div class="stages">
            <div class="form-group stage">
                <div class="input-group col-xs-12">
                    <?php
                    echo $this->Form->input('stages.0.label', [
                        'type' => 'text',
                        'class' => 'form-control',
                        'placeholder' => __('Nome'),
                        'label' => false,
                        'escape' => false
                    ]);

                    ?>

                    <span class="input-group-btn">
                        <button class="btn btn-success btn-add" type="button">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">

                <div class="col-xs-12">
                    <?php
                    echo $this->Form->button(__('Aggiungi pipeline'), [
                        'class' => 'btn btn-success pull-right',
                        'type' => 'submit'
                    ]);
                    echo $this->Form->end();

                    ?>
                </div>
            </div>
        </div>

    </div>
</div>

