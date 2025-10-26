DROP TABLE IF EXISTS `taxonomy_item__field_value`;

CREATE TABLE `taxonomy_item__field_value` (
`taxonomy_item__id` INTEGER NOT NULL,
`field_id` INTEGER NOT NULL,
`language_id` INT NOT NULL,
`value` TEXT NOT NULL
-- PRIMARY KEY (`field_value_id`)
);

CREATE INDEX `taxonomy_item__field_valuefield_id_language_id` ON `taxonomy_item__field_value` (`taxonomy_item__id`,`field_id`,`language_id`);
