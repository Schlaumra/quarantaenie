<?php
require_once 'inc/require.php';
use inc\db\QuarantaenieDB;
checkSession('/quarantine.php');
$db = new QuarantaenieDB();
$_SESSION['backlink'] = '/quarantine.php';
?>
<html lang="de">
<head>
    <title>Quarantänen</title>
    <?php include 'modules/header.php'?>
</head>
<body>
<?php include 'modules/header-bar.php'?>
<div class="content">
    <div class="table-wrapper">
        <div class="table-preface">
            <div><h2>Alle Quarantänen</h2></div>
            <div class="button-wrapper">
                <a href="create/quarantine.php" class="button">Quarantäne hinzufügen</a>
            </div>
        </div>
        <table id="quarantine-table" class="big-table">
            <thead>
            <tr>
                <th onclick="sortTable(0, 'quarantine-table')">Klasse</th>
                <th onclick="sortTable(1, 'quarantine-table')">Schüler</th>
                <th onclick="sortTable(2, 'quarantine-table')">Seit</th>
                <th onclick="sortTable(3, 'quarantine-table')">Bis</th>
                <th onclick="sortTable(4, 'quarantine-table')">Aktiv</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($db->queryAllQuarantinesGenerator() as $row) {
                $qEnd = $row['qEnd'] ?? 'Unknown';
                $quarantine = $row['activeQT'] ? 'Ja' : 'Nein';
                $quarantine_highlight = $row['activeQT'] ? 'quarantine' : '';
                echo <<<END
                <tr class="$quarantine_highlight">
                    <td class="cell-clickable" onclick="window.location = '/overview/class.php?clID={$row['clID']}'">{$row['class']}</td>
                    <td class="cell-clickable" onclick="window.location = '/overview/student.php?stID={$row['stID']}'">{$row['lastName']} {$row['firstName']}</td>
                    <td>{$row['qStart']}</td>
                    <td>$qEnd</td>
                    <td>$quarantine</td>
                    <td>
                    <div class="table-icon-box">
                        <a href="/edit/quarantine.php?id={$row['qtID']}"><img class="table-icon edit-icon" src="src/edit.svg" alt="edit"></a>
                        <a href="/actions/quarantine.php?action=delete&qtID={$row['qtID']}"><img class="table-icon" src="src/remove.svg" alt="remove"></a>
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