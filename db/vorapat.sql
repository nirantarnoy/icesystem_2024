/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : vorapat

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2021-02-18 20:23:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `addressbook`
-- ----------------------------
DROP TABLE IF EXISTS `addressbook`;
CREATE TABLE `addressbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` int(11) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL,
  `district_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `zipcode` varchar(255) DEFAULT NULL,
  `address_type_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_address` (`company_id`),
  KEY `fk_branch_address` (`branch_id`),
  CONSTRAINT `fk_branch_address` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_address` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of addressbook
-- ----------------------------

-- ----------------------------
-- Table structure for `branch`
-- ----------------------------
DROP TABLE IF EXISTS `branch`;
CREATE TABLE `branch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company` (`company_id`),
  CONSTRAINT `fk_company` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of branch
-- ----------------------------
INSERT INTO `branch` VALUES ('1', '1', 'B01', 'สาขา 1', '', '', '1', '1607428129', '1610769258', null, null, 'dfdfd');
INSERT INTO `branch` VALUES ('2', '1', 'B02', 'สาขา 2', 'dffd', null, '1', '1608950566', '1610767185', null, null, 'xxx');

-- ----------------------------
-- Table structure for `car`
-- ----------------------------
DROP TABLE IF EXISTS `car`;
CREATE TABLE `car` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `car_type_id` int(11) DEFAULT NULL,
  `plate_number` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `sale_group_id` int(11) DEFAULT NULL,
  `sale_com_id` int(11) DEFAULT NULL,
  `sale_com_extra` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_car` (`company_id`),
  KEY `fk_branch_car` (`branch_id`),
  CONSTRAINT `fk_branch_car` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_car` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of car
-- ----------------------------
INSERT INTO `car` VALUES ('2', 'Car02', 'Car02', 'Car02', '1', '', '', '1', null, null, '1610685481', '1612750153', null, null, '2', '1', '1');
INSERT INTO `car` VALUES ('3', 'Car03', 'Car03', 'Car03', '1', '5สบ5798', '', '1', null, null, '1610718137', '1612750711', null, null, '1', '1', '1');

-- ----------------------------
-- Table structure for `car_daily`
-- ----------------------------
DROP TABLE IF EXISTS `car_daily`;
CREATE TABLE `car_daily` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `is_driver` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=295 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of car_daily
-- ----------------------------
INSERT INTO `car_daily` VALUES ('73', '2', '1', null, '1', '2021-01-01 00:00:00', '1611587818', '1611587818', null, null);
INSERT INTO `car_daily` VALUES ('74', '2', '2', null, '1', '2021-01-01 00:00:00', '1611587818', '1611587818', null, null);
INSERT INTO `car_daily` VALUES ('75', '3', '8', null, '1', '2021-01-01 00:00:00', '1611587959', '1611587959', null, null);
INSERT INTO `car_daily` VALUES ('76', '2', '1', null, '1', '2021-01-02 00:00:00', '1611588030', '1611588030', null, null);
INSERT INTO `car_daily` VALUES ('77', '2', '2', null, '1', '2021-01-02 00:00:00', '1611588030', '1611588030', null, null);
INSERT INTO `car_daily` VALUES ('78', '3', '3', null, '1', '2021-01-02 00:00:00', '1611588146', '1611588146', null, null);
INSERT INTO `car_daily` VALUES ('79', '2', '1', null, '1', '2021-01-03 00:00:00', '1611588355', '1611588355', null, null);
INSERT INTO `car_daily` VALUES ('80', '3', '2', null, '1', '2021-01-03 00:00:00', '1611589142', '1611589142', null, null);
INSERT INTO `car_daily` VALUES ('81', '3', '3', null, '1', '2021-01-03 00:00:00', '1611589142', '1611589142', null, null);
INSERT INTO `car_daily` VALUES ('85', '3', '1', null, '1', '2021-01-22 00:00:00', '1611589950', '1611589950', null, null);
INSERT INTO `car_daily` VALUES ('97', '2', '3', null, '1', '2021-01-04 00:00:00', '1611591271', '1611591271', null, null);
INSERT INTO `car_daily` VALUES ('98', '2', '1', null, '1', '2021-01-24 00:00:00', '1611592123', '1611592123', null, null);
INSERT INTO `car_daily` VALUES ('99', '2', '5', null, '1', '2021-01-24 00:00:00', '1611592123', '1611592123', null, null);
INSERT INTO `car_daily` VALUES ('100', '1', '8', null, '1', '2021-01-24 00:00:00', '1611592123', '1611592123', null, null);
INSERT INTO `car_daily` VALUES ('101', '1', '11', null, '1', '2021-01-24 00:00:00', '1611592123', '1611592123', null, null);
INSERT INTO `car_daily` VALUES ('102', '1', '13', null, '1', '2021-01-24 00:00:00', '1611592123', '1611592123', null, null);
INSERT INTO `car_daily` VALUES ('103', '1', '17', null, '1', '2021-01-24 00:00:00', '1611592123', '1611592123', null, null);
INSERT INTO `car_daily` VALUES ('104', '1', '19', null, '1', '2021-01-24 00:00:00', '1611592123', '1611592123', null, null);
INSERT INTO `car_daily` VALUES ('107', '3', '3', null, '1', '2021-01-24 00:00:00', '1611592123', '1611592123', null, null);
INSERT INTO `car_daily` VALUES ('108', '3', '4', null, '1', '2021-01-24 00:00:00', '1611592123', '1611592123', null, null);
INSERT INTO `car_daily` VALUES ('109', '2', '1', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('110', '2', '5', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('111', '1', '8', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('112', '1', '11', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('113', '1', '13', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('114', '1', '17', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('115', '1', '19', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('116', '2', '33', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('117', '2', '7', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('118', '3', '3', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('119', '3', '4', null, '1', '2021-01-15 00:00:00', '1611592201', '1611592201', null, null);
INSERT INTO `car_daily` VALUES ('120', '2', '1', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('121', '2', '5', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('122', '1', '8', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('123', '1', '11', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('124', '1', '13', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('125', '1', '17', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('126', '1', '19', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('127', '2', '33', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('128', '2', '7', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('129', '3', '3', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('130', '3', '4', null, '1', '2021-01-16 00:00:00', '1611592219', '1611592219', null, null);
INSERT INTO `car_daily` VALUES ('131', '2', '1', null, '1', '2021-01-13 00:00:00', '1611593013', '1611593013', null, null);
INSERT INTO `car_daily` VALUES ('132', '2', '5', null, '1', '2021-01-13 00:00:00', '1611593013', '1611593013', null, null);
INSERT INTO `car_daily` VALUES ('133', '1', '8', null, '1', '2021-01-13 00:00:00', '1611593013', '1611593013', null, null);
INSERT INTO `car_daily` VALUES ('134', '1', '11', null, '1', '2021-01-13 00:00:00', '1611593013', '1611593013', null, null);
INSERT INTO `car_daily` VALUES ('135', '1', '13', null, '1', '2021-01-13 00:00:00', '1611593013', '1611593013', null, null);
INSERT INTO `car_daily` VALUES ('136', '1', '17', null, '1', '2021-01-13 00:00:00', '1611593013', '1611593013', null, null);
INSERT INTO `car_daily` VALUES ('137', '1', '19', null, '1', '2021-01-13 00:00:00', '1611593013', '1611593013', null, null);
INSERT INTO `car_daily` VALUES ('138', '2', '33', null, '1', '2021-01-13 00:00:00', '1611593013', '1611593013', null, null);
INSERT INTO `car_daily` VALUES ('139', '2', '7', null, '1', '2021-01-13 00:00:00', '1611593013', '1611593013', null, null);
INSERT INTO `car_daily` VALUES ('140', '3', '3', null, '1', '2021-01-13 00:00:00', '1611593014', '1611593014', null, null);
INSERT INTO `car_daily` VALUES ('141', '3', '4', null, '1', '2021-01-13 00:00:00', '1611593014', '1611593014', null, null);
INSERT INTO `car_daily` VALUES ('142', '2', '2', null, '1', '2021-01-26 00:00:00', '1611629454', '1611629454', null, null);
INSERT INTO `car_daily` VALUES ('143', '2', '33', null, '1', '2021-01-26 00:00:00', '1611629454', '1611629454', null, null);
INSERT INTO `car_daily` VALUES ('146', '2', '3', null, '1', '2021-01-30 00:00:00', '1612065618', '1612065618', null, null);
INSERT INTO `car_daily` VALUES ('147', '2', '5', null, '1', '2021-01-30 00:00:00', '1612065618', '1612065618', null, null);
INSERT INTO `car_daily` VALUES ('148', '2', '1', null, '1', '2021-02-03 00:00:00', '1612369481', '1612369481', null, null);
INSERT INTO `car_daily` VALUES ('202', '2', '1', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('203', '2', '5', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('204', '1', '8', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('205', '1', '11', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('206', '1', '13', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('207', '1', '17', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('208', '1', '19', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('209', '2', '33', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('210', '2', '7', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('211', '3', '3', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('212', '3', '4', null, '1', '2021-02-07 00:00:00', '1612625362', '1612625362', null, null);
INSERT INTO `car_daily` VALUES ('213', '2', '1', null, '1', '2021-02-06 00:00:00', '1612625382', '1612625382', null, null);
INSERT INTO `car_daily` VALUES ('214', '2', '5', null, '1', '2021-02-06 00:00:00', '1612625382', '1612625382', null, null);
INSERT INTO `car_daily` VALUES ('215', '1', '8', null, '1', '2021-02-06 00:00:00', '1612625382', '1612625382', null, null);
INSERT INTO `car_daily` VALUES ('216', '1', '11', null, '1', '2021-02-06 00:00:00', '1612625382', '1612625382', null, null);
INSERT INTO `car_daily` VALUES ('217', '1', '13', null, '1', '2021-02-06 00:00:00', '1612625382', '1612625382', null, null);
INSERT INTO `car_daily` VALUES ('218', '1', '17', null, '1', '2021-02-06 00:00:00', '1612625382', '1612625382', null, null);
INSERT INTO `car_daily` VALUES ('219', '1', '19', null, '1', '2021-02-06 00:00:00', '1612625382', '1612625382', null, null);
INSERT INTO `car_daily` VALUES ('222', '3', '3', null, '1', '2021-02-06 00:00:00', '1612625382', '1612625382', null, null);
INSERT INTO `car_daily` VALUES ('223', '3', '4', null, '1', '2021-02-06 00:00:00', '1612625382', '1612625382', null, null);
INSERT INTO `car_daily` VALUES ('224', '2', '1', null, '1', '2021-02-04 00:00:00', '1612625628', '1612625628', null, null);
INSERT INTO `car_daily` VALUES ('225', '2', '5', null, '1', '2021-02-04 00:00:00', '1612625628', '1612625628', null, null);
INSERT INTO `car_daily` VALUES ('226', '1', '8', null, '1', '2021-02-04 00:00:00', '1612625628', '1612625628', null, null);
INSERT INTO `car_daily` VALUES ('227', '1', '11', null, '1', '2021-02-04 00:00:00', '1612625628', '1612625628', null, null);
INSERT INTO `car_daily` VALUES ('228', '1', '13', null, '1', '2021-02-04 00:00:00', '1612625628', '1612625628', null, null);
INSERT INTO `car_daily` VALUES ('229', '1', '17', null, '1', '2021-02-04 00:00:00', '1612625628', '1612625628', null, null);
INSERT INTO `car_daily` VALUES ('230', '1', '19', null, '1', '2021-02-04 00:00:00', '1612625628', '1612625628', null, null);
INSERT INTO `car_daily` VALUES ('231', '3', '3', null, '1', '2021-02-04 00:00:00', '1612625628', '1612625628', null, null);
INSERT INTO `car_daily` VALUES ('232', '3', '4', null, '1', '2021-02-04 00:00:00', '1612625628', '1612625628', null, null);
INSERT INTO `car_daily` VALUES ('233', '1', '8', null, '1', '2021-02-09 00:00:00', '1612876878', '1612876878', null, null);
INSERT INTO `car_daily` VALUES ('234', '1', '11', null, '1', '2021-02-09 00:00:00', '1612876878', '1612876878', null, null);
INSERT INTO `car_daily` VALUES ('235', '1', '13', null, '1', '2021-02-09 00:00:00', '1612876878', '1612876878', null, null);
INSERT INTO `car_daily` VALUES ('236', '1', '17', null, '1', '2021-02-09 00:00:00', '1612876878', '1612876878', null, null);
INSERT INTO `car_daily` VALUES ('237', '1', '19', null, '1', '2021-02-09 00:00:00', '1612876878', '1612876878', null, null);
INSERT INTO `car_daily` VALUES ('238', '2', '5', null, '1', '2021-02-09 00:00:00', '1612876878', '1612876878', null, null);
INSERT INTO `car_daily` VALUES ('239', '2', '33', null, '1', '2021-02-09 00:00:00', '1612876878', '1612876878', null, null);
INSERT INTO `car_daily` VALUES ('254', '1', '8', null, '1', '2021-02-11 00:00:00', '1612945165', '1612945165', null, null);
INSERT INTO `car_daily` VALUES ('255', '1', '11', null, '1', '2021-02-11 00:00:00', '1612945165', '1612945165', null, null);
INSERT INTO `car_daily` VALUES ('256', '1', '13', null, '1', '2021-02-11 00:00:00', '1612945165', '1612945165', null, null);
INSERT INTO `car_daily` VALUES ('257', '1', '17', null, '1', '2021-02-11 00:00:00', '1612945165', '1612945165', null, null);
INSERT INTO `car_daily` VALUES ('258', '1', '19', null, '1', '2021-02-11 00:00:00', '1612945165', '1612945165', null, null);
INSERT INTO `car_daily` VALUES ('259', '2', '5', null, '1', '2021-02-11 00:00:00', '1612945165', '1612945165', null, null);
INSERT INTO `car_daily` VALUES ('260', '2', '33', null, '1', '2021-02-11 00:00:00', '1612945165', '1612945165', null, null);
INSERT INTO `car_daily` VALUES ('261', '3', '3', null, '1', '2021-02-11 00:00:00', '1612945165', '1612945165', null, null);
INSERT INTO `car_daily` VALUES ('263', '1', '8', null, '1', '2021-02-10 00:00:00', '1612971084', '1612971084', null, null);
INSERT INTO `car_daily` VALUES ('264', '1', '11', null, '1', '2021-02-10 00:00:00', '1612971084', '1612971084', null, null);
INSERT INTO `car_daily` VALUES ('265', '1', '13', null, '1', '2021-02-10 00:00:00', '1612971084', '1612971084', null, null);
INSERT INTO `car_daily` VALUES ('266', '1', '17', null, '1', '2021-02-10 00:00:00', '1612971084', '1612971084', null, null);
INSERT INTO `car_daily` VALUES ('267', '1', '19', null, '1', '2021-02-10 00:00:00', '1612971084', '1612971084', null, null);
INSERT INTO `car_daily` VALUES ('268', '2', '5', null, '1', '2021-02-10 00:00:00', '1612971084', '1612971084', null, null);
INSERT INTO `car_daily` VALUES ('269', '2', '33', null, '1', '2021-02-10 00:00:00', '1612971084', '1612971084', null, null);
INSERT INTO `car_daily` VALUES ('274', '3', '3', null, '1', '2021-02-10 00:00:00', '1612971180', '1612971180', null, null);
INSERT INTO `car_daily` VALUES ('276', '3', '4', null, '1', '2021-02-10 00:00:00', '1612971248', '1612971248', null, null);
INSERT INTO `car_daily` VALUES ('277', '1', '8', null, '1', '2021-02-13 00:00:00', '1613193574', '1613193574', null, null);
INSERT INTO `car_daily` VALUES ('278', '1', '11', null, '1', '2021-02-13 00:00:00', '1613193574', '1613193574', null, null);
INSERT INTO `car_daily` VALUES ('279', '1', '13', null, '1', '2021-02-13 00:00:00', '1613193574', '1613193574', null, null);
INSERT INTO `car_daily` VALUES ('280', '1', '17', null, '1', '2021-02-13 00:00:00', '1613193574', '1613193574', null, null);
INSERT INTO `car_daily` VALUES ('281', '1', '19', null, '1', '2021-02-13 00:00:00', '1613193574', '1613193574', null, null);
INSERT INTO `car_daily` VALUES ('282', '2', '5', null, '1', '2021-02-13 00:00:00', '1613193574', '1613193574', null, null);
INSERT INTO `car_daily` VALUES ('283', '2', '33', null, '1', '2021-02-13 00:00:00', '1613193574', '1613193574', null, null);
INSERT INTO `car_daily` VALUES ('284', '3', '1', null, '1', '2021-02-13 00:00:00', '1613193574', '1613193574', null, null);
INSERT INTO `car_daily` VALUES ('285', '3', '13', null, '1', '2021-02-13 00:00:00', '1613193574', '1613193574', null, null);
INSERT INTO `car_daily` VALUES ('286', '1', '8', null, '1', '2021-02-14 00:00:00', '1613219485', '1613219485', null, null);
INSERT INTO `car_daily` VALUES ('287', '1', '11', null, '1', '2021-02-14 00:00:00', '1613219485', '1613219485', null, null);
INSERT INTO `car_daily` VALUES ('288', '1', '13', null, '1', '2021-02-14 00:00:00', '1613219485', '1613219485', null, null);
INSERT INTO `car_daily` VALUES ('289', '1', '17', null, '1', '2021-02-14 00:00:00', '1613219485', '1613219485', null, null);
INSERT INTO `car_daily` VALUES ('290', '1', '19', null, '1', '2021-02-14 00:00:00', '1613219485', '1613219485', null, null);
INSERT INTO `car_daily` VALUES ('291', '2', '5', null, '1', '2021-02-14 00:00:00', '1613219485', '1613219485', null, null);
INSERT INTO `car_daily` VALUES ('292', '2', '33', null, '1', '2021-02-14 00:00:00', '1613219485', '1613219485', null, null);
INSERT INTO `car_daily` VALUES ('293', '3', '1', null, '1', '2021-02-14 00:00:00', '1613219485', '1613219485', null, null);
INSERT INTO `car_daily` VALUES ('294', '3', '13', null, '1', '2021-02-14 00:00:00', '1613219485', '1613219485', null, null);

-- ----------------------------
-- Table structure for `car_emp`
-- ----------------------------
DROP TABLE IF EXISTS `car_emp`;
CREATE TABLE `car_emp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of car_emp
-- ----------------------------
INSERT INTO `car_emp` VALUES ('3', '1', '8', '1');
INSERT INTO `car_emp` VALUES ('4', '1', '11', '1');
INSERT INTO `car_emp` VALUES ('5', '1', '13', '1');
INSERT INTO `car_emp` VALUES ('6', '1', '17', '1');
INSERT INTO `car_emp` VALUES ('7', '1', '19', '1');
INSERT INTO `car_emp` VALUES ('22', '2', '5', '1');
INSERT INTO `car_emp` VALUES ('23', '2', '33', '1');
INSERT INTO `car_emp` VALUES ('24', '3', '1', '1');
INSERT INTO `car_emp` VALUES ('25', '3', '13', '1');

-- ----------------------------
-- Table structure for `car_type`
-- ----------------------------
DROP TABLE IF EXISTS `car_type`;
CREATE TABLE `car_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_car_type` (`company_id`),
  KEY `fk_branch_car_type` (`branch_id`),
  CONSTRAINT `fk_branch_car_type` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_car_type` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of car_type
-- ----------------------------
INSERT INTO `car_type` VALUES ('1', 'ปิกอัพ', 'ปิกอัพ', 'ปิกอัพ', '1', null, null, '1608953515', '1608953803', null, null);

-- ----------------------------
-- Table structure for `company`
-- ----------------------------
DROP TABLE IF EXISTS `company`;
CREATE TABLE `company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `engname` varchar(255) DEFAULT NULL,
  `taxid` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `tenant_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of company
-- ----------------------------
INSERT INTO `company` VALUES ('1', 'Vorapat', 'วรภัทรไอซ์', 'Vorapat Ice', '2222222222222', '', '1607417726', '1610769475', '1', '1', null, '1', 'dfdfddfdf');

-- ----------------------------
-- Table structure for `contacts`
-- ----------------------------
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_type` int(11) DEFAULT NULL,
  `contact_detail` varchar(255) DEFAULT NULL,
  `is_primary` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_contact` (`company_id`),
  KEY `fk_branch_contact` (`branch_id`),
  CONSTRAINT `fk_branch_contact` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_contact` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of contacts
-- ----------------------------

-- ----------------------------
-- Table structure for `customer`
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `customer_group_id` int(11) DEFAULT NULL,
  `location_info` varchar(255) DEFAULT NULL,
  `delivery_route_id` int(11) DEFAULT NULL,
  `active_date` datetime DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `shop_photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `customer_type_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `payment_term_id` int(11) DEFAULT NULL,
  `branch_no` varchar(255) DEFAULT NULL,
  `address2` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_customer` (`company_id`),
  KEY `fk_branch_customer` (`branch_id`),
  CONSTRAINT `fk_branch_customer` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_customer` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3498 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES ('2850', 'CU-2100001', 'สน. บรมราชชนนี ขาเข้า CC1799', 'สน. บรมราชชนนี ขาเข้า CC1799', '8', '', '5', null, null, null, '1', null, null, '1613193043', '1613193043', null, null, '', '9', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'CC1799', 'AZ01');
INSERT INTO `customer` VALUES ('2851', 'CU-2100002', 'สน. ราชพฤกษ์ 1 CC2844', 'สน. ราชพฤกษ์ 1 CC2844', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '9', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'CC2844', 'AZ01');
INSERT INTO `customer` VALUES ('2852', 'CU-2100003', 'ม.สยาม CC2844', 'ม.สยาม CC2844', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '9', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC1853', 'AZ01');
INSERT INTO `customer` VALUES ('2853', 'CU-2100004', 'The Mall บางแค ชั้น 1 SC0899', 'The Mall บางแค ชั้น 1 SC0899', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '9', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC0899', 'AZ01');
INSERT INTO `customer` VALUES ('2854', 'CU-2100005', 'อเมซอนหน้ากรมแรงงาน', 'อเมซอนหน้ากรมแรงงาน', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '10', '20 ถนนบรมราชชนนี แขวงฉิมพลี เขตตลิ่งชัน กรุงเทพฯ 10170', '092-2947926', null, '7', 'ไม่ระบุ', 'AZ01');
INSERT INTO `customer` VALUES ('2855', 'CU-2100006', 'รพ.เกษมราษฎร์ บางแค', 'รพ.เกษมราษฎร์ บางแค', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '10', '586 ถนนเพชรเกษม แขวงบางแคเหนือ เขตบางแค กรุงเทพฯ 10160', '', null, '7', 'ไม่ระบุ', 'AZ01');
INSERT INTO `customer` VALUES ('2856', 'CU-2100007', 'หม่อมถนัดแดก', 'หม่อมถนัดแดก', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '10', '8/5,8/6 ถนนรัชดา-รามอีนทรา แขวงนวลจันทร์ เขตบึงกุ่ม กรุงเทพฯ 10230', '', null, '7', 'ไม่ระบุ', 'AZ01');
INSERT INTO `customer` VALUES ('2857', 'CU-2100008', 'ร้านขนมจีนบางกอก', 'ร้านขนมจีนบางกอก', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '10', '', '', null, '8', 'ไม่ระบุ', 'AZ01');
INSERT INTO `customer` VALUES ('2858', 'CU-2100009', 'ร้านฮั่วเช่งฮง1', 'ร้านฮั่วเช่งฮง1', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '10', '41 ซอยสุภาพงษ์ 3 แยก 5-2 แขวงหนองบอน เขตประเวศ กรุงเทพฯ 10250', '', null, '7', 'ไม่ระบุ', 'AZ01');
INSERT INTO `customer` VALUES ('2859', 'CU-2100010', 'ร้านเทียนกงข้าวมันไก่', 'ร้านเทียนกงข้าวมันไก่', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '10', '', '062-2501250', null, '9', 'ไม่ระบุ', 'AZ01');
INSERT INTO `customer` VALUES ('2860', 'CU-2100011', 'ลิ้มเหล่าโหงว', 'ลิ้มเหล่าโหงว', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '10', '', '', null, '9', 'ไม่ระบุ', 'AZ01');
INSERT INTO `customer` VALUES ('2861', 'CU-2100012', 'อเมซอนหนองแขม CC3763', 'อเมซอนหนองแขม CC3763', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '9', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10899', '', null, '7', 'CC3763', 'AZ01');
INSERT INTO `customer` VALUES ('2862', 'CU-2100013', 'อเมซอนสวนผัก CC3794', 'อเมซอนสวนผัก CC3794', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '9', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'CC3794', 'AZ01');
INSERT INTO `customer` VALUES ('2863', 'CU-2100014', 'รปภ.', 'รปภ.', '8', '', '5', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '9', '', '', null, '9', 'AZ01', 'AZ01');
INSERT INTO `customer` VALUES ('2864', 'CU-2100015', 'ธรรมศาลา CC2160', 'ธรรมศาลา CC2160', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '11', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'CC2160', 'AZ02');
INSERT INTO `customer` VALUES ('2865', 'CU-2100016', 'อเมซอน สาย 7', 'อเมซอน สาย 7', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '11', '64/31 หมู่ที่ 1 ตำบลขุนแก้ว อำเภอนครชัยศรี จังหวัดนครปฐม 73120', '', null, '7', 'ไม่ระบุ', 'AZ02');
INSERT INTO `customer` VALUES ('2866', 'CU-2100017', 'ตลาดพลู ธนบุรี SC3118', 'ตลาดพลู ธนบุรี SC3118', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '11', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC3118', 'AZ02');
INSERT INTO `customer` VALUES ('2867', 'CU-2100018', 'ตลาดครอบครัว ท่าพระ SC3348', 'ตลาดครอบครัว ท่าพระ SC3348', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '11', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC3348', 'AZ02');
INSERT INTO `customer` VALUES ('2868', 'CU-2100019', 'The Mall ท่าพระ SC1674', 'The Mall ท่าพระ SC1674', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '11', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC1674', 'AZ02');
INSERT INTO `customer` VALUES ('2869', 'CU-2100020', 'อเมซอน สาย 2', 'อเมซอน สาย 2', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '12', '42/33 ห้องเลขที่ C201 แขวงศาลาธรรมสพน์ เขตทวีวัฒนา กรุงเทพฯ 10170', '', null, '7', 'ไม่ระบุ', 'AZ02');
INSERT INTO `customer` VALUES ('2870', 'CU-2100021', 'ร้านฮั่วเช่งฮง2', 'ร้านฮั่วเช่งฮง2', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '12', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'ไม่ระบุ', 'AZ02');
INSERT INTO `customer` VALUES ('2871', 'CU-2100022', 'ร้านผลไม้ ตลาดครอบครัวท่าพระ', 'ร้านผลไม้ ตลาดครอบครัวท่าพระ', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '12', '', '098-4646828', null, '10', 'ไม่ระบุ', 'AZ02');
INSERT INTO `customer` VALUES ('2872', 'CU-2100023', 'น้ำปั่นพี่ใช้ ท่าพระ', 'น้ำปั่นพี่ใช้ ท่าพระ', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '12', '', '', null, '10', 'ไม่ระบุ', 'AZ02');
INSERT INTO `customer` VALUES ('2873', 'CU-2100024', 'หมีพ่นไฟ สาย 7', 'หมีพ่นไฟ สาย 7', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '12', '', '', null, '10', 'ไม่ระบุ', 'AZ02');
INSERT INTO `customer` VALUES ('2874', 'CU-2100025', 'กาแฟสด พี่ก้อย', 'ป้าแดงข้าวแกง', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '12', '', '', null, '10', 'ไม่ระบุ', 'AZ02');
INSERT INTO `customer` VALUES ('2875', 'CU-2100026', 'ขายสด', '', '8', '', '6', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '12', '', '', null, '10', 'ไม่ระบุ', 'AZ02');
INSERT INTO `customer` VALUES ('2876', 'CU-2100028', 'กฟผ. SC1606', 'กฟผ. SC1606', '8', '', '7', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '13', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '093-125-1978', null, '7', 'SC1606', 'AZ03');
INSERT INTO `customer` VALUES ('2877', 'CU-2100029', 'อาคารศรีสวรินทิรา รพ.ศิริราช SC3434', 'อาคารศรีสวรินทิรา รพ.ศิริราช SC3434', '8', '', '7', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '13', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '064-952-3618', null, '7', 'SC3434', 'AZ03');
INSERT INTO `customer` VALUES ('2878', 'CU-2100030', 'คณะพยาบาลศาสตร์ รพ.ศิริราช SC2069', 'คณะพยาบาลศาสตร์ รพ.ศิริราช SC2069', '8', '', '7', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '13', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '096-248-5951', null, '7', 'SC2069', 'AZ03');
INSERT INTO `customer` VALUES ('2879', 'CU-2100031', 'สถานีรถไฟธนบุรี SC2977', 'สถานีรถไฟธนบุรี SC2977', '8', '', '7', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '13', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '091-868-5727', null, '7', 'SC2977', 'AZ03');
INSERT INTO `customer` VALUES ('2880', 'CU-2100032', 'กรมสวัสดิการทหารเรือ SC2895', 'กรมสวัสดิการทหารเรือ SC2895', '8', '', '7', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '13', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '092-296-1926', null, '7', 'SC2895', 'AZ03');
INSERT INTO `customer` VALUES ('2881', 'CU-2100033', 'Central ปิ่นเกล้า SC1483', 'Central ปิ่นเกล้า SC1483', '8', '', '7', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '13', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '085-999-5622', null, '7', 'SC1483', 'AZ03');
INSERT INTO `customer` VALUES ('2882', 'CU-2100034', 'อเมซอนปิ่นเกล้า (ออซั่ม 7) ', '', '8', '', '7', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '14', '', '', null, '11', 'ไม่ระบุ', 'AZ03');
INSERT INTO `customer` VALUES ('2883', 'CU-2100037', 'สน.ราชพฤกษ์ 3 CC2369', 'สน.ราชพฤกษ์ 3 CC2369', '8', '', '8', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '15', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '096-248-5951', null, '7', 'CC2369', 'AZ04');
INSERT INTO `customer` VALUES ('2884', 'CU-2100038', 'สน.ตลิ่งชัน CC1579', 'สน.ตลิ่งชัน CC1579', '8', '', '8', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '15', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '099-310-0389', null, '7', 'CC1579', 'AZ04');
INSERT INTO `customer` VALUES ('2885', 'CU-2100039', 'Lotus บางกรวย-ไทรน้อย SC2571', 'Lotus บางกรวย-ไทรน้อย SC2571', '8', '', '8', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '15', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '061-397-9928', null, '7', 'SC2571', 'AZ04');
INSERT INTO `customer` VALUES ('2886', 'CU-2100040', 'Central เวสต์เกต ชั้น 2 SC1199', 'Central เวสต์เกต ชั้น 2 SC1199', '8', '', '8', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '15', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '097-236-3618', null, '7', 'SC1199', 'AZ04');
INSERT INTO `customer` VALUES ('2887', 'CU-2100041', 'Central เวสต์เกต ชั้น 1 SC2780', 'Central เวสต์เกต ชั้น 1 SC2780', '8', '', '8', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '15', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '095-115-4263', null, '7', 'SC2780', 'AZ04');
INSERT INTO `customer` VALUES ('2888', 'CU-2100042', 'อเมซอนไทวัสดุ ', 'อเมซอนไทวัสดุ (25)', '8', '', '8', null, null, null, '1', null, null, '1613193068', '1613193068', null, null, '', '16', '59/9 หมู่1 ตำบลบางบัวทอง อำเภอบางบัวทอง จังหวัดนนทบุรี 11110', '', null, '7', 'ไม่ระบุ', 'AZ04');
INSERT INTO `customer` VALUES ('2889', 'CU-2100043', 'เตี๋ยวเรืออนุเสาวรีย์ 4', 'เตี๋ยวเรืออนุเสาวรีย์ 4', '8', '', '8', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '16', '199/90 หมู่ 5 ตำบลบางขนุน อำเภอบางกรวย จังหวัดนนทบุรี 11130', '', null, '7', 'ไม่ระบุ', 'AZ04');
INSERT INTO `customer` VALUES ('2890', 'CU-2100044', 'ชานมไข่มุก โลตัสบางกรวย', 'ชานมไข่มุก โลตัสบางกรวย', '8', '', '8', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '16', '', '', null, '10', 'ไม่ระบุ', 'AZ04');
INSERT INTO `customer` VALUES ('2891', 'CU-2100045', 'ราดหน้าอินเตอร์', '', '8', '', '8', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '16', '', '', null, '10', 'ไม่ระบุ', 'AZ04');
INSERT INTO `customer` VALUES ('2892', 'CU-2100046', 'น้ำส้ม', '', '8', '', '8', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '16', '', '', null, '10', 'ไม่ระบุ', 'AZ04');
INSERT INTO `customer` VALUES ('2893', 'CU-2100049', 'กระทรวงพาณิชย์ นนทบุรี SC3449', 'กระทรวงพาณิชย์ นนทบุรี SC3449', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '17', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '099-507-3544', null, '7', 'SC3449', 'AZ05');
INSERT INTO `customer` VALUES ('2894', 'CU-2100050', 'สลากกินแบ่งรัฐบาล SC2769', 'สลากกินแบ่งรัฐบาล SC2769', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '17', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '089-306-8233', null, '7', 'SC2769', 'AZ05');
INSERT INTO `customer` VALUES ('2895', 'CU-2100051', 'ปปช. SC1003', 'ปปช. SC1003', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '17', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '094-536-2445', null, '7', 'SC1003', 'AZ05');
INSERT INTO `customer` VALUES ('2896', 'CU-2100052', 'ชลประทานปากเกร็ด SC2862', 'ชลประทานปากเกร็ด SC2862', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '17', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '097-165-6727', null, '7', 'SC2862', 'AZ05');
INSERT INTO `customer` VALUES ('2897', 'CU-2100053', 'Central เเจ้งวัฒนะ SC1633', 'Central เเจ้งวัฒนะ SC1633', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '17', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '093-831-1650', null, '7', 'SC1633', 'AZ05');
INSERT INTO `customer` VALUES ('2898', 'CU-2100054', 'โครงการNicheID SC3443', 'โครงการNicheID SC3443', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '17', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '099-063-9239', null, '7', 'SC3443', 'AZ05');
INSERT INTO `customer` VALUES ('2899', 'CU-2100055', 'อเมซอน แจ้งวัฒนะ ', 'อเมซอน แจ้งวัฒนะ (25)', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '18', '61/4 หมู่4 ถนนแจ้งวัฒนะ ตำบลปากเกร็ด อำเภอปากเกร็ด จังหวัดนนทบุรี 11120', '', null, '7', 'ไม่ระบุ', 'AZ05');
INSERT INTO `customer` VALUES ('2900', 'CU-2100056', 'ราดหน้าบียอน ', 'ราดหน้าบียอน (25)', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '18', '', '', null, '10', 'ไม่ระบุ', 'AZ05');
INSERT INTO `customer` VALUES ('2901', 'CU-2100057', 'เมืองทอง เอ็มโซไซตี้', 'เมืองทอง เอ็มโซไซตี้ (25)', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '18', '120/1072 หมู่ที่ 9 ตำบลบางพูด อำเภอปากเกร็ด จังหวัดนนทบุรี 11120', '', null, '7', 'ไม่ระบุ', 'AZ05');
INSERT INTO `customer` VALUES ('2902', 'CU-2100058', 'เมืองทอง บรอนสตีท', 'เมืองทอง บรอนสตีท (25)', '8', '', '9', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '18', '50/251 หมู่ที่ 6 ตำบลบ้านใหม่ อำเภอปากเกร็ด จังหวัดนนทบุรี 11120', '', null, '7', 'ไม่ระบุ', 'AZ05');
INSERT INTO `customer` VALUES ('2903', 'CU-2100062', 'สน.ร.พ.ศรีธัญญา CC3038', 'สน.ร.พ.ศรีธัญญา CC3038', '8', '', '10', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '19', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '082-585-8564', null, '7', 'CC3038', 'AZ06');
INSERT INTO `customer` VALUES ('2904', 'CU-2100063', 'กรมอนามัย SC1394', 'กรมอนามัย SC1394', '8', '', '10', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '19', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '095-797-0342', null, '7', 'SC1394', 'AZ06');
INSERT INTO `customer` VALUES ('2905', 'CU-2100064', 'สน.กรมวิทย์ฯการแพทย์ CC3081', 'สน.กรมวิทย์ฯการแพทย์ CC3081', '8', '', '10', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '19', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '088-559-6011', null, '7', 'CC3081', 'AZ06');
INSERT INTO `customer` VALUES ('2906', 'CU-2100065', 'The Mall งามวงศ์วาน ชั้น6 SC3029', 'The Mall งามวงศ์วาน ชั้น6 SC3029', '8', '', '10', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '19', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '093-110-6837', null, '7', 'SC3029', 'AZ06');
INSERT INTO `customer` VALUES ('2907', 'CU-2100066', 'สน.ประชาชื่น 2 CC2779', 'สน.ประชาชื่น 2 CC2779', '8', '', '10', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '19', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '092-659-9668', null, '7', 'CC2779', 'AZ06');
INSERT INTO `customer` VALUES ('2908', 'CU-2100067', 'The Mall งามวงศ์วาน ชั้น G SC3793', 'The Mall งามวงศ์วาน ชั้น G SC3793', '8', '', '10', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '19', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC3793', 'AZ06');
INSERT INTO `customer` VALUES ('2909', 'CU-2100068', 'อเมซอนท่าน้ำบางศรีเมือง', 'อเมซอนท่าน้ำบางศรีเมือง', '8', '', '10', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '20', '193 หมู่ 3 ตำบลบางศรีเมือง อำเภอเมืองนนทบุรี จังหวัดนนทบุรี 11110', '', null, '7', 'ไม่ระบุ', 'AZ06');
INSERT INTO `customer` VALUES ('2910', 'CU-2100069', 'เตี๋ยวเรือเสาวรีย์ 6', 'เตี๋ยวเรือเสาวรีย์ 6', '8', '', '10', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '20', '199/90 หมู่ 5 ตำบลบางขนุน อำเภอบางกรวย จังหวัดนนทบุรี 11130', '', null, '7', 'ไม่ระบุ', 'AZ06');
INSERT INTO `customer` VALUES ('2911', 'CU-2100070', 'ดาคาซี่', 'เมืองทอง บรอนสตีท (25)', '8', '', '10', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '20', '50/251 หมู่ที่ 6 ตำบลบ้านใหม่ อำเภอปากเกร็ด จังหวัดนนทบุรี 11120', '', null, '10', 'ไม่ระบุ', 'AZ06');
INSERT INTO `customer` VALUES ('2912', 'CU-2100073', 'ศูนย์การแพทย์กาญจนาภิเษก ม.มหิดล SC2948', 'ศูนย์การแพทย์กาญจนาภิเษก ม.มหิดล SC2948', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '21', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC2948', 'AZ07');
INSERT INTO `customer` VALUES ('2913', 'CU-2100074', 'พุทธมณฑล สาย 4 CC3091', 'พุทธมณฑล สาย 4 CC3091', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '21', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'CC3091', 'AZ07');
INSERT INTO `customer` VALUES ('2914', 'CU-2100075', 'พุทธมณฑล สาย 5 CC1833', 'พุทธมณฑล สาย 5 CC1833', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '21', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', '', 'AZ07');
INSERT INTO `customer` VALUES ('2915', 'CU-2100076', 'สน.เพชรเกษม 81 CC2716', 'สน.เพชรเกษม 81 CC2716', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '21', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'CC2716', 'AZ07');
INSERT INTO `customer` VALUES ('2916', 'CU-2100077', 'สน. พระราม 2 ขาเข้า กม.19 CC2155', 'สน. พระราม 2 ขาเข้า กม.19 CC2155', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '21', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'CC2155', 'AZ07');
INSERT INTO `customer` VALUES ('2917', 'CU-2100078', 'Central มหาชัย ชั้น 1 SC2201', 'Central มหาชัย ชั้น 1 SC2201', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '21', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC2201', 'AZ07');
INSERT INTO `customer` VALUES ('2918', 'CU-2100079', 'Central มหาชัย ชั้น 2 SC2196', 'Central มหาชัย ชั้น 2 SC2196', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '21', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC2196', 'AZ07');
INSERT INTO `customer` VALUES ('2919', 'CU-2100080', 'รพ. สมเด็จพระพุทธเลิศหล้า SC2316', 'รพ. สมเด็จพระพุทธเลิศหล้า SC2316', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '21', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', null, '7', 'SC2316', 'AZ07');
INSERT INTO `customer` VALUES ('2920', 'CU-2100081', 'ร้านละมุนชาบาร์', 'ร้านละมุนชาบาร์', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '22', '', '', null, '8', 'ไม่ระบุ', 'AZ07');
INSERT INTO `customer` VALUES ('2921', 'CU-2100082', 'อเมซอนวุฒิคุณ', 'อเมซอนวุฒิคุณ', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '22', '746/12 อาคารสมุทรวุฒิคุณ ถนนราชญาติรักษา ตำบลแม่กลอง อำเภอเมืองสมุทรสงคราม จังหวัดสมุทรสงคราม 75000', '', null, '7', 'ไม่ระบุ', 'AZ07');
INSERT INTO `customer` VALUES ('2922', 'CU-2100083', 'ร้านปริวัฒน์ช็อป', 'ร้านปริวัฒน์ช็อป', '8', '', '11', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '22', '', '', null, '9', 'ไม่ระบุ', 'AZ07');
INSERT INTO `customer` VALUES ('2923', 'CU-2100086', 'สิรินธร', 'สิรินธร', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3781822', null, '7', '0110', 'CJ01');
INSERT INTO `customer` VALUES ('2924', 'CU-2100087', 'ลาดปลาเค้า', 'ลาดปลาเค้า', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '089-8365522', null, '7', '0094', 'CJ01');
INSERT INTO `customer` VALUES ('2925', 'CU-2100088', 'สระกระเทียม', 'สระกระเทียม', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '095-2098875', null, '7', '0242', 'CJ01');
INSERT INTO `customer` VALUES ('2926', 'CU-2100089', 'หนองโพ', 'หนองโพ', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9431740', null, '7', '0076', 'CJ01');
INSERT INTO `customer` VALUES ('2927', 'CU-2100090', 'ดอนทราย', 'ดอนทราย', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3780274', null, '7', '0128', 'CJ01');
INSERT INTO `customer` VALUES ('2928', 'CU-2100091', 'หลุมดิน', 'หลุมดิน', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '063-8431042', null, '7', '0325', 'CJ01');
INSERT INTO `customer` VALUES ('2929', 'CU-2100092', 'บ้านไร่', 'บ้านไร่', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443871', null, '7', '0300', 'CJ01');
INSERT INTO `customer` VALUES ('2930', 'CU-2100093', 'ดอนตะโก', 'ดอนตะโก', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9438472', null, '7', '0119', 'CJ01');
INSERT INTO `customer` VALUES ('2931', 'CU-2100094', 'เมืองทอง', 'เมืองทอง', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9445070', null, '7', '0040', 'CJ01');
INSERT INTO `customer` VALUES ('2932', 'CU-2100095', 'แยกต้นสำโรง', 'แยกต้นสำโรง', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3789174', null, '7', '0129', 'CJ01');
INSERT INTO `customer` VALUES ('2933', 'CU-2100096', 'เขาวัง', 'เขาวัง', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443917', null, '7', '0043', 'CJ01');
INSERT INTO `customer` VALUES ('2934', 'CU-2100097', 'เจดีย์หัก', 'เจดีย์หัก', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443746', null, '7', '0029', 'CJ01');
INSERT INTO `customer` VALUES ('2935', 'CU-2100098', 'เขางู', 'เขางู', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782060', null, '7', '0055', 'CJ01');
INSERT INTO `customer` VALUES ('2936', 'CU-2100099', 'จอมบึง2', 'จอมบึง2', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443752', null, '7', '0030', 'CJ01');
INSERT INTO `customer` VALUES ('2937', 'CU-2100100', 'จอมบึง 1', 'จอมบึง 1', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443520', null, '7', '0008', 'CJ01');
INSERT INTO `customer` VALUES ('2938', 'CU-2100101', 'ด่านทับตะโก', 'ด่านทับตะโก', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9432266', null, '7', '0089', 'CJ01');
INSERT INTO `customer` VALUES ('2939', 'CU-2100102', 'ชัฎป่าหวาย', 'ชัฎป่าหวาย', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443968', null, '7', '0050', 'CJ01');
INSERT INTO `customer` VALUES ('2940', 'CU-2100103', 'สวนผึ้ง', 'สวนผึ้ง', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3781331', null, '7', '0082', 'CJ01');
INSERT INTO `customer` VALUES ('2941', 'CU-2100104', 'บ้านคา', 'บ้านคา', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3781610', null, '7', '0137', 'CJ01');
INSERT INTO `customer` VALUES ('2942', 'CU-2100105', 'ตลาดนัดบ้านนา', 'ตลาดนัดบ้านนา', '9', '', '18', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '23', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '095-3845621', null, '7', '0430', 'CJ01');
INSERT INTO `customer` VALUES ('2943', 'CU-2100106', 'บึงกระจับ', 'บึงกระจับ', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1480926', null, '7', '0339', 'CJ02');
INSERT INTO `customer` VALUES ('2944', 'CU-2100107', 'โป่งดุสิต', 'โป่งดุสิต', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9951672', null, '7', '0064', 'CJ02');
INSERT INTO `customer` VALUES ('2945', 'CU-2100108', 'ปากแรต', 'ปากแรต', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9418338', null, '7', '0091', 'CJ02');
INSERT INTO `customer` VALUES ('2946', 'CU-2100109', 'บ้านฆ้องน้อย', 'บ้านฆ้องน้อย', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', null, '7', '0571', 'CJ02');
INSERT INTO `customer` VALUES ('2947', 'CU-2100110', 'เบิกไพร', 'เบิกไพร', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-8562266', null, '7', '0087', 'CJ02');
INSERT INTO `customer` VALUES ('2948', 'CU-2100111', 'ไผ่สามเกาะ', 'ไผ่สามเกาะ', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '092-2506437', null, '7', '0231', 'CJ02');
INSERT INTO `customer` VALUES ('2949', 'CU-2100112', 'เขาขวาง', 'เขาขวาง', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-8309535', null, '7', '0078', 'CJ02');
INSERT INTO `customer` VALUES ('2950', 'CU-2100113', 'ท่าชุมพล', 'ท่าชุมพล', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-6268148', null, '7', '0323', 'CJ02');
INSERT INTO `customer` VALUES ('2951', 'CU-2100114', 'ท่าวัด', 'ท่าวัด', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443631', null, '7', '0002', 'CJ02');
INSERT INTO `customer` VALUES ('2952', 'CU-2100115', 'ตลาดโพธาราม', 'ตลาดโพธาราม', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-3017502', null, '7', '0239', 'CJ02');
INSERT INTO `customer` VALUES ('2953', 'CU-2100116', 'บ้านฆ้อง', 'บ้านฆ้อง', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3789107', null, '7', '0131', 'CJ02');
INSERT INTO `customer` VALUES ('2954', 'CU-2100117', 'บางแพ', 'บางแพ', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443927', null, '7', '0045', 'CJ02');
INSERT INTO `customer` VALUES ('2955', 'CU-2100118', 'บ้านไร่ชาวเหนือ', 'บ้านไร่ชาวเหนือ', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782871', null, '7', '0058', 'CJ02');
INSERT INTO `customer` VALUES ('2956', 'CU-2100119', 'โพหัก', 'โพหัก', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9445018', null, '7', '0048', 'CJ02');
INSERT INTO `customer` VALUES ('2957', 'CU-2100120', 'ประสาทสิทธิ์', 'ประสาทสิทธิ์', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9950648', null, '7', '0063', 'CJ02');
INSERT INTO `customer` VALUES ('2958', 'CU-2100121', 'ดอนกรวย', 'ดอนกรวย', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '097-0755873', null, '7', '0495', 'CJ02');
INSERT INTO `customer` VALUES ('2959', 'CU-2100122', 'ดำเนิน 1', 'ดำเนิน 1', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443869', null, '7', '0025', 'CJ02');
INSERT INTO `customer` VALUES ('2960', 'CU-2100123', 'ตลาดน้ำดำเนิน2', 'ตลาดน้ำดำเนิน2', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '089-8373331', null, '7', '0099', 'CJ02');
INSERT INTO `customer` VALUES ('2961', 'CU-2100124', 'วัดเพลง', 'วัดเพลง', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9818496', null, '7', '0059', 'CJ02');
INSERT INTO `customer` VALUES ('2962', 'CU-2100125', 'ปากท่อ1', 'ปากท่อ1', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '092-2500460', null, '7', '0270', 'CJ02');
INSERT INTO `customer` VALUES ('2963', 'CU-2100126', 'ปากท่อ3', 'ปากท่อ3', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2991057', null, '7', '0143', 'CJ02');
INSERT INTO `customer` VALUES ('2964', 'CU-2100127', 'ปากท่อ2', 'ปากท่อ2', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782853', null, '7', '0056', 'CJ02');
INSERT INTO `customer` VALUES ('2965', 'CU-2100128', 'ห้วยชินสีห์', 'ห้วยชินสีห์', '9', '', '19', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '24', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9447815', null, '7', '0066', 'CJ02');
INSERT INTO `customer` VALUES ('2966', 'CU-2100130', 'ชุมชนจันทราคามพิทักษ์', 'ชุมชนจันทราคามพิทักษ์', '9', '', '20', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '098-2612413', null, '7', '0223', 'CJ03');
INSERT INTO `customer` VALUES ('2967', 'CU-2100131', 'เหนือวัง', 'เหนือวัง', '9', '', '20', null, null, null, '1', null, null, '1613193069', '1613193069', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443960', null, '7', '0051', 'CJ03');
INSERT INTO `customer` VALUES ('2968', 'CU-2100132', 'สวนตะไคร้', 'สวนตะไคร้', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9445029', null, '7', '0052', 'CJ03');
INSERT INTO `customer` VALUES ('2969', 'CU-2100133', 'ลำพยา', 'ลำพยา', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3781953', null, '7', '0121', 'CJ03');
INSERT INTO `customer` VALUES ('2970', 'CU-2100134', 'โพรงมะเดื่อ', 'โพรงมะเดื่อ', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '061-3841236', null, '7', '0276', 'CJ03');
INSERT INTO `customer` VALUES ('2971', 'CU-2100135', 'วัดลาดหญ้าไทร', 'วัดลาดหญ้าไทร', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '084-1091976', null, '7', '0474', 'CJ03');
INSERT INTO `customer` VALUES ('2972', 'CU-2100136', 'หนองงูเหลือม', 'หนองงูเหลือม', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '095-3847827', null, '7', '0429', 'CJ03');
INSERT INTO `customer` VALUES ('2973', 'CU-2100137', 'ห้วยกระบอก', 'ห้วยกระบอก', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-7050550', null, '7', '0086', 'CJ03');
INSERT INTO `customer` VALUES ('2974', 'CU-2100138', 'วัดกำแพงแสน', 'วัดกำแพงแสน', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', null, '10', '0014', 'CJ03');
INSERT INTO `customer` VALUES ('2975', 'CU-2100139', 'กำแพงแสน', 'กำแพงแสน', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', null, '7', '0046', 'CJ03');
INSERT INTO `customer` VALUES ('2976', 'CU-2100140', 'วังน้ำเขียว', 'วังน้ำเขียว', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', null, '7', '0547', 'CJ03');
INSERT INTO `customer` VALUES ('2977', 'CU-2100141', 'สระพัฒนา', 'สระพัฒนา', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1590947', null, '7', '0284', 'CJ03');
INSERT INTO `customer` VALUES ('2978', 'CU-2100142', 'บางหลวง', 'บางหลวง', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2991034', null, '7', '0142', 'CJ03');
INSERT INTO `customer` VALUES ('2979', 'CU-2100143', 'บางเลน', 'บางเลน', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1482849', null, '7', '0343', 'CJ03');
INSERT INTO `customer` VALUES ('2980', 'CU-2100144', 'ตลาดโรงยาง', 'ตลาดโรงยาง', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '097-0759705', null, '7', '0290', 'CJ03');
INSERT INTO `customer` VALUES ('2981', 'CU-2100145', 'นราภิรมย์', 'นราภิรมย์', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1591013', null, '7', '0285', 'CJ03');
INSERT INTO `customer` VALUES ('2982', 'CU-2100146', 'ศาลายา', 'ศาลายา', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9415552', null, '7', '0105', 'CJ03');
INSERT INTO `customer` VALUES ('2983', 'CU-2100147', 'ห้วยพลู', 'ห้วยพลู', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443498', null, '7', '0015', 'CJ03');
INSERT INTO `customer` VALUES ('2984', 'CU-2100148', 'แหลมบัว', 'แหลมบัว', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', null, '7', '0507', 'CJ03');
INSERT INTO `customer` VALUES ('2985', 'CU-2100149', 'บางพระ', 'บางพระ', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3780433', null, '7', '0116', 'CJ03');
INSERT INTO `customer` VALUES ('2986', 'CU-2100150', 'บ้านหลวง', 'บ้านหลวง', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '097-2790875', null, '7', '0411', 'CJ03');
INSERT INTO `customer` VALUES ('2987', 'CU-2100151', 'ดอนตูม', 'ดอนตูม', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443563', null, '7', '0012', 'CJ03');
INSERT INTO `customer` VALUES ('2988', 'CU-2100152', 'วัดตาก้อง', 'วัดตาก้อง', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1590965', null, '7', '0287', 'CJ03');
INSERT INTO `customer` VALUES ('2989', 'CU-2100153', 'วัดพะเนียงแตก', 'วัดพะเนียงแตก', '9', '', '20', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '25', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', null, '7', '0493', 'CJ03');
INSERT INTO `customer` VALUES ('2990', 'CU-2100154', 'ห้วยจรเข้', 'ห้วยจรเข้', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782876', null, '7', '0057', 'CJ04');
INSERT INTO `customer` VALUES ('2991', 'CU-2100155', 'ทุ่งพระเมรุ', 'ทุ่งพระเมรุ', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3783170', null, '7', '0138', 'CJ04');
INSERT INTO `customer` VALUES ('2992', 'CU-2100156', 'วัดไผ่ล้อม', 'วัดไผ่ล้อม', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3789137', null, '7', '0132', 'CJ04');
INSERT INTO `customer` VALUES ('2993', 'CU-2100157', 'ต้นสน', 'ต้นสน', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443926', null, '7', '0053', 'CJ04');
INSERT INTO `customer` VALUES ('2994', 'CU-2100158', 'ประปานาสร้าง', 'ประปานาสร้าง', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-8568240', null, '7', '0074', 'CJ04');
INSERT INTO `customer` VALUES ('2995', 'CU-2100159', 'สี่แยกวัดกลาง', 'สี่แยกวัดกลาง', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '098-2612421', null, '7', '0225', 'CJ04');
INSERT INTO `customer` VALUES ('2996', 'CU-2100160', 'บ่อพลับ', 'บ่อพลับ', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3780912', null, '7', '0159', 'CJ04');
INSERT INTO `customer` VALUES ('2997', 'CU-2100161', 'หน้าวัด3กระบือเผือก', 'หน้าวัด3กระบือเผือก', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2990347', null, '7', '0176', 'CJ04');
INSERT INTO `customer` VALUES ('2998', 'CU-2100162', 'พุทธมณฑลสาย7', 'พุทธมณฑลสาย7', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2990355', null, '7', '0185', 'CJ04');
INSERT INTO `customer` VALUES ('2999', 'CU-2100163', 'วัดไร่ขิง', 'วัดไร่ขิง', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9440935', null, '7', '0072', 'CJ04');
INSERT INTO `customer` VALUES ('3000', 'CU-2100164', 'ดอนหวาย', 'ดอนหวาย', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-2286532', null, '7', '0477', 'CJ04');
INSERT INTO `customer` VALUES ('3001', 'CU-2100165', 'นครชื่นชุ่ม', 'นครชื่นชุ่ม', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-7957819', null, '7', '0412', 'CJ04');
INSERT INTO `customer` VALUES ('3002', 'CU-2100166', 'ซอยไวไว', 'ซอยไวไว', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-5704587', null, '7', '0446', 'CJ04');
INSERT INTO `customer` VALUES ('3003', 'CU-2100167', 'เทียนดัด 2', 'เทียนดัด 2', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782843', null, '7', '0123', 'CJ04');
INSERT INTO `customer` VALUES ('3004', 'CU-2100168', 'เทียนดัด', 'เทียนดัด', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-7363838', null, '7', '0079', 'CJ04');
INSERT INTO `customer` VALUES ('3005', 'CU-2100169', 'สามพราน', 'สามพราน', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443506', null, '7', '0013', 'CJ04');
INSERT INTO `customer` VALUES ('3006', 'CU-2100170', 'แยกอนุสาวรีย์', 'แยกอนุสาวรีย์', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443583', null, '7', '0189', 'CJ04');
INSERT INTO `customer` VALUES ('3007', 'CU-2100171', 'คลองใหม่', 'คลองใหม่', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '061-0126564', null, '7', '0294', 'CJ04');
INSERT INTO `customer` VALUES ('3008', 'CU-2100172', 'ซอยวัดไทร(นครปฐม)', 'ซอยวัดไทร(นครปฐม)', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2990605', null, '10', '0195', 'CJ04');
INSERT INTO `customer` VALUES ('3009', 'CU-2100173', 'ห้วยตะโก', 'ห้วยตะโก', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '097-2791042', null, '7', '0415', 'CJ04');
INSERT INTO `customer` VALUES ('3010', 'CU-2100174', 'โคกพระ', 'โคกพระ', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-2688131', null, '7', '0289', 'CJ04');
INSERT INTO `customer` VALUES ('3011', 'CU-2100175', 'ดอนยายหอม', 'ดอนยายหอม', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3780461', null, '7', '0127', 'CJ04');
INSERT INTO `customer` VALUES ('3012', 'CU-2100176', 'ตลาดจินดา', 'ตลาดจินดา', '9', '', '21', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '26', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '061-0126457', null, '7', '0292', 'CJ04');
INSERT INTO `customer` VALUES ('3013', 'CU-2100177', 'IFC-10', 'IFC-10', '10', '', '17', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '27', '', '', null, '7', 'ไม่ระบุ', 'VP16');
INSERT INTO `customer` VALUES ('3014', 'CU-2100178', 'IFC-11', 'IFC-11', '10', '', '17', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, '', '27', '', '', null, '7', 'ไม่ระบุ', 'VP16');
INSERT INTO `customer` VALUES ('3015', 'CU-2100179', 'หมีพ่นไฟ', 'หมีพ่นไฟ', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3016', 'CU-2100180', 'feel Good', 'feel Good', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3017', 'CU-2100181', 'O Cha ya', 'O Cha ya', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3018', 'CU-2100182', 'ชาคุมะ', 'ชาคุมะ', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3019', 'CU-2100183', 'Rabbit Bubble', 'Rabbit Bubble', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3020', 'CU-2100184', 'เฉาก๋วย เต็งหนึ่ง', 'เฉาก๋วย เต็งหนึ่ง', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3021', 'CU-2100185', 'หมูสะเต๊ะ พี่จุ๋ม', 'หมูสะเต๊ะ พี่จุ๋ม', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3022', 'CU-2100186', 'น้ำดื่ม น้ำทิพย์', 'น้ำดื่ม น้ำทิพย์', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3023', 'CU-2100187', 'คั่วไก่ ไข่ลาวา', 'คั่วไก่ ไข่ลาวา', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3024', 'CU-2100188', 'เตี๋ยวเลิศรส', 'เตี๋ยวเลิศรส', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3025', 'CU-2100189', 'Brown BEF', 'Brown BEF', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3026', 'CU-2100190', 'ผัดไท แม่วรรณ', 'ผัดไท แม่วรรณ', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3027', 'CU-2100191', 'เมี่ยงญวน', 'เมี่ยงญวน', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3028', 'CU-2100192', 'น้ำจับเลี้ยง สระบัว', 'น้ำจับเลี้ยง สระบัว', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3029', 'CU-2100193', 'Jer ma Jer', 'Jer ma Jer', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3030', 'CU-2100194', 'Ninja ซูซิ', 'Ninja ซูซิ', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3031', 'CU-2100195', 'คำหวาน', 'คำหวาน', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3032', 'CU-2100196', 'น้ำดื่ม ป้าสมจิตร', 'น้ำดื่ม ป้าสมจิตร', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3033', 'CU-2100197', 'ขนมจีน ป้าสมจิตร', 'ขนมจีน ป้าสมจิตร', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3034', 'CU-2100198', 'อิ่มอร่อยกับเฮียตรง', 'อิ่มอร่อยกับเฮียตรง', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3035', 'CU-2100199', 'นมหมี', 'นมหมี', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3036', 'CU-2100200', 'ข้าวขาหมูพี่เกด', 'ข้าวขาหมูพี่เกด', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3037', 'CU-2100201', 'หมูบินเกาหลี', 'หมูบินเกาหลี', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3038', 'CU-2100202', 'แหนมหมูอินดิ้', 'แหนมหมูอินดิ้', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3039', 'CU-2100203', 'อาหารคลีน', 'อาหารคลีน', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3040', 'CU-2100204', 'จันทร์เอ๋ยจันทร์เจ้า', 'จันทร์เอ๋ยจันทร์เจ้า', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3041', 'CU-2100205', 'แบล็คชิกคาเฟ่', 'แบล็คชิกคาเฟ่', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3042', 'CU-2100206', 'เตี๋ยวเย็นตาโฟ', 'เตี๋ยวเย็นตาโฟ', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3043', 'CU-2100207', 'ข้าวมันไก่นายพล', 'เตี๋ยวเย็นตาโฟ', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3044', 'CU-2100208', 'ดีไลน์', 'ดีไลน์', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3045', 'CU-2100209', 'ลูกชิ้นหมูทิพย์', 'ลูกชิ้นหมูทิพย์', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3046', 'CU-2100210', 'Toy ลูกชิ้นทอด', 'Toy ลูกชิ้นทอด', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3047', 'CU-2100211', 'หมุปิ้งฮีโร่', 'หมูปิ้งฮีโร่', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3048', 'CU-2100212', 'นกกาแฟสด', 'นกกาแฟสด', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3049', 'CU-2100213', 'แซ่บจี๊ดจ๊าด', 'แซ่บจี๊ดจ๊าด', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3050', 'CU-2100214', 'วุ้นเส้นเจ้าสัว', 'วุ้นเส้นเจ้าสัว', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3051', 'CU-2100215', 'หมึกย่าง', 'หมึกย่าง', '10', '', '23', null, null, null, '1', null, null, '1613193070', '1613193070', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3052', 'CU-2100216', 'ชา', 'ชา', '10', '', '23', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3053', 'CU-2100218', 'แม่บ้าน-รปภ.', 'แม่บ้าน-รปภ.', '10', '', '23', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '28', '', '', null, '9', 'ไม่ระบุ', 'VP17');
INSERT INTO `customer` VALUES ('3054', 'CU-2100219', 'เฮียติ', 'เฮียติ', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '29', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3055', 'CU-2100220', 'พ่อเฮียติ', 'พ่อเฮียติ', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '29', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3056', 'CU-2100221', 'เจ๊ติ๊ก', 'เจ๊ติ๊ก', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3057', 'CU-2100222', 'เจ๊ขวัญ', 'เจ๊ขวัญ', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3058', 'CU-2100223', 'เจ๊แต๋ว', 'เจ๊แต๋ว', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3059', 'CU-2100224', 'เจ๊สาว', 'เจ๊สาว', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3060', 'CU-2100225', 'เจ๊เพ็ญ', 'เจ๊เพ็ญ', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3061', 'CU-2100226', 'ร้านเพลิน', 'ร้านเพลิน', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3062', 'CU-2100227', 'ก๋วยเตี๋ยวแม่กลอง', 'ก๋วยเตี๋ยวแม่กลอง', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3063', 'CU-2100228', 'อเมซอล ซ.กลาง', 'อเมซอล ซ.กลาง', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '19 ถนนรถไฟ ตำบลพระปฐมเจดีย์ อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3064', 'CU-2100229', 'อเมซอล ซ.4', 'อเมซอล ซ.4', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '333 ถนนพิพัธประสาท ตำบลพระปฐมเจดีย์ อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3065', 'CU-2100230', 'เจ๊ยุพา', 'เจ๊ยุพา', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3066', 'CU-2100231', 'เจ๊แดง', 'เจ๊แดง', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3067', 'CU-2100232', 'เจ๊อร', 'เจ๊อร', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '31', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3068', 'CU-2100233', 'เจ๊ปุ๊ก', 'เจ๊ปุ๊ก', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3069', 'CU-2100234', 'อาแปะ', 'อาแปะ', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3070', 'CU-2100235', 'เจ้เพลิน', 'ร้านเพลิน', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3071', 'CU-2100236', 'เจ๊กี', 'เจ๊ปุ๊ก', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3072', 'CU-2100237', 'เจ๊จุ๋ม', 'เจ๊จุ๋ม', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3073', 'CU-2100238', 'ป้าแก้ว', 'ป้าแก้ว', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3074', 'CU-2100239', 'ก๋วยเตี๋ยว จ่า ช.', 'ก๋วยเตี๋ยว จ่า ช.', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3075', 'CU-2100240', 'ร้านองุ่น', 'ร้านองุ่น', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '32', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3076', 'CU-2100241', 'เฮียรุ่ง', 'เฮียรุ่ง', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3077', 'CU-2100242', 'เจ๊วารี ตึก1', 'เจ๊วารี ตึก1', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3078', 'CU-2100243', 'เจ๊รี', 'เจ๊รี', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3079', 'CU-2100244', 'ช.บะหมี่', 'ช.บะหมี่', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3080', 'CU-2100245', 'อรพรรณ', 'ร้านพริ้ม', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3081', 'CU-2100246', 'เจ๊ไหม', 'เจ๊ไหม', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3082', 'CU-2100247', 'ร้านพริ้ม', 'ร้านพริ้ม', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3083', 'CU-2100248', 'วินเนอร์ คาราโอเกะ', 'วินเนอร์ คาราโอเกะ', '10', '', '24', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '30', '', '', null, '10', 'ไม่ระบุ', 'VP18');
INSERT INTO `customer` VALUES ('3084', 'CU-2100249', 'พี่ต่าย', 'พี่ต่าย', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3085', 'CU-2100250', 'เจ้เพ็ญ', 'เจ้เพ็ญ', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3086', 'CU-2100251', 'เสริมสวย', 'เสริมสวย', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3087', 'CU-2100252', 'พี่แรง', 'พี่แรง', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3088', 'CU-2100253', 'พี่บูรณ์', 'พี่บูรณ์', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3089', 'CU-2100254', 'พี่บุญชู', 'พี่บุญชู', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3090', 'CU-2100255', 'เจ้มัด', 'เจ้มัด', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3091', 'CU-2100256', 'พี่วินัย', 'พี่วินัย', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3092', 'CU-2100257', 'เจ้ติ๋ม', 'เจ้ติ๋ม', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3093', 'CU-2100258', 'พี่น้ำค้าง', 'พี่น้ำค้าง', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3094', 'CU-2100259', 'พี่สุดาภา', 'พี่สุดาภา', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3095', 'CU-2100260', 'ป้าอัด', 'ป้าอัด', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3096', 'CU-2100261', 'เจ้พี', 'เจ้พี', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3097', 'CU-2100262', 'พี่ชม้าย', 'พี่ชม้าย', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3098', 'CU-2100263', 'พี่นิด', 'พี่นิด', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3099', 'CU-2100264', 'ร้านกาแฟ', 'ร้านกาแฟ', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3100', 'CU-2100265', 'Freedom', 'Freedom', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3101', 'CU-2100266', 'บะหมี่', 'บะหมี่', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3102', 'CU-2100267', 'ข้าวแกง', 'ข้าวแกง', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3103', 'CU-2100268', 'ตามสั่ง 1', 'ข้าวแกง', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3104', 'CU-2100269', 'ตาระ', 'ตาระ', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3105', 'CU-2100270', 'ไก่มะระ', 'ไก่มะระ', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3106', 'CU-2100271', 'พี่จูน', 'พี่จูน', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3107', 'CU-2100272', 'เจ้แก่น', 'เจ้แก่น', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3108', 'CU-2100273', 'เฌอแตม', 'เฌอแตม', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3109', 'CU-2100274', 'โรงเรียน พี่ขุน', 'โรงเรียน พี่ขุน', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3110', 'CU-2100275', 'ขายมะพร้าว', 'ไพโรจน์', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '33', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3111', 'CU-2100276', 'ป้าโก๊ะ', 'ป้าโก๊ะ', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '34', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3112', 'CU-2100277', 'เฮียทุด', 'เฮียทุด', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '34', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3113', 'CU-2100278', 'ไพโรจน์', 'ไพโรจน์', '10', '', '25', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '34', '', '', null, '10', 'ไม่ระบุ', 'VP19');
INSERT INTO `customer` VALUES ('3114', 'CU-2100279', 'เต็กฮง', 'เต็กฮง - จ๊อก', '10', '', '26', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '35', '', '', null, '10', 'ไม่ระบุ', 'VP20');
INSERT INTO `customer` VALUES ('3115', 'CU-2100280', 'ไก่', 'ไก่ - จ๊อก', '10', '', '26', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '35', '', '', null, '10', 'ไม่ระบุ', 'VP20');
INSERT INTO `customer` VALUES ('3116', 'CU-2100281', 'เช็งฮวง', 'เช็งฮวง - จ๊อก', '10', '', '26', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '35', '', '', null, '10', 'ไม่ระบุ', 'VP20');
INSERT INTO `customer` VALUES ('3117', 'CU-2100282', 'ถุงทอง', 'ถุงทอง - จ๊อก', '10', '', '26', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, '', '35', '', '', null, '10', 'ไม่ระบุ', 'VP20');
INSERT INTO `customer` VALUES ('3118', 'CU-2100283', 'เฮียหยู', 'เฮียหยู - ตู้', '10', '', '27', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '36', '', '', null, '9', 'ไม่ระบุ', 'VP21');
INSERT INTO `customer` VALUES ('3119', 'CU-2100284', 'กม.5', 'กม.5 - ตู้', '10', '', '27', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '36', '', '', null, '9', 'ไม่ระบุ', 'VP21');
INSERT INTO `customer` VALUES ('3120', 'CU-2100285', 'ม่วงตารส', 'ม่วงตารส - ตู้', '10', '', '27', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '36', '', '', null, '9', 'ไม่ระบุ', 'VP21');
INSERT INTO `customer` VALUES ('3121', 'CU-2100286', 'ธัญญบูรณ์', 'ธัญญบูรณ์ - ตู้', '10', '', '27', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '36', '', '', null, '9', 'ไม่ระบุ', 'VP21');
INSERT INTO `customer` VALUES ('3122', 'CU-2100287', 'เฮียสุด', 'เฮียสุด - ตู้', '10', '', '27', null, null, null, '1', null, null, '1613193071', '1613193071', null, null, 'NULL', '37', '', '', null, '9', 'ไม่ระบุ', 'VP21');
INSERT INTO `customer` VALUES ('3123', 'CU-2100288', 'ก๊อต', 'ก๊อต - ตู้', '10', '', '27', null, null, null, '1', null, null, '1613193072', '1613193072', null, null, 'NULL', '36', '', '', null, '9', 'ไม่ระบุ', 'VP21');
INSERT INTO `customer` VALUES ('3124', 'CU-2100289', 'เจ้วงศ์', 'เจ้วงศ์ - ตู้', '10', '', '27', null, null, null, '1', null, null, '1613193072', '1613193072', null, null, 'NULL', '36', '', '', null, '9', 'ไม่ระบุ', 'VP21');
INSERT INTO `customer` VALUES ('3125', 'CU-2100290', 'ปิ่นทิพย์', 'ปิ่นทิพย์ - บอย', '10', '', '28', null, null, null, '1', null, null, '1613193072', '1613193072', null, null, 'NULL', '38', '', '', null, '7', 'ไม่ระบุ', 'VP22');
INSERT INTO `customer` VALUES ('3126', 'CU-2100291', 'เต็กฮงจั่น', 'เต็กฮงจั่น - บอย', '10', '', '28', null, null, null, '1', null, null, '1613193072', '1613193072', null, null, 'NULL', '38', '', '', null, '7', 'ไม่ระบุ', 'VP22');
INSERT INTO `customer` VALUES ('3127', 'CU-2100292', 'ดาว', 'ดาว - บอย', '10', '', '28', null, null, null, '1', null, null, '1613193072', '1613193072', null, null, 'NULL', '38', '', '', null, '10', 'ไม่ระบุ', 'VP22');
INSERT INTO `customer` VALUES ('3128', 'CU-2100293', 'หยู', 'หยู-แซม', '10', '', '29', null, null, null, '1', null, null, '1613193072', '1613193072', null, null, '', '39', '', '', null, '10', 'ไม่ระบุ', 'VP23');
INSERT INTO `customer` VALUES ('3201', 'CU-2100001', 'สน. บรมราชชนนี ขาเข้า CC1799', 'สน. บรมราชชนนี ขาเข้า CC1799', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613279438', null, null, ' ', '40', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'CC1799', '');
INSERT INTO `customer` VALUES ('3202', 'CU-2100002', 'สน. ราชพฤกษ์ 1 CC2844', 'สน. ราชพฤกษ์ 1 CC2844', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206381', null, null, ' ', '40', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'CC2844', '');
INSERT INTO `customer` VALUES ('3203', 'CU-2100003', 'ม.สยาม CC2844', 'ม.สยาม CC2844', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206372', null, null, ' ', '40', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC1853', '');
INSERT INTO `customer` VALUES ('3204', 'CU-2100004', 'The Mall บางแค ชั้น 1 SC0899', 'The Mall บางแค ชั้น 1 SC0899', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206363', null, null, ' ', '40', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC0899', '');
INSERT INTO `customer` VALUES ('3205', 'CU-2100005', 'อเมซอนหน้ากรมแรงงาน', 'อเมซอนหน้ากรมแรงงาน', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206572', null, null, ' ', '77', '20 ถนนบรมราชชนนี แขวงฉิมพลี เขตตลิ่งชัน กรุงเทพฯ 10170', '092-2947926', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3206', 'CU-2100006', 'รพ.เกษมราษฎร์ บางแค', 'รพ.เกษมราษฎร์ บางแค', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206271', null, null, ' ', '77', '586 ถนนเพชรเกษม แขวงบางแคเหนือ เขตบางแค กรุงเทพฯ 10160', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3207', 'CU-2100007', 'หม่อมถนัดแดก', 'หม่อมถนัดแดก', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206311', null, null, ' ', '77', '8/5,8/6 ถนนรัชดา-รามอีนทรา แขวงนวลจันทร์ เขตบึงกุ่ม กรุงเทพฯ 10230', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3208', 'CU-2100008', 'ร้านขนมจีนบางกอก', 'ร้านขนมจีนบางกอก', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206218', null, null, ' ', '77', '', '', '2', '1', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3209', 'CU-2100009', 'ร้านฮั่วเช่งฮง1', 'ร้านฮั่วเช่งฮง1', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206297', null, null, ' ', '77', '41 ซอยสุภาพงษ์ 3 แยก 5-2 แขวงหนองบอน เขตประเวศ กรุงเทพฯ 10250', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3210', 'CU-2100010', 'ร้านเทียนกงข้าวมันไก่', 'ร้านเทียนกงข้าวมันไก่', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613279568', null, null, ' ', '77', '', '062-2501250', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3211', 'CU-2100011', 'ลิ้มเหล่าโหงว', 'ลิ้มเหล่าโหงว', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613279595', null, null, ' ', '77', '', '', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3212', 'CU-2100012', 'อเมซอนหนองแขม CC3763', 'อเมซอนหนองแขม CC3763', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206287', null, null, ' ', '40', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10899', '', '2', '3', 'CC3763', '');
INSERT INTO `customer` VALUES ('3213', 'CU-2100013', 'อเมซอนสวนผัก CC3794', 'อเมซอนสวนผัก CC3794', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613206135', null, null, ' ', '40', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'CC3794', '');
INSERT INTO `customer` VALUES ('3214', 'CU-2100014', 'รปภ.', 'รปภ.', '8', '', '860', null, null, '', '1', null, null, '1613203692', '1613205989', null, null, ' ', '40', '', '', '2', '3', 'AZ01', '');
INSERT INTO `customer` VALUES ('3215', 'CU-2100015', 'ธรรมศาลา CC2160', 'ธรรมศาลา CC2160', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613281047', null, null, ' ', '78', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'CC2160', '');
INSERT INTO `customer` VALUES ('3216', 'CU-2100016', 'อเมซอน สาย 7', 'อเมซอน สาย 7', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613281035', null, null, ' ', '78', '64/31 หมู่ที่ 1 ตำบลขุนแก้ว อำเภอนครชัยศรี จังหวัดนครปฐม 73120', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3217', 'CU-2100017', 'ตลาดพลู ธนบุรี SC3118', 'ตลาดพลู ธนบุรี SC3118', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613281026', null, null, ' ', '78', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC3118', '');
INSERT INTO `customer` VALUES ('3218', 'CU-2100018', 'ตลาดครอบครัว ท่าพระ SC3348', 'ตลาดครอบครัว ท่าพระ SC3348', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613281013', null, null, ' ', '78', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC3348', '');
INSERT INTO `customer` VALUES ('3219', 'CU-2100019', 'The Mall ท่าพระ SC1674', 'The Mall ท่าพระ SC1674', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613280991', null, null, ' ', '78', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC1674', '');
INSERT INTO `customer` VALUES ('3220', 'CU-2100020', 'อเมซอน สาย 2', 'อเมซอน สาย 2', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613280976', null, null, ' ', '79', '42/33 ห้องเลขที่ C201 แขวงศาลาธรรมสพน์ เขตทวีวัฒนา กรุงเทพฯ 10170', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3221', 'CU-2100021', 'ร้านฮั่วเช่งฮง2', 'ร้านฮั่วเช่งฮง2', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613280963', null, null, ' ', '79', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3222', 'CU-2100022', 'ร้านผลไม้ ตลาดครอบครัวท่าพระ', 'ร้านผลไม้ ตลาดครอบครัวท่าพระ', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613280952', null, null, ' ', '79', '', '098-4646828', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3223', 'CU-2100023', 'น้ำปั่นพี่ใช้ ท่าพระ', 'น้ำปั่นพี่ใช้ ท่าพระ', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613280935', null, null, ' ', '79', '', '', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3224', 'CU-2100024', 'หมีพ่นไฟ สาย 7', 'หมีพ่นไฟ สาย 7', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613280918', null, null, ' ', '79', '', '', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3225', 'CU-2100025', 'กาแฟสด พี่ก้อย', 'กาแฟสด พี่ก้อย', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613280903', null, null, ' ', '79', '', '', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3226', 'CU-2100026', 'ขายสด', 'ขายสด', '8', '', '861', null, null, '', '1', null, null, '1613203692', '1613280889', null, null, ' ', '79', '', '', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3227', 'CU-2100028', 'กฟผ. SC1606', 'กฟผ. SC1606', '8', '', '862', null, null, '', '1', null, null, '1613203692', '1613206982', null, null, ' ', '80', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '093-125-1978', '2', '3', 'SC1606', '');
INSERT INTO `customer` VALUES ('3228', 'CU-2100029', 'อาคารศรีสวรินทิรา รพ.ศิริราช SC3434', 'อาคารศรีสวรินทิรา รพ.ศิริราช SC3434', '8', '', '862', null, null, '', '1', null, null, '1613203692', '1613206991', null, null, ' ', '80', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '064-952-3618', '2', '3', 'SC3434', '');
INSERT INTO `customer` VALUES ('3229', 'CU-2100030', 'คณะพยาบาลศาสตร์ รพ.ศิริราช SC2069', 'คณะพยาบาลศาสตร์ รพ.ศิริราช SC2069', '8', '', '862', null, null, '', '1', null, null, '1613203692', '1613206959', null, null, ' ', '80', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '096-248-5951', '2', '3', 'SC2069', '');
INSERT INTO `customer` VALUES ('3230', 'CU-2100031', 'สถานีรถไฟธนบุรี SC2977', 'สถานีรถไฟธนบุรี SC2977', '8', '', '862', null, null, '', '1', null, null, '1613203692', '1613206948', null, null, ' ', '80', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '091-868-5727', '2', '3', 'SC2977', '');
INSERT INTO `customer` VALUES ('3231', 'CU-2100032', 'กรมสวัสดิการทหารเรือ SC2895', 'กรมสวัสดิการทหารเรือ SC2895', '8', '', '862', null, null, '', '1', null, null, '1613203692', '1613206938', null, null, ' ', '80', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '092-296-1926', '2', '3', 'SC2895', '');
INSERT INTO `customer` VALUES ('3232', 'CU-2100033', 'Central ปิ่นเกล้า SC1483', 'Central ปิ่นเกล้า SC1483', '8', '', '862', null, null, '', '1', null, null, '1613203692', '1613284553', null, null, ' ', '80', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '085-999-5622', '2', '3', 'SC1483', '');
INSERT INTO `customer` VALUES ('3233', 'CU-2100034', 'อเมซอนปิ่นเกล้า (ออซั่ม 7) ', '', '8', '', '862', null, null, '', '1', null, null, '1613203692', '1613284568', null, null, ' ', '85', '', '', '2', '4', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3234', 'CU-2100037', 'สน.ราชพฤกษ์ 3 CC2369', 'สน.ราชพฤกษ์ 3 CC2369', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613207069', null, null, ' ', '81', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '096-248-5951', '2', '3', 'CC2369', '');
INSERT INTO `customer` VALUES ('3235', 'CU-2100038', 'สน.ตลิ่งชัน CC1579', 'สน.ตลิ่งชัน CC1579', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613207060', null, null, ' ', '81', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '099-310-0389', '2', '3', 'CC1579', '');
INSERT INTO `customer` VALUES ('3236', 'CU-2100039', 'Lotus บางกรวย-ไทรน้อย SC2571', 'Lotus บางกรวย-ไทรน้อย SC2571', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613207049', null, null, ' ', '81', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '061-397-9928', '2', '3', 'SC2571', '');
INSERT INTO `customer` VALUES ('3237', 'CU-2100040', 'Central เวสต์เกต ชั้น 2 SC1199', 'Central เวสต์เกต ชั้น 2 SC1199', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613207038', null, null, ' ', '81', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '097-236-3618', '2', '3', 'SC1199', '');
INSERT INTO `customer` VALUES ('3238', 'CU-2100041', 'Central เวสต์เกต ชั้น 1 SC2780', 'Central เวสต์เกต ชั้น 1 SC2780', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613207028', null, null, ' ', '81', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '095-115-4263', '2', '3', 'SC2780', '');
INSERT INTO `customer` VALUES ('3239', 'CU-2100042', 'อเมซอนไทวัสดุ ', 'อเมซอนไทวัสดุ (25)', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613285895', null, null, ' ', '86', '59/9 หมู่1 ตำบลบางบัวทอง อำเภอบางบัวทอง จังหวัดนนทบุรี 11110', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3240', 'CU-2100043', 'เตี๋ยวเรืออนุเสาวรีย์ 4', 'เตี๋ยวเรืออนุเสาวรีย์ 4', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613207003', null, null, ' ', '86', '199/90 หมู่ 5 ตำบลบางขนุน อำเภอบางกรวย จังหวัดนนทบุรี 11130', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3241', 'CU-2100044', 'ชานมไข่มุก โลตัสบางกรวย', 'ชานมไข่มุก โลตัสบางกรวย', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613285922', null, null, ' ', '86', '', '', '4', '4', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3242', 'CU-2100045', 'ราดหน้าอินเตอร์', '', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613285973', null, null, ' ', '86', '', '', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3243', 'CU-2100046', 'จูซซิ่ง เซ็กชั่น  ', 'น้ำส้ม  ไทวัสดุ', '8', '', '863', null, null, '', '1', null, null, '1613203692', '1613285374', null, null, ' ', '86', '', '', '1', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3244', 'CU-2100049', 'กระทรวงพาณิชย์ นนทบุรี SC3449', 'กระทรวงพาณิชย์ นนทบุรี SC3449', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613211808', null, null, ' ', '82', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '099-507-3544', '2', '3', 'SC3449', '');
INSERT INTO `customer` VALUES ('3245', 'CU-2100050', 'สลากกินแบ่งรัฐบาล SC2769', 'สลากกินแบ่งรัฐบาล SC2769', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613211799', null, null, ' ', '82', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '089-306-8233', '2', '3', 'SC2769', '');
INSERT INTO `customer` VALUES ('3246', 'CU-2100051', 'ปปช. SC1003', 'ปปช. SC1003', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613211791', null, null, ' ', '82', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '094-536-2445', '2', '3', 'SC1003', '');
INSERT INTO `customer` VALUES ('3247', 'CU-2100052', 'ชลประทานปากเกร็ด SC2862', 'ชลประทานปากเกร็ด SC2862', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613211783', null, null, ' ', '82', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '097-165-6727', '2', '3', 'SC2862', '');
INSERT INTO `customer` VALUES ('3248', 'CU-2100053', 'Central เเจ้งวัฒนะ SC1633', 'Central เเจ้งวัฒนะ SC1633', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613211764', null, null, ' ', '82', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '093-831-1650', '2', '3', 'SC1633', '');
INSERT INTO `customer` VALUES ('3249', 'CU-2100054', 'โครงการNicheID SC3443', 'โครงการNicheID SC3443', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613211754', null, null, ' ', '82', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '099-063-9239', '2', '3', 'SC3443', '');
INSERT INTO `customer` VALUES ('3250', 'CU-2100055', 'อเมซอน แจ้งวัฒนะ ', 'อเมซอน แจ้งวัฒนะ (25)', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613211745', null, null, ' ', '87', '61/4 หมู่4 ถนนแจ้งวัฒนะ ตำบลปากเกร็ด อำเภอปากเกร็ด จังหวัดนนทบุรี 11120', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3251', 'CU-2100056', 'ราดหน้าบียอน ', 'ราดหน้าบียอน (25)', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613286279', null, null, ' ', '87', '', '', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3252', 'CU-2100057', 'เมืองทอง เอ็มโซไซตี้', 'เมืองทอง เอ็มโซไซตี้ (25)', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613211722', null, null, ' ', '87', '120/1072 หมู่ที่ 9 ตำบลบางพูด อำเภอปากเกร็ด จังหวัดนนทบุรี 11120', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3253', 'CU-2100058', 'เมืองทอง บรอนสตีท', 'เมืองทอง บรอนสตีท (25)', '8', '', '864', null, null, '', '1', null, null, '1613203692', '1613211706', null, null, ' ', '87', '50/251 หมู่ที่ 6 ตำบลบ้านใหม่ อำเภอปากเกร็ด จังหวัดนนทบุรี 11120', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3254', 'CU-2100062', 'สน.ร.พ.ศรีธัญญา CC3038', 'สน.ร.พ.ศรีธัญญา CC3038', '8', '', '865', null, null, '', '1', null, null, '1613203692', '1613206227', null, null, ' ', '83', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '082-585-8564', '2', '3', 'CC3038', '');
INSERT INTO `customer` VALUES ('3255', 'CU-2100063', 'กรมอนามัย SC1394', 'กรมอนามัย SC1394', '8', '', '865', null, null, '', '1', null, null, '1613203692', '1613206218', null, null, ' ', '83', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '095-797-0342', '2', '3', 'SC1394', '');
INSERT INTO `customer` VALUES ('3256', 'CU-2100064', 'สน.กรมวิทย์ฯการแพทย์ CC3081', 'สน.กรมวิทย์ฯการแพทย์ CC3081', '8', '', '865', null, null, '', '1', null, null, '1613203692', '1613206207', null, null, ' ', '83', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '088-559-6011', '2', '3', 'CC3081', '');
INSERT INTO `customer` VALUES ('3257', 'CU-2100065', 'The Mall งามวงศ์วาน ชั้น6 SC3029', 'The Mall งามวงศ์วาน ชั้น6 SC3029', '8', '', '865', null, null, '', '1', null, null, '1613203692', '1613206272', null, null, ' ', '83', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '093-110-6837', '2', '3', 'SC3029', '');
INSERT INTO `customer` VALUES ('3258', 'CU-2100066', 'สน.ประชาชื่น 2 CC2779', 'สน.ประชาชื่น 2 CC2779', '8', '', '865', null, null, '', '1', null, null, '1613203692', '1613206197', null, null, ' ', '83', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '092-659-9668', '2', '3', 'CC2779', '');
INSERT INTO `customer` VALUES ('3259', 'CU-2100067', 'The Mall งามวงศ์วาน ชั้น G SC3793', 'The Mall งามวงศ์วาน ชั้น G SC3793', '8', '', '865', null, null, '', '1', null, null, '1613203692', '1613206186', null, null, ' ', '83', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC3793', '');
INSERT INTO `customer` VALUES ('3260', 'CU-2100068', 'อเมซอนท่าน้ำบางศรีเมือง', 'อเมซอนท่าน้ำบางศรีเมือง', '8', '', '865', null, null, '', '1', null, null, '1613203692', '1613206174', null, null, ' ', '88', '193 หมู่ 3 ตำบลบางศรีเมือง อำเภอเมืองนนทบุรี จังหวัดนนทบุรี 11110', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3261', 'CU-2100069', 'เตี๋ยวเรือเสาวรีย์ 6', 'เตี๋ยวเรือเสาวรีย์ 6', '8', '', '865', null, null, '', '1', null, null, '1613203692', '1613286903', null, null, ' ', '88', '199/90 หมู่ 5 ตำบลบางขนุน อำเภอบางกรวย จังหวัดนนทบุรี 11130', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3262', 'CU-2100070', 'ดาคาซี่', 'เมืองทอง บรอนสตีท (25)', '8', '', '865', null, null, '', '1', null, null, '1613203692', '1613286871', null, null, ' ', '88', '50/251 หมู่ที่ 6 ตำบลบ้านใหม่ อำเภอปากเกร็ด จังหวัดนนทบุรี 11120', '', '5', '5', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3263', 'CU-2100073', 'ศูนย์การแพทย์กาญจนาภิเษก ม.มหิดล SC2948', 'ศูนย์การแพทย์กาญจนาภิเษก ม.มหิดล SC2948', '8', '', '866', null, null, '', '1', null, null, '1613203692', '1613211114', null, null, ' ', '84', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC2948', '');
INSERT INTO `customer` VALUES ('3264', 'CU-2100074', 'พุทธมณฑล สาย 4 CC3091', 'พุทธมณฑล สาย 4 CC3091', '8', '', '866', null, null, '', '1', null, null, '1613203692', '1613211102', null, null, ' ', '84', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'CC3091', '');
INSERT INTO `customer` VALUES ('3265', 'CU-2100075', 'พุทธมณฑล สาย 5 CC1833', 'พุทธมณฑล สาย 5 CC1833', '8', '', '866', null, null, '', '1', null, null, '1613203692', '1613211085', null, null, ' ', '84', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', '', '');
INSERT INTO `customer` VALUES ('3266', 'CU-2100076', 'สน.เพชรเกษม 81 CC2716', 'สน.เพชรเกษม 81 CC2716', '8', '', '866', null, null, '', '1', null, null, '1613203692', '1613211063', null, null, ' ', '84', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'CC2716', '');
INSERT INTO `customer` VALUES ('3267', 'CU-2100077', 'สน. พระราม 2 ขาเข้า กม.19 CC2155', 'สน. พระราม 2 ขาเข้า กม.19 CC2155', '8', '', '866', null, null, '', '1', null, null, '1613203692', '1613211023', null, null, ' ', '84', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'CC2155', '');
INSERT INTO `customer` VALUES ('3268', 'CU-2100078', 'Central มหาชัย ชั้น 1 SC2201', 'Central มหาชัย ชั้น 1 SC2201', '8', '', '866', null, null, '', '1', null, null, '1613203692', '1613211371', null, null, ' ', '84', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC2201', '');
INSERT INTO `customer` VALUES ('3269', 'CU-2100079', 'Central มหาชัย ชั้น 2 SC2196', 'Central มหาชัย ชั้น 2 SC2196', '8', '', '866', null, null, '', '1', null, null, '1613203692', '1613211052', null, null, ' ', '84', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC2196', '');
INSERT INTO `customer` VALUES ('3270', 'CU-2100080', 'รพ. สมเด็จพระพุทธเลิศหล้า SC2316', 'รพ. สมเด็จพระพุทธเลิศหล้า SC2316', '8', '', '866', null, null, '', '1', null, null, '1613203692', '1613210996', null, null, ' ', '84', 'อาคารศูนย์เอนเนอร์ยี่คอมเพล็กซ์ อาคารบี ชั้นที่ 12 555/2 ถนนวิภาวดีรังสิต แขวงจตุจักร เขตจตุจักร กรุงเทพฯ 10900', '', '2', '3', 'SC2316', '');
INSERT INTO `customer` VALUES ('3271', 'CU-2100081', 'ร้านละมุนชาบาร์', 'ร้านละมุนชาบาร์', '8', '', '866', null, null, '', '1', null, null, '1613203692', '1613288354', null, null, ' ', '89', '', '', '4', '1', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3272', 'CU-2100082', 'อเมซอนวุฒิคุณ', 'อเมซอนวุฒิคุณ', '8', '', '866', null, null, '', '1', null, null, '1613203693', '1613210958', null, null, ' ', '89', '746/12 อาคารสมุทรวุฒิคุณ ถนนราชญาติรักษา ตำบลแม่กลอง อำเภอเมืองสมุทรสงคราม จังหวัดสมุทรสงคราม 75000', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3273', 'CU-2100083', 'ร้านปริวัฒน์ช็อป', 'ร้านปริวัฒน์ช็อป', '8', '', '866', null, null, '', '1', null, null, '1613203693', '1613288374', null, null, ' ', '89', '', '', '5', null, 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3274', 'CU-2100086', 'สิรินธร', 'สิรินธร', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271484', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3781822', '2', '3', '0110', '143/32 หมู่ 2 ต.สนามจันทร์ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3275', 'CU-2100087', 'ลาดปลาเค้า', 'ลาดปลาเค้า', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271470', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '089-8365522', '2', '3', '0094', '37/6 หมู่9 ต.บางแขม อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3276', 'CU-2100088', 'สระกระเทียม', 'สระกระเทียม', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271453', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '095-2098875', '2', '3', '0242', '115 หมู่ 1 ตำบลสวนป่าน อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000');
INSERT INTO `customer` VALUES ('3277', 'CU-2100089', 'หนองโพ', 'หนองโพ', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271441', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9431740', '2', '3', '0076', '153 หมู่ 9 ต.หนองโพ อ.โพธาราม จ.ราชบุรี 70120');
INSERT INTO `customer` VALUES ('3278', 'CU-2100090', 'ดอนทราย', 'ดอนทราย', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271353', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3780274', '2', '3', '0128', '82/30 หมู่ 9 ต.ดอนทราย อ.โพธาราม จ.ราชบุรี 70120');
INSERT INTO `customer` VALUES ('3279', 'CU-2100091', 'หลุมดิน', 'หลุมดิน', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271336', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '063-8431042', '2', '3', '0325', '94 หมู่ที่ 6 ตำบลหลุมดิน อำเภอเมืองราชบุรี จังหวัดราชบุรี 70000');
INSERT INTO `customer` VALUES ('3280', 'CU-2100092', 'บ้านไร่', 'บ้านไร่', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271318', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443871', '2', '3', '0300', '351 หมู่ 4 ต.บ้านไร่ อ.ดำเนินสะดวก จ.ราชบุรี 70130');
INSERT INTO `customer` VALUES ('3281', 'CU-2100093', 'ดอนตะโก', 'ดอนตะโก', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271299', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9438472', '2', '3', '0119', '252/7 หมู่ 3 ต.ดอนตะโก อ.เมืองราชบุรี จ.ราชบุรี 70000');
INSERT INTO `customer` VALUES ('3282', 'CU-2100094', 'เมืองทอง', 'เมืองทอง', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271285', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9445070', '2', '3', '0040', '99/4 ถ.สมบูรณ์กุล ต.หน้าเมือง อ.เมืองราชบุรี จ.ราชบุรี 70000');
INSERT INTO `customer` VALUES ('3283', 'CU-2100095', 'แยกต้นสำโรง', 'แยกต้นสำโรง', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271273', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3789174', '2', '3', '0129', '37/26 ถ.เจดีย์หัก ต.หน้าเมือง อ.เมืองราชบุรี จ.ราชบุรี 70000');
INSERT INTO `customer` VALUES ('3284', 'CU-2100096', 'เขาวัง', 'เขาวัง', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271428', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443917', '2', '3', '0043', '152 หมู่ 10 ต.เจดีย์หัก อ.เมืองราชบุรี จ.ราชบุรี 70000');
INSERT INTO `customer` VALUES ('3285', 'CU-2100097', 'เจดีย์หัก', 'เจดีย์หัก', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271414', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443746', '2', '3', '0029', '225/3 หมู่ 11 ต.เจดีย์หัก อ.เมืองราชบุรี จ.ราชบุรี 70000');
INSERT INTO `customer` VALUES ('3286', 'CU-2100098', 'เขางู', 'เขางู', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613273194', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782060', '2', '3', '0055', '240 หมู่ 5 ต.เจดีย์หัก อ.เมืองราชบุรี จ.ราชบุรี 70000');
INSERT INTO `customer` VALUES ('3287', 'CU-2100099', 'จอมบึง2', 'จอมบึง2', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271197', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443752', '2', '3', '0030', '680 หมู่ 3 ต.จอมบึง อ.จอมบึง จ.ราชบุรี 70150');
INSERT INTO `customer` VALUES ('3288', 'CU-2100100', 'จอมบึง 1', 'จอมบึง 1', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271183', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443520', '2', '3', '0008', '299/18 หมู่ 3 ต.จอมบึง อ.จอมบึง จ.ราชบุรี 70150');
INSERT INTO `customer` VALUES ('3289', 'CU-2100101', 'ด่านทับตะโก', 'ด่านทับตะโก', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271135', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9432266', '2', '3', '0089', '91 หมู่1 ต.ด่านทับตะโก อ.จอมบึง จ.ราชบุรี 70150');
INSERT INTO `customer` VALUES ('3290', 'CU-2100102', 'ชัฎป่าหวาย', 'ชัฎป่าหวาย', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271123', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443968', '2', '3', '0050', '5/20 หมู่ 1 ต.ป่าหวาย อ.สวนผึ้ง จ.ราชบุรี 70180');
INSERT INTO `customer` VALUES ('3291', 'CU-2100103', 'สวนผึ้ง', 'สวนผึ้ง', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271112', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3781331', '2', '3', '0082', '140/3 หมู่1 ต.สวนผึ้ง อ.สวนผึ้ง จ.ราชบุรี 70180');
INSERT INTO `customer` VALUES ('3292', 'CU-2100104', 'บ้านคา', 'บ้านคา', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271101', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3781610', '2', '3', '0137', '43/7 หมู่ 1 ต.บ้านคา อ.บ้านคา จ.ราชบุรี 70180');
INSERT INTO `customer` VALUES ('3293', 'CU-2100105', 'ตลาดนัดบ้านนา', 'ตลาดนัดบ้านนา', '9', '', '867', null, null, '', '1', null, null, '1613203693', '1613271070', null, null, ' ', '70', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '095-3845621', '2', '3', '0430', '245 หมู่ที่ 1 ตำบลโพรงมะเดื่อ อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000');
INSERT INTO `customer` VALUES ('3294', 'CU-2100106', 'บึงกระจับ', 'บึงกระจับ', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271090', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1480926', '2', '3', '0339', '24/12  หมู่ที่ 5  ตำบลหนองอ้อ  อำเภอบ้านโป่ง  จังหวัดราชบุรี  70110');
INSERT INTO `customer` VALUES ('3295', 'CU-2100107', 'โป่งดุสิต', 'โป่งดุสิต', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271106', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9951672', '2', '3', '0064', '110/19 ถ.หลังสถานี ต.บ้านโป่ง อ.บ้านโป่ง จ.ราชบุรี 70110');
INSERT INTO `customer` VALUES ('3296', 'CU-2100108', 'ปากแรต', 'ปากแรต', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271126', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9418338', '2', '3', '0091', '13/17 ถ.ค่ายหลวง ต.บ้านโป่ง อ.บ้านโป่ง จ.ราชบุรี 70110');
INSERT INTO `customer` VALUES ('3297', 'CU-2100109', 'บ้านฆ้องน้อย', 'บ้านฆ้องน้อย', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271142', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', '2', '3', '0571', '');
INSERT INTO `customer` VALUES ('3298', 'CU-2100110', 'เบิกไพร', 'เบิกไพร', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271159', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-8562266', '2', '3', '0087', '86/17-19 หมู่6 ต.เบิกไพร อ.บ้านโป่ง จ.ราชบุรี 70110');
INSERT INTO `customer` VALUES ('3299', 'CU-2100111', 'ไผ่สามเกาะ', 'ไผ่สามเกาะ', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271176', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '092-2506437', '2', '3', '0231', '127 หมู่ 17 ต.เขาขลุง อ.บ้านโป่ง จ.ราชบุรี 70110');
INSERT INTO `customer` VALUES ('3300', 'CU-2100112', 'เขาขวาง', 'เขาขวาง', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271195', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-8309535', '2', '3', '0078', '163 หมู่6 ต.นางแก้ว อ.โพธาราม จ.ราชบุรี 70120');
INSERT INTO `customer` VALUES ('3301', 'CU-2100113', 'ท่าชุมพล', 'ท่าชุมพล', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271214', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-6268148', '2', '3', '0323', '253 หมู่ที่ 2 ตำบลท่าชุมพล อำเภอโพธาราม จังหวัดราชบุรี 70120');
INSERT INTO `customer` VALUES ('3302', 'CU-2100114', 'ท่าวัด', 'ท่าวัด', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271229', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443631', '2', '3', '0002', '18 ถ.ท่าวัด ต.โพธาราม อ.โพธาราม จ.ราชบุรี 70120');
INSERT INTO `customer` VALUES ('3303', 'CU-2100115', 'ตลาดโพธาราม', 'ตลาดโพธาราม', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271247', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-3017502', '2', '3', '0239', '209 ถนนโชคชัย ตำบลโพธาราม อำเภอโพธาราม จังหวัดราชบุรี 70120');
INSERT INTO `customer` VALUES ('3304', 'CU-2100116', 'บ้านฆ้อง', 'บ้านฆ้อง', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271270', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3789107', '2', '3', '0131', '121/1 หมู่ 2 ต.บ้านฆ้อง อ.โพธาราม จ.ราชบุรี 70120');
INSERT INTO `customer` VALUES ('3305', 'CU-2100117', 'บางแพ', 'บางแพ', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271290', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443927', '2', '3', '0045', '167/5 หมู่ 5 ต.บางแพ อ.บางแพ จ.ราชบุรี 70160');
INSERT INTO `customer` VALUES ('3306', 'CU-2100118', 'บ้านไร่ชาวเหนือ', 'บ้านไร่ชาวเหนือ', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271308', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782871', '2', '3', '0058', '351 หมู่ 4 ต.บ้านไร่ อ.ดำเนินสะดวก จ.ราชบุรี 70130');
INSERT INTO `customer` VALUES ('3307', 'CU-2100119', 'โพหัก', 'โพหัก', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271323', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9445018', '2', '3', '0048', '192 หมู่ 3 ต.โพหัก อ.บางแพ จ.ราชบุรี 70160');
INSERT INTO `customer` VALUES ('3308', 'CU-2100120', 'ประสาทสิทธิ์', 'ประสาทสิทธิ์', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271341', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9950648', '2', '3', '0063', '413 หมู่ 5 ต.ประสาทสิทธิ์ อ.ดำเนินสะดวก จ.ราชบุรี 70130');
INSERT INTO `customer` VALUES ('3309', 'CU-2100121', 'ดอนกรวย', 'ดอนกรวย', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271364', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '097-0755873', '2', '3', '0495', '107/6 หมู่ที่ 5  ตำบลดอนกรวย  อำเภอดำเนินสะดวก  จังหวัดราชบุรี  70130');
INSERT INTO `customer` VALUES ('3310', 'CU-2100122', 'ดำเนิน 1', 'ดำเนิน 1', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271381', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443869', '2', '3', '0025', '162 หมู่ 4 ต.ท่านัด อ.ดำเนินสะดวก จ.ราชบุรี 70130');
INSERT INTO `customer` VALUES ('3311', 'CU-2100123', 'ตลาดน้ำดำเนิน2', 'ตลาดน้ำดำเนิน2', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271395', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '089-8373331', '2', '3', '0099', '399 หมู่9 ต.ดำเนินสะดวก อ.ดำเนินสะดวก จ.ราชบุรี 70130');
INSERT INTO `customer` VALUES ('3312', 'CU-2100124', 'วัดเพลง', 'วัดเพลง', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271415', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9818496', '2', '3', '0059', '59/1 หมู่ 5 ต.วัดเพลง อำภอวัดเพลง จ.ราชบุรี 70170');
INSERT INTO `customer` VALUES ('3313', 'CU-2100125', 'ปากท่อ1', 'ปากท่อ1', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271431', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '092-2500460', '2', '3', '0270', '399  หมู่ที่ 1  ตำบลปากท่อ  อำเภอปากท่อ  จังหวัดราชบุรี  70140');
INSERT INTO `customer` VALUES ('3314', 'CU-2100126', 'ปากท่อ3', 'ปากท่อ3', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271443', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2991057', '2', '3', '0143', '404 หมู่ 4 ต.ดอนทราย อ.ปากท่อ จ.ราชบุรี 70140');
INSERT INTO `customer` VALUES ('3315', 'CU-2100127', 'ปากท่อ2', 'ปากท่อ2', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271471', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782853', '2', '3', '0056', '134/1 หมู่ 4 ต.ดอนทราย อ.ปากท่อ จ.ราชบุรี 70140');
INSERT INTO `customer` VALUES ('3316', 'CU-2100128', 'ห้วยชินสีห์', 'ห้วยชินสีห์', '9', '', '868', null, null, '', '1', null, null, '1613203693', '1613271489', null, null, ' ', '90', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9447815', '2', '3', '0066', '143/4 หมู่7 ต.อ่างทอง อ.เมือง จ.ราชบุรี 70000');
INSERT INTO `customer` VALUES ('3317', 'CU-2100130', 'ชุมชนจันทราคามพิทักษ์', 'ชุมชนจันทราคามพิทักษ์', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271598', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '098-2612413', '2', '3', '0223', '51/3 ถ.สนามจันทร์ ต.สนามจันทร์ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3318', 'CU-2100131', 'เหนือวัง', 'เหนือวัง', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271570', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443960', '2', '3', '0051', '18 ถ.ข้างวัง ต.พระปฐมเจดีย์ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3319', 'CU-2100132', 'สวนตะไคร้', 'สวนตะไคร้', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271586', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9445029', '2', '3', '0052', '41/2 ถ.สวนตะไคร้ ต.สนามจันทร์ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3320', 'CU-2100133', 'ลำพยา', 'ลำพยา', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271601', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3781953', '2', '3', '0121', '35/1 หมู่ 3 ต.ลำพยา อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3321', 'CU-2100134', 'โพรงมะเดื่อ', 'โพรงมะเดื่อ', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271622', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '061-3841236', '2', '3', '0276', '18/23 หมู่ที่ 14 ตำบลโพรงมะเดื่อ อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000');
INSERT INTO `customer` VALUES ('3322', 'CU-2100135', 'วัดลาดหญ้าไทร', 'วัดลาดหญ้าไทร', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271640', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '084-1091976', '2', '3', '0474', '177  หมู่ที่ 10  ตำบลห้วยขวาง  อำเภอกำแพงแสน จังหวัดนครปฐม  73140');
INSERT INTO `customer` VALUES ('3323', 'CU-2100136', 'หนองงูเหลือม', 'หนองงูเหลือม', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271655', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '095-3847827', '2', '3', '0429', '');
INSERT INTO `customer` VALUES ('3324', 'CU-2100137', 'ห้วยกระบอก', 'ห้วยกระบอก', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271669', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-7050550', '2', '3', '0086', '117/12 หมู่ 9 ต.กรับใหญ่ อ.บ้านโป่ง จ.ราชบุรี 70110');
INSERT INTO `customer` VALUES ('3325', 'CU-2100138', 'วัดกำแพงแสน', 'วัดกำแพงแสน', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271971', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', '2', '3', '0014', '');
INSERT INTO `customer` VALUES ('3326', 'CU-2100139', 'กำแพงแสน', 'กำแพงแสน', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271696', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', '2', '3', '0046', '244 หมู่ 1 ต.กำแพงแสน อ.กำแพงแสน จ.นครปฐม 73140');
INSERT INTO `customer` VALUES ('3327', 'CU-2100140', 'วังน้ำเขียว', 'วังน้ำเขียว', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271707', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', '2', '3', '0547', '');
INSERT INTO `customer` VALUES ('3328', 'CU-2100141', 'สระพัฒนา', 'สระพัฒนา', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271724', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1590947', '2', '3', '0284', '27 หมู่ที่ 2 ตำบลสระพัฒนา อำเภอกำแพงแสน จังหวัดนครปฐม 73140');
INSERT INTO `customer` VALUES ('3329', 'CU-2100142', 'บางหลวง', 'บางหลวง', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271735', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2991034', '2', '3', '0142', '238 หมู่ 6 ต.บางหลวง อ.บางเลน จ.นครปฐม 73130');
INSERT INTO `customer` VALUES ('3330', 'CU-2100143', 'บางเลน', 'บางเลน', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271751', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1482849', '2', '3', '0343', '518 หมู่ที่ 8 ตำบลบางเลน อำเภอบางเลน จังหวัดนครปฐม 73130');
INSERT INTO `customer` VALUES ('3331', 'CU-2100144', 'ตลาดโรงยาง', 'ตลาดโรงยาง', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271765', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '097-0759705', '2', '3', '0290', '216 หมู่ที่ 13 ตำบลบางปลา อำเภอบางเลน จังหวัดนครปฐม 73130');
INSERT INTO `customer` VALUES ('3332', 'CU-2100145', 'นราภิรมย์', 'นราภิรมย์', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271777', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1591013', '2', '3', '0285', '229 หมู่ที่ 3 ตำบลนราภิรมย์ อำเภอบางเลน จังหวัดนครปฐม 73130');
INSERT INTO `customer` VALUES ('3333', 'CU-2100146', 'ศาลายา', 'ศาลายา', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271787', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9415552', '2', '3', '0105', '179/10 หมู่ 5 ต.ศาลายา อ.พุทธมณฑล จ.นครปฐม 73170');
INSERT INTO `customer` VALUES ('3334', 'CU-2100147', 'ห้วยพลู', 'ห้วยพลู', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271799', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443498', '2', '3', '0015', '278/1 หมู่ 1 ต.ห้วยพลู อ.นครชัยศรี จ.นครปฐม 73120');
INSERT INTO `customer` VALUES ('3335', 'CU-2100148', 'แหลมบัว', 'แหลมบัว', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271812', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', '2', '3', '0507', '');
INSERT INTO `customer` VALUES ('3336', 'CU-2100149', 'บางพระ', 'บางพระ', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271827', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3780433', '2', '3', '0116', '28/41 หมู่ 1 ต.บางพระ อ.นครชัยศรี จ.นครปฐม 73120');
INSERT INTO `customer` VALUES ('3337', 'CU-2100150', 'บ้านหลวง', 'บ้านหลวง', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271838', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '097-2790875', '2', '3', '0411', '16/1  หมู่ที่ 4  ตำบลดอนพุทรา อำเภอดอนตูม  จังหวัดนครปฐม  73150');
INSERT INTO `customer` VALUES ('3338', 'CU-2100151', 'ดอนตูม', 'ดอนตูม', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271850', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443563', '2', '3', '0012', '186 หมู่ 1 ต.สามง่าม อ.ดอนตูม จ.นครปฐม 73150');
INSERT INTO `customer` VALUES ('3339', 'CU-2100152', 'วัดตาก้อง', 'วัดตาก้อง', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271894', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-1590965', '2', '3', '0287', '147/2 หมู่ที่ 10 ตำบลตาก้อง อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000');
INSERT INTO `customer` VALUES ('3340', 'CU-2100153', 'วัดพะเนียงแตก', 'วัดพะเนียงแตก', '9', '', '869', null, null, '', '1', null, null, '1613203693', '1613271913', null, null, ' ', '68', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '', '2', '3', '0493', '');
INSERT INTO `customer` VALUES ('3341', 'CU-2100154', 'ห้วยจรเข้', 'ห้วยจรเข้', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613271981', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782876', '2', '3', '0057', '19/1 หมู่ 6 ต.ห้วยจรเข้ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3342', 'CU-2100155', 'ทุ่งพระเมรุ', 'ทุ่งพระเมรุ', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272031', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3783170', '2', '3', '0138', '241 ถ.ทวาราวดี ต.ห้วยจรเข้ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3343', 'CU-2100156', 'วัดไผ่ล้อม', 'วัดไผ่ล้อม', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272049', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3789137', '2', '3', '0132', '18/2 ถ.ไผ่เตย ต.ห้วยจรเข้ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3344', 'CU-2100157', 'ต้นสน', 'ต้นสน', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272068', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443926', '2', '3', '0053', '44 ถ.ราชดำเนิน ต.พระปฐมเจดีย์ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3345', 'CU-2100158', 'ประปานาสร้าง', 'ประปานาสร้าง', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272085', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-8568240', '2', '3', '0074', '9/1 ถ.นาสร้าง ต.นครปฐม อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3346', 'CU-2100159', 'สี่แยกวัดกลาง', 'สี่แยกวัดกลาง', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272120', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '098-2612421', '2', '3', '0225', '16 ถ.ถวิลราษฎรบูรณะ ต.บ่อพลับ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3347', 'CU-2100160', 'บ่อพลับ', 'บ่อพลับ', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272132', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3780912', '2', '3', '0159', '383 ถ.ทหารบก ต.บ่อพลับ อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3348', 'CU-2100161', 'หน้าวัด3กระบือเผือก', 'หน้าวัด3กระบือเผือก', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272205', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2990347', '2', '3', '0176', '5/7 หมู่ 4 ต.สามควายเผือก อ.เมืองงนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3349', 'CU-2100162', 'พุทธมณฑลสาย7', 'พุทธมณฑลสาย7', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272219', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2990355', '2', '3', '0185', '59/54 หมู่ 2 ต.ท่าตลาด อ.สามพราน จ.นครปฐม 73110');
INSERT INTO `customer` VALUES ('3350', 'CU-2100163', 'วัดไร่ขิง', 'วัดไร่ขิง', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272290', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9440935', '2', '3', '0072', '69/28 หมู่6 ต.ท่าตลาด อ.สามพราน จ.นครปฐม 73110');
INSERT INTO `customer` VALUES ('3351', 'CU-2100164', 'ดอนหวาย', 'ดอนหวาย', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272305', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-2286532', '2', '3', '0477', '4/2  หมู่ที่ 5  ตำบลบางกระทึก  อำเภอสามพราน  จังหวัดนครปฐม  73210');
INSERT INTO `customer` VALUES ('3352', 'CU-2100165', 'นครชื่นชุ่ม', 'นครชื่นชุ่ม', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272318', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-7957819', '2', '3', '0412', '168/5  หมู่ที่ 7  ตำบลกระทุ่มล้ม อำเภอสามพราน  จังหวัดนครปฐม  73220');
INSERT INTO `customer` VALUES ('3353', 'CU-2100166', 'ซอยไวไว', 'ซอยไวไว', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272344', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-5704587', '2', '3', '0446', '6/256 หมู่ที่ 7 ตำบลไร่ขิง อำเภอสามพราน จังหวัดนครปฐม 73210');
INSERT INTO `customer` VALUES ('3354', 'CU-2100167', 'เทียนดัด 2', 'เทียนดัด 2', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272357', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3782843', '2', '3', '0123', '43/10 หมู่ 1 ต.บ้านใหม่ อ.สามพราน จ.นครปฐม 73110');
INSERT INTO `customer` VALUES ('3355', 'CU-2100168', 'เทียนดัด', 'เทียนดัด', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272369', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-7363838', '2', '3', '0079', '99/5 หมู่1 ต.บ้านใหม่ อ.สามพราน จ.นครปฐม 73110');
INSERT INTO `customer` VALUES ('3356', 'CU-2100169', 'สามพราน', 'สามพราน', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272382', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443506', '2', '3', '0013', '236/9 หมู่ 8 ต.สามพราน อ.สามพราน จ.นครปฐม 73110');
INSERT INTO `customer` VALUES ('3357', 'CU-2100170', 'แยกอนุสาวรีย์', 'แยกอนุสาวรีย์', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272396', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-9443583', '2', '3', '0189', '29/64 หมู่ 1 ต.ท่าตลาด อ.สามพราน จ.นครปฐม 73110');
INSERT INTO `customer` VALUES ('3358', 'CU-2100171', 'คลองใหม่', 'คลองใหม่', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272412', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '061-0126564', '2', '3', '0294', '127/2 หมู่ที่ 7  ตำบลคลองใหม่ อำเภอสามพราน จังหวัดนครปฐม 73110');
INSERT INTO `customer` VALUES ('3359', 'CU-2100172', 'ซอยวัดไทร(นครปฐม)', 'ซอยวัดไทร(นครปฐม)', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613278142', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-2990605', '2', '3', '0195', '20/4 หมู่ 4 ต.ท่าตำหนัก อ.นครชัยศรี จ.นครปฐม 73120');
INSERT INTO `customer` VALUES ('3360', 'CU-2100173', 'ห้วยตะโก', 'ห้วยตะโก', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272438', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '097-2791042', '2', '3', '0415', '71/3 หมู่ที่ 2 ตำบลพะเนียด อำเภอนครชัยศรี จังหวัดนครปฐม 73120');
INSERT INTO `customer` VALUES ('3361', 'CU-2100174', 'โคกพระ', 'โคกพระ', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272451', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '064-2688131', '2', '3', '0289', '43/4 หมู่ที่ 4 ตำบลบางระกำ อำเภอนครชัยศรี จังหวัดนครปฐม 73120');
INSERT INTO `customer` VALUES ('3362', 'CU-2100175', 'ดอนยายหอม', 'ดอนยายหอม', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272462', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '081-3780461', '2', '3', '0127', '262/4 หมู่ 3 ต.ดอนยายหอม อ.เมืองนครปฐม จ.นครปฐม 73000');
INSERT INTO `customer` VALUES ('3363', 'CU-2100176', 'ตลาดจินดา', 'ตลาดจินดา', '9', '', '870', null, null, '', '1', null, null, '1613203693', '1613272474', null, null, ' ', '67', '393 อาคาร 393 สีลม ชั้น 5-6 ถนนสีลม แขวงสีลม เขตบางรัก กรุงเทพฯ 10500', '061-0126457', '2', '3', '0292', '145 หมู่ที่ 2 ตำบลตลาดจินดา อำเภอสามพราน จังหวัดนครปฐม 73110');
INSERT INTO `customer` VALUES ('3364', 'CU-2100177', 'IFC-10', 'IFC-10', '6', '', '871', null, null, '', '1', null, null, '1613203693', '1613206911', null, null, ' ', '51', '', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3365', 'CU-2100178', 'IFC-11', 'IFC-11', '6', '', '871', null, null, '', '1', null, null, '1613203693', '1613206902', null, null, ' ', '51', '', '', '2', '3', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3366', 'CU-2100179', 'หมีพ่นไฟ', 'หมีพ่นไฟ', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235160', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3367', 'CU-2100180', 'feel Good', 'feel Good', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235172', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3368', 'CU-2100181', 'O Cha ya', 'O Cha ya', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235183', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3369', 'CU-2100182', 'ชาคุมะ', 'ชาคุมะ', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235196', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3370', 'CU-2100183', 'Rabbit Bubble', 'Rabbit Bubble', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235207', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3371', 'CU-2100184', 'เฉาก๋วย เต็งหนึ่ง', 'เฉาก๋วย เต็งหนึ่ง', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235240', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3372', 'CU-2100185', 'หมูสะเต๊ะ พี่จุ๋ม', 'หมูสะเต๊ะ พี่จุ๋ม', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235251', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3373', 'CU-2100186', 'น้ำดื่ม น้ำทิพย์', 'น้ำดื่ม น้ำทิพย์', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235266', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3374', 'CU-2100187', 'คั่วไก่ ไข่ลาวา', 'คั่วไก่ ไข่ลาวา', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235277', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3375', 'CU-2100188', 'เตี๋ยวเลิศรส', 'เตี๋ยวเลิศรส', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235290', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3376', 'CU-2100189', 'Brown BEF', 'Brown BEF', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235302', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3377', 'CU-2100190', 'ผัดไท แม่วรรณ', 'ผัดไท แม่วรรณ', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235331', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3378', 'CU-2100191', 'เมี่ยงญวน', 'เมี่ยงญวน', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235342', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3379', 'CU-2100192', 'น้ำจับเลี้ยง สระบัว', 'น้ำจับเลี้ยง สระบัว', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235354', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3380', 'CU-2100193', 'Jer ma Jer', 'Jer ma Jer', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235364', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3381', 'CU-2100194', 'Ninja ซูซิ', 'Ninja ซูซิ', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235377', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3382', 'CU-2100195', 'ดีไลน์', 'ดีไลน์', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235400', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3383', 'CU-2100196', 'น้ำดื่ม ป้าสมจิตร', 'น้ำดื่ม ป้าสมจิตร', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235412', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3384', 'CU-2100197', 'ขนมจีน ป้าสมจิตร', 'ขนมจีน ป้าสมจิตร', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235423', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3385', 'CU-2100198', 'อิ่มอร่อยกับเฮียตรง', 'อิ่มอร่อยกับเฮียตรง', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235434', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3386', 'CU-2100199', 'นมหมี', 'นมหมี', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235447', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3387', 'CU-2100200', 'ข้าวขาหมูพี่เกด', 'ข้าวขาหมูพี่เกด', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235480', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3388', 'CU-2100201', 'หมูบินเกาหลี', 'หมูบินเกาหลี', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235493', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3389', 'CU-2100202', 'แหนมหมูอินดิ้', 'แหนมหมูอินดิ้', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235503', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3390', 'CU-2100203', 'อาหารคลีน', 'อาหารคลีน', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235514', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3391', 'CU-2100204', 'จันทร์เอ๋ยจันทร์เจ้า', 'จันทร์เอ๋ยจันทร์เจ้า', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235524', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3392', 'CU-2100205', 'แบล็คชิกคาเฟ่', 'แบล็คชิกคาเฟ่', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235535', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3393', 'CU-2100206', 'เตี๋ยวเย็นตาโฟ', 'เตี๋ยวเย็นตาโฟ', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235547', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3394', 'CU-2100207', 'ข้าวมันไก่นายพล', 'เตี๋ยวเย็นตาโฟ', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235557', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3395', 'CU-2100208', 'เจ้ติ๊ก', 'เจ้ติ๊ก', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235567', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3396', 'CU-2100209', 'ลูกชิ้นหมูทิพย์', 'ลูกชิ้นหมูทิพย์', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235577', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3397', 'CU-2100210', 'Toy ลูกชิ้นทอด', 'Toy ลูกชิ้นทอด', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235587', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3398', 'CU-2100211', 'หมุปิ้งฮีโร่', 'หมูปิ้งฮีโร่', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235597', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3399', 'CU-2100212', 'นกกาแฟสด', 'นกกาแฟสด', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235607', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3400', 'CU-2100213', 'แซ่บจี๊ดจ๊าด', 'แซ่บจี๊ดจ๊าด', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235618', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3401', 'CU-2100214', 'วุ้นเส้นเจ้าสัว', 'วุ้นเส้นเจ้าสัว', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235630', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3402', 'CU-2100215', 'หมึกย่าง', 'หมึกย่าง', '6', '', '872', null, null, '', '1', null, null, '1613203693', '1613235642', null, null, ' ', '71', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3403', 'CU-2100216', 'ชา', 'ชา', '6', '', null, null, null, '', '1', null, null, '1613203693', '1613280738', null, null, ' ', '71', '', '', '1', null, 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3404', 'CU-2100218', 'แม่บ้าน-รปภ.', 'แม่บ้าน-รปภ.', '6', '', '879', null, null, '', '1', null, null, '1613203693', '1613280728', null, null, ' ', '71', '', '', null, null, 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3405', 'CU-2100219', 'เฮียติ', 'เฮียติ', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207003', null, null, ' ', '48', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3406', 'CU-2100220', 'พ่อเฮียติ', 'พ่อเฮียติ', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207015', null, null, ' ', '48', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3407', 'CU-2100221', 'เจ๊ติ๊ก', 'เจ๊ติ๊ก', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207027', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3408', 'CU-2100222', 'เจ๊ขวัญ', 'เจ๊ขวัญ', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207037', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3409', 'CU-2100223', 'เจ๊แต๋ว', 'เจ๊แต๋ว', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207046', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3410', 'CU-2100224', 'เจ๊สาว', 'เจ๊สาว', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207055', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3411', 'CU-2100225', 'เจ๊เพ็ญ', 'เจ๊เพ็ญ', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207065', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3412', 'CU-2100226', 'ร้านเพลิน', 'ร้านเพลิน', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207075', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3413', 'CU-2100227', 'ก๋วยเตี๋ยวแม่กลอง', 'ก๋วยเตี๋ยวแม่กลอง', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207085', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3414', 'CU-2100228', 'อเมซอล ซ.กลาง', 'อเมซอล ซ.กลาง', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613209012', null, null, ' ', '93', '19 ถนนรถไฟ ตำบลพระปฐมเจดีย์ อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000', '', '2', '4', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3415', 'CU-2100229', 'อเมซอล ซ.4', 'อเมซอล ซ.4', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613209024', null, null, ' ', '93', '333 ถนนพิพัธประสาท ตำบลพระปฐมเจดีย์ อำเภอเมืองนครปฐม จังหวัดนครปฐม 73000', '', '2', '4', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3416', 'CU-2100230', 'เจ๊ยุพา', 'เจ๊ยุพา', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207113', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3417', 'CU-2100231', 'เจ๊แดง', 'เจ๊แดง', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207123', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3418', 'CU-2100232', 'เจ๊อร', 'เจ๊อร', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207132', null, null, ' ', '92', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3419', 'CU-2100233', 'เจ๊ปุ๊ก', 'เจ๊ปุ๊ก', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613208991', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3420', 'CU-2100234', 'อาแปะ', 'อาแปะ', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207153', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3421', 'CU-2100235', 'เจ้เพลิน', 'ร้านเพลิน', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207163', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3422', 'CU-2100236', 'เจ๊กี', 'เจ๊ปุ๊ก', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207172', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3423', 'CU-2100237', 'เจ๊จุ๋ม', 'เจ๊จุ๋ม', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613221242', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3424', 'CU-2100238', 'ป้าแก้ว', 'ป้าแก้ว', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207198', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3425', 'CU-2100239', 'ก๋วยเตี๋ยว จ่า ช.', 'ก๋วยเตี๋ยว จ่า ช.', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207208', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3426', 'CU-2100240', 'ร้านองุ่น', 'ร้านองุ่น', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207218', null, null, ' ', '91', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3427', 'CU-2100241', 'เฮียรุ่ง', 'เฮียรุ่ง', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207228', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3428', 'CU-2100242', 'เจ๊วารี ตึก1', 'เจ๊วารี ตึก1', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207237', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3429', 'CU-2100243', 'เจ๊รี', 'เจ๊รี', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207251', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3430', 'CU-2100244', 'ช.บะหมี่', 'ช.บะหมี่', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207262', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3431', 'CU-2100245', 'อรพรรณ', 'ร้านพริ้ม', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207273', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3432', 'CU-2100246', 'เจ๊ไหม', 'เจ๊ไหม', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207282', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3433', 'CU-2100247', 'ร้านพริ้ม', 'ร้านพริ้ม', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207290', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3434', 'CU-2100248', 'วินเนอร์ คาราโอเกะ', 'วินเนอร์ คาราโอเกะ', '6', '', '873', null, null, '', '1', null, null, '1613203693', '1613207300', null, null, ' ', '93', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3435', 'CU-2100249', 'พี่ต่าย', 'พี่ต่าย', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207310', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3436', 'CU-2100250', 'เจ้เพ็ญ', 'เจ้เพ็ญ', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207319', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3437', 'CU-2100251', 'เสริมสวย', 'เสริมสวย', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207327', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3438', 'CU-2100252', 'พี่แรง', 'พี่แรง', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207337', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3439', 'CU-2100253', 'พี่บูรณ์', 'พี่บูรณ์', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207352', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3440', 'CU-2100254', 'พี่บุญชู', 'พี่บุญชู', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207362', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3441', 'CU-2100255', 'เจ้มัด', 'เจ้มัด', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207370', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3442', 'CU-2100256', 'พี่วินัย', 'พี่วินัย', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207383', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3443', 'CU-2100257', 'เจ้ติ๋ม', 'เจ้ติ๋ม', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207400', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3444', 'CU-2100258', 'พี่น้ำค้าง', 'พี่น้ำค้าง', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207408', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3445', 'CU-2100259', 'พี่สุดาภา', 'พี่สุดาภา', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207416', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3446', 'CU-2100260', 'ป้าอัด', 'ป้าอัด', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207430', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3447', 'CU-2100261', 'เจ้พี', 'เจ้พี', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207440', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3448', 'CU-2100262', 'พี่ชม้าย', 'พี่ชม้าย', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207451', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3449', 'CU-2100263', 'พี่นิด', 'พี่นิด', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207471', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3450', 'CU-2100264', 'ร้านกาแฟ', 'ร้านกาแฟ', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207482', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3451', 'CU-2100265', 'Freedom', 'Freedom', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207491', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3452', 'CU-2100266', 'บะหมี่', 'บะหมี่', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207501', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3453', 'CU-2100267', 'ข้าวแกง', 'ข้าวแกง', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207509', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3454', 'CU-2100268', 'ตามสั่ง 1', 'ข้าวแกง', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207519', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3455', 'CU-2100269', 'ตาระ', 'ตาระ', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207528', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3456', 'CU-2100270', 'ไก่มะระ', 'ไก่มะระ', '6', '', '874', null, null, '', '1', null, null, '1613203693', '1613207537', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3457', 'CU-2100271', 'พี่จูน', 'พี่จูน', '6', '', '874', null, null, '', '1', null, null, '1613203694', '1613207546', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3458', 'CU-2100272', 'เจ้แก่น', 'เจ้แก่น', '6', '', '874', null, null, '', '1', null, null, '1613203694', '1613207554', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3459', 'CU-2100273', 'เฌอแตม', 'เฌอแตม', '6', '', '874', null, null, '', '1', null, null, '1613203694', '1613207562', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3460', 'CU-2100274', 'โรงเรียน ', 'โรงเรียน ', '6', '', '874', null, null, '', '1', null, null, '1613203694', '1613225296', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3461', 'CU-2100275', 'ขายมะพร้าว', 'ไพโรจน์', '6', '', '874', null, null, '', '1', null, null, '1613203694', '1613207585', null, null, ' ', '73', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3462', 'CU-2100276', 'ป้าโก๊ะ', 'ป้าโก๊ะ', '6', '', '874', null, null, '', '1', null, null, '1613203694', '1613207594', null, null, ' ', '74', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3463', 'CU-2100277', 'เฮียทุด', 'เฮียทุด', '6', '', '874', null, null, '', '1', null, null, '1613203694', '1613207603', null, null, ' ', '74', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3464', 'CU-2100278', 'ไพโรจน์', 'ไพโรจน์', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613356972', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3465', 'CU-2100279', 'เต็กฮง', 'เต็กฮง - จ๊อก', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355815', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3466', 'CU-2100280', 'ไก่', 'ไก่ - จ๊อก', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355806', null, null, ' ', '7', '', '', '2', '5', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3467', 'CU-2100281', 'เช็งฮวง', 'เช็งฮวง - จ๊อก', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355796', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3468', 'CU-2100282', 'ถุงทอง', 'ถุงทอง - จ๊อก', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355786', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3469', 'CU-2100283', 'เฮียหยู', 'เฮียหยู - ตู้', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355777', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3470', 'CU-2100284', 'กม.5', 'กม.5 - ตู้', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355767', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3471', 'CU-2100285', 'ม่วงตารส', 'ม่วงตารส - ตู้', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355752', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3472', 'CU-2100286', 'ธัญญบูรณ์', 'ธัญญบูรณ์ - ตู้', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355741', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3473', 'CU-2100287', 'เฮียสุด', 'เฮียสุด - ตู้', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355729', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3474', 'CU-2100288', 'ก๊อต', 'ก๊อต - ตู้', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613355714', null, null, ' ', '7', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3475', 'CU-2100289', 'เจ้วงศ์', 'เจ้วงศ์ - ตู้', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613357797', null, null, ' ', '23', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3476', 'CU-2100290', 'ปิ่นทิพย์', 'ปิ่นทิพย์ - บอย', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613357791', null, null, ' ', '23', '', '', '2', '3', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3477', 'CU-2100291', 'เต็กฮงจั่น', 'เต็กฮงจั่น - บอย', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613357785', null, null, ' ', '23', '', '', '2', '3', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3478', 'CU-2100292', 'ดาว', 'ดาว - บอย', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613357778', null, null, ' ', '23', '', '', '1', '2', 'ไม่ระบุ', 'NULL');
INSERT INTO `customer` VALUES ('3479', 'CU-2100293', 'หยู', 'หยู-แซม', '6', '', '18', null, null, '', '1', null, null, '1613203694', '1613357761', null, null, ' ', '23', '', '', '1', '2', 'ไม่ระบุ', '');
INSERT INTO `customer` VALUES ('3481', 'CU-2100027', 'รปภ.', 'รปภ.', '8', '', '18', null, null, '', '1', null, null, '1613205046', '1613357772', null, null, null, '23', '', '', null, null, '', null);
INSERT INTO `customer` VALUES ('3482', 'CU-2100035', 'ขายสด', 'ขายสด', '8', '', '18', null, null, '', '1', null, null, '1613205223', '1613357767', null, null, null, '23', '', '', '1', null, '', null);
INSERT INTO `customer` VALUES ('3483', 'CU-2100036', 'รปภ.', 'รปภ.', '8', '', '18', null, null, '', '1', null, null, '1613205259', '1613357754', null, null, null, '23', '', '', null, null, '', null);
INSERT INTO `customer` VALUES ('3484', 'CU-2100047', 'ขายสด', 'ขายสด', '8', '', '18', null, null, '', '1', null, null, '1613205334', '1613357227', null, null, null, '23', '', '', '1', null, '', null);
INSERT INTO `customer` VALUES ('3485', 'CU-2100048', 'รปภ.', 'รปภ.', '8', '', '18', null, null, '', '1', null, null, '1613205388', '1613357240', null, null, null, '23', '', '', null, null, '', null);
INSERT INTO `customer` VALUES ('3486', 'CU-2100061', 'รปภ.', 'รปภ.', '8', '', '18', null, null, '', '1', null, null, '1613205446', '1613357233', null, null, null, '23', '', '', null, null, '', null);
INSERT INTO `customer` VALUES ('3487', 'CU-2100060', 'ขายสด', 'ขายสด', '8', '', '18', null, null, '', '1', null, null, '1613205477', '1613357222', null, null, null, '23', '', '', '1', null, '', null);
INSERT INTO `customer` VALUES ('3488', 'CU-2100072', 'รปภ.', 'รปภ.', '8', '', '18', null, null, '', '1', null, null, '1613205538', '1613357215', null, null, null, '23', '', '', null, null, '', null);
INSERT INTO `customer` VALUES ('3489', 'CU-2100071', 'ขายสด', 'ขายสด', '8', '', '18', null, null, '', '1', null, null, '1613205553', '1613357209', null, null, null, '23', '', '', null, null, '', null);
INSERT INTO `customer` VALUES ('3490', 'CU-2100085', 'รปภ.', 'รปภ.', '8', '', '18', null, null, '', '1', null, null, '1613205615', '1613357204', null, null, null, '23', '', '', null, null, '', null);
INSERT INTO `customer` VALUES ('3491', 'CU-2100084', 'ขายสด', 'ขายสด', '8', '', '18', null, null, '', '1', null, null, '1613205643', '1613357199', null, null, null, '23', '', '', null, null, '', null);
INSERT INTO `customer` VALUES ('3493', 'CU-2100129', 'เขาวัง', 'เขาวัง', '9', '', '18', null, null, '', '1', null, null, '1613206289', '1613357193', null, null, null, '23', '', '', '2', '3', '', null);
INSERT INTO `customer` VALUES ('3495', 'CU-2100059', 'รพ. สมเด็จพระพุทธเลิศหล้า-น้ำถัง', 'รพ. สมเด็จพระพุทธเลิศหล้า-น้ำถัง', '8', '', '18', null, null, '', '1', null, null, '1613208143', '1613357187', null, null, null, '23', '', '', null, null, '', null);
INSERT INTO `customer` VALUES ('3496', 'CU-2100217', 'ขายสด', 'ขายสด\r\n', '6', '', '18', null, null, '', '1', null, null, '1613233484', '1613357181', null, null, null, '23', '', '', '1', null, '', null);
INSERT INTO `customer` VALUES ('3497', 'CU-2100294', 'ซอยหมอศรี', 'ซอยหมอศรี', '9', '', '18', null, null, '', '1', null, null, '1613274821', '1613357175', null, null, null, '23', '', '', '2', '3', '', null);

-- ----------------------------
-- Table structure for `customer_group`
-- ----------------------------
DROP TABLE IF EXISTS `customer_group`;
CREATE TABLE `customer_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_customer_group` (`company_id`),
  KEY `fk_branch_customer_group` (`branch_id`),
  CONSTRAINT `fk_branch_customer_group` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_customer_group` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_group
-- ----------------------------
INSERT INTO `customer_group` VALUES ('1', '001', 'ทดสอบ', 'fdfd', '1', null, null, '1608949052', '1608952700', null, null);
INSERT INTO `customer_group` VALUES ('2', 'AZ', 'AZ', 'AZ', '1', null, null, '1611335718', '1611335718', null, null);
INSERT INTO `customer_group` VALUES ('3', 'BP', 'BP', 'BP', '1', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `customer_group` VALUES ('4', 'NV', 'NV', 'NV', '1', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `customer_group` VALUES ('5', 'VP', 'VP', 'VP', '1', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `customer_group` VALUES ('6', 'CJ', 'CJ', 'CJ', '1', null, null, '1611335720', '1611335720', null, null);
INSERT INTO `customer_group` VALUES ('7', 'XX', 'XX', 'XX', '1', null, null, '1611335721', '1611335721', null, null);
INSERT INTO `customer_group` VALUES ('8', 'AZ อเมซอน', 'AZ อเมซอน', 'AZ อเมซอน', '1', null, null, '1613193014', '1613193014', null, null);
INSERT INTO `customer_group` VALUES ('9', 'CJ Express', 'CJ Express', 'CJ Express', '1', null, null, '1613193069', '1613193069', null, null);
INSERT INTO `customer_group` VALUES ('10', 'VP ขายรถ', 'VP ขายรถ', 'VP ขายรถ', '1', null, null, '1613193070', '1613193070', null, null);

-- ----------------------------
-- Table structure for `customer_type`
-- ----------------------------
DROP TABLE IF EXISTS `customer_type`;
CREATE TABLE `customer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of customer_type
-- ----------------------------
INSERT INTO `customer_type` VALUES ('1', 'TR20', 'ขายปลีก 20', 'ขายปลีก 20', '1', '1610115919', null, '1610979358', null);
INSERT INTO `customer_type` VALUES ('2', 'ขายปลีก 30', 'ขายปลีก 30', 'ขายปลีก 30', '1', '1610115938', null, '1610119424', null);
INSERT INTO `customer_type` VALUES ('3', 'AZ01', 'AZ01', 'AZ01', '1', '1611335718', null, '1611335718', null);
INSERT INTO `customer_type` VALUES ('4', 'BP01', 'BP01', 'BP01', '1', '1611335719', null, '1611335719', null);
INSERT INTO `customer_type` VALUES ('5', 'NV01', 'NV01', 'NV01', '1', '1611335719', null, '1611335719', null);
INSERT INTO `customer_type` VALUES ('6', 'VP01', 'VP01', 'VP01', '1', '1611335719', null, '1611335719', null);
INSERT INTO `customer_type` VALUES ('8', 'XXXX', 'XXXX', 'XXXX', '1', '1611335721', null, '1611335721', null);
INSERT INTO `customer_type` VALUES ('9', 'AZ01-20', 'AZ01-20', 'AZ01-20', '1', '1613193014', null, '1613193014', null);
INSERT INTO `customer_type` VALUES ('10', 'AZ01-25', 'AZ01-25', 'AZ01-25', '1', '1613193068', null, '1613193068', null);
INSERT INTO `customer_type` VALUES ('11', 'AZ02-20', 'AZ02-20', 'AZ02-20', '1', '1613193068', null, '1613193068', null);
INSERT INTO `customer_type` VALUES ('12', 'AZ02-25', 'AZ02-25', 'AZ02-25', '1', '1613193068', null, '1613193068', null);
INSERT INTO `customer_type` VALUES ('13', 'AZ03-20', 'AZ03-20', 'AZ03-20', '1', '1613193068', null, '1613193068', null);
INSERT INTO `customer_type` VALUES ('14', 'AZ03-25', 'AZ03-25', 'AZ03-25', '1', '1613193068', null, '1613193068', null);
INSERT INTO `customer_type` VALUES ('15', 'AZ04-20', 'AZ04-20', 'AZ04-20', '1', '1613193068', null, '1613193068', null);
INSERT INTO `customer_type` VALUES ('16', 'AZ04-25', 'AZ04-25', 'AZ04-25', '1', '1613193068', null, '1613193068', null);
INSERT INTO `customer_type` VALUES ('17', 'AZ05-20', 'AZ05-20', 'AZ05-20', '1', '1613193069', null, '1613193069', null);
INSERT INTO `customer_type` VALUES ('18', 'AZ05-25', 'AZ05-25', 'AZ05-25', '1', '1613193069', null, '1613193069', null);
INSERT INTO `customer_type` VALUES ('19', 'AZ06-20', 'AZ06-20', 'AZ06-20', '1', '1613193069', null, '1613193069', null);
INSERT INTO `customer_type` VALUES ('20', 'AZ06-25', 'AZ06-25', 'AZ06-25', '1', '1613193069', null, '1613193069', null);
INSERT INTO `customer_type` VALUES ('21', 'AZ07-20', 'AZ07-20', 'AZ07-20', '1', '1613193069', null, '1613193069', null);
INSERT INTO `customer_type` VALUES ('22', 'AZ07-25', 'AZ07-25', 'AZ07-25', '1', '1613193069', null, '1613193069', null);
INSERT INTO `customer_type` VALUES ('23', 'CJ-01', 'CJ-01', 'CJ-01', '1', '1613193069', null, '1613193069', null);
INSERT INTO `customer_type` VALUES ('24', 'CJ-02', 'CJ-02', 'CJ-02', '1', '1613193069', null, '1613193069', null);
INSERT INTO `customer_type` VALUES ('25', 'CJ-03', 'CJ-03', 'CJ-03', '1', '1613193069', null, '1613193069', null);
INSERT INTO `customer_type` VALUES ('26', 'CJ-04', 'CJ-04', 'CJ-04', '1', '1613193070', null, '1613193070', null);
INSERT INTO `customer_type` VALUES ('27', 'VP16', 'VP16', 'VP16', '1', '1613193070', null, '1613193070', null);
INSERT INTO `customer_type` VALUES ('28', 'VP17', 'VP17', 'VP17', '1', '1613193070', null, '1613193070', null);
INSERT INTO `customer_type` VALUES ('29', 'VP18-11', 'VP18-11', 'VP18-11', '1', '1613193071', null, '1613193071', null);
INSERT INTO `customer_type` VALUES ('30', 'VP18-20', 'VP18-20', 'VP18-20', '1', '1613193071', null, '1613193071', null);
INSERT INTO `customer_type` VALUES ('31', 'VP18-17', 'VP18-17', 'VP18-17', '1', '1613193071', null, '1613193071', null);
INSERT INTO `customer_type` VALUES ('32', 'VP18-15', 'VP18-15', 'VP18-15', '1', '1613193071', null, '1613193071', null);
INSERT INTO `customer_type` VALUES ('33', 'VP19-40', 'VP19-40', 'VP19-40', '1', '1613193071', null, '1613193071', null);
INSERT INTO `customer_type` VALUES ('34', 'VP19-23', 'VP19-23', 'VP19-23', '1', '1613193071', null, '1613193071', null);
INSERT INTO `customer_type` VALUES ('35', 'VP20-23', 'VP20-23', 'VP20-23', '1', '1613193071', null, '1613193071', null);
INSERT INTO `customer_type` VALUES ('36', 'VP21-110', 'VP21-110', 'VP21-110', '1', '1613193071', null, '1613193071', null);
INSERT INTO `customer_type` VALUES ('37', 'VP21-105', 'VP21-105', 'VP21-105', '1', '1613193071', null, '1613193071', null);
INSERT INTO `customer_type` VALUES ('38', 'VP22-23', 'VP22-23', 'VP22-23', '1', '1613193072', null, '1613193072', null);
INSERT INTO `customer_type` VALUES ('39', 'VP23-23', 'VP23-23', 'VP23-23', '1', '1613193072', null, '1613193072', null);

-- ----------------------------
-- Table structure for `delivery_route`
-- ----------------------------
DROP TABLE IF EXISTS `delivery_route`;
CREATE TABLE `delivery_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_delivery_route` (`company_id`),
  KEY `fk_branch_delivery_route` (`branch_id`),
  CONSTRAINT `fk_branch_delivery_route` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_delivery_route` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of delivery_route
-- ----------------------------
INSERT INTO `delivery_route` VALUES ('1', '001', 'VP1', 'VP1', null, null, null, '1610347283', null, null);
INSERT INTO `delivery_route` VALUES ('2', '002', 'VP2', 'VP2', null, null, null, '1610347276', null, null);
INSERT INTO `delivery_route` VALUES ('3', '003', 'VP3', 'VP3', null, null, null, '1610347269', null, null);
INSERT INTO `delivery_route` VALUES ('4', 'รหัสของ Route ', 'Route ', 'รหัสของ Route ', null, null, '1611335718', '1611335718', null, null);
INSERT INTO `delivery_route` VALUES ('5', 'AZ01', 'AZ01', 'AZ01', null, null, '1611335718', '1611335718', null, null);
INSERT INTO `delivery_route` VALUES ('6', 'AZ02', 'AZ02', 'AZ02', null, null, '1611335718', '1611335718', null, null);
INSERT INTO `delivery_route` VALUES ('7', 'AZ03', 'AZ03', 'AZ03', null, null, '1611335718', '1611335718', null, null);
INSERT INTO `delivery_route` VALUES ('8', 'AZ04', 'AZ04', 'AZ04', null, null, '1611335718', '1611335718', null, null);
INSERT INTO `delivery_route` VALUES ('9', 'AZ05', 'AZ05', 'AZ05', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `delivery_route` VALUES ('10', 'AZ06', 'AZ06', 'AZ06', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `delivery_route` VALUES ('11', 'AZ07', 'AZ07', 'AZ07', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `delivery_route` VALUES ('12', 'BP01', 'BP01', 'BP01', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `delivery_route` VALUES ('13', 'BP02', 'BP02', 'BP02', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `delivery_route` VALUES ('14', 'NV01', 'NV01', 'NV01', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `delivery_route` VALUES ('15', 'NV02', 'NV02', 'NV02', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `delivery_route` VALUES ('16', 'NV04', 'NV04', 'NV04', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `delivery_route` VALUES ('17', 'VP16', 'VP16', 'VP16', null, null, '1611335719', '1611335719', null, null);
INSERT INTO `delivery_route` VALUES ('18', 'CJ01', 'CJ01', 'CJ01', null, null, '1611335720', '1611335720', null, null);
INSERT INTO `delivery_route` VALUES ('19', 'CJ02', 'CJ02', 'CJ02', null, null, '1611335720', '1611335720', null, null);
INSERT INTO `delivery_route` VALUES ('20', 'CJ03', 'CJ03', 'CJ03', null, null, '1611335720', '1611335720', null, null);
INSERT INTO `delivery_route` VALUES ('21', 'CJ04', 'CJ04', 'CJ04', null, null, '1611335720', '1611335720', null, null);
INSERT INTO `delivery_route` VALUES ('22', 'ROXX', 'ROXX', 'ROXX', null, null, '1611335721', '1611335721', null, null);
INSERT INTO `delivery_route` VALUES ('23', 'VP17', 'VP17', 'VP17', null, null, '1613193070', '1613193070', null, null);
INSERT INTO `delivery_route` VALUES ('24', 'VP18', 'VP18', 'VP18', null, null, '1613193071', '1613193071', null, null);
INSERT INTO `delivery_route` VALUES ('25', 'VP19', 'VP19', 'VP19', null, null, '1613193071', '1613193071', null, null);
INSERT INTO `delivery_route` VALUES ('26', 'VP20', 'VP20', 'VP20', null, null, '1613193071', '1613193071', null, null);
INSERT INTO `delivery_route` VALUES ('27', 'VP21', 'VP21', 'VP21', null, null, '1613193071', '1613193071', null, null);
INSERT INTO `delivery_route` VALUES ('28', 'VP22', 'VP22', 'VP22', null, null, '1613193072', '1613193072', null, null);
INSERT INTO `delivery_route` VALUES ('29', 'VP23', 'VP23', 'VP23', null, null, '1613193072', '1613193072', null, null);

-- ----------------------------
-- Table structure for `employee`
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `fname` varchar(255) DEFAULT NULL,
  `lname` varchar(255) DEFAULT NULL,
  `gender` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `salary_type` int(11) DEFAULT NULL,
  `emp_start` datetime DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_employee` (`company_id`),
  KEY `fk_branch_employee` (`branch_id`),
  CONSTRAINT `fk_branch_employee` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_employee` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES ('1', 'AZ01', 'นายศุภชัย', 'สุทธิประภา', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('2', 'AZ02', 'นายหอมหวน', 'รอดหิรัญ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('3', 'AZ03', 'นายมาโนช', 'เอี่ยมละออ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('4', 'AZ04', 'นายพงศ์พัทธ์', 'เลิศวัชรลือชา', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('5', 'AZ05', 'นายรักชาติ', 'ยังแก้ว', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('6', 'AZ06', 'นายอภิชาติ', 'ธนาทัพย์เจริญ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('7', 'AZ07', 'นายตุลา', 'โพธิ์จินดา', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('8', 'CJ01', 'นายอโณทัย', 'มุจะเงิน', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('9', 'VP01', 'นายวสูตร์', 'เหลืองพุ่มพิพัฒน์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('10', 'VP02', 'นายฉัตรมงคล', 'ทองมณโท', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('11', 'VP03', 'นายนราธิป', 'เฉลิมชัย', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('12', 'VP04', 'นายกัญจน์อมร', 'เกศเกื้อวิชญ์กุล', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('13', 'VP05', 'นายณธกร', 'ศรีเพชร', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('14', 'VP06', 'นายไพรัช', 'มัจฉาชม', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('15', 'VP07', 'นายธำรงค์', 'แก้วพูนผล', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('16', 'VP08', 'นายจตุภัทร', 'อ่วมวงษ์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('17', 'VP09', 'นายพิพต', 'สุภาเสิด', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('18', 'VP10', 'นายธีรพงษ์', 'เกตุสม', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('19', 'VP11', 'นายสุวัฒน์', 'รัฐลาด', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('20', 'VP12', 'นายณัทพงษ์', 'ตามะนี', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('21', 'VP13', 'นายณราชัย', 'เกิดสมบุญ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('22', 'VP14', 'นายวีรวัฒน์', 'หอมขจร', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('23', 'S001', 'นายประสพโชค', 'ประทุมแก้ว', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('24', 'S002', 'นายธวัชร์', 'อุปการะ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('25', 'S003', 'นายสุพจน์', 'ชีพันธ์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('26', 'S004', 'นายกฤษณะ', 'ผิวผ่อง', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('27', 'S006', 'นายจีระวัฒน์', 'จ่างแสง', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('28', 'S007', 'นายชาญณรงค์', 'บ่อสอาด', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('29', 'S008', 'นายอานนท์', 'บุญธรรม', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('30', 'S009', 'นายตนุภัทร', 'อิทธิกรวรกุล', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('31', 'S010', 'นายพิสิษฐ์', 'วงษ์จำปา', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('32', 'S011', 'นายนวนนท์', 'นาคนุช', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('33', 'S012', 'นายนิรันดร์', 'ชีพันธ์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('34', 'S015', 'นายวรนาถ', 'สุวรรณพิทักษ์', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('35', 'S016', 'นายวรพงศ์', 'สงวนชื่อ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('36', 'S017', 'นายพิจักษณ์', 'แสงใหญ่', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('37', 'S018', 'นายกิตติธัช', 'เปี่ยมคล้า', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('38', 'M001', 'นางสาวอนิสรา', 'รักศรี', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('39', 'M002', 'นางสาวสุรัตร์ดา', 'หมวกเมือง', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('40', 'M003', 'นางสาวกันทิมา', 'ชูสุวรรณ', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('41', 'M004', 'นางสาวสุทธิดา', 'เอกสินิทธ์กุล', null, null, null, null, null, null, '1', null, null, '1610023398', '1610023398', null, null);
INSERT INTO `employee` VALUES ('42', 'M005', 'นางสาวสุวัจจี', 'ตริศายลักษณ์', '1', '1', null, '0000-00-00 00:00:00', '', '', '1', null, null, '1610023398', '1611072868', null, null);
INSERT INTO `employee` VALUES ('43', 'S019', 'นายรุ่งเรือง', 'เปล่งปลั่ง', null, null, null, null, '', '1612749148.png', '1', null, null, '1610023398', '1612749148', null, null);

-- ----------------------------
-- Table structure for `journal_issue`
-- ----------------------------
DROP TABLE IF EXISTS `journal_issue`;
CREATE TABLE `journal_issue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `journal_no` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `car_ref_id` int(11) DEFAULT NULL,
  `delivery_route_id` int(11) DEFAULT NULL,
  `order_ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of journal_issue
-- ----------------------------
INSERT INTO `journal_issue` VALUES ('2', 'IS-210216-0001', '2021-02-16 00:00:00', '2', '1613486083', null, '1613535378', null, null, '5', '24');
INSERT INTO `journal_issue` VALUES ('3', 'IS-210216-0002', '2021-02-16 00:00:00', '1', '1613487721', null, '1613487721', null, null, '1', null);

-- ----------------------------
-- Table structure for `journal_issue_line`
-- ----------------------------
DROP TABLE IF EXISTS `journal_issue_line`;
CREATE TABLE `journal_issue_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `warehouse_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of journal_issue_line
-- ----------------------------
INSERT INTO `journal_issue_line` VALUES ('10', '2', '1', null, null, '3', '1', '1613486083', null, '1613534118', null);
INSERT INTO `journal_issue_line` VALUES ('11', '2', '2', null, null, '3', '1', '1613486083', null, '1613534118', null);
INSERT INTO `journal_issue_line` VALUES ('12', '2', '3', null, null, '4', '1', '1613486083', null, '1613534118', null);
INSERT INTO `journal_issue_line` VALUES ('13', '2', '4', null, null, '0', '1', '1613486083', null, '1613534118', null);
INSERT INTO `journal_issue_line` VALUES ('14', '2', '5', null, null, '5', '1', '1613486083', null, '1613534118', null);
INSERT INTO `journal_issue_line` VALUES ('15', '2', '6', null, null, '0', '1', '1613486083', null, '1613534118', null);
INSERT INTO `journal_issue_line` VALUES ('16', '2', '7', null, null, '0', '1', '1613486083', null, '1613534118', null);
INSERT INTO `journal_issue_line` VALUES ('17', '2', '8', null, null, '0', '1', '1613486083', null, '1613534118', null);
INSERT INTO `journal_issue_line` VALUES ('18', '2', '9', null, null, '0', '1', '1613486083', null, '1613534118', null);
INSERT INTO `journal_issue_line` VALUES ('19', '3', '1', null, null, '5', '1', '1613487721', null, '1613487721', null);
INSERT INTO `journal_issue_line` VALUES ('20', '3', '2', null, null, '0', '1', '1613487721', null, '1613487721', null);
INSERT INTO `journal_issue_line` VALUES ('21', '3', '3', null, null, '0', '1', '1613487721', null, '1613487721', null);
INSERT INTO `journal_issue_line` VALUES ('22', '3', '4', null, null, '0', '1', '1613487721', null, '1613487721', null);
INSERT INTO `journal_issue_line` VALUES ('23', '3', '5', null, null, '9', '1', '1613487721', null, '1613487721', null);
INSERT INTO `journal_issue_line` VALUES ('24', '3', '6', null, null, '0', '1', '1613487721', null, '1613487721', null);
INSERT INTO `journal_issue_line` VALUES ('25', '3', '7', null, null, '0', '1', '1613487721', null, '1613487721', null);
INSERT INTO `journal_issue_line` VALUES ('26', '3', '8', null, null, '12', '1', '1613487721', null, '1613487721', null);
INSERT INTO `journal_issue_line` VALUES ('27', '3', '9', null, null, '0', '1', '1613487721', null, '1613487721', null);

-- ----------------------------
-- Table structure for `journal_payment`
-- ----------------------------
DROP TABLE IF EXISTS `journal_payment`;
CREATE TABLE `journal_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `journal_no` varchar(255) DEFAULT NULL,
  `trans_date` varchar(255) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `payment_term_id` int(11) DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `pay_amount` float DEFAULT NULL,
  `change_amount` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of journal_payment
-- ----------------------------
INSERT INTO `journal_payment` VALUES ('1', 'AX', '2021-01-23', '47', '1', null, '46', '50', '4', null, null, null, null, null);
INSERT INTO `journal_payment` VALUES ('2', 'AX', '2021-01-24', '48', '1', null, '238', '500', '262', null, null, null, null, null);
INSERT INTO `journal_payment` VALUES ('3', 'AX', '2021-02-13', '17', '1', null, '46', '100', '54', null, null, null, null, null);

-- ----------------------------
-- Table structure for `location`
-- ----------------------------
DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warehouse_id` int(11) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_location` (`company_id`),
  KEY `fk_branch_location` (`branch_id`),
  CONSTRAINT `fk_branch_location` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_location` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of location
-- ----------------------------
INSERT INTO `location` VALUES ('1', '2', 'LOC01', 'LOC01', '', '', '1', null, null, '1608949019', '1608952467', null, null);

-- ----------------------------
-- Table structure for `member`
-- ----------------------------
DROP TABLE IF EXISTS `member`;
CREATE TABLE `member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of member
-- ----------------------------
INSERT INTO `member` VALUES ('4', 'niran', null, '1', null);
INSERT INTO `member` VALUES ('5', 'tarlek', null, '2', null);

-- ----------------------------
-- Table structure for `migration`
-- ----------------------------
DROP TABLE IF EXISTS `migration`;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of migration
-- ----------------------------
INSERT INTO `migration` VALUES ('m000000_000000_base', '1607399800');
INSERT INTO `migration` VALUES ('m130524_201442_init', '1607400303');
INSERT INTO `migration` VALUES ('m180505_140600_create_sequence_table', '1610206908');
INSERT INTO `migration` VALUES ('m190124_110200_add_verification_token_column_to_user_table', '1607400303');
INSERT INTO `migration` VALUES ('m201208_035857_create_company_table', '1607400303');
INSERT INTO `migration` VALUES ('m201208_040301_create_branch_table', '1607400602');
INSERT INTO `migration` VALUES ('m201208_040357_add_tenant_id_column_to_company_table', '1607400303');
INSERT INTO `migration` VALUES ('m201208_041659_add_status_column_to_company_table', '1607401024');
INSERT INTO `migration` VALUES ('m201208_042419_create_addressbook_table', '1607404890');
INSERT INTO `migration` VALUES ('m201208_042926_create_contacts_table', '1607405059');
INSERT INTO `migration` VALUES ('m201208_043127_create_unit_table', '1607405059');
INSERT INTO `migration` VALUES ('m201208_043224_create_product_type_table', '1607405059');
INSERT INTO `migration` VALUES ('m201208_043253_create_customer_group_table', '1607405059');
INSERT INTO `migration` VALUES ('m201208_044133_create_product_group_table', '1607405060');
INSERT INTO `migration` VALUES ('m201208_045324_create_standard_price_table', '1607405060');
INSERT INTO `migration` VALUES ('m201208_052613_create_delivery_route_table', '1607405515');
INSERT INTO `migration` VALUES ('m201208_052942_create_employee_table', '1607405515');
INSERT INTO `migration` VALUES ('m201208_074407_create_warehouse_table', '1607413666');
INSERT INTO `migration` VALUES ('m201208_074431_create_location_table', '1607413666');
INSERT INTO `migration` VALUES ('m201208_080819_create_car_type_table', '1607415143');
INSERT INTO `migration` VALUES ('m201208_081001_create_car_table', '1607415143');
INSERT INTO `migration` VALUES ('m201208_082456_create_orders_table', '1607416117');
INSERT INTO `migration` VALUES ('m201208_082630_create_order_line_table', '1607416117');
INSERT INTO `migration` VALUES ('m201208_083739_create_user_group_table', '1607431347');
INSERT INTO `migration` VALUES ('m201208_124019_create_customer_table', '1607431347');
INSERT INTO `migration` VALUES ('m201208_125131_create_product_table', '1607431993');
INSERT INTO `migration` VALUES ('m201208_132837_create_member_table', '1607434142');
INSERT INTO `migration` VALUES ('m201208_133314_add_status_column_to_member_table', '1607434400');
INSERT INTO `migration` VALUES ('m201209_094324_add_note_column_to_orders_table', '1607507012');
INSERT INTO `migration` VALUES ('m210107_121716_add_contact_name_column_to_customer_table', '1610021843');
INSERT INTO `migration` VALUES ('m210107_134401_add_sale_status_column_to_product_table', '1610027047');
INSERT INTO `migration` VALUES ('m210107_154145_create_customer_type_table', '1610034116');
INSERT INTO `migration` VALUES ('m210107_154731_create_price_group_table', '1610034703');
INSERT INTO `migration` VALUES ('m210107_155137_create_price_group_line_table', '1610034703');
INSERT INTO `migration` VALUES ('m210108_144031_create_price_customer_type_table', '1610116890');
INSERT INTO `migration` VALUES ('m210108_150930_add_customer_type_column_to_customer_table', '1610118577');
INSERT INTO `migration` VALUES ('m210109_134756_create_sale_group_table', '1610200083');
INSERT INTO `migration` VALUES ('m210110_153026_create_sale_com_table', '1610292836');
INSERT INTO `migration` VALUES ('m210110_153249_create_sale_com_summary_table', '1610292836');
INSERT INTO `migration` VALUES ('m210114_151250_add_customer_id_column_to_order_line_table', '1610637175');
INSERT INTO `migration` VALUES ('m210115_015438_create_payment_method_table', '1610675684');
INSERT INTO `migration` VALUES ('m210115_033428_add_payment_method_id_column_to_orders_table', '1610681674');
INSERT INTO `migration` VALUES ('m210115_043106_create_car_emp_table', '1610685073');
INSERT INTO `migration` VALUES ('m210115_061228_add_sale_group_id_column_to_car_table', '1610691216');
INSERT INTO `migration` VALUES ('m210115_061327_add_delivery_route_id_column_to_sale_group_table', '1610691216');
INSERT INTO `migration` VALUES ('m210115_161634_add_sale_com_id_column_to_car_table', '1610727398');
INSERT INTO `migration` VALUES ('m210116_031531_add_address_column_to_company_table', '1610766954');
INSERT INTO `migration` VALUES ('m210116_031544_add_address_column_to_branch_table', '1610767018');
INSERT INTO `migration` VALUES ('m210118_142958_create_payment_term_table', '1610980203');
INSERT INTO `migration` VALUES ('m210118_163121_create_position_table', '1610987487');
INSERT INTO `migration` VALUES ('m210119_161725_add_payment_term_id_column_to_orders_table', '1611073050');
INSERT INTO `migration` VALUES ('m210122_022612_create_car_daily_table', '1611282381');
INSERT INTO `migration` VALUES ('m210122_032335_add_trans_date_column_to_car_daily_table', '1611285822');
INSERT INTO `migration` VALUES ('m210122_163038_add_address_column_to_customer_table', '1611333045');
INSERT INTO `migration` VALUES ('m210122_163943_add_payment_method_id_column_to_payment_term_table', '1611333590');
INSERT INTO `migration` VALUES ('m210122_171345_add_address2_column_to_customer_table', '1611335631');
INSERT INTO `migration` VALUES ('m210123_124805_add_sale_channel_id_column_to_orders_table', '1611406092');
INSERT INTO `migration` VALUES ('m210123_131208_create_journal_payment_table', '1611418429');
INSERT INTO `migration` VALUES ('m210123_162632_add_payment_status_column_to_orders_table', '1611419201');
INSERT INTO `migration` VALUES ('m210129_170113_add_price_group_id_column_to_order_line_table', '1611939679');
INSERT INTO `migration` VALUES ('m210130_080108_create_payment_trans_table', '1611993931');
INSERT INTO `migration` VALUES ('m210130_080523_create_payment_trans_line_table', '1611994327');
INSERT INTO `migration` VALUES ('m210206_064346_add_order_ref_id_column_to_payment_trans_table', '1612593833');
INSERT INTO `migration` VALUES ('m210206_064458_add_order_ref_id_column_to_payment_trans_line_table', '1612593904');
INSERT INTO `migration` VALUES ('m210214_113817_add_pay_type_column_to_payment_method_table', '1613302702');
INSERT INTO `migration` VALUES ('m210216_130256_create_journal_issue_table', '1613481330');
INSERT INTO `migration` VALUES ('m210216_131524_create_journal_issue_line_table', '1613481330');
INSERT INTO `migration` VALUES ('m210216_132536_add_car_ref_id_column_to_journal_issue_table', '1613481941');
INSERT INTO `migration` VALUES ('m210216_145409_add_issue_id_column_to_order_table', '1613487320');
INSERT INTO `migration` VALUES ('m210217_032210_add_bill_no_column_to_order_line_table', '1613532137');
INSERT INTO `migration` VALUES ('m210217_040612_add_order_ref_id_column_to_journal_issue_table', '1613534776');

-- ----------------------------
-- Table structure for `orders`
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `customer_type` int(11) DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `order_date` datetime DEFAULT NULL,
  `vat_amt` float DEFAULT NULL,
  `vat_per` float DEFAULT NULL,
  `order_total_amt` float DEFAULT NULL,
  `emp_sale_id` int(11) DEFAULT NULL,
  `car_ref_id` int(11) DEFAULT NULL,
  `order_channel_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `payment_term_id` int(11) DEFAULT NULL,
  `sale_channel_id` int(11) DEFAULT NULL,
  `payment_status` int(11) DEFAULT NULL,
  `issue_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_order` (`company_id`),
  KEY `fk_branch_order` (`branch_id`),
  CONSTRAINT `fk_branch_order` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_order` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('17', 'SO-210213-0001', '2851', null, null, '2021-02-13 00:00:00', null, null, null, null, null, null, '1', null, null, '1613225912', '1613225912', null, null, null, null, null, '2', '0', null);
INSERT INTO `orders` VALUES ('18', 'SO-210213-0002', '2854', null, null, '2021-02-13 00:00:00', null, null, '60', null, null, null, '1', null, null, '1613229471', '1613229471', null, null, null, null, null, '2', '0', null);
INSERT INTO `orders` VALUES ('19', 'SO-210213-0003', '2854', null, null, '2021-02-13 00:00:00', null, null, '60', null, null, null, '1', null, null, '1613229523', '1613229523', null, null, null, null, null, '2', '0', null);
INSERT INTO `orders` VALUES ('20', 'SO-210213-0004', '2854', null, null, '2021-02-13 00:00:00', null, null, '60', null, null, null, '1', null, null, '1613229539', '1613229539', null, null, null, null, null, '2', '0', null);
INSERT INTO `orders` VALUES ('21', 'SO-210213-0005', '2854', null, null, '2021-02-13 00:00:00', null, null, '60', null, null, null, '1', null, null, '1613229555', '1613229555', null, null, null, null, null, '2', '0', null);
INSERT INTO `orders` VALUES ('23', 'SO-210217-0001', null, null, null, '2021-02-17 00:00:00', null, null, '40', null, '3', '5', '1', null, null, '1613535214', '1613535214', null, null, null, null, null, '1', null, null);
INSERT INTO `orders` VALUES ('24', 'SO-210217-0002', null, null, null, '2021-02-17 00:00:00', null, null, null, null, '3', '5', '1', null, null, '1613535378', '1613535378', null, null, null, null, null, '1', null, '2');

-- ----------------------------
-- Table structure for `order_line`
-- ----------------------------
DROP TABLE IF EXISTS `order_line`;
CREATE TABLE `order_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `qty` float DEFAULT NULL,
  `price` float DEFAULT NULL,
  `line_disc_amt` float DEFAULT NULL,
  `line_disc_per` float DEFAULT NULL,
  `line_total` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `price_group_id` int(11) DEFAULT NULL,
  `bill_no` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_order_line` (`company_id`),
  KEY `fk_branch_order_line` (`branch_id`),
  CONSTRAINT `fk_branch_order_line` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_order_line` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2373 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order_line
-- ----------------------------
INSERT INTO `order_line` VALUES ('2284', '17', '4', '2', '23', null, null, '46', '1', null, null, '1613225912', '1613225912', null, null, null, null, null);
INSERT INTO `order_line` VALUES ('2285', '18', '2', '6', '10', null, null, '60', '1', null, null, '1613229471', '1613229471', null, null, '2854', '0', null);
INSERT INTO `order_line` VALUES ('2286', '19', '2', '6', '10', null, null, '60', '1', null, null, '1613229523', '1613229523', null, null, '2854', '0', null);
INSERT INTO `order_line` VALUES ('2287', '20', '2', '6', '10', null, null, '60', '1', null, null, '1613229539', '1613229539', null, null, '2854', '0', null);
INSERT INTO `order_line` VALUES ('2288', '21', '2', '6', '10', null, null, '60', '1', null, null, '1613229555', '1613229555', null, null, '2854', '0', null);
INSERT INTO `order_line` VALUES ('2317', '23', '1', '0', '20', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2850', '8', '');
INSERT INTO `order_line` VALUES ('2318', '23', '2', '0', '21', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2850', '8', '');
INSERT INTO `order_line` VALUES ('2319', '23', '3', '0', '22', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2850', '8', '');
INSERT INTO `order_line` VALUES ('2320', '23', '4', '0', '23', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2850', '8', '');
INSERT INTO `order_line` VALUES ('2321', '23', '1', '0', '20', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2851', '8', '');
INSERT INTO `order_line` VALUES ('2322', '23', '2', '0', '21', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2851', '8', '');
INSERT INTO `order_line` VALUES ('2323', '23', '3', '0', '22', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2851', '8', '');
INSERT INTO `order_line` VALUES ('2324', '23', '4', '0', '23', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2851', '8', '');
INSERT INTO `order_line` VALUES ('2325', '23', '1', '0', '20', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2852', '8', '');
INSERT INTO `order_line` VALUES ('2326', '23', '2', '0', '21', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2852', '8', '');
INSERT INTO `order_line` VALUES ('2327', '23', '3', '0', '22', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2852', '8', '');
INSERT INTO `order_line` VALUES ('2328', '23', '4', '0', '23', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2852', '8', '');
INSERT INTO `order_line` VALUES ('2329', '23', '1', '0', '20', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2853', '8', '');
INSERT INTO `order_line` VALUES ('2330', '23', '2', '0', '21', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2853', '8', '');
INSERT INTO `order_line` VALUES ('2331', '23', '3', '0', '22', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2853', '8', '');
INSERT INTO `order_line` VALUES ('2332', '23', '4', '0', '23', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2853', '8', '');
INSERT INTO `order_line` VALUES ('2333', '23', '1', '0', '20', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2861', '8', '');
INSERT INTO `order_line` VALUES ('2334', '23', '2', '0', '21', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2861', '8', '');
INSERT INTO `order_line` VALUES ('2335', '23', '3', '0', '22', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2861', '8', '');
INSERT INTO `order_line` VALUES ('2336', '23', '4', '0', '23', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2861', '8', '');
INSERT INTO `order_line` VALUES ('2337', '23', '1', '0', '20', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2862', '8', '');
INSERT INTO `order_line` VALUES ('2338', '23', '2', '0', '21', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2862', '8', '');
INSERT INTO `order_line` VALUES ('2339', '23', '3', '0', '22', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2862', '8', '');
INSERT INTO `order_line` VALUES ('2340', '23', '4', '0', '23', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2862', '8', '');
INSERT INTO `order_line` VALUES ('2341', '23', '1', '2', '20', null, null, '40', null, null, null, '1613535214', '1613535214', null, null, '2863', '8', '');
INSERT INTO `order_line` VALUES ('2342', '23', '2', '0', '21', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2863', '8', '');
INSERT INTO `order_line` VALUES ('2343', '23', '3', '0', '22', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2863', '8', '');
INSERT INTO `order_line` VALUES ('2344', '23', '4', '0', '23', null, null, '0', null, null, null, '1613535214', '1613535214', null, null, '2863', '8', '');
INSERT INTO `order_line` VALUES ('2345', '24', '1', '0', '20', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2850', '8', '');
INSERT INTO `order_line` VALUES ('2346', '24', '2', '0', '21', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2850', '8', '');
INSERT INTO `order_line` VALUES ('2347', '24', '3', '0', '22', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2850', '8', '');
INSERT INTO `order_line` VALUES ('2348', '24', '4', '0', '23', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2850', '8', '');
INSERT INTO `order_line` VALUES ('2349', '24', '1', '0', '20', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2851', '8', '');
INSERT INTO `order_line` VALUES ('2350', '24', '2', '0', '21', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2851', '8', '');
INSERT INTO `order_line` VALUES ('2351', '24', '3', '0', '22', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2851', '8', '');
INSERT INTO `order_line` VALUES ('2352', '24', '4', '0', '23', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2851', '8', '');
INSERT INTO `order_line` VALUES ('2353', '24', '1', '0', '20', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2852', '8', '');
INSERT INTO `order_line` VALUES ('2354', '24', '2', '0', '21', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2852', '8', '');
INSERT INTO `order_line` VALUES ('2355', '24', '3', '0', '22', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2852', '8', '');
INSERT INTO `order_line` VALUES ('2356', '24', '4', '0', '23', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2852', '8', '');
INSERT INTO `order_line` VALUES ('2357', '24', '1', '0', '20', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2853', '8', '');
INSERT INTO `order_line` VALUES ('2358', '24', '2', '0', '21', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2853', '8', '');
INSERT INTO `order_line` VALUES ('2359', '24', '3', '0', '22', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2853', '8', '');
INSERT INTO `order_line` VALUES ('2360', '24', '4', '0', '23', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2853', '8', '');
INSERT INTO `order_line` VALUES ('2361', '24', '1', '0', '20', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2861', '8', '');
INSERT INTO `order_line` VALUES ('2362', '24', '2', '0', '21', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2861', '8', '');
INSERT INTO `order_line` VALUES ('2363', '24', '3', '0', '22', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2861', '8', '');
INSERT INTO `order_line` VALUES ('2364', '24', '4', '0', '23', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2861', '8', '');
INSERT INTO `order_line` VALUES ('2365', '24', '1', '0', '20', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2862', '8', '');
INSERT INTO `order_line` VALUES ('2366', '24', '2', '0', '21', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2862', '8', '');
INSERT INTO `order_line` VALUES ('2367', '24', '3', '0', '22', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2862', '8', '');
INSERT INTO `order_line` VALUES ('2368', '24', '4', '0', '23', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2862', '8', '');
INSERT INTO `order_line` VALUES ('2369', '24', '1', '0', '20', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2863', '8', '');
INSERT INTO `order_line` VALUES ('2370', '24', '2', '0', '21', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2863', '8', '');
INSERT INTO `order_line` VALUES ('2371', '24', '3', '0', '22', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2863', '8', '');
INSERT INTO `order_line` VALUES ('2372', '24', '4', '0', '23', null, null, '0', null, null, null, '1613535378', '1613535378', null, null, '2863', '8', '');

-- ----------------------------
-- Table structure for `payment_method`
-- ----------------------------
DROP TABLE IF EXISTS `payment_method`;
CREATE TABLE `payment_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `pay_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_method
-- ----------------------------
INSERT INTO `payment_method` VALUES ('1', 'เงินสด', 'เงินสด', 'เงินสด', '1', '1610681572', null, '1610681608', null, null);
INSERT INTO `payment_method` VALUES ('2', ' เงินเชื่อ', ' เงินเชื่อ', ' เงินเชื่อ', '1', '1610728609', null, '1610728609', null, null);

-- ----------------------------
-- Table structure for `payment_term`
-- ----------------------------
DROP TABLE IF EXISTS `payment_term`;
CREATE TABLE `payment_term` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_term
-- ----------------------------
INSERT INTO `payment_term` VALUES ('1', 'ชำระเงินสด', 'ชำระเงินสด', 'ชำระเงินสด', '1', '1611230478', null, null, '1611334041', '1');
INSERT INTO `payment_term` VALUES ('2', 'เครคิด', 'เครคิด', 'เครคิด', '1', '1611370995', null, null, '1611370995', null);
INSERT INTO `payment_term` VALUES ('3', '30 วัน', '30 วัน', '30 วัน', '1', '1611370995', null, null, '1611370995', null);
INSERT INTO `payment_term` VALUES ('4', '15 วัน', '15 วัน', '15 วัน', '1', '1611370996', null, null, '1611370996', null);
INSERT INTO `payment_term` VALUES ('5', '7 วัน', '7 วัน', '7 วัน', '1', '1611370996', null, null, '1611370996', null);
INSERT INTO `payment_term` VALUES ('6', '3 วัน', '3 วัน', '3 วัน', '1', '1611370996', null, null, '1611373023', '2');
INSERT INTO `payment_term` VALUES ('7', '30', '30', '30', '1', '1613193014', null, null, '1613193014', null);
INSERT INTO `payment_term` VALUES ('8', '15', '15', '15', '1', '1613193068', null, null, '1613193068', null);
INSERT INTO `payment_term` VALUES ('9', '00', '00', '00', '1', '1613193068', null, null, '1613193068', null);
INSERT INTO `payment_term` VALUES ('10', 'NULL', 'NULL', 'NULL', '1', '1613193068', null, null, '1613193068', null);
INSERT INTO `payment_term` VALUES ('11', '7', '7', '7', '1', '1613193068', null, null, '1613193068', null);

-- ----------------------------
-- Table structure for `payment_trans`
-- ----------------------------
DROP TABLE IF EXISTS `payment_trans`;
CREATE TABLE `payment_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_no` varchar(255) DEFAULT NULL,
  `trans_date` datetime DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `order_ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_trans
-- ----------------------------
INSERT INTO `payment_trans` VALUES ('9', 'IV21000001', '2021-02-04 21:18:17', '61', '0', '1612448297', '1', '1612448297', null, null);
INSERT INTO `payment_trans` VALUES ('10', 'IV21000002', '2021-02-04 21:19:33', '61', '0', '1612448373', '1', '1612448373', null, null);
INSERT INTO `payment_trans` VALUES ('11', 'IV21000003', '2021-02-04 21:22:30', '61', '0', '1612448550', '1', '1612448550', null, null);
INSERT INTO `payment_trans` VALUES ('13', 'IV21000004', '2021-02-04 21:52:14', '61', '0', '1612450334', '1', '1612450334', null, null);
INSERT INTO `payment_trans` VALUES ('14', 'IV21000005', '2021-02-04 21:55:08', '61', '0', '1612450508', '1', '1612450508', null, null);
INSERT INTO `payment_trans` VALUES ('15', 'IV21000006', '2021-02-06 13:37:44', '62', '0', '1612593464', '1', '1612593464', null, null);
INSERT INTO `payment_trans` VALUES ('16', 'IV21000007', '2021-02-06 13:47:23', '62', '0', '1612594043', '1', '1612594043', null, null);
INSERT INTO `payment_trans` VALUES ('17', 'IV21000008', '2021-02-06 13:48:59', '62', '0', '1612594139', '1', '1612594139', null, null);
INSERT INTO `payment_trans` VALUES ('18', 'IV21000009', '2021-02-06 14:47:04', '62', '0', '1612597624', '1', '1612597624', null, null);
INSERT INTO `payment_trans` VALUES ('19', 'IV21000010', '2021-02-06 15:19:55', '62', '0', '1612599595', '1', '1612599595', null, null);
INSERT INTO `payment_trans` VALUES ('20', 'IV21000011', '2021-02-07 22:56:53', '6', '0', '1612713413', '1', '1612713413', null, null);
INSERT INTO `payment_trans` VALUES ('21', 'IV21000012', '2021-02-07 22:57:12', '6', '0', '1612713432', '1', '1612713432', null, null);
INSERT INTO `payment_trans` VALUES ('22', 'IV21000013', '2021-02-07 22:57:29', '6', '0', '1612713449', '1', '1612713449', null, null);
INSERT INTO `payment_trans` VALUES ('23', 'IV21000014', '2021-02-07 22:58:30', '6', '0', '1612713510', '1', '1612713510', null, null);
INSERT INTO `payment_trans` VALUES ('24', 'IV21000015', '2021-02-10 23:13:59', '9', '0', '1612973639', '1', '1612973639', null, null);
INSERT INTO `payment_trans` VALUES ('25', 'IV21000016', '2021-02-11 08:52:38', '16', '0', '1613008358', '1', '1613008358', null, null);
INSERT INTO `payment_trans` VALUES ('26', 'IV21000017', '2021-02-13 22:18:43', '19', '0', '1613229523', '1', '1613229523', null, null);
INSERT INTO `payment_trans` VALUES ('27', 'IV21000018', '2021-02-13 22:18:59', '20', '0', '1613229539', '1', '1613229539', null, null);
INSERT INTO `payment_trans` VALUES ('28', 'IV21000019', '2021-02-13 22:19:15', '21', '0', '1613229555', '1', '1613229555', null, null);

-- ----------------------------
-- Table structure for `payment_trans_line`
-- ----------------------------
DROP TABLE IF EXISTS `payment_trans_line`;
CREATE TABLE `payment_trans_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_method_id` int(11) DEFAULT NULL,
  `payment_term_id` int(11) DEFAULT NULL,
  `payment_amount` float DEFAULT NULL,
  `total_amount` float DEFAULT NULL,
  `change_amount` float DEFAULT NULL,
  `doc` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `order_ref_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of payment_trans_line
-- ----------------------------
INSERT INTO `payment_trans_line` VALUES ('26', '10', '2646', '2021-02-04 21:19:33', null, null, '100', '0', null, '', '1', '1612448373', '1', '1612448373', null, null);
INSERT INTO `payment_trans_line` VALUES ('28', '13', '2646', '2021-02-04 21:52:14', null, null, '65', '0', null, '', '1', '1612450334', '1', '1612450334', null, null);
INSERT INTO `payment_trans_line` VALUES ('29', '14', '2647', '2021-02-04 21:55:08', null, null, '120', '0', null, '', '1', '1612450508', '1', '1612450508', null, null);
INSERT INTO `payment_trans_line` VALUES ('30', '14', '2648', '2021-02-04 21:55:08', null, null, '276', '0', null, '', '1', '1612450508', '1', '1612450508', null, null);
INSERT INTO `payment_trans_line` VALUES ('31', '15', '2678', '2021-02-06 13:37:44', '1', '0', '100', '0', null, '', '1', '1612593464', '1', '1612599580', '1', '62');
INSERT INTO `payment_trans_line` VALUES ('32', '16', '2678', '2021-02-06 13:47:23', '1', '0', '20', '0', null, '', '1', '1612594043', '1', '1612599580', '1', '62');
INSERT INTO `payment_trans_line` VALUES ('34', '18', '2679', '2021-02-06 14:47:04', '1', '0', '100', '0', null, '', '1', '1612597624', '1', '1612597624', null, '62');
INSERT INTO `payment_trans_line` VALUES ('35', '18', '2680', '2021-02-06 14:47:04', '1', '0', '130', '0', null, '', '1', '1612597624', '1', '1612598798', '1', '62');
INSERT INTO `payment_trans_line` VALUES ('36', '19', '2678', '2021-02-06 15:19:55', '1', '0', '20', '0', null, '', '1', '1612599595', '1', '1612599595', null, '62');
INSERT INTO `payment_trans_line` VALUES ('37', '23', '2646', '2021-02-07 22:58:30', '2', '6', '0', '0', null, '', '1', '1612713510', '1', '1612713510', null, '6');
INSERT INTO `payment_trans_line` VALUES ('38', '24', '2678', '2021-02-10 23:13:59', '1', '1', '66', '0', null, '', '1', '1612973639', '1', '1612973639', null, '9');
INSERT INTO `payment_trans_line` VALUES ('39', '24', '2679', '2021-02-10 23:13:59', '1', '1', '56', '0', null, '', '1', '1612973639', '1', '1612973639', null, '9');
INSERT INTO `payment_trans_line` VALUES ('40', '24', '2680', '2021-02-10 23:13:59', '1', '1', '53', '0', null, '', '1', '1612973639', '1', '1612973639', null, '9');
INSERT INTO `payment_trans_line` VALUES ('41', '24', '2681', '2021-02-10 23:13:59', '1', '1', '78', '0', null, '', '1', '1612973639', '1', '1612973639', null, '9');
INSERT INTO `payment_trans_line` VALUES ('42', '24', '2682', '2021-02-10 23:13:59', '1', '1', '13', '0', null, '', '1', '1612973639', '1', '1612973639', null, '9');
INSERT INTO `payment_trans_line` VALUES ('43', '24', '2683', '2021-02-10 23:13:59', '1', '1', '13', '0', null, '', '1', '1612973639', '1', '1612973639', null, '9');
INSERT INTO `payment_trans_line` VALUES ('44', '25', '2646', '2021-02-11 08:52:38', '1', '1', '30', '0', null, '', '1', '1613008358', '1', '1613008358', null, '16');
INSERT INTO `payment_trans_line` VALUES ('45', '27', '2854', '2021-02-13 22:18:59', '1', null, '100', '0', null, '', '1', '1613229539', '1', '1613229539', null, '20');
INSERT INTO `payment_trans_line` VALUES ('46', '28', '2854', '2021-02-13 22:19:15', '1', null, '100', '0', null, '', '1', '1613229555', '1', '1613229555', null, '21');

-- ----------------------------
-- Table structure for `position`
-- ----------------------------
DROP TABLE IF EXISTS `position`;
CREATE TABLE `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of position
-- ----------------------------
INSERT INTO `position` VALUES ('1', 'EMP01', 'Saleman', 'Saleman', '1', '1611071181', null, '1611071181', null);

-- ----------------------------
-- Table structure for `price_customer_type`
-- ----------------------------
DROP TABLE IF EXISTS `price_customer_type`;
CREATE TABLE `price_customer_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price_group_id` int(11) DEFAULT NULL,
  `customer_type_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=54 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of price_customer_type
-- ----------------------------
INSERT INTO `price_customer_type` VALUES ('19', '7', '5', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('21', '6', '6', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('22', '8', '9', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('23', '9', '10', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('24', '10', '11', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('25', '11', '12', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('26', '12', '13', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('27', '13', '14', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('28', '14', '15', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('29', '15', '16', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('30', '16', '17', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('31', '17', '18', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('32', '18', '19', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('33', '19', '20', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('34', '20', '21', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('35', '21', '22', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('37', '23', '24', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('38', '24', '25', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('39', '25', '26', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('40', '26', '27', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('41', '27', '28', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('42', '28', '29', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('43', '29', '30', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('44', '30', '31', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('45', '31', '32', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('46', '32', '33', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('47', '33', '34', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('48', '34', '35', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('49', '35', '36', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('50', '36', '37', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('51', '37', '38', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('52', '38', '39', '1', null, null, null, null);
INSERT INTO `price_customer_type` VALUES ('53', '22', '23', '1', null, null, null, null);

-- ----------------------------
-- Table structure for `price_group`
-- ----------------------------
DROP TABLE IF EXISTS `price_group`;
CREATE TABLE `price_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of price_group
-- ----------------------------
INSERT INTO `price_group` VALUES ('6', 'ขายปลีก 10', 'ขายปลีก 10', 'ขายปลีก 10', '1', '1610118066', null, '1610118066', null);
INSERT INTO `price_group` VALUES ('7', 'ขายปลีก 15', 'ขายปลีก 15', 'ขายปลีก 15', '1', '1610118268', null, '1610118268', null);
INSERT INTO `price_group` VALUES ('8', 'AZ01-20', 'AZ01-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', 'AZ01-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', '1', '1613193043', null, '1613193043', null);
INSERT INTO `price_group` VALUES ('9', 'AZ01-25', 'AZ01-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', 'AZ01-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', '1', '1613193068', null, '1613193068', null);
INSERT INTO `price_group` VALUES ('10', 'AZ02-20', 'AZ02-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', 'AZ02-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', '1', '1613193068', null, '1613193068', null);
INSERT INTO `price_group` VALUES ('11', 'AZ02-25', 'AZ02-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', 'AZ02-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', '1', '1613193068', null, '1613193068', null);
INSERT INTO `price_group` VALUES ('12', 'AZ03-20', 'AZ03-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', 'AZ03-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', '1', '1613193068', null, '1613193068', null);
INSERT INTO `price_group` VALUES ('13', 'AZ03-25', 'AZ03-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', 'AZ03-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', '1', '1613193068', null, '1613193068', null);
INSERT INTO `price_group` VALUES ('14', 'AZ04-20', 'AZ04-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', 'AZ04-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', '1', '1613193068', null, '1613193068', null);
INSERT INTO `price_group` VALUES ('15', 'AZ04-25', 'AZ04-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', 'AZ04-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', '1', '1613193068', null, '1613193068', null);
INSERT INTO `price_group` VALUES ('16', 'AZ05-20', 'AZ05-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', 'AZ05-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', '1', '1613193069', null, '1613193069', null);
INSERT INTO `price_group` VALUES ('17', 'AZ05-25', 'AZ05-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', 'AZ05-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', '1', '1613193069', null, '1613193069', null);
INSERT INTO `price_group` VALUES ('18', 'AZ06-20', 'AZ06-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', 'AZ06-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', '1', '1613193069', null, '1613193069', null);
INSERT INTO `price_group` VALUES ('19', 'AZ06-25', 'AZ06-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', 'AZ06-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', '1', '1613193069', null, '1613193069', null);
INSERT INTO `price_group` VALUES ('20', 'AZ07-20', 'AZ07-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', 'AZ07-20 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE20', '1', '1613193069', null, '1613193069', null);
INSERT INTO `price_group` VALUES ('21', 'AZ07-25', 'AZ07-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', 'AZ07-25 - กลุ่มลูกค้าอเมซอน ใช้ราคา SALE25', '1', '1613193069', null, '1613193069', null);
INSERT INTO `price_group` VALUES ('22', 'CJ-01', 'CJ-01 - กลุ่มลูกค้าซีเจ สาย 1 ใช้ราคา SALE 4.5', 'CJ-01 - กลุ่มลูกค้าซีเจ สาย 1 ใช้ราคา SALE 4.5', '1', '1613193069', null, '1613193069', null);
INSERT INTO `price_group` VALUES ('23', 'CJ-02', 'CJ-02 - กลุ่มลูกค้าซีเจ สาย 2 ใช้ราคา SALE 4.5', 'CJ-02 - กลุ่มลูกค้าซีเจ สาย 2 ใช้ราคา SALE 4.5', '1', '1613193069', null, '1613193069', null);
INSERT INTO `price_group` VALUES ('24', 'CJ-03', 'CJ-03 - กลุ่มลูกค้าซีเจ สาย 3 ใช้ราคา SALE 4.5', 'CJ-03 - กลุ่มลูกค้าซีเจ สาย 3 ใช้ราคา SALE 4.5', '1', '1613193069', null, '1613193069', null);
INSERT INTO `price_group` VALUES ('25', 'CJ-04', 'CJ-04 - กลุ่มลูกค้าซีเจ สาย 4 ใช้ราคา SALE 4.5', 'CJ-04 - กลุ่มลูกค้าซีเจ สาย 4 ใช้ราคา SALE 4.5', '1', '1613193070', null, '1613193070', null);
INSERT INTO `price_group` VALUES ('26', 'VP16', 'VP16 กลุ่มลูกค้า IFC ใช้ราคา SALE 13.2', 'VP16 กลุ่มลูกค้า IFC ใช้ราคา SALE 13.2', '1', '1613193070', null, '1613193070', null);
INSERT INTO `price_group` VALUES ('27', 'VP17', 'VP17 กลุ่มลูกค้าขายรถ ใช้ราคา SALE 20', 'VP17 กลุ่มลูกค้าขายรถ ใช้ราคา SALE 20', '1', '1613193070', null, '1613193070', null);
INSERT INTO `price_group` VALUES ('28', 'VP18-11', 'VP18-11 กลุ่มลูกค้าพี่ภูมิ ใช้ราคา SALE 11.5', 'VP18-11 กลุ่มลูกค้าพี่ภูมิ ใช้ราคา SALE 11.5', '1', '1613193071', null, '1613193071', null);
INSERT INTO `price_group` VALUES ('29', 'VP18-20', 'VP18-20 กลุ่มลูกค้าพี่ภูมิ ใช้ราคา SALE 20', 'VP18-20 กลุ่มลูกค้าพี่ภูมิ ใช้ราคา SALE 20', '1', '1613193071', null, '1613193071', null);
INSERT INTO `price_group` VALUES ('30', 'VP18-17', 'VP18-17 กลุ่มลูกค้าพี่ภูมิ ใช้ราคา SALE 17.5', 'VP18-17 กลุ่มลูกค้าพี่ภูมิ ใช้ราคา SALE 17.5', '1', '1613193071', null, '1613193071', null);
INSERT INTO `price_group` VALUES ('31', 'VP18-15', 'VP18-15 กลุ่มลูกค้าพี่ภูมิ ใช้ราคา SALE 15', 'VP18-15 กลุ่มลูกค้าพี่ภูมิ ใช้ราคา SALE 15', '1', '1613193071', null, '1613193071', null);
INSERT INTO `price_group` VALUES ('32', 'VP19-40', 'VP19-40 กลุ่มลูกค้าพี่ขุน ใช้ราคา SALE 40', 'VP19-40 กลุ่มลูกค้าพี่ขุน ใช้ราคา SALE 40', '1', '1613193071', null, '1613193071', null);
INSERT INTO `price_group` VALUES ('33', 'VP19-23', 'VP19-23 กลุ่มลูกค้าพี่ขุน ใช้ราคา SALE 23', 'VP19-23 กลุ่มลูกค้าพี่ขุน ใช้ราคา SALE 23', '1', '1613193071', null, '1613193071', null);
INSERT INTO `price_group` VALUES ('34', 'VP20-23', 'VP20-23 กลุ่มลูกค้าพี่ขุน ใช้ราคา SALE 23', 'VP20-23 กลุ่มลูกค้าพี่ขุน ใช้ราคา SALE 23', '1', '1613193071', null, '1613193071', null);
INSERT INTO `price_group` VALUES ('35', 'VP21-110', 'VP21-110 กลุ่มลูกค้าพี่ตู้ ใช้ราคา SALE 110', 'VP21-110 กลุ่มลูกค้าพี่ตู้ ใช้ราคา SALE 110', '1', '1613193071', null, '1613193071', null);
INSERT INTO `price_group` VALUES ('36', 'VP21-105', 'VP21-105 กลุ่มลูกค้าพี่ตู้ ใช้ราคา SALE 105', 'VP21-105 กลุ่มลูกค้าพี่ตู้ ใช้ราคา SALE 105', '1', '1613193071', null, '1613193071', null);
INSERT INTO `price_group` VALUES ('37', 'VP22-23', 'VP22-23 กลุ่มลูกค้ารถส่ง-บอย ใช้ราคา SALE23', 'VP22-23 กลุ่มลูกค้ารถส่ง-บอย ใช้ราคา SALE23', '1', '1613193072', null, '1613193072', null);
INSERT INTO `price_group` VALUES ('38', 'VP23-23', 'VP23-23 กลุ่มลูกค้ารถส่ง-แซม ใช้ราคา SALE23', 'VP23-23 กลุ่มลูกค้ารถส่ง-แซม ใช้ราคา SALE23', '1', '1613193072', null, '1613193072', null);

-- ----------------------------
-- Table structure for `price_group_line`
-- ----------------------------
DROP TABLE IF EXISTS `price_group_line`;
CREATE TABLE `price_group_line` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `price_group_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of price_group_line
-- ----------------------------
INSERT INTO `price_group_line` VALUES ('14', '6', '1', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('15', '6', '2', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('16', '6', '3', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('17', '6', '4', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('28', '7', '1', '15', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('29', '7', '2', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('30', '7', '3', '23', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('31', '7', '4', '13', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('33', '7', '5', '14', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('36', '6', '7', '12', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('38', '6', '6', '33', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('39', '7', '6', '33', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('40', '6', '5', '14', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('41', '7', '9', '13', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('42', '8', '1', '20', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('43', '8', '2', '21', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('44', '8', '3', '22', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('45', '8', '4', '23', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('46', '22', '1', '27', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('47', '22', '2', '10', '1', null, null, null, null);
INSERT INTO `price_group_line` VALUES ('48', '22', '3', '23', '1', null, null, null, null);

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `product_type_id` int(11) DEFAULT NULL,
  `product_group_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `std_cost` float DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `nw` float DEFAULT NULL,
  `gw` float DEFAULT NULL,
  `min_stock` float DEFAULT NULL,
  `max_stock` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `sale_status` int(11) DEFAULT NULL,
  `stock_type` int(11) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_product` (`company_id`),
  KEY `fk_branch_product` (`branch_id`),
  CONSTRAINT `fk_branch_product` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_product` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', 'PB', 'PB หลอดใหญ่', '', '1', '1', '', '455', '27', '1', null, null, null, null, '1', null, null, null, '1612186233', null, null, '1', '1', null);
INSERT INTO `product` VALUES ('2', 'PS', 'PB หลอดเล็ก', '', '2', '1', '', null, '10', '0', null, null, null, null, '2', null, null, null, '1610119052', null, null, '1', '1', null);
INSERT INTO `product` VALUES ('3', 'PC', 'PC แพ็คโม่', null, '2', '1', null, null, '23', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('4', 'P2KG', 'P2KG น้ำแข็งแพ็ค2กก.', null, '2', '1', null, null, '13', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('5', 'M', 'M น้ำแข็งโม่', null, '1', '1', null, null, '14', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('6', 'K', 'K น้ำแข็งกั๊ก', null, '1', '1', null, null, '33', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('7', 'B', 'B น้ำแข็งหลอดใหญ่', null, '1', '1', null, null, '12', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('8', 'S', 'S น้ำแข็งหลอดเล็ก', null, '1', '1', null, null, '15', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);
INSERT INTO `product` VALUES ('9', 'SC', 'SC น้ำแข็งหลอดเล็กโม่', null, '1', '1', null, null, '13', null, null, null, null, null, '2', null, null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `product_group`
-- ----------------------------
DROP TABLE IF EXISTS `product_group`;
CREATE TABLE `product_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_product_group` (`company_id`),
  KEY `fk_branch_product_group` (`branch_id`),
  CONSTRAINT `fk_branch_product_group` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_product_group` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_group
-- ----------------------------
INSERT INTO `product_group` VALUES ('1', '01', 'ขายเงินสด', 'ทดสอบxcxcxcxccx', '1', '1', '1', '1608194431', '1608951690', null, null);
INSERT INTO `product_group` VALUES ('2', '02', 'ขายเงินเชื่อ', 'ขายเงินเชื่อ', '1', null, null, '1610704172', '1610704172', null, null);

-- ----------------------------
-- Table structure for `product_type`
-- ----------------------------
DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_product_type` (`company_id`),
  KEY `fk_branch_product_type` (`branch_id`),
  CONSTRAINT `fk_branch_product_type` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_product_type` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of product_type
-- ----------------------------
INSERT INTO `product_type` VALUES ('1', '01', 'น้ำแข็งก้อน', 'ทดสอบด', '1', '1', '1', '1608194405', '1608952485', null, null);
INSERT INTO `product_type` VALUES ('2', '02', 'น้ำแข็งแพ็ค', 'น้ำแข็งแพ็ค34343', '1', '1', '1', '1608199053', '1608311444', null, null);

-- ----------------------------
-- Table structure for `sale_com`
-- ----------------------------
DROP TABLE IF EXISTS `sale_com`;
CREATE TABLE `sale_com` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `emp_qty` int(11) DEFAULT NULL,
  `com_extra` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_com
-- ----------------------------
INSERT INTO `sale_com` VALUES ('1', 'SALE01', 'SALE01', '2', '0.5', '1', '1610345757', '1610727734', null);

-- ----------------------------
-- Table structure for `sale_com_summary`
-- ----------------------------
DROP TABLE IF EXISTS `sale_com_summary`;
CREATE TABLE `sale_com_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `sale_price` float DEFAULT NULL,
  `com_extra` float DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_com_summary
-- ----------------------------
INSERT INTO `sale_com_summary` VALUES ('1', 'Orver 3,000', 'Orver 3,000', '3500', '30', '1', '1610345813', '1610944015', null, null);

-- ----------------------------
-- Table structure for `sale_group`
-- ----------------------------
DROP TABLE IF EXISTS `sale_group`;
CREATE TABLE `sale_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `delivery_route_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sale_group
-- ----------------------------
INSERT INTO `sale_group` VALUES ('1', 'VP1', 'สาย 4-5', '1', '1610691426', null, '1611371326', null, '5');
INSERT INTO `sale_group` VALUES ('2', 'VP2', 'VP2', '1', '1610697545', null, '1613355918', null, '18');

-- ----------------------------
-- Table structure for `sequence`
-- ----------------------------
DROP TABLE IF EXISTS `sequence`;
CREATE TABLE `sequence` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plant_id` int(11) DEFAULT NULL,
  `module_id` int(11) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `symbol` varchar(255) DEFAULT NULL,
  `use_year` int(11) DEFAULT NULL,
  `use_month` int(11) DEFAULT NULL,
  `use_day` int(11) DEFAULT NULL,
  `minimum` int(11) DEFAULT NULL,
  `maximum` int(11) DEFAULT NULL,
  `currentnum` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sequence
-- ----------------------------
INSERT INTO `sequence` VALUES ('1', null, '1', 'PR', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('2', null, '2', 'PO', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('3', null, '3', 'QUO', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('4', null, '4', 'SO', '-', '1', '1', '1', '1', '9999', '0', '1', '1610287738', '1612710363', '1', '1');
INSERT INTO `sequence` VALUES ('5', null, '5', 'TF', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('6', null, '6', 'IS', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('7', null, '7', 'RT', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('8', null, '8', 'SRT', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('9', null, '9', 'PRT', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('10', null, '10', 'CT', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('11', null, '11', 'AD', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('12', null, '12', 'CU', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('13', null, '13', 'WO', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('14', null, '14', 'PDR', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('15', null, '15', 'REP', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('16', null, '16', 'INV', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);
INSERT INTO `sequence` VALUES ('17', null, '17', 'QC', '', '1', '0', '0', '1', '999999', '0', '1', '1610287738', '1610287738', '1', null);

-- ----------------------------
-- Table structure for `standard_price`
-- ----------------------------
DROP TABLE IF EXISTS `standard_price`;
CREATE TABLE `standard_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_standard_price` (`company_id`),
  KEY `fk_branch_standard_price` (`branch_id`),
  CONSTRAINT `fk_branch_standard_price` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_standard_price` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of standard_price
-- ----------------------------

-- ----------------------------
-- Table structure for `unit`
-- ----------------------------
DROP TABLE IF EXISTS `unit`;
CREATE TABLE `unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_unit` (`company_id`),
  KEY `fk_branch_unit` (`branch_id`),
  CONSTRAINT `fk_branch_unit` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_unit` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of unit
-- ----------------------------
INSERT INTO `unit` VALUES ('1', 'Pcs', 'ชิ้น', '', '1', null, null, '1608948374', '1608952504', null, null);
INSERT INTO `unit` VALUES ('2', 'Set', 'Set', '', '1', null, null, '1610159013', '1610159013', null, null);

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `verification_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'iceadmin', 'mYoUzWjaVR-YU1QuZq8XFss-Z32Hd49u', '$2y$13$l9F0RL6wBqCHh3mRm4tPOupGQ6azGVh6/3L2W6GLapM5h.OWplTG.', null, 'admin@icesystem.com', '10', '1607409003', '1607409003', null);

-- ----------------------------
-- Table structure for `user_group`
-- ----------------------------
DROP TABLE IF EXISTS `user_group`;
CREATE TABLE `user_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `car_type_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user_group
-- ----------------------------

-- ----------------------------
-- Table structure for `warehouse`
-- ----------------------------
DROP TABLE IF EXISTS `warehouse`;
CREATE TABLE `warehouse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_company_warehouse` (`company_id`),
  KEY `fk_branch_warehouse` (`branch_id`),
  CONSTRAINT `fk_branch_warehouse` FOREIGN KEY (`branch_id`) REFERENCES `branch` (`id`),
  CONSTRAINT `fk_company_warehouse` FOREIGN KEY (`company_id`) REFERENCES `company` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of warehouse
-- ----------------------------
INSERT INTO `warehouse` VALUES ('1', 'Factory1', 'คลังกระจายสินค้า', 'คลังกระจายสินค้า', '', '2', '1', null, '1607417927', '1608951503', null, null);
INSERT INTO `warehouse` VALUES ('2', 'Factory2', 'Factory2', 'Factory2', '', '1', '1', null, '1607436837', '1607436872', null, null);

-- ----------------------------
-- View structure for `newview`
-- ----------------------------
DROP VIEW IF EXISTS `newview`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `newview` AS select `query_sale_trans_by_emp`.`order_channel_id` AS `order_channel_id`,`query_sale_trans_by_emp`.`route_code` AS `route_code`,`query_sale_trans_by_emp`.`payment_method_id` AS `payment_method_id`,`query_sale_trans_by_emp`.`emp_id` AS `emp_id`,`query_sale_trans_by_emp`.`fname` AS `fname`,`query_sale_trans_by_emp`.`lname` AS `lname`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 1) then `query_sale_trans_by_emp`.`qty` end)) AS `1`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 2) then `query_sale_trans_by_emp`.`qty` end)) AS `2`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 3) then `query_sale_trans_by_emp`.`qty` end)) AS `3`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 4) then `query_sale_trans_by_emp`.`qty` end)) AS `4`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 5) then `query_sale_trans_by_emp`.`qty` end)) AS `5`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 6) then `query_sale_trans_by_emp`.`qty` end)) AS `6`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 7) then `query_sale_trans_by_emp`.`qty` end)) AS `7`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 8) then `query_sale_trans_by_emp`.`qty` end)) AS `8`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 9) then `query_sale_trans_by_emp`.`qty` end)) AS `9`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 10) then `query_sale_trans_by_emp`.`qty` end)) AS `10`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 11) then `query_sale_trans_by_emp`.`qty` end)) AS `11`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 12) then `query_sale_trans_by_emp`.`qty` end)) AS `12`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 13) then `query_sale_trans_by_emp`.`qty` end)) AS `13`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 14) then `query_sale_trans_by_emp`.`qty` end)) AS `14`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 15) then `query_sale_trans_by_emp`.`qty` end)) AS `15` from `query_sale_trans_by_emp` group by `query_sale_trans_by_emp`.`order_channel_id`,`query_sale_trans_by_emp`.`route_code`,`query_sale_trans_by_emp`.`payment_method_id`,`query_sale_trans_by_emp`.`emp_id`,`query_sale_trans_by_emp`.`fname`,`query_sale_trans_by_emp`.`lname` ;

-- ----------------------------
-- View structure for `query_car_daily_emp_count`
-- ----------------------------
DROP VIEW IF EXISTS `query_car_daily_emp_count`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_car_daily_emp_count` AS select `car_daily`.`car_id` AS `car_id`,`car_daily`.`trans_date` AS `trans_date`,count(`car_daily`.`employee_id`) AS `emp_qty` from `car_daily` group by `car_daily`.`car_id`,`car_daily`.`trans_date` ;

-- ----------------------------
-- View structure for `query_car_emp_data`
-- ----------------------------
DROP VIEW IF EXISTS `query_car_emp_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_car_emp_data` AS select `delivery_route`.`code` AS `code`,`car`.`code` AS `car_code_`,`car`.`name` AS `car_name_`,`delivery_route`.`id` AS `id`,`car`.`id` AS `car_id_`,`car_daily`.`employee_id` AS `emp_id`,`employee`.`code` AS `emp_code_`,`employee`.`fname` AS `fname`,`employee`.`lname` AS `lname`,`car_daily`.`trans_date` AS `trans_date` from ((((`delivery_route` join `sale_group` on((`delivery_route`.`id` = `sale_group`.`delivery_route_id`))) join `car` on((`sale_group`.`id` = `car`.`sale_group_id`))) left join `car_daily` on((`car`.`id` = `car_daily`.`car_id`))) left join `employee` on((`car_daily`.`employee_id` = `employee`.`id`))) ;

-- ----------------------------
-- View structure for `query_car_route`
-- ----------------------------
DROP VIEW IF EXISTS `query_car_route`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_car_route` AS select `car`.`id` AS `id`,`car`.`code` AS `code`,`car`.`name` AS `name`,`car`.`description` AS `description`,`sale_group`.`delivery_route_id` AS `delivery_route_id`,`delivery_route`.`code` AS `route_code`,`delivery_route`.`name` AS `route_name`,`sale_com`.`emp_qty` AS `emp_qty` from (((`car` left join `sale_group` on((`car`.`sale_group_id` = `sale_group`.`id`))) left join `delivery_route` on((`sale_group`.`delivery_route_id` = `delivery_route`.`id`))) left join `sale_com` on((`car`.`sale_com_id` = `sale_com`.`id`))) ;

-- ----------------------------
-- View structure for `query_customer_info`
-- ----------------------------
DROP VIEW IF EXISTS `query_customer_info`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_customer_info` AS select `delivery_route`.`id` AS `rt_id`,`delivery_route`.`code` AS `route_code`,`sale_group`.`name` AS `sale_grp_name`,`customer`.`name` AS `cus_name`,`customer_group`.`name` AS `cus_group_name`,`customer_type`.`name` AS `cus_type_name`,`customer`.`id` AS `customer_id`,`customer`.`branch_no` AS `branch_no` from ((((`delivery_route` left join `sale_group` on((`sale_group`.`delivery_route_id` = `delivery_route`.`code`))) join `customer` on((`delivery_route`.`id` = `customer`.`delivery_route_id`))) left join `customer_group` on((`customer`.`customer_group_id` = `customer_group`.`id`))) left join `customer_type` on((`customer`.`customer_type_id` = `customer_type`.`id`))) ;

-- ----------------------------
-- View structure for `query_customer_info_copy`
-- ----------------------------
DROP VIEW IF EXISTS `query_customer_info_copy`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_customer_info_copy` AS select `customer`.`code` AS `code`,`customer`.`name` AS `cus_name`,`customer`.`branch_no` AS `branch_no`,`delivery_route`.`code` AS `route_code`,`sale_group`.`name` AS `sale_grp_name`,`customer_group`.`name` AS `cus_group_name`,`customer_type`.`name` AS `cus_type_name`,`customer`.`address` AS `address`,`customer`.`address2` AS `address2`,`customer`.`contact_name` AS `contact_name`,`customer`.`phone` AS `phone`,`customer`.`description` AS `description`,`payment_method`.`code` AS `payment_method`,`payment_method`.`name` AS `payment_method_name`,`payment_term`.`code` AS `term_code`,`payment_term`.`name` AS `term_name` from ((((((`delivery_route` left join `sale_group` on((`sale_group`.`delivery_route_id` = `delivery_route`.`code`))) join `customer` on((`delivery_route`.`id` = `customer`.`delivery_route_id`))) left join `customer_group` on((`customer`.`customer_group_id` = `customer_group`.`id`))) left join `customer_type` on((`customer`.`customer_type_id` = `customer_type`.`id`))) left join `payment_method` on((`customer`.`payment_method_id` = `payment_method`.`id`))) left join `payment_term` on((`customer`.`payment_term_id` = `payment_term`.`id`))) ;

-- ----------------------------
-- View structure for `query_customer_price`
-- ----------------------------
DROP VIEW IF EXISTS `query_customer_price`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_customer_price` AS select `price_group`.`id` AS `id`,`price_group`.`code` AS `code`,`price_group`.`name` AS `name`,`price_customer_type`.`customer_type_id` AS `customer_type_id`,`customer`.`id` AS `cus_id`,`customer`.`code` AS `cus_code`,`customer`.`name` AS `cus_name`,`price_group_line`.`product_id` AS `product_id`,`price_group_line`.`sale_price` AS `sale_price` from (((`price_group` join `price_customer_type` on((`price_group`.`id` = `price_customer_type`.`price_group_id`))) join `customer` on((`price_customer_type`.`customer_type_id` = `customer`.`customer_type_id`))) left join `price_group_line` on((`price_group`.`id` = `price_group_line`.`price_group_id`))) ;

-- ----------------------------
-- View structure for `query_order_data`
-- ----------------------------
DROP VIEW IF EXISTS `query_order_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_order_data` AS select `orders`.`id` AS `id`,`orders`.`order_no` AS `order_no`,`orders`.`order_date` AS `order_date`,`orders`.`vat_amt` AS `vat_amt`,`orders`.`order_channel_id` AS `order_channel_id`,`orders`.`payment_method_id` AS `payment_method_id`,`order_line`.`product_id` AS `product_id`,`order_line`.`qty` AS `qty`,`order_line`.`price` AS `price`,`order_line`.`customer_id` AS `customer_id`,`orders`.`car_ref_id` AS `car_ref_id`,`order_line`.`price_group_id` AS `price_group_id`,(`order_line`.`qty` * `order_line`.`price`) AS `line_total_amt` from (`orders` left join `order_line` on((`orders`.`id` = `order_line`.`order_id`))) ;

-- ----------------------------
-- View structure for `query_order_update`
-- ----------------------------
DROP VIEW IF EXISTS `query_order_update`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_order_update` AS select `order_line`.`customer_id` AS `customer_id`,`customer`.`name` AS `name`,`order_line`.`order_id` AS `order_id`,`customer`.`code` AS `code`,`order_line`.`price_group_id` AS `price_group_id`,`order_line`.`id` AS `id`,`order_line`.`bill_no` AS `bill_no` from (`order_line` join `customer` on((`order_line`.`customer_id` = `customer`.`id`))) group by `order_line`.`customer_id`,`order_line`.`order_id` ;

-- ----------------------------
-- View structure for `query_payment`
-- ----------------------------
DROP VIEW IF EXISTS `query_payment`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_payment` AS select `payment_trans`.`id` AS `id`,`payment_trans`.`trans_no` AS `trans_no`,`payment_trans`.`trans_date` AS `trans_date`,`payment_trans`.`order_id` AS `order_id`,`payment_trans_line`.`customer_id` AS `customer_id`,`payment_trans_line`.`payment_date` AS `payment_date`,`payment_trans_line`.`payment_method_id` AS `payment_method_id`,`payment_trans_line`.`payment_term_id` AS `payment_term_id`,`payment_trans_line`.`payment_amount` AS `payment_amount`,`payment_trans_line`.`total_amount` AS `total_amount`,`payment_trans_line`.`doc` AS `doc`,`payment_trans_line`.`change_amount` AS `change_amount`,`payment_trans`.`status` AS `status`,`payment_trans`.`created_at` AS `created_at`,`payment_trans`.`created_by` AS `created_by`,`payment_trans`.`updated_at` AS `updated_at`,`payment_trans`.`updated_by` AS `updated_by` from (`payment_trans` left join `payment_trans_line` on((`payment_trans`.`id` = `payment_trans_line`.`trans_id`))) ;

-- ----------------------------
-- View structure for `query_products`
-- ----------------------------
DROP VIEW IF EXISTS `query_products`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_products` AS select `product`.`id` AS `id`,`product`.`code` AS `code`,`product`.`name` AS `name`,`product`.`description` AS `description`,`product`.`product_type_id` AS `product_type_id`,`product`.`product_group_id` AS `product_group_id`,`product_type`.`code` AS `type_code`,`product_type`.`name` AS `type_name`,`product_group`.`code` AS `group_code`,`product_group`.`name` AS `group_name`,(case when (`product`.`status` = 1) then 'ใช้งาน' else 'ไม่ใช้งาน' end) AS `status` from ((`product` left join `product_group` on((`product`.`product_group_id` = `product_group`.`id`))) left join `product_type` on((`product`.`product_type_id` = `product_type`.`id`))) ;

-- ----------------------------
-- View structure for `query_product_by_price_group`
-- ----------------------------
DROP VIEW IF EXISTS `query_product_by_price_group`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_product_by_price_group` AS select `price_group_line`.`price_group_id` AS `price_group_id`,`price_group_line`.`product_id` AS `product_id`,`product`.`code` AS `code`,`product`.`name` AS `name`,`price_group_line`.`sale_price` AS `sale_price` from (`price_group_line` join `product` on((`price_group_line`.`product_id` = `product`.`id`))) ;

-- ----------------------------
-- View structure for `query_product_by_route`
-- ----------------------------
DROP VIEW IF EXISTS `query_product_by_route`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_product_by_route` AS select `customer`.`delivery_route_id` AS `delivery_route_id`,`price_group_line`.`product_id` AS `product_id`,`product`.`code` AS `code`,`product`.`name` AS `name`,`price_group_line`.`sale_price` AS `sale_price` from (((`customer` left join `price_customer_type` on((`customer`.`customer_type_id` = `price_customer_type`.`customer_type_id`))) join `price_group_line` on((`price_customer_type`.`price_group_id` = `price_group_line`.`price_group_id`))) join `product` on((`price_group_line`.`product_id` = `product`.`id`))) group by `customer`.`id`,`customer`.`code`,`customer`.`name`,`customer`.`customer_type_id`,`price_customer_type`.`price_group_id`,`price_group_line`.`product_id`,`customer`.`delivery_route_id`,`price_group_line`.`sale_price` ;

-- ----------------------------
-- View structure for `query_product_from_route`
-- ----------------------------
DROP VIEW IF EXISTS `query_product_from_route`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_product_from_route` AS select `query_product_by_route`.`delivery_route_id` AS `delivery_route_id`,`query_product_by_route`.`product_id` AS `product_id`,`query_product_by_route`.`code` AS `code`,`query_product_by_route`.`sale_price` AS `sale_price` from `query_product_by_route` where (`query_product_by_route`.`delivery_route_id` > 0) group by `query_product_by_route`.`delivery_route_id`,`query_product_by_route`.`product_id` ;

-- ----------------------------
-- View structure for `query_saleorder`
-- ----------------------------
DROP VIEW IF EXISTS `query_saleorder`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_saleorder` AS select `orders`.`id` AS `id`,`orders`.`order_no` AS `order_no`,`orders`.`order_date` AS `order_date`,`orders`.`payment_method_id` AS `payment_method_id`,`order_line`.`product_id` AS `product_id`,`order_line`.`qty` AS `qty`,`order_line`.`price` AS `price`,`order_line`.`line_total` AS `line_total`,`orders`.`car_ref_id` AS `car_ref_id`,`order_line`.`customer_id` AS `customer_id`,`customer`.`code` AS `cus_code`,`customer`.`name` AS `cus_name`,`orders`.`sale_channel_id` AS `sale_channel_id`,`orders`.`customer_id` AS `pos_customer_id` from ((`orders` left join `order_line` on((`orders`.`id` = `order_line`.`order_id`))) left join `customer` on((`order_line`.`customer_id` = `customer`.`id`))) where (`order_line`.`qty` > 0) ;

-- ----------------------------
-- View structure for `query_saleorder_by_emp`
-- ----------------------------
DROP VIEW IF EXISTS `query_saleorder_by_emp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_saleorder_by_emp` AS select `query_saleorder_by_route`.`id` AS `id`,`query_saleorder_by_route`.`order_no` AS `order_no`,`query_saleorder_by_route`.`order_date` AS `order_date`,`query_saleorder_by_route`.`payment_method_id` AS `payment_method_id`,`query_saleorder_by_route`.`product_id` AS `product_id`,`query_saleorder_by_route`.`qty` AS `qty`,`query_saleorder_by_route`.`price` AS `price`,`query_saleorder_by_route`.`line_total` AS `line_total`,`query_saleorder_by_route`.`car_ref_id` AS `car_ref_id`,`query_saleorder_by_route`.`customer_id` AS `customer_id`,`query_saleorder_by_route`.`cus_code` AS `cus_code`,`query_saleorder_by_route`.`cus_name` AS `cus_name`,`query_saleorder_by_route`.`rt_id` AS `rt_id`,`query_saleorder_by_route`.`route_code` AS `route_code`,`query_saleorder_by_route`.`car_code` AS `car_code`,`query_saleorder_by_route`.`car_name` AS `car_name`,`car_daily`.`employee_id` AS `employee_id`,`employee`.`code` AS `emp_code`,`employee`.`fname` AS `emp_fname`,`employee`.`lname` AS `emp_lname`,`employee`.`position` AS `emp_position` from ((`query_saleorder_by_route` left join `car_daily` on(((`query_saleorder_by_route`.`car_ref_id` = `car_daily`.`car_id`) and (`query_saleorder_by_route`.`order_date` = `car_daily`.`trans_date`)))) join `employee` on((`car_daily`.`employee_id` = `employee`.`id`))) ;

-- ----------------------------
-- View structure for `query_saleorder_by_route`
-- ----------------------------
DROP VIEW IF EXISTS `query_saleorder_by_route`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_saleorder_by_route` AS select `query_saleorder`.`id` AS `id`,`query_saleorder`.`order_no` AS `order_no`,`query_saleorder`.`order_date` AS `order_date`,`query_saleorder`.`payment_method_id` AS `payment_method_id`,`query_saleorder`.`product_id` AS `product_id`,`query_saleorder`.`qty` AS `qty`,`query_saleorder`.`price` AS `price`,`query_saleorder`.`line_total` AS `line_total`,`query_saleorder`.`car_ref_id` AS `car_ref_id`,`query_saleorder`.`customer_id` AS `customer_id`,`query_saleorder`.`cus_code` AS `cus_code`,`query_saleorder`.`cus_name` AS `cus_name`,`query_customer_info`.`rt_id` AS `rt_id`,`query_customer_info`.`route_code` AS `route_code`,`car`.`code` AS `car_code`,`car`.`name` AS `car_name`,`query_customer_info`.`branch_no` AS `branch_no`,`product`.`code` AS `prod_code`,`product`.`name` AS `prod_name` from (((`query_saleorder` left join `query_customer_info` on((`query_saleorder`.`customer_id` = `query_customer_info`.`customer_id`))) left join `car` on((`query_saleorder`.`car_ref_id` = `car`.`id`))) join `product` on((`query_saleorder`.`product_id` = `product`.`id`))) ;

-- ----------------------------
-- View structure for `query_sale_by_customer`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_by_customer`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_by_customer` AS select `orders`.`order_date` AS `order_date`,`orders`.`order_no` AS `order_no`,`order_line`.`customer_id` AS `customer_id`,`orders`.`id` AS `id` from (`orders` join `order_line` on((`orders`.`id` = `order_line`.`order_id`))) group by `orders`.`id`,`orders`.`order_no`,`orders`.`order_date`,`order_line`.`customer_id` ;

-- ----------------------------
-- View structure for `query_sale_customer_pay`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_customer_pay`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_customer_pay` AS select `payment_trans_line`.`customer_id` AS `customer_id`,`payment_trans_line`.`payment_date` AS `payment_date`,`payment_trans`.`order_id` AS `order_id`,`payment_trans_line`.`payment_method_id` AS `payment_method_id`,`payment_trans_line`.`payment_amount` AS `payment_amount`,`payment_trans_line`.`doc` AS `doc`,`payment_trans_line`.`status` AS `status`,`orders`.`order_no` AS `order_no` from ((`payment_trans` join `payment_trans_line` on((`payment_trans`.`id` = `payment_trans_line`.`trans_id`))) join `orders` on((`payment_trans`.`order_id` = `orders`.`id`))) ;

-- ----------------------------
-- View structure for `query_sale_summary_by_emp`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_summary_by_emp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_summary_by_emp` AS select `query_sale_trans_by_emp`.`order_channel_id` AS `order_channel_id`,`query_sale_trans_by_emp`.`route_code` AS `route_code`,`query_sale_trans_by_emp`.`payment_method_id` AS `payment_method_id`,`query_sale_trans_by_emp`.`emp_id` AS `emp_id`,`query_sale_trans_by_emp`.`fname` AS `fname`,`query_sale_trans_by_emp`.`lname` AS `lname`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 1) then `query_sale_trans_by_emp`.`qty` end)) AS `1`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 2) then `query_sale_trans_by_emp`.`qty` end)) AS `2`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 3) then `query_sale_trans_by_emp`.`qty` end)) AS `3`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 4) then `query_sale_trans_by_emp`.`qty` end)) AS `4`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 5) then `query_sale_trans_by_emp`.`qty` end)) AS `5`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 6) then `query_sale_trans_by_emp`.`qty` end)) AS `6`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 7) then `query_sale_trans_by_emp`.`qty` end)) AS `7`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 8) then `query_sale_trans_by_emp`.`qty` end)) AS `8`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 9) then `query_sale_trans_by_emp`.`qty` end)) AS `9`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 10) then `query_sale_trans_by_emp`.`qty` end)) AS `10`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 11) then `query_sale_trans_by_emp`.`qty` end)) AS `11`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 12) then `query_sale_trans_by_emp`.`qty` end)) AS `12`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 13) then `query_sale_trans_by_emp`.`qty` end)) AS `13`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 14) then `query_sale_trans_by_emp`.`qty` end)) AS `14`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 15) then `query_sale_trans_by_emp`.`qty` end)) AS `15` from `query_sale_trans_by_emp` group by `query_sale_trans_by_emp`.`order_channel_id`,`query_sale_trans_by_emp`.`route_code`,`query_sale_trans_by_emp`.`payment_method_id`,`query_sale_trans_by_emp`.`emp_id`,`query_sale_trans_by_emp`.`fname`,`query_sale_trans_by_emp`.`lname` ;

-- ----------------------------
-- View structure for `query_sale_summary_by_emp2`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_summary_by_emp2`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_summary_by_emp2` AS select `query_sale_trans_by_emp`.`order_channel_id` AS `order_channel_id`,`query_sale_trans_by_emp`.`route_code` AS `route_code`,`query_sale_trans_by_emp`.`emp_id` AS `emp_id`,`query_sale_trans_by_emp`.`fname` AS `fname`,`query_sale_trans_by_emp`.`lname` AS `lname`,sum((case when (`query_sale_trans_by_emp`.`payment_method_id` = 1) then `query_sale_trans_by_emp`.`qty` end)) AS `Cash`,sum((case when (`query_sale_trans_by_emp`.`payment_method_id` = 2) then `query_sale_trans_by_emp`.`qty` end)) AS `Credit`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 1) then `query_sale_trans_by_emp`.`qty` end)) AS `1`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 2) then `query_sale_trans_by_emp`.`qty` end)) AS `2`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 3) then `query_sale_trans_by_emp`.`qty` end)) AS `3`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 4) then `query_sale_trans_by_emp`.`qty` end)) AS `4`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 5) then `query_sale_trans_by_emp`.`qty` end)) AS `5`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 6) then `query_sale_trans_by_emp`.`qty` end)) AS `6`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 7) then `query_sale_trans_by_emp`.`qty` end)) AS `7`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 8) then `query_sale_trans_by_emp`.`qty` end)) AS `8`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 9) then `query_sale_trans_by_emp`.`qty` end)) AS `9`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 10) then `query_sale_trans_by_emp`.`qty` end)) AS `10`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 11) then `query_sale_trans_by_emp`.`qty` end)) AS `11`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 12) then `query_sale_trans_by_emp`.`qty` end)) AS `12`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 13) then `query_sale_trans_by_emp`.`qty` end)) AS `13`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 14) then `query_sale_trans_by_emp`.`qty` end)) AS `14`,sum((case when (`query_sale_trans_by_emp`.`product_id` = 15) then `query_sale_trans_by_emp`.`qty` end)) AS `15` from `query_sale_trans_by_emp` group by `query_sale_trans_by_emp`.`order_channel_id`,`query_sale_trans_by_emp`.`route_code`,`query_sale_trans_by_emp`.`emp_id`,`query_sale_trans_by_emp`.`fname`,`query_sale_trans_by_emp`.`lname` ;

-- ----------------------------
-- View structure for `query_sale_trans_by_emp`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_trans_by_emp`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_trans_by_emp` AS select `query_sale_trans_data`.`order_no` AS `order_no`,`query_sale_trans_data`.`order_date` AS `order_date`,`query_sale_trans_data`.`vat_amt` AS `vat_amt`,`query_sale_trans_data`.`order_channel_id` AS `order_channel_id`,`query_sale_trans_data`.`payment_method_id` AS `payment_method_id`,`query_sale_trans_data`.`product_id` AS `product_id`,`query_sale_trans_data`.`qty` AS `qty`,`query_sale_trans_data`.`price` AS `price`,`query_sale_trans_data`.`customer_id` AS `customer_id`,`query_sale_trans_data`.`route_code` AS `route_code`,`query_sale_trans_data`.`sale_grp_name` AS `sale_grp_name`,`query_sale_trans_data`.`cus_name` AS `cus_name`,`query_sale_trans_data`.`cus_group_name` AS `cus_group_name`,`query_sale_trans_data`.`cus_type_name` AS `cus_type_name`,`query_car_emp_data`.`car_id_` AS `car_id_`,`query_car_emp_data`.`car_code_` AS `car_code_`,`query_car_emp_data`.`car_name_` AS `car_name_`,`query_car_emp_data`.`emp_id` AS `emp_id`,`query_car_emp_data`.`fname` AS `fname`,`query_car_emp_data`.`lname` AS `lname` from (`query_sale_trans_data` join `query_car_emp_data` on((`query_sale_trans_data`.`order_channel_id` = `query_car_emp_data`.`id`))) ;

-- ----------------------------
-- View structure for `query_sale_trans_data`
-- ----------------------------
DROP VIEW IF EXISTS `query_sale_trans_data`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `query_sale_trans_data` AS select `query_order_data`.`order_no` AS `order_no`,`query_order_data`.`order_date` AS `order_date`,`query_order_data`.`vat_amt` AS `vat_amt`,`query_order_data`.`order_channel_id` AS `order_channel_id`,`query_order_data`.`payment_method_id` AS `payment_method_id`,`query_order_data`.`product_id` AS `product_id`,`query_order_data`.`qty` AS `qty`,`query_order_data`.`price` AS `price`,`query_order_data`.`customer_id` AS `customer_id`,`query_customer_info`.`route_code` AS `route_code`,`query_customer_info`.`sale_grp_name` AS `sale_grp_name`,`query_customer_info`.`cus_name` AS `cus_name`,`query_customer_info`.`cus_group_name` AS `cus_group_name`,`query_customer_info`.`cus_type_name` AS `cus_type_name`,`query_order_data`.`id` AS `order_id`,`query_order_data`.`price_group_id` AS `price_group_id`,(`query_order_data`.`qty` * `query_order_data`.`price`) AS `line_total_amt` from (`query_order_data` left join `query_customer_info` on((`query_order_data`.`customer_id` = `query_customer_info`.`customer_id`))) ;
