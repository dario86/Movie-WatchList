<?php
use Cake\Routing\Router;

echo $this->Html->script('plugins/bootstrap-validator/validator', ['block' => 'script']);
echo $this->Html->script('users', ['block' => 'script']); ?>

<div class="login-box">
    <div class="login-logo">
        <b>Movies</b>WatchList</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?= __('Esegui il login') ?></p>

        <div class="flash-error hidden">
            <?= $this->element('Flash/error', ['message' => '']); ?>
        </div>

        <?php
        echo $this->Form->create(null, [
            'id' => 'login_user',
            'url' => ['plugin' => 'API', 'controller' => 'Users', 'action' => 'login'],
            'data-toggle' => 'validator',
            'role' => 'form',
            'identify' => Router::url(['controller' => 'Users', 'action' => 'identify'])
        ]);

        ?>
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
                'label' => false,
                'required' => true,
            ]);

            ?>

        </div>

        <div class="row">
            <div class="col-xs-8">
                <!--                        <div class="checkbox icheck">
                                            <label>
                                                <input type="checkbox"> Remember Me
                                            </label>
                                        </div>-->
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?php
                echo $this->Form->button(__('Accedi'), [
                    'class' => 'btn btn-success btn-block btn-flat',
                    'type' => 'submit'
                ]);

                ?>

            </div>
            <!-- /.col -->
        </div>
        <?php echo $this->Form->end(); ?>


        <a href="<?php echo Cake\Routing\Router::url(['controller' => 'Pages', 'action' => 'signup']); ?>" class="text-center"><?= __('Registra nuovo utente') ?></a>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
