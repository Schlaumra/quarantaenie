<div class="header-bar">
    <div>
        <a href="/index.php"><img class="logo" src="/src/logo_with_text.svg" alt="logo"></a>
    </div>
    <div class="links <?php echo !key_exists('username', $_SESSION) ? 'hidden' : ''?>">
        <a href="/class.php">Klassen</a>
        <a href="/student.php">Schüler</a>
        <a href="/quarantine.php">Quarantänen</a>
    </div>
    <div class="logout <?php echo !key_exists('username', $_SESSION) ? 'hidden' : ''?>">
        <a href="/exit.php"><img class="exit-icon" src="/src/exit.svg" alt="logo"></a>
    </div>
</div>