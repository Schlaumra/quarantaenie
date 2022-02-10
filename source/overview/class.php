<?php
require_once '../inc/require.php';
use inc\db\QuarantaenieDB;
checkSession('/overview/class.php');
$db = new QuarantaenieDB();
$classID = $_GET['clID'] ?? null;
$_SESSION['backlink'] = "/overview/class.php?clID=$classID";
if(!$classID)
{
    header("HTTP/1.1 303 See Other");
    header("Location: /index.php");
    exit();
}
$classObj = $db->getClassById($classID);
if (!$classObj)
{
    header("HTTP/1.1 303 See Other");
    header("Location: /class.php");
    exit();
}
?>
<html lang="de">
<head>
    <title>Klasse</title>
    <?php include '../modules/header.php'?>
</head>
<body>
<?php include '../modules/header-bar.php'?>
<div class="content">
    <div class="table-wrapper">
        <div class="table-preface-overview">
            <div><h2>Klasse <?=$classObj['name']?></h2></div>
            <div class="overview-icons">
                <a href="/edit/class.php?id=<?=$classObj['id']?>"><img class="table-icon edit-icon" src="/src/edit.svg" alt="edit"></a>
                <a href="/create/student.php?clID=<?=$classObj['id']?>"><img class="table-icon" src="/src/add-student.svg" alt="add"></a>
                <a href="/actions/class.php?action=delete&clID=<?=$classObj['id']?>"><img class="table-icon" src="/src/remove.svg" alt="remove"></a>
            </div>
        </div>
        <table id="class-table" class="big-table">
            <thead>
            <tr>
                <th onclick="sortTable(0, 'class-table')">Vorname</th>
                <th onclick="sortTable(1, 'class-table')">Nachname</th>
                <th onclick="sortTableByNumber(2, 'class-table')">Insgesamt Quarantänen</th>
                <th onclick="sortTable(3, 'class-table')">In Quarantäne</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($db->queryStudentsByClassGenerator($classID) as $row) {
                $quarantine = $row['activeQT'] ? 'Ja' : 'Nein';
                $quarantine_highlight = $row['activeQT'] ? 'quarantine' : '';
                echo <<<END
                    <tr class="$quarantine_highlight" class="cell-clickable" onclick="window.location = '/overview/student.php?stID={$row['stID']}'">
                        <td>{$row['firstName']}</td>
                        <td>{$row['lastName']}</td>
                        <td>{$row['totalQT']}</td>
                        <td>$quarantine</td>
                        <td>
                        <div class="table-icon-box">
                            <a href="/edit/student.php?id={$row['stID']}"><img class="table-icon edit-icon" src="/src/edit.svg" alt="edit"></a>
                            <a href="/create/quarantine.php?stID={$row['stID']}"><img class="table-icon" src="/src/add-quarantine.svg" alt="add"></a>
                            <a href="/actions/student.php?action=delete&stID={$row['stID']}"><img class="table-icon" src="/src/remove.svg" alt="remove"></a>
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