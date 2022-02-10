<?php
require_once 'inc/require.php';
use inc\db\QuarantaenieDB;
checkSession('/student.php');
$db = new QuarantaenieDB();
$_SESSION['backlink'] = '/student.php';
?>
<html lang="de">
<head>
    <title>Schüler</title>
    <?php include 'modules/header.php'?>
</head>
<body>
<?php include 'modules/header-bar.php'?>
<div class="content">
    <div class="table-wrapper">
        <div class="table-preface">
            <div><h2>Alle Schüler</h2></div>
            <div class="button-wrapper">
                <a href="create/student.php" class="button">Schüler hinzufügen</a>
            </div>
        </div>
        <table id="student-table" class="big-table">
            <thead>
            <tr>
                <th onclick="sortTable(0, 'student-table')">Klasse</th>
                <th onclick="sortTable(1, 'student-table')">Vorname</th>
                <th onclick="sortTable(2, 'student-table')">Nachname</th>
                <th onclick="sortTableByNumber(3, 'student-table')">Insgesamt Quarantänen</th>
                <th onclick="sortTable(4, 'student-table')">In Quarantäne</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($db->queryAllStudentsGenerator() as $row) {
                $quarantine = $row['activeQT'] ? 'Ja' : 'Nein';
                $quarantine_highlight = $row['activeQT'] ? 'quarantine' : '';
                echo <<<END
                    <tr class="$quarantine_highlight">
                        <td class="cell-clickable" onclick="window.location = '/overview/class.php?clID={$row['clID']}'">{$row['class']}</td>
                        <td class="cell-clickable" onclick="window.location = '/overview/student.php?stID={$row['stID']}'">{$row['firstName']}</td>
                        <td class="cell-clickable" onclick="window.location = '/overview/student.php?stID={$row['stID']}'">{$row['lastName']}</td>
                        <td>{$row['totalQT']}</td>
                        <td>$quarantine</td>
                        <td>
                        <div class="table-icon-box">
                            <a href="edit/student.php?id={$row['stID']}"><img class="table-icon edit-icon" src="src/edit.svg" alt="edit"></a>
                            <a href="create/quarantine.php?stID={$row['stID']}"><img class="table-icon" src="src/add-quarantine.svg" alt="add"></a>
                            <a href="actions/student.php?action=delete&stID={$row['stID']}"><img class="table-icon" src="src/remove.svg" alt="remove"></a>
                        </div>
                        </td>
                    </tr>
                    END;
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>