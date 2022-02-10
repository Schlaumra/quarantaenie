<?php
require_once 'inc/require.php';
use inc\db\QuarantaenieDB;
checkSession('/class.php');
$db = new QuarantaenieDB();
$_SESSION['backlink'] = '/class.php';
?>
<html lang="de">
<head>
    <title>Klassen</title>
    <?php include 'modules/header.php'?>
</head>
<body>
<?php include 'modules/header-bar.php'?>
<div class="content">
    <div class="table-wrapper">
        <div class="table-preface">
            <div><h2>Alle Klassen</h2></div>
            <div class="button-wrapper">
                <a href="create/class.php" class="button">Klasse hinzufügen</a>
            </div>
        </div>
        <table id="class-table" class="big-table">
            <thead>
            <tr>
                <th onclick="sortTable(0, 'class-table')">Name</th>
                <th onclick="sortTableByNumber(1, 'class-table')">Schüler</th>
                <th onclick="sortTableByNumber(2, 'class-table')">Davon in Quarantäne</th>
                <th onclick="sortTableByNumber(3, 'class-table')">%</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
                <?php
                foreach ($db->queryAllClassesGenerator() as $row) {
                    $percent = (int) (($row['totalST'] != 0) ? (100 / $row['totalST'] * $row['activeQT']) : 0);
                    $quarantine_highlight = $percent >= 50 ? 'quarantine' : '';
                    echo <<<END
                    <tr class="$quarantine_highlight">
                        <td class="cell-clickable" onclick="window.location = '/overview/class.php?clID={$row['clID']}'">{$row['name']}</td>
                        <td>{$row['totalST']}</td>
                        <td>{$row['activeQT']}</td>
                        <td>$percent</td>
                        <td>
                            <div class="table-icon-box">
                                <a href="edit/class.php?id={$row['clID']}"><img class="table-icon edit-icon" src="src/edit.svg" alt="edit"></a>
                                <a href="create/student.php?clID={$row['clID']}"><img class="table-icon" src="src/add-student.svg" alt="add"></a>
                                <a href="actions/class.php?action=delete&clID={$row['clID']}"><img class="table-icon" src="src/remove.svg" alt="remove"></a>
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