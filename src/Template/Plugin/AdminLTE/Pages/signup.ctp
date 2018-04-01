<?php
use Cake\Routing\Router;

echo $this->Html->script('plugins/bootstrap-validator/validator', ['block' => 'script']);
echo $this->Html->script('base', ['block' => 'script']);

?>
<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <b>Soisy</b>Test
        </div>

        <div class="register-box-body">
            <p class="login-box-msg"><?= __('Registra nuovo utente') ?></p>

            <div class="flash-success hidden">
                <?= $this->element('Flash/success', ['message' => '']); ?>
            </div>
            <div class="flash-error hidden">
                <?= $this->element('Flash/error', ['message' => '']); ?>
            </div>

            <?php
            echo $this->Form->create(null, [
                'id' => 'add_user',
                'url' => ['plugin' => 'API', 'controller' => 'Users', 'action' => 'add'],
                'data-toggle' => 'validator',
                'role' => 'form',
            ]);

            ?>
            <div class="form-group has-feedback">
                <?php
                echo $this->Form->input('name', [
                    'type' => 'text',
                    'class' => 'form-control',
                    'placeholder' => __('Nome'),
                    'label' => false,
                    'required' => true,
                ]);

                ?>

            </div>

            <div class="form-group has-feedback">
                <?php
                echo $this->Form->input('surname', [
                    'type' => 'text',
                    'class' => 'form-control',
                    'placeholder' => __('Cognome'),
                    'label' => false,
                    'required' => true,
                ]);

                ?>

            </div>
            <div class="form-group has-feedback">
                <?php
                echo $this->Form->input('username', [
                    'type' => 'email',
                    'class' => 'form-control',
                    'placeholder' => 'Email',
                    'label' => false,
                    'required' => true,
                ]);

                ?>

            </div>

            <div class="form-group has-feedback">
                <?php
                echo $this->Form->input('password', [
                    'type' => 'password',
                    'class' => 'form-control',
                    'placeholder' => 'Password',
                    'value' => '',
                    'required' => false,
                    'label' => false,
                    'required' => true,
                ]);

                ?>
            </div>


            <div class="form-group has-feedback">
                <?php
                echo $this->Form->input('password_repeat', [
                    'type' => 'password',
                    'class' => 'form-control',
                    'placeholder' => __('Ripeti Password'),
                    'value' => '',
                    'required' => false,
                    'label' => false,
                    'required' => true,
                    'data-match' => "#password"
                ]);

                ?>
            </div>

            <div class="row">
                <div class="col-xs-8">
                    <!--                <div class="checkbox icheck">
                                        <placeholder>
                                            <input type="checkbox"> I agree to the <a href="#">terms</a>
                                        </placeholder>
                                    </div>-->
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <?php
                    echo $this->Form->button(__('Iscriviti'), [
                        'class' => 'btn btn-success btn-block btn-flat',
                        'type' => 'submit'
                    ]);
                    echo $this->Form->end();

                    ?>
                </div>
                <!-- /.col -->
            </div>
            <?php echo $this->Form->end(); ?>

            <a href="<?php echo Cake\Routing\Router::url(['controller' => 'Pages', 'action' => 'login']); ?>" class="text-center"><?= __('Ho già un account') ?></a>
        </div>
        <!--/.form-box -->
    </div>
    <!--/.register-box -->
</body>