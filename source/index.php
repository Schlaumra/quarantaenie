<?php
require_once 'inc/require.php';
use inc\db\QuarantaenieDB;
checkSession('/index.php');
$db = new QuarantaenieDB();
$_SESSION['backlink'] = '/index.php';
?>
<html lang="de">
<head>
    <title>Quarantänie</title>
    <?php include 'modules/header.php'?>
</head>
<body>
<?php include 'modules/header-bar.php'?>
<div class="content">
    <div class="table-wrapper">
        <div class="table-preface">
            <h2>Derzeitige Quarantänen</h2>
        </div>
        <table id="active-table" class="big-table">
            <thead>
                <tr>
                    <th onclick="sortTable(0, 'active-table')">Klasse</th>
                    <th onclick="sortTable(1, 'active-table')">Schüler</th>
                    <th onclick="sortTableByDate(2, 'active-table')">Seit</th>
                    <th onclick="sortTableByDate(3, 'active-table')">Bis</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($db->queryActiveQuarantinesGenerator() as $row) {
                    $qEnd = $row['qEnd'] ?? 'Unknown';
                    echo <<<END
                    <tr>
                        <td class="cell-clickable" onclick="window.location = '/overview/class.php?clID={$row['clID']}'">{$row['class']}</td>
                        <td class="cell-clickable" onclick="window.location = '/overview/student.php?stID={$row['stID']}'">{$row['lastName']} {$row['firstName']}</td>
                        <td>{$row['qStart']}</td>
                        <td>$qEnd</td>
                        <td>
                        <div class="table-icon-box">
                            <a href="edit/quarantine.php?id={$row['qtID']}"><img class="table-icon" src="src/edit.svg" alt="edit"></a>
                            <a href="actions/quarantine.php?action=delete&qtID={$row['qtID']}"><img class="table-icon" src="src/remove.svg" alt="remove"></a>
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