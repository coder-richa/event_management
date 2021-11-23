DROP  DATABASE IF EXISTS event_management;
CREATE  DATABASE IF NOT EXISTS event_management;
CREATE TABLE IF NOT EXISTS `event_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL, 
  PRIMARY KEY (type_id)
) ;

CREATE TABLE IF NOT EXISTS `event_status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(15) NOT NULL, 
  PRIMARY KEY (status_id)
) ;

CREATE TABLE IF NOT EXISTS `services` (
  `service_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `icon` VARCHAR(20) NOT NULL,
  `description` VARCHAR(300) NOT NULL, 
  PRIMARY KEY (service_id)
) ;

CREATE TABLE IF NOT EXISTS `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL, 
  PRIMARY KEY (state_id)
) ;

CREATE TABLE IF NOT EXISTS `city` (
  `city_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL, 
  `state_id` int(11) NOT NULL,
  PRIMARY KEY (city_id),
  FOREIGN KEY (state_id) REFERENCES state(state_id) ON DELETE CASCADE
) ;

CREATE TABLE IF NOT EXISTS `event_manager` (
  `event_manager_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL, 
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `contact_number` varchar(10) NOT NULL, 
  `password` varchar(50) NOT NULL,  
  `email_id` varchar(25) NOT NULL,
  `joined_on` datetime DEFAULT current_timestamp(),
   PRIMARY KEY (event_manager_id)
);
ALTER TABLE `event_manager` ADD UNIQUE(`email_id`);
CREATE TABLE IF NOT EXISTS `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) NOT NULL, 
  `first_name` varchar(25) NOT NULL,
  `middle_name` varchar(25) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `contact_number` varchar(10) NOT NULL, 
  `password` varchar(50) NOT NULL, 
  `email_id` varchar(25) NOT NULL,
  `joined_on` datetime DEFAULT current_timestamp(),
   PRIMARY KEY (customer_id)
); 
ALTER TABLE `customer` ADD UNIQUE(`email_id`);
CREATE TABLE IF NOT EXISTS `customer_address_details` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `street_no` varchar(50) NOT NULL, 
  `customer_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `pincode` varchar(6) NOT NULL,
   PRIMARY KEY (address_id),
   FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE,
   FOREIGN KEY (city_id) REFERENCES city(city_id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS `event` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL,
  `event_manager_id` int(11) DEFAULT NULL,
  `description` text NOT NULL,
  `special_requirement` varchar(250) DEFAULT NULL ,  
  `type_id` int(11) NOT NULL,
  `status_id` int(11) DEFAULT 1,
  `event_start_on` datetime DEFAULT current_timestamp(),
  `event_end_on` datetime DEFAULT current_timestamp(),  
  `booked_on` datetime DEFAULT current_timestamp(),
   PRIMARY KEY (event_id),
   FOREIGN KEY (customer_id) REFERENCES customer(customer_id) ON DELETE CASCADE,
   FOREIGN KEY (event_manager_id) REFERENCES event_manager(event_manager_id) ON DELETE CASCADE,
   FOREIGN KEY (type_id) REFERENCES event_type(type_id) ON DELETE CASCADE,
   FOREIGN KEY (status_id) REFERENCES event_status(status_id) ON DELETE CASCADE
); 

CREATE TABLE IF NOT EXISTS `event_services_details` (
  `event_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
   FOREIGN KEY (event_id) REFERENCES event(event_id) ON DELETE CASCADE,
   FOREIGN KEY (service_id) REFERENCES services(service_id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS `event_location_details` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `street_no` varchar(50) NOT NULL, 
  `event_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `pincode` varchar(6) NOT NULL,
   PRIMARY KEY (location_id),
   FOREIGN KEY (event_id) REFERENCES event(event_id) ON DELETE CASCADE,
   FOREIGN KEY (city_id) REFERENCES city(city_id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS `event_images` (
  `image_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `image_extension` varchar(5) DEFAULT NULL,
   PRIMARY KEY (image_id),
   FOREIGN KEY (event_id) REFERENCES event(event_id) ON DELETE CASCADE  
);


INSERT INTO `state` (`state_id`, `title`) VALUES(1, 'Queensland');
INSERT INTO `state` (`state_id`, `title`) VALUES(2, 'South Australia');
INSERT INTO `state` (`state_id`, `title`) VALUES(3, 'Tasmania');
INSERT INTO `state` (`state_id`, `title`) VALUES(4, 'Victoria');
INSERT INTO `state` (`state_id`, `title`) VALUES(5, 'Western Australia');

INSERT INTO `city` (`city_id`, `title`, `state_id`) VALUES(1, 'Brisbane', 1);
INSERT INTO `city` (`city_id`, `title`, `state_id`) VALUES(2, 'Gladstone', 1);
INSERT INTO `city` (`city_id`, `title`, `state_id`) VALUES(3, 'Gold Coast', 1);
INSERT INTO `city` (`city_id`, `title`, `state_id`) VALUES(4, 'Mackay', 1);
INSERT INTO `city` (`city_id`, `title`, `state_id`) VALUES(5, 'Caloundra', 1);

INSERT INTO `event_status` (`status_id`, `title`) VALUES(1, 'Booked');
INSERT INTO `event_status` (`status_id`, `title`) VALUES(2, 'Assigned');
INSERT INTO `event_status` (`status_id`, `title`) VALUES(3, 'Cancelled');
INSERT INTO `event_status` (`status_id`, `title`) VALUES(4, 'Completed');


INSERT INTO `event_type` (`type_id`, `title`) VALUES(1, 'Birthday Party');
INSERT INTO `event_type` (`type_id`, `title`) VALUES(2, 'Marriage');
INSERT INTO `event_type` (`type_id`, `title`) VALUES(3, 'Group Meeting');
INSERT INTO `event_type` (`type_id`, `title`) VALUES(4, 'Marriage Anniversary');

INSERT INTO `services` (`service_id`, `title`, `icon`, `description`) VALUES(1, 'Hiring a Caterer', 'bx bx-dish', 'We provide best catering services in the region for the event.');
INSERT INTO `services` (`service_id`, `title`, `icon`, `description`) VALUES(2, 'Reserve Location', 'bx bx-map', 'We can make an arrangement for the location booking based on the customer requirements.');
INSERT INTO `services` (`service_id`, `title`, `icon`, `description`) VALUES(3, 'Customized Food Menu', 'bx bx-food-menu', 'We can make an arrangement for the variety of cuisines based on the customer requirements.');
INSERT INTO `services` (`service_id`, `title`, `icon`, `description`) VALUES(4, 'Selecting a theme', 'bx bxs-smile', 'We can make an arrangement for the variety of themes based on the customer requirements.');
INSERT INTO `services` (`service_id`, `title`, `icon`, `description`) VALUES(5, 'Managing staff', 'bx bxs-user', 'We can make an arrangement for the serving food to guests based on the customer requirements.');
INSERT INTO `services` (`service_id`, `title`, `icon`, `description`) VALUES(6, 'Negotiating Hotel Contract', 'bx bx-building', 'We can negotiate hotel contract based on the customer requirements.');

COMMIT;