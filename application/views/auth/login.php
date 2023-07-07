<h2>Login</h2>

<?php echo form_open('login'); ?>
    <label for="email">Email</label>
    <?php echo form_error('email'); ?>
    <input type="email" name="email" value="<?php echo set_value('email'); ?>">
    <br>

    <label for="password">Password</label>
    <?php echo form_error('password'); ?>
    <input type="password" name="password">
    <br>

    <input type="submit" name="submit" value="Login">
<?php echo form_close(); ?>