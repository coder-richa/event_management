<?php

include_once dirname(__FILE__) . '/DBHelper.php';
include_once dirname(__FILE__) . '/Model.php';
include_once dirname(__FILE__) . '/Customer.php';
include_once dirname(__FILE__) . '/UserHelper.php';

class EventManager extends Model {

    // instance variables
    var $title, $first_name, $middle_name, $last_name, $contact_number, $password, $email_id, $joined_on, $event_manager_id;
    // class variable
    static $table = EVENT_MANAGER_TBL;

    use UserHelper;
    // constructor
    function __construct($title="", $first_name="", $middle_name="", $last_name="", $contact_number="", $password="", $email_id="", $joined_on = "", $event_manager_id = Null) {
        $this->title = $title;
        $this->first_name = $first_name;
        $this->middle_name = $middle_name;
        $this->last_name = $last_name;
        $this->contact_number = $contact_number;
        $this->password = $password;
        $this->email_id = $email_id;
        $this->joined_on = empty($joined_on) ? date('Y-m-d H:i:s') : $joined_on;
        $this->event_manager_id = $event_manager_id;
    }
    // getters and setters
    function getTitle() {
        return $this->title;
    }

    function getFirst_name() {
        return $this->first_name;
    }

    function getMiddle_name() {
        return $this->middle_name;
    }

    function getLast_name() {
        return $this->last_name;
    }

    function getContact_number() {
        return $this->contact_number;
    }

    function getPassword() {
        return $this->password;
    }

    function getEmail_id() {
        return $this->email_id;
    }

    function getJoined_on() {
        return $this->joined_on;
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function setFirst_name($first_name) {
        $this->first_name = $first_name;
    }

    function setMiddle_name($middle_name) {
        $this->middle_name = $middle_name;
    }

    function setLast_name($last_name) {
        $this->last_name = $last_name;
    }

    function setContact_number($contact_number) {
        $this->contact_number = $contact_number;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setEmail_id($email_id) {
        $this->email_id = $email_id;
    }

    function setJoined_on($joined_on) {
        $this->joined_on = $joined_on;
    }

    function getEvent_manager_id() {
        return $this->event_manager_id;
    }

    function setEvent_manager_id($event_manager_id) {
        $this->event_manager_id = $event_manager_id;
    }

// Returns all Record
    static function getALL($first_name = "", $last_name = "", $contact_number = "", $email = "") {
        $db = new DBHelper();
        $condition = array();
        if (!empty($first_name)) {
            $condition[] = " a.first_name LIKE '%" . $first_name . "%' ";
        }
        if (!empty($last_name)) {
            $condition[] = " a.last_name LIKE '%" . $last_name . "%' ";
        }
        if (!empty($contact_number)) {
            $condition[] = " a.contact_number LIKE '%" . $contact_number . "%' ";
        }
        if (!empty($email)) {
            $condition[] = " a.email_id LIKE '%" . $email . "%' ";
        }
        $cond = count($condition) == 0 ? "" : "WHERE " . implode(" AND ", $condition);
        $query = "SELECT * FROM " . self::$table . " a $cond"
                . " ORDER BY a.event_manager_id desc";
        $result = $db->select($query);
        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = new EventManager($row['title'], $row['first_name'], $row['middle_name'], $row['last_name'], $row['contact_number'], $row['password'], $row['email_id'], $row['joined_on'], $row['event_manager_id']);
        }
        $db->closeConnection();
        return $data;
    }
 // Delete Record
    static function delete($id) {
        $db = new DBHelper();
        $query = "DELETE FROM " . self::$table . " WHERE event_manager_id = ?";
        $param = array($id);
        $db->update_delete($query, $param);
        $db->closeConnection();
    }

// Insert / Update Record
    function save() {
        $isAddOperation = $this->getEvent_manager_id() < 1;
        $isExistingRecord = self::isExistingEmail($this->getEmail_id());
        $existingRecord = self::getByEmail($this->getEmail_id());
        if (!((!$isExistingRecord) || ($isExistingRecord && ($existingRecord != NULL && $this->getEvent_manager_id() == $existingRecord->getEvent_manager_id() ) ) )) {
            $this->setEvent_manager_id(-1);
            return;
        }
        $db = new DBHelper();
        if ($isAddOperation) {
            $query = "INSERT INTO " . self::$table . " (event_manager_id, title, first_name, middle_name, last_name, contact_number, password, email_id, joined_on) "
                    . "VALUES (NULL,?,?,?,?,?,?,?,?)";
            $param = array($this->getTitle(), $this->getFirst_name(), $this->getMiddle_name(), $this->getLast_name(), $this->getContact_number(), $this->getPassword(), $this->getEmail_id(), $this->getJoined_on());
            $this->setEvent_manager_id($db->insert($query, $param));
        } else {
            $query = "UPDATE " . self::$table . " SET title=?, first_name=?, middle_name=?, last_name=?, contact_number=?, password=?, email_id=? "
                    . "WHERE event_manager_id = ?";
            $param = array($this->getTitle(), $this->getFirst_name(), $this->getMiddle_name(), $this->getLast_name(), $this->getContact_number(), $this->getPassword(), $this->getEmail_id(), $this->getEvent_manager_id());
            $db->update_delete($query, $param);
        }

        $db->closeConnection();
    }

    // returns record with email id
    static function getByEmail($email) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table
                . " WHERE email_id=?";
        $result = $db->select($query, array($email));
        $manager = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $manager = new EventManager($row['title'], $row['first_name'], $row['middle_name'], $row['last_name'], $row['contact_number'], $row['password'], $row['email_id'], $row['joined_on'], $row['event_manager_id']);
        }
        $db->closeConnection();
        return $manager;
    }

// return record by id
    static function getById($id) {
        $db = new DBHelper();
        $query = "SELECT * FROM " . self::$table
                . " WHERE event_manager_id=?";
        $result = $db->select($query, array($id));
        $rec = NULL;
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $rec = new EventManager($row['title'], $row['first_name'], $row['middle_name'], $row['last_name'], $row['contact_number'], $row['password'], $row['email_id'], $row['joined_on'], $row['event_manager_id']);
        }
        $db->closeConnection();
        return $rec;
    }

    // Returns Table element with state data for JSON representation
    static function getTableData($first_name = "", $last_name = "", $contact_number = "", $email = "") {
        $headings = array("SR No.", "Title", "First Name", "Middle Name", "Last Name", "Email ID", "Contact No.", "Edit","Delete");
        $data = array();
        $records = self::getALL($first_name, $last_name, $contact_number, $email);
        foreach ($records as $key => $record) {
            $data[] = array($key + 1, $record->getTitle(), $record->getFirst_name(), $record->getMiddle_name(), $record->getLast_name(), $record->getEmail_id(), 
                $record->getContact_number(), self::createSpanWithLink($record->getEvent_manager_id(), EVENT_MANAGER_SAVE_FORM_API_URL),
                self::createSpanWithLink($record->getEvent_manager_id(), EVENT_MANAGER_DELETE_API_URL, "Delete", "delete"));
        }
        return self::getTableJSON($headings, $data);
    }

    // returns save form for add/edit records
    static function saveFormData($id = 0) {
        $obj = $id < 1 ? NULL : self::getById($id);
        $title = is_null($obj) ? "" : $obj->getTitle();
        $first_name = is_null($obj) ? "" : $obj->getFirst_name();
        $middle_name = is_null($obj) ? "" : $obj->getMiddle_name();
        $last_name = is_null($obj) ? "" : $obj->getLast_name();
        $contact_number = is_null($obj) ? "" : $obj->getContact_number();
        $email_id = is_null($obj) ? "" : $obj->getEmail_id();
        $password = is_null($obj) ? "" : $obj->getPassword();
        $form = self::createForm("saveForm", "saveForm", EVENT_MANAGER_SAVE_API_URL);
        $form->addChild(self::getFormInputField("id", "id", $id, "hidden"));
        $options = array();
        $options["Mr."] = "Mr.";
        $options["Mrs."] = "Mrs.";
        $options["Ms."] = "Ms.";
        $titleColumn = self::getColumnWithFormField(self::getFormSelectField("title", "title", $options, $title, TRUE, "checkNonEmpty", "every"), self::createLabel("Title", array("for" => "title", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL6_CLASS);
        $firstNameColumn = self::getColumnWithFormField(self::getFormInputField("first_name", "first_name", $first_name, "text", TRUE, "lettersAndSpaces", "checkNonEmpty,checkName", "every", "name"), self::createLabel("First Name", array("for" => "first_name", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL6_CLASS);

        $middleNameColumn = self::getColumnWithFormField(self::getFormInputField("middle_name", "middle_name", $middle_name, "text", TRUE, "lettersAndSpaces", "checkEmpty,checkName", "some", "name"), self::createLabel("Middle Name", array("for" => "middle_name", "class" => FORM_LABEL_CLASS)), COL6_CLASS);
        $lastNameColumn = self::getColumnWithFormField(self::getFormInputField("last_name", "last_name", $last_name, "text", TRUE, "lettersAndSpaces", "checkNonEmpty,checkName", "every", "name"), self::createLabel("Last Name", array("for" => "last_name", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL6_CLASS);

        $emailNameColumn = self::getColumnWithFormField(self::getFormInputField("email_id", "email_id", $email_id, "text", TRUE, "email", "checkNonEmpty,checkEmail", "every", "email"), self::createLabel("E-mail ID", array("for" => "email_id", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL6_CLASS);
        $passwordNameColumn = self::getColumnWithFormField(self::getFormInputField("password", "password", $password, "text", TRUE, "password", "checkNonEmpty", "every", "password"), self::createLabel("Password", array("for" => "password", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL6_CLASS);

        $contactNumberColumn = self::getColumnWithFormField(self::getFormInputField("contact_number", "contact_number", $contact_number, "text", TRUE, "phone", "checkNonEmpty,checkPhone", "every", "phone"), self::createLabel("Contact Number", array("for" => "contact_number", "class" => FORM_LABEL_CLASS . " " . IS_REQUIRED_CLASS)), COL6_CLASS);

        $buttonColumn = self::getColumnWithFormField(self::getFormButton("saveBtn", "Save"), NULL, COL12_CLASS);
        $form->addChild(self::createRow(array($titleColumn, $firstNameColumn)));
        $form->addChild(self::createRow(array($middleNameColumn, $lastNameColumn)));
        $form->addChild(self::createRow(array($emailNameColumn, $passwordNameColumn)));
        $form->addChild(self::createRow(array($contactNumberColumn)));
        $form->addChild(self::createRow(array($buttonColumn)));
        return $form;
        return self::createAddEditTitleForm(EVENT_STATUS_SAVE_API_URL, $id, $title);
    }

}

?>