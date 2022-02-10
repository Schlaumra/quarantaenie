<?php
require_once '../inc/require.php';
use inc\db\QuarantaenieDB;
checkSession('/overview/student.php');
$db = new QuarantaenieDB();
$studentID = $_GET['stID'] ?? null;
$_SESSION['backlink'] = "/overview/student.php?stID=$studentID";
if(!$studentID)
{
    header("HTTP/1.1 303 See Other");
    header("Location: /index.php");
    exit();
}
$studentObj = $db->getStudentById($studentID);
if (!$studentObj)
{
    header("HTTP/1.1 303 See Other");
    header("Location: /student.php");
    exit();
}
?>
<html lang="de">
<head>
    <title>Schüler</title>
    <?php include '../modules/header.php'?>
</head>
<body>
<?php include '../modules/header-bar.php'?>
<div class="content">
    <div class="table-wrapper">
        <div class="table-preface-overview">
            <div><h2><?=$studentObj['lastName'] . ' ' . $studentObj['firstName'] . ' - ' . $db->getClassById($studentObj['class_fk'])['name']?></h2></div>
            <div class="overview-icons">
                <a href="/edit/student.php?id=<?=$studentObj['id']?>"><img class="table-icon edit-icon" src="/src/edit.svg" alt="edit"></a>
                <a href="/create/quarantine.php?stID=<?=$studentObj['id']?>"><img class="table-icon" src="/src/add-quarantine.svg" alt="add"></a>
                <a href="/actions/student.php?action=delete&stID=<?=$studentObj['id']?>"><img class="table-icon" src="/src/remove.svg" alt="remove"></a>
            </div>
        </div>
        <table id="student-table" class="big-table">
            <thead>
            <tr>
                <th onclick="sortTableByDate(0, 'student-table')">Seit</th>
                <th onclick="sortTableByDate(1, 'student-table')">Bis</th>
                <th onclick="sortTable(2, 'student-table')">Aktiv</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            <?php
            foreach ($db->queryAllQuarantinesByStudentGenerator($studentID) as $row) {
                $quarantine = $row['active'] ? 'Ja' : 'Nein';
                $quarantine_highlight = $row['active'] ? 'quarantine' : '';
                echo <<<END
                    <tr class="$quarantine_highlight" class="cell-clickable" onclick="window.location = '/edit/quarantine.php?id={$row['qtID']}'">
                        <td>{$row['qStart']}</td>
                        <td>{$row['qEnd']}</td>
                        <td>$quarantine</td>
                        <td>
                        <div class="table-icon-box">
                            <a href="/actions/quarantine.php?action=delete&qtID={$row['qtID']}"><img class="table-icon" src="/src/remove.svg" alt="remove"></a>
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