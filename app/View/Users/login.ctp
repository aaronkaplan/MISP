<?php
    App::uses('RandomTool', 'Tools');
    $randomString = (new RandomTool())->random_str(false, 12);
?>
<div style="width:100%;">
    <?php
        echo $this->Session->flash('auth');
    ?>
<table style="margin-left:auto;margin-right:auto;">
    <tr>
    <td style="text-align:right;width:250px;padding-right:50px">
        <?php if (Configure::read('MISP.welcome_logo')) echo $this->Html->image('custom/' . h(Configure::read('MISP.welcome_logo')), array('alt' => __('Logo'), 'onerror' => "this.style.display='none';")); ?>
    </td>
    <td style="width:460px">
        <span style="font-size:18px;">
            <?php
                if (Configure::read('MISP.welcome_text_top')) {
                    echo h(Configure::read('MISP.welcome_text_top'));
                }
            ?>
        </span><br /><br />
        <div>
        <?php if (Configure::read('MISP.main_logo') && file_exists(APP . '/webroot/img/custom/' . Configure::read('MISP.main_logo'))): ?>
            <img src="<?php echo $baseurl?>/img/custom/<?php echo h(Configure::read('MISP.main_logo'));?>" style=" display:block; margin-left: auto; margin-right: auto;" />
        <?php else: ?>
            <img src="/img/misp-logo.png" style="display:block; margin-left: auto; margin-right: auto;"/>
        <?php endif;?>
        </div>
        <?php
            if (true == Configure::read('MISP.welcome_text_bottom')):
        ?>
                <div style="text-align:right;font-size:18px;">
                <?php
                    echo h(Configure::read('MISP.welcome_text_bottom'));
                ?>
                </div>
        <?php
            endif;
            echo $this->Form->create('User', ['id' => 'UserLoginForm_' . $randomString]);
        ?>
        <legend><?php echo __('Login');?></legend>
        <?php
            echo $this->Form->input('email', array('autocomplete' => 'off', 'autofocus'));
            echo $this->Form->input('password', array('autocomplete' => 'off'));
        ?>
            <div class="clear">
            <?php
                echo empty(Configure::read('Security.allow_self_registration')) ? '' : sprintf(
                    '<a href="%s/users/register" title="%s">%s</a>',
                    $baseurl,
                    __('Registration will be sent to the administrators of the instance for consideration.'),
                    __('No account yet? Register now!')
                );
            ?>
            </div>
            <button class="btn btn-primary" type="submit" onclick="submitLoginForm()"><?= __('Login') ?></button>
        <?php
            echo $this->Form->end();
            if (Configure::read('ApacheShibbAuth') == true) {
                echo '<div class="clear"></div><a class="btn btn-info" href="/Shibboleth.sso/Login">Login with SAML</a>';
            }
        ?>
    </td>
    <td style="width:250px;padding-left:50px">
        <?php if (Configure::read('MISP.welcome_logo2')) echo $this->Html->image('custom/' . h(Configure::read('MISP.welcome_logo2')), array('alt' => 'Logo2', 'onerror' => "this.style.display='none';")); ?>
    </td>
    </tr>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#UserLoginForm').submit(function(event) {
        event.preventDefault()
        submitLoginForm()
    });
})

function submitLoginForm() {
    var $form = $('#UserLoginForm_<?= $randomString ?>')
    var url = $form.attr('action')
    var email = $form.find('#UserEmail').val()
    var password = $form.find('#UserPassword').val()
    if (!$form[0].checkValidity()) {
        $form[0].reportValidity()
    } else {
        fetchFormDataAjax(url, function(formHTML) {
            $('body').append($('<div id="temp" style="display: none"/>').html(formHTML))
            var $tmpForm = $('#temp form')
            $tmpForm.find('#UserEmail').val(email)
            $tmpForm.find('#UserPassword').val(password)
            $tmpForm.submit()
        })
    }
}
</script>
