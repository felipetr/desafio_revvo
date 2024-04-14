/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80300 (8.3.0)
 Source Host           : localhost:3306
 Source Schema         : desafio_revvo

 Target Server Type    : MySQL
 Target Server Version : 80300 (8.3.0)
 File Encoding         : 65001

 Date: 14/04/2024 16:45:18
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cursos
-- ----------------------------
DROP TABLE IF EXISTS `cursos`;
CREATE TABLE `cursos`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `image` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `text` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `isNew` int NULL DEFAULT NULL,
  `destaque` int NULL DEFAULT NULL,
  `createdDate` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedDate` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` longtext CHARACTER SET utf16 COLLATE utf16_bin NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf16 COLLATE = utf16_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cursos
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `gender` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `avatar` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `lastLogged` datetime NULL DEFAULT NULL,
  `createdDate` datetime NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedDate` datetime NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `slug` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `pass` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf16 COLLATE utf16_bin NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf16 COLLATE = utf16_bin ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'John Doe', 'o', 'avatar.jpg', NULL, '2024-04-12 14:22:58', '2024-04-12 16:29:31', 'john-doe', '9d4e1e23bd5b727046a9e3b4b7db57bd8d6ee684', 'email@user.com');

SET FOREIGN_KEY_CHECKS = 1;
