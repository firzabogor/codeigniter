<h2>Register</h2>

<?php echo form_open('register'); ?>
    <label for="email">Email</label>
    <?php echo form_error('email'); ?>
    <input type="email" name="email" value="<?php echo set_value('email'); ?>">
    <br>

    <label for="password">Password</label>
    <?php echo form_error('password'); ?>
    <input type="password" name="password">
    <br>

    <label for="konfirmasi_password">Konfirmasi Password</label>
    <?php echo form_error('konfirmasi_password'); ?>
    <input type="password" name="konfirmasi_password">
    <br>
    

    <input type="submit" name="submit" value="Register">
<?php echo form_close(); ?>