<?php
include_once dirname(__FILE__) . '/../../../classes/EventType.php';
include_once dirname(__FILE__) . '/../../../classes/City.php';
include_once dirname(__FILE__) . '/../../../classes/EventStatus.php';
include_once dirname(__FILE__) . '/../../../classes/EventManager.php';
?> 
<div class="row form-row">
    <form action="<?= EVENT_GET_API_URL ?>" method="post"  class="searchFrm">
        <div class="row">
            <div class="col-sm-2 form-group">
                <input
                    type="text"
                    id="event_start_on"
                    name="event_start_on"
                    class="form-control"
                    placeholder="Start Date"
                    />
            </div>
            <div class="col-sm-2 form-group">
                <input
                    type="text"
                    id="event_end_on"
                    name="event_end_on"
                    class="form-control"
                    placeholder="End Date"
                    />
            </div>
            <div class="col-sm-2 form-group">
                <select id="type_id" name="type_id" class="form-control">
                    <option value="All">Event Type</option>
                    <?php
                    $eventTypes = EventType::getALL();
                    foreach ($eventTypes as $eventType) {
                        ?>
                        <option value="<?= $eventType->getType_id() ?>"><?= $eventType->getTitle() ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-2 form-group">
                <select id="city_id" name="city_id" class="form-control">
                    <option value="All">City</option>
                    <?php
                    $cities = City::getALL();
                    foreach ($cities as $city) {
                        ?>
                        <option value="<?= $city->getCity_id() ?>"><?= $city->getTitle() ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-2 form-group">
                <select id="status_id" name="status_id" class="form-control">
                    <option value="All">Event Status</option>
                    <?php
                    $statuses = EventStatus::getALL();
                    foreach ($statuses as $status) {
                        ?>
                        <option value="<?= $status->getStatus_id() ?>"><?= $status->getTitle() ?></option>
                    <?php } ?>
                </select>
            </div>
            <?php if ($_SESSION['USER_TYPE'] == ADMIN_USER) { ?>
                <div class="col-sm-2 form-group">
                    <select id="event_manager_id" name="event_manager_id" class="form-control">
                        <option value="All">Event Manager</option>
                        <?php
                        $managers = EventManager::getALL();
                        foreach ($managers as $manager) {
                            ?>
                            <option value="<?= $manager->getEvent_manager_id() ?>"><?= implode(" ", array($manager->getTitle(), $manager->getFirst_name(), $manager->getLast_name())) ?></option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
            <div class="col-sm-2 form-group">
                <button type="button" class="<?= FORM_SUBMIT_BTN_CLASS ?> searchTableBtn <?= $_SESSION['USER_TYPE'] == ADMIN_USER ? 'form-label' : '' ?>" data-target="#searchResult" >Search</button>
            </div>
        </div>
    </form>
</div>