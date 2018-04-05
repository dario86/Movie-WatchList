<?php 
echo $this->Html->script('movies', ['block' => 'script']);

$this->start('scriptBottom'); ?>
<script>
    // Call function `search` to populate the table
    search($('#search_movies'));
</script>
<?php $this->end(); ?>

<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?= __('Filtri') ?></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                <i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">

        <div class="row">

            <?php
            echo $this->Form->create(null, [
                'url' => ['plugin' => 'API', 'controller' => 'Movies', 'action' => 'search'],
                'type' => 'POST',
                'id' => 'search_movies'
            ]);

            ?>

            <div class="col-sm-12 col-md-4">
                <label for="watched"><?= __('Visti') ?></label>
                <?php
                echo $this->Form->select('watched', [-1 => 'No', 1 => 'Si'], [
                    'label' => 'Visti',
                    'class' => 'form-control',
                    'empty' => 'Seleziona...',
                ]);

                ?>
            </div>

            <div class="col-sm-12 col-md-4">
                <label for="limit"><?= __('Limite risultati') ?></label>
                <?php
                echo $this->Form->select('limit', [10 => '10', 20 => '20', 50 => '50', 100 => '100', 200 => '200'], [
                    'label' => 'Limite risultati',
                    'class' => 'form-control',
                    'empty' => 'Seleziona...',
                ]);

                ?>
            </div>

            <div class="col-sm-12 col-md-4">
                <?php
                echo $this->Form->input('page', [
                    'label' => __('Pagina'),
                    'class' => 'form-control',
                ]);

                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <span class="input-group-btn">
                    <?php
                    echo $this->Form->submit(__('Esegui'), [
                        'class' => 'btn btn-success pull-right',
                    ]);

                    ?>
                </span>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>
</div>

<div class="box">
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered footable">
                <thead>
                    <tr>
                        <th class="text-center">
                            <?= __('Cancella') ?>
                        </th>
                        <th class="text-center">
                            <?= __('Titolo') ?>
                        </th>
                        <th class="text-center">
                            <?= __('Aggiunto il') ?>
                        </th>
                        <th class="text-center">
                            <?= __('Visto') ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>