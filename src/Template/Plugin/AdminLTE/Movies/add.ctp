<?php
use Cake\Core\Configure;

$this->set('heading', [
    'title' => __('Aggiungi film'),
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
echo $this->Html->css('plugins/jquery-ui-1.12.1/jquery-ui.min', ['block' => 'css']);

$this->start('script');

?>
<script>
    var api_key = '<?= Configure::read('themoviedb_api_key') ?>';
</script>
<?php
$this->end();
echo $this->Html->script('plugins/jquery-ui-1.12.1/jquery-ui.min', ['block' => 'script']);
echo $this->Html->script('movies', ['block' => 'script']);

?>

<div class="box">
    <div class="box-header with-border">
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
                <i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">

        <?php
        echo $this->Form->create(null, [
            'id' => 'add_movie',
            'url' => ['plugin' => 'API', 'controller' => 'Movies', 'action' => 'add'],
            'data-toggle' => 'validator',
            'role' => 'form',
        ]);

        ?>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                    <?php
                    echo $this->Form->input('title', [
                        'type' => 'text',
                        'id' => 'movie_name',
                        'class' => 'form-control',
                        'placeholder' => __('Titolo'),
                        'label' => __('Title'),
                        'required' => true,
                    ]);

                    ?>
                </div>
                <div class="col-xs-12 col-md-6">
                    <label for="watched">Visto?</label>
                    <?php
                    echo $this->Form->select('watched', [
                        0 => 'No',
                        1 => 'Si'
                        ], [
                        'class' => 'form-control',
                        'required' => true,
                    ]);

                    ?>
                </div>

            </div>

            <div class="row">

                <div class="col-xs-12">
                    <?php
                    echo $this->Form->button(__('Aggiungi film'), [
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

