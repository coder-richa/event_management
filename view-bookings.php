<?php
$pageTitle = "Booking";
include_once './partials/common_includes/header.php';
include_once './classes/event.php';
include_once './classes/EventType.php';
include_once './classes/EventStatus.php';
include_once './classes/EventManager.php';
include_once './classes/EventImages.php';
include_once './classes/EventServicesDetails.php';
include_once './classes/Services.php';
$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
$event = Event::getById($id);
if (is_null($event)) {
    header("location: make-bookings.php");
}
$customer = Customer::getById($event->getCustomer_id());
$customerName = implode(" ", array($customer->getTitle(), $customer->getFirst_name(), $customer->getMiddle_name(), $customer->getLast_name()));
$eventManager = EventManager::getById($event->getEvent_manager_id());
$services = EventServicesDetails::getALL($id);
$servicesTitleArr = array();
$eventImages = EventImages::getAll($id);
foreach ($services as $key => $value) {
    $servicesTitleArr[] = Services::getById($value->getService_id())->getTitle();
}
?>
<main id="main" class="booking">
    <section>
        <div class="container" data-aos="fade-up">
            <div class="section-title">
                <h2>Booking Details</h2>
            </div>
            <div class="section-details">
                <div class="row">
                    <div class="col-sm-6" ><h3>Customer</h3></div>
                    <div class="col-sm-6" ><h3>Event Manager</h3></div>
                </div>
                <div class="row">
                    <div class="col-sm-6" >
                        <div class="row">
                            <div class="col-sm-6" ><b>Name</b></div>
                            <div class="col-sm-6" ><?= $customerName ?></div>
                            <div class="col-sm-6" ><b>Contact Number</b></div>
                            <div class="col-sm-6" ><?= $customer->getContact_number() ?></div>
                            <div class="col-sm-6" ><b>E-mail ID</b></div>
                            <div class="col-sm-6" ><?= $customer->getEmail_id() ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6" >
                        <?php if (!is_null($eventManager)) { ?>
                            <div class="row">

                            </div>
                            <div class="row">
                                <div class="col-sm-6" ><b>Name</b></div>
                                <div class="col-sm-6" ><?= implode(" ", array($eventManager->getTitle(), $eventManager->getFirst_name(), $eventManager->getMiddle_name(), $eventManager->getLast_name())) ?></div>
                                <div class="col-sm-6" ><b>Contact Number</b></div>
                                <div class="col-sm-6" ><?= $eventManager->getContact_number() ?></div>
                                <div class="col-sm-6" ><b>E-mail ID</b></div>
                                <div class="col-sm-6" ><?= $eventManager->getEmail_id() ?></div>
                            </div> 
                        <?php } ?>
                    </div>

                </div> 

                <div class="row">
                    <div class="col-sm-12" ><h3>Event</h3></div>
                </div>
                <div class="row">
                    <div class="col-sm-6" >
                        <div class="row">
                            <div class="col-sm-6" ><b>Type</b></div>
                            <div class="col-sm-6" ><?= EventType::getById($event->getType_id())->getTitle() ?></div>
                            <div class="col-sm-6" ><b>Status</b></div>
                            <div class="col-sm-6" ><?= EventStatus::getById($event->getStatus_id())->getTitle() ?></div>
                            <div class="col-sm-6" ><b>Booked for</b></div>
                            <div class="col-sm-6" ><?= date('M d, Y', strtotime($event->getEvent_start_on())) ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6" >
                        <div class="row">
                            <div class="col-sm-6" ><b>Services</b></div>
                            <div class="col-sm-6" ><?= implode("<br/> ", $servicesTitleArr) ?></div>
                        </div>
                    </div>
                </div> 
                <div class="row">

                </div>
                <?php if (count($eventImages) > 0) { ?>
                    <div class="row">
                        <div class="col-sm-12" ><h3>Gallery</h3></div>
                    </div>
                    <div class="row">
                        <?php foreach ($eventImages as $key => $eventImage) { ?>
                            <div class="col-sm-6" > <img class="img-fluid" src="uploads/<?= $eventImage->getImage_id() . "." . $eventImage->getImage_extension() ?>" alt="Image <?= $key + 1 ?>" /> </div>
                            <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>   
    </section>
</main>
<!-- End #main -->
<?php
include_once './partials/common_includes/footer.php';
?>        