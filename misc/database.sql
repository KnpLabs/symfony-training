DROP TABLE IF EXISTS `dinosaur`;

CREATE TABLE `dinosaur` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `gender` VARCHAR(6) NOT NULL,
  `age` INT NOT NULL,
  `species` VARCHAR(255) NOT NULL
);

INSERT INTO `dinosaur` (name, gender, age, species) VALUES
  ("Callie", "Female", 34, "Tyrannosaurus"),
  ("Sebastian", "Male", 25, "Triceratops"),
  ("Natalia", "Female", 3, "Pterodactyl"),
  ("Dakota", "Male", 37, "Pterodactyl")
;
