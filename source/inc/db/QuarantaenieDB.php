<?php

namespace inc\db;

require_once 'DB.php';

use Exception;
use Generator;

/*********************************
 *          Credentials          *
 *********************************/
const dbName = 'quarantaenie';
const dbUser = 'quarantine';
const dbPassword = 'Kennwort0';
const dbHost = 'localhost';
const dbPort = 3307;

class QuarantaenieDB extends DB
{
    public function __construct()
    {
        // Init db class with the values
        parent::__construct(dbName, dbUser, dbPassword, dbHost, dbPort);
    }

    /*********************************
     *             Class             *
     *********************************/

    /**
     * Get all rows from the class table.
     *
     * @return Generator Iterator for returning row by row.
     */
    public function queryClassGenerator(): Generator
    {
        return $this->query('SELECT * FROM class');
    }

    /**
     * Get the class by its ID.
     *
     * ATTENTION: Returns NULL if a wrong ID is provided.
     *
     * @param int $id => The class ID
     * @return array|NULL => The row as a result
     */
    public function getClassById(int $id): ?array
    {
        $query = 'SELECT * FROM class WHERE id = :id';
        return $this->query($query, ['id' => $id])->current();
    }

    /**
     * Check the validity of the values.
     *
     * @param string $name => The name of the class
     * @return void
     * @throws Exception => If the name is longer than 100 chars
     */
    private function checkClassValues(string $name): void
    {
        if (!strlen($name) > 100)
            throw new Exception('Name is longer than 100 chars');
    }

    /**
     * Insert a class with the provided values.
     *
     * @param string $name => The name of the class
     * @return int|null The ID or NULL if it fails
     * @throws Exception => If the name is longer than 100 chars
     */
    public function insertClass(string $name): ?int
    {
        $this->checkClassValues($name);
        $query = 'INSERT INTO class(name) VALUES (:name) RETURNING id';
        return $this->query($query, ['name' => $name])->current()['id'] ?? NULL;
    }

    /**
     * Delete a class by the provided ID.
     *
     * @param int $id => The ID of the wanted class.
     * @return void
     */
    public function deleteClassById(int $id): void
    {
        $query = 'DELETE FROM class WHERE id = :id';
        $this->query($query, ['id' => $id])->next();
    }

    /**
     * Update a class by its ID.
     *
     * @param int $id => The ID
     * @param string $name => The name of the class
     * @return void
     * @throws Exception => If the name is longer than 100 chars
     */
    public function updateClassById(int $id, string $name): void
    {
        $this->checkClassValues($name);
        $query = 'UPDATE class SET name=:name WHERE id = :id';
        $this->query($query, ['id' => $id, 'name' => $name])->next();
    }

    /*********************************
     *            Student            *
     *********************************/

    /**
     * Get all rows from the student table.
     *
     * @return Generator Iterator for returning row by row.
     */
    public function queryStudentGenerator(): Generator
    {
        $query = 'SELECT * FROM student';
        return $this->query($query);
    }

    /**
     * Get the student by its ID.
     *
     * ATTENTION: Returns NULL if a wrong ID is provided.
     *
     * @param int $id => The student ID
     * @return array|NULL => The row as a result or NULL
     */
    public function getStudentById(int $id): ?array
    {
        $query = 'SELECT * FROM student WHERE id = :id';
        return $this->query($query, ['id' => $id])->current();
    }

    /**
     * Check the validity of the values.
     *
     * @param string $firstName => The firstname of the student
     * @param string $lastName => The lastname of the student
     * @param int $class_fk => The foreign key for the class
     * @return void
     * @throws Exception => firstname or lastname is longer than 100 chars | class_fk is negative
     */
    private function checkStudentValues(string $firstName, string $lastName, int $class_fk): void
    {
        if (!strlen($firstName) > 100)
            throw new Exception('FirstName is longer than 100 chars');
        if (!strlen($lastName) > 100)
            throw new Exception('LastName is longer than 100 chars');
        if ($class_fk < 0)
            throw new Exception('Class_fk is negative');
    }

    /**
     * Insert a student with the provided values.
     *
     * @param string $firstName => The firstname of the student
     * @param string $lastName => The lastname of the student
     * @param int $class_fk => The foreign key for the class
     * @return int|null The id of the created student or NULL if it fails
     * @throws Exception => firstname or lastname is longer than 100 chars | class_fk is negative
     */
    public function insertStudent(string $firstName, string $lastName, int $class_fk): ?int
    {
        $this->checkStudentValues($firstName, $lastName, $class_fk);
        $query = 'INSERT INTO student(firstName, lastName, class_fk) VALUES (:firstName, :lastName, :classFK) RETURNING id';
        return $this->query($query, ['firstName' => $firstName, 'lastName' => $lastName, 'classFK' => $class_fk])->current()['id'] ?? NULL;
    }

    /**
     * Delete a student by the provided ID.
     *
     * @param int $id => The ID of the wanted student.
     * @return void
     */
    public function deleteStudentById(int $id): void
    {
        $query = 'DELETE FROM student WHERE id = :id';
        $this->query($query, ['id' => $id])->next();
    }

    /**
     * Update a student by its ID.
     *
     * @param int $id => The ID
     * @param string $firstName => The firstname of the student
     * @param string $lastName => The lastname of the student
     * @param int $class_fk => The foreign key for the class
     * @return void
     * @throws Exception => firstname or lastname is longer than 100 chars | class_fk is negative
     */
    public function updateStudentById(int $id, string $firstName, string $lastName, int $class_fk): void
    {
        $this->checkStudentValues($firstName, $lastName, $class_fk);
        $query = 'UPDATE student SET firstName=:firstName, lastName=:lastName, class_fk=:classFK WHERE id = :id';
        $this->query($query, ['id' => $id, 'firstName' => $firstName, 'lastName' => $lastName, 'classFK' => $class_fk])->next();
    }

    /**
     * Opt all students from a class out. Provided by the class ID.
     * To remove all relation to a class to delete it.
     *
     * @param int $class_id => The ID of the class
     * @return void
     */
    public function optStudentOutOfClass(int $class_id): void
    {
        $query = 'UPDATE student SET class_fk=NULL WHERE class_fk = :id';
        $this->query($query, ['id' => $class_id])->next();
    }

    /*********************************
     *           Quarantine          *
     *********************************/

    /**
     * Get all rows from the quarantine table.
     *
     * @return Generator Iterator for returning row by row.
     */
    public function queryQuarantineGenerator(): Generator
    {
        $query = 'SELECT * FROM quarantine';
        return $this->query($query);
    }

    /**
     * Get the quarantine by its ID.
     *
     * ATTENTION: Returns NULL if a wrong ID is provided.
     *
     * @param int $id => The quarantine ID
     * @return array|NULL => The row as a result or NULL
     */
    public function getQuarantineById(int $id): ?array
    {
        $query = 'SELECT * FROM quarantine WHERE id = :id';
        return $this->query($query, ['id' => $id])->current();
    }

    /**
     * Check the validity of the values.
     *
     * @param string $qStart => The start date of the quarantine
     * @param string $qEnd => The end date of the quarantine
     * @param int $student_fk => The foreign key for the student
     * @return void
     * @throws Exception => If qEnd is before qStart | student_fk is negative
     */
    private function checkQuarantineValues(string $qStart, string $qEnd, int $student_fk)
    {
        if (!($qStart < $qEnd))
            throw new Exception("qEnd is before qStart");

        if ($student_fk < 0)
            throw new Exception("Student_fk is negative");
    }

    /**
     * Insert a quarantine with the provided values.
     *
     * @param string $qStart => The start date of the quarantine
     * @param string $qEnd => The end date of the quarantine
     * @param int $student_fk => The foreign key for the student
     * @return int|null The id of the created quarantine or null if it fails.
     * @throws Exception => If qEnd is before qStart | student_fk is negative
     */
    public function insertQuarantine(string $qStart, string $qEnd, int $student_fk): ?int
    {
        if ($qStart and $qEnd and $student_fk) {
            $this->checkQuarantineValues($qStart, $qEnd, $student_fk);
            $query = 'INSERT INTO quarantine(qStart, qEnd, student_fk) VALUES (:qStart, :qEnd, :studentFK) RETURNING id';
            return $this->query($query, ['qStart' => $qStart, 'qEnd' => $qEnd, 'studentFK' => $student_fk])->current()['id'] ?? null;
        } else {
            throw new Exception('qStart, qEnd or student_fk is NULL');
        }
    }

    /**
     * Delete a quarantine by the provided ID.
     *
     * @param int $id => The ID of the wanted quarantine.
     * @return void
     */
    public function deleteQuarantineById(int $id): void
    {
        $query = 'DELETE FROM quarantine WHERE id = :id';
        $this->query($query, ['id' => $id])->next();
    }

    /**
     * Update a quarantine by its ID.
     *
     * @param int $id => The ID
     * @param string $qStart => The start date of the quarantine
     * @param string $qEnd => The end date of the quarantine
     * @param int $student_fk => The foreign key for the student
     * @return void
     * @throws Exception => If qEnd is before qStart | student_fk is negative
     */
    public function updateQuarantineById(int $id, string $qStart, string $qEnd, int $student_fk)
    {
        $this->checkQuarantineValues($qStart, $qEnd, $student_fk);
        $query = 'UPDATE quarantine SET qStart=:qStart, qEnd=:qEnd, student_fk=:studentFK WHERE id = :id';
        $this->query($query, ['id' => $id, 'qStart' => $qStart, 'qEnd' => $qEnd, 'studentFK' => $student_fk])->next();
    }

    /**
     * Delete all quarantines associated with student ID.
     *
     * @param int $studentID => The ID of the student.
     * @return void
     */
    public function deleteQuarantineByStudentId(int $studentID)
    {
        $query = 'DELETE FROM quarantine WHERE student_fk = :id';
        $this->query($query, ['id' => $studentID])->next();
    }

    /*********************************
     *             Custom            *
     *********************************/

    /**
     * Get all active quarantines (QEnd after today or qEnd is NULL).
     *
     * | clID | class | stID | firstName | lastName | qtID | qStart | qEnd |
     *
     * @return Generator => Get it row by row
     */
    public function queryActiveQuarantinesGenerator(): Generator
    {
        $query = 'SELECT cl.id AS clID, cl.name AS class, st.id AS stID, st.firstName, st.lastName, qt.id AS qtID, qt.qStart, qt.qEnd
                    FROM student st
                    LEFT JOIN class cl
                    ON (cl.id = st.class_fk)
                    LEFT JOIN quarantine qt
                    ON (st.id = qt.student_fk)
                    WHERE ((qt.qEnd >= CURRENT_DATE() OR qt.qEnd IS NULL) AND qt.qStart IS NOT NULL)
                    ORDER BY cl.name';
        return $this->query($query);
    }

    /**
     * Query All Quarantines.
     *
     * | clID | class | stID | firstName | lastName | qtID | qStart | qEnd | activeQT |
     *
     * @return Generator
     */
    public function queryAllQuarantinesGenerator(): Generator
    {
        $query = 'SELECT
                        cl.id AS clID,
                        cl.name AS class,
                        st.id AS stID,
                        st.firstName,
                        st.lastName,
                        qt.id AS qtID,
                        qt.qStart,
                        qt.qEnd,
                        SUM(qt.qEnd >= CURRENT_DATE() OR (qt.qEnd IS NULL AND qt.qStart IS NOT NULL)) AS activeQT
                    FROM student st
                    LEFT JOIN class cl
                    ON (cl.id = st.class_fk)
                    LEFT JOIN quarantine qt
                    ON (st.id = qt.student_fk)
                    WHERE qt.student_fk = st.id
                    GROUP BY qt.id
                    ORDER BY cl.name';
        return $this->query($query);
    }

    /**
     * Get All Quarantines filtered by Student.
     *
     * | qtID | qStart | qEnd | active |
     *
     * @param int $studentID
     * @return Generator
     */
    public function queryAllQuarantinesByStudentGenerator(int $studentID): Generator
    {
        $query = 'SELECT
                        qt.id AS qtID,
                        qt.qStart,
                        qt.qEnd,
                        qt.qEnd >= CURRENT_DATE() OR (qt.qEnd IS NULL AND qt.qStart IS NOT NULL) AS active
                    FROM quarantine qt
                    WHERE qt.student_fk = :id';
        return $this->query($query, ['id' => $studentID]);
    }

    /**
     * Get all students.
     *
     * | stID | clID | class | firstName | lastName | totalQT | activeQT |
     *
     * @return Generator
     */
    public function queryAllStudentsGenerator(): Generator
    {
        $query = 'SELECT
                        st.id AS stID,
                        cl.id AS clID,
                        cl.name AS class,
                        st.firstName,
                        st.lastName,
                        COUNT(DISTINCT qt.id) AS totalQT,
                        IF(SUM(qt.qEnd >= CURRENT_DATE() OR (qt.qEnd IS NULL AND qt.qStart IS NOT NULL)) > 0, TRUE, FALSE) AS activeQT
                    FROM student st
                    LEFT JOIN quarantine qt
                    ON (st.id = qt.student_fk)
                    LEFT JOIN class cl
                    ON (cl.id = st.class_fk)
                    GROUP BY st.id
                    ORDER BY cl.name';
        return $this->query($query);
    }

    /**
     * Get Students with the class filter.
     *
     * | stID | firstName | lastName | totalQT | activeQT |
     *
     * @param $classID
     * @return Generator
     */
    public function queryStudentsByClassGenerator($classID): Generator
    {
        $query = 'SELECT
                        st.id AS stID,
                        st.firstName,
                        st.lastName,
                        COUNT(DISTINCT qt.id) AS totalQT,
                        IF(SUM(qt.qEnd >= CURRENT_DATE() OR (qt.qEnd IS NULL AND qt.qStart IS NOT NULL)) > 0, TRUE, FALSE) AS activeQT
                    FROM student st
                    LEFT JOIN quarantine qt
                    ON (st.id = qt.student_fk)
                    LEFT JOIN class cl
                    ON (cl.id = st.class_fk)
                    WHERE cl.id = :id
                    GROUP BY st.id
                    ORDER BY cl.name';
        return $this->query($query, ['id' => $classID]);
    }

    /**
     * Get all classes.
     *
     * | clID | name | totalST | totalQT | activeQT |
     *
     * @return Generator
     */
    public function queryAllClassesGenerator(): Generator
    {
        $query = 'SELECT
                        cl.id AS clID,
                        cl.name,
                        count(DISTINCT st.id) as totalST,
                        COUNT(DISTINCT qt.id) AS totalQT,
                        COALESCE(SUM(qt.qEnd >= CURRENT_DATE() OR (qt.qEnd IS NULL AND qt.qStart IS NOT NULL)), 0) AS activeQT
                    FROM class cl
                    LEFT JOIN student st ON (cl.id = st.class_fk)
                    LEFT JOIN quarantine qt ON (st.id = qt.student_fk)
                    GROUP BY cl.id';
        return $this->query($query);
    }
}