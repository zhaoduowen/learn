/*
 Navicat Premium Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50714
 Source Host           : 127.0.0.1:3306
 Source Schema         : test

 Target Server Type    : MySQL
 Target Server Version : 50714
 File Encoding         : 65001

 Date: 09/11/2018 18:28:08
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for activity_master
-- ----------------------------
DROP TABLE IF EXISTS `activity_master`;
CREATE TABLE `activity_master`  (
  `activity_id` int(10) UNSIGNED NOT NULL COMMENT '优惠券id',
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '优惠券名称\n',
  `device_limit` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '使用设备限制',
  `day_limit` int(11) UNSIGNED DEFAULT NULL COMMENT '投资天数限制',
  `amount_limit` int(11) DEFAULT NULL COMMENT '投资金额限制',
  `amount_top_limit` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '使用优惠券投资金额上限',
  `activity_type` int(11) NOT NULL DEFAULT 0 COMMENT '优惠券类型 对应activity_type_master 表',
  `begin_time` datetime(0) NOT NULL COMMENT '活动开始时间',
  `end_time` datetime(0) NOT NULL COMMENT '活动结束时间',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间\n',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`activity_id`) USING BTREE,
  UNIQUE INDEX `actiivity_id_UNIQUE`(`activity_id`) USING BTREE,
  INDEX `device_limit_idx`(`device_limit`) USING BTREE,
  INDEX `activity_type_key`(`activity_type`) USING BTREE,
  CONSTRAINT `activity_master_ibfk_1` FOREIGN KEY (`activity_type`) REFERENCES `activity_type_master` (`activity_type`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `activity_master_ibfk_2` FOREIGN KEY (`device_limit`) REFERENCES `device_limit_master` (`device_limit`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '优惠券主表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for activity_record
-- ----------------------------
DROP TABLE IF EXISTS `activity_record`;
CREATE TABLE `activity_record`  (
  `record_id` int(10) UNSIGNED NOT NULL COMMENT '优惠券记录id\n',
  `uid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
  `product_pay_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '订单id  对应product_pay_master的id',
  `amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '金额',
  `rate` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '加息',
  `activity_id` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '优惠券主表id',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '红包使用状态 0 未使用 1已使用',
  `begin_time` datetime(0) NOT NULL COMMENT '优惠券有效期起始时间',
  `end_time` datetime(0) NOT NULL COMMENT '优惠券有效期结束时间',
  `create_time` datetime(0) NOT NULL COMMENT '创建/获得优惠券时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  `use_time` datetime(0) DEFAULT NULL COMMENT '使用时间',
  PRIMARY KEY (`record_id`) USING BTREE,
  UNIQUE INDEX `record_id_UNIQUE`(`record_id`) USING BTREE,
  INDEX `acvitity_id_idx`(`activity_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '优惠券记录表\n' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for activity_type_master
-- ----------------------------
DROP TABLE IF EXISTS `activity_type_master`;
CREATE TABLE `activity_type_master`  (
  `activity_type` int(11) NOT NULL COMMENT '优惠券类型',
  `description` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`activity_type`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '优惠券类型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for ad_master
-- ----------------------------
DROP TABLE IF EXISTS `ad_master`;
CREATE TABLE `ad_master`  (
  `ad_id` int(10) NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '广告标题',
  `position_id` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '广告位ID 首页',
  `link_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `img_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '默认封面图片',
  `ordern` smallint(2) UNSIGNED DEFAULT 0 COMMENT '排序值',
  `target` tinyint(255) DEFAULT NULL COMMENT '跳转方式1 _blank、 2 _self',
  `status` tinyint(2) DEFAULT 1 COMMENT '状态：1上线，2下线，-1删除',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT '更新时间',
  PRIMARY KEY (`ad_id`) USING BTREE,
  INDEX `position_id`(`position_id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '广告主表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ad_pic
-- ----------------------------
DROP TABLE IF EXISTS `ad_pic`;
CREATE TABLE `ad_pic`  (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图片id',
  `ad_id` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '套餐计划ID',
  `pic_path` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片缩略图地址',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `ad_id`(`ad_id`(255)) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '广告图片表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for ad_position
-- ----------------------------
DROP TABLE IF EXISTS `ad_position`;
CREATE TABLE `ad_position`  (
  `position_id` int(11) NOT NULL COMMENT '广告位id',
  `position_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '广告位名称',
  `status` tinyint(4) DEFAULT 1 COMMENT '1 正常 -1 删除',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`position_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '广告位表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of ad_position
-- ----------------------------
INSERT INTO `ad_position` VALUES (1, '首页', 1, '2018-11-09 18:05:28', NULL);

-- ----------------------------
-- Table structure for admin_master
-- ----------------------------
DROP TABLE IF EXISTS `admin_master`;
CREATE TABLE `admin_master`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `role_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色ID',
  `realname` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '真实姓名',
  `mobile` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号码',
  `head` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '头像地址',
  `status` tinyint(4) DEFAULT 1 COMMENT '状态（1：激活 0：停用 -1：删除）',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `role_id`(`role_id`) USING BTREE,
  INDEX `status`(`status`, `id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台用户基础表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of admin_master
-- ----------------------------
INSERT INTO `admin_master` VALUES (1, 'admin', '96e79218965eb72c92a549dd5a330112', '1', '', '', '', 1, '2018-11-08 20:18:31', NULL);
INSERT INTO `admin_master` VALUES (2, 'test', '46f94c8de14fb36680850768ff1b7f2a', '', 'tetss', '13000000000', '', 0, '2018-11-09 02:10:08', '2018-11-09 02:10:39');

-- ----------------------------
-- Table structure for app_master
-- ----------------------------
DROP TABLE IF EXISTS `app_master`;
CREATE TABLE `app_master`  (
  `app_id` int(11) NOT NULL COMMENT 'app id',
  `description` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`app_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'APP信息主表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for app_version_master
-- ----------------------------
DROP TABLE IF EXISTS `app_version_master`;
CREATE TABLE `app_version_master`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) NOT NULL DEFAULT 0 COMMENT 'appid 对应app_master ',
  `version` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '版本号',
  `update_info` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '更新内容',
  `flag_force` int(11) NOT NULL DEFAULT 0 COMMENT '是否强制更新 0非强制 1强制',
  `down_path` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '下载地址',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态 0无效 1有效  -1已删除',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `create_admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '创建人id',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  `update_admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '更新人id',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `app_id_fk`(`app_id`) USING BTREE,
  CONSTRAINT `app_version_master_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `app_master` (`app_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = 'APP版本管理表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bonus_give_log
-- ----------------------------
DROP TABLE IF EXISTS `bonus_give_log`;
CREATE TABLE `bonus_give_log`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bonus_id` int(11) NOT NULL DEFAULT 0 COMMENT '红包id',
  `bonus_type` int(11) DEFAULT 1 COMMENT '红包来源',
  `pay_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '订单id',
  `uid` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '用户id',
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '状态 0未使用  1已使用 -1 已过期',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 350 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '红包发放记录表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bonus_master
-- ----------------------------
DROP TABLE IF EXISTS `bonus_master`;
CREATE TABLE `bonus_master`  (
  `bonus_id` int(11) NOT NULL AUTO_INCREMENT,
  `bonus_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '红包名称',
  `amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '红包金额',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态 0停用 1启用 -1删除',
  `invest_amount_limit` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '最低投资金额限制 元为单位 0为不限',
  `term_limit_length` int(11) NOT NULL DEFAULT 0 COMMENT '最低投资期限 天为单位 0为不限',
  `product_class_id` int(11) NOT NULL DEFAULT 0 COMMENT '限制使用产品类id',
  `product_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '限制使用产品编号id',
  `invest_begin_date` date DEFAULT NULL COMMENT '红包使用开始日期',
  `invest_end_date` date DEFAULT NULL COMMENT '红包使用结束日期',
  `total_amount` int(11) NOT NULL DEFAULT 0 COMMENT '总红包个数  -1为无限',
  `sent_amount` int(11) NOT NULL DEFAULT 0 COMMENT '已发红包个数',
  `description` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`bonus_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '红包表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bonus_rule_master
-- ----------------------------
DROP TABLE IF EXISTS `bonus_rule_master`;
CREATE TABLE `bonus_rule_master`  (
  `bonus_rule_id` int(11) NOT NULL AUTO_INCREMENT,
  `bonus_rule_name` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则名称',
  `bonus_rule_type` int(11) NOT NULL DEFAULT 1 COMMENT '规则类型 1注册 2开户 3投资 4活动',
  `low_invest_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '最低投资金额 元为单位',
  `top_invest_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '最高投资金额 元为单位',
  `rule_begin_date` date DEFAULT NULL COMMENT '有效期开始日期',
  `rule_end_date` date DEFAULT NULL COMMENT '有效期结束日期',
  `product_class_id` int(11) NOT NULL DEFAULT 0 COMMENT '限制使用产品类id',
  `product_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '限制使用产品编号id',
  `term_limit_length` int(11) NOT NULL DEFAULT 0 COMMENT '最低投资期限 天为单位 0为不限',
  `bonus_id` int(11) NOT NULL DEFAULT 0 COMMENT '发放的红包id',
  `auto_send_flag` int(11) NOT NULL DEFAULT 0 COMMENT '自动发放 0否 1是',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态 0停用 1启用 -1删除',
  `description` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`bonus_rule_id`) USING BTREE,
  INDEX `bonus_rule_type`(`bonus_rule_type`) USING BTREE,
  CONSTRAINT `bonus_rule_master_ibfk_1` FOREIGN KEY (`bonus_rule_type`) REFERENCES `bonus_rule_type` (`bonus_rule_type`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '红包发放规则表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for bonus_rule_type
-- ----------------------------
DROP TABLE IF EXISTS `bonus_rule_type`;
CREATE TABLE `bonus_rule_type`  (
  `bonus_rule_type` int(11) NOT NULL,
  `bonus_rule_type_name` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '规则名称',
  PRIMARY KEY (`bonus_rule_type`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '规则类型表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jz_oper_admin
-- ----------------------------
DROP TABLE IF EXISTS `jz_oper_admin`;
CREATE TABLE `jz_oper_admin`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '密码',
  `role_id` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色ID',
  `realname` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '真实姓名',
  `dept` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '所在部门',
  `place` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '职位',
  `email` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '邮件',
  `qq` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'QQ',
  `head` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '头像地址',
  `state` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '状态（1：激活 0：停用 -1：删除）',
  `project_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '所属项目ID,0默认为通用',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `role_id`(`role_id`) USING BTREE,
  INDEX `state`(`state`, `id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '运营后台用户基础表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jz_oper_menu
-- ----------------------------
DROP TABLE IF EXISTS `jz_oper_menu`;
CREATE TABLE `jz_oper_menu`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '菜单/功能名称',
  `pid` int(11) NOT NULL DEFAULT 0 COMMENT '上级菜单（0表示没有上级菜单）',
  `state` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '1' COMMENT '状态（1：激活 0：停用 -1：删除）',
  `type` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '类型（1：菜单 2：功能）',
  `href_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'url地址',
  `sort` int(10) DEFAULT 0 COMMENT '排序',
  `is_show` int(1) DEFAULT 1 COMMENT '是否展示在前端(1.是0.不显示)',
  `project_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '所属项目ID,0默认为通用',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `href_url`(`href_url`, `state`) USING BTREE,
  INDEX `type_state`(`type`, `state`, `pid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 65 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '运营后台菜单功能表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jz_oper_role
-- ----------------------------
DROP TABLE IF EXISTS `jz_oper_role`;
CREATE TABLE `jz_oper_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `state` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1' COMMENT '状态（1：激活 0：停用 -1：删除）',
  `menu_id` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '对应的菜单ID（列 ,1,15,155,11,55,）',
  `project_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0' COMMENT '所属项目ID,0默认为通用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '运营后台角色表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for jz_oper_sms
-- ----------------------------
DROP TABLE IF EXISTS `jz_oper_sms`;
CREATE TABLE `jz_oper_sms`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone_num` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电话号码',
  `msg` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '信息',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 49 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台发送信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for product_class_master
-- ----------------------------
DROP TABLE IF EXISTS `product_class_master`;
CREATE TABLE `product_class_master`  (
  `product_class_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '产品名称',
  `product_source` int(11) NOT NULL DEFAULT 0 COMMENT '理财类别',
  `product_class_type` int(11) NOT NULL DEFAULT 0 COMMENT '产品类的 理财项目的类型',
  `limit_invest_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '起投金额',
  `increase_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '递增金额',
  `term_limit_type` int(11) NOT NULL DEFAULT 1 COMMENT '投资期限类型0 限制天 1 限制月',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态 0无效 1有效 -1 删除',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `create_admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '创建管理员的id',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  `update_admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '更新的管理员id',
  PRIMARY KEY (`product_class_id`) USING BTREE,
  INDEX `term_limit_type_class_fk`(`term_limit_type`) USING BTREE,
  INDEX `product_source_class_fk`(`product_source`) USING BTREE,
  INDEX `product_class_type_fk`(`product_class_type`) USING BTREE,
  CONSTRAINT `product_class_master_ibfk_1` FOREIGN KEY (`product_class_type`) REFERENCES `product_class_type_master` (`product_class_type`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `product_class_master_ibfk_2` FOREIGN KEY (`product_source`) REFERENCES `product_source_master` (`product_source`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `product_class_master_ibfk_3` FOREIGN KEY (`term_limit_type`) REFERENCES `term_limit_type_master` (`term_limit_type`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品类' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for product_class_type_master
-- ----------------------------
DROP TABLE IF EXISTS `product_class_type_master`;
CREATE TABLE `product_class_type_master`  (
  `product_class_type` int(11) NOT NULL DEFAULT 0 COMMENT '理财项目的类型',
  `description` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`product_class_type`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品类的类型 票据理财  股权收益权转让等' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for product_master
-- ----------------------------
DROP TABLE IF EXISTS `product_master`;
CREATE TABLE `product_master`  (
  `product_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '产品id',
  `product_class_id` int(11) NOT NULL DEFAULT 0 COMMENT '产品类',
  `name` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '产品名称',
  `amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '产品募集总额',
  `amount_done` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '已募集金额',
  `limit_invest_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '起投金额',
  `limit_top_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '投资金额上限',
  `increase_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '递增金额',
  `device_limit` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '0,1,2' COMMENT '设备限制 对应 device_limit_master 主键 以都好分割',
  `term_limit_type` int(11) NOT NULL DEFAULT 1 COMMENT '投资期限类型0 限制天 1 限制月',
  `term_limit_length` int(11) NOT NULL DEFAULT 0 COMMENT '投资期限',
  `rate` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '利率（10% 则rate=10）',
  `fee_rate` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '服务费利率（10% 则rate=10)',
  `product_type` int(10) UNSIGNED NOT NULL COMMENT '产品类型',
  `flag_limit_time` int(11) NOT NULL DEFAULT 0 COMMENT '是否是限时秒杀标',
  `flag_hot_recommend` int(11) NOT NULL DEFAULT 0 COMMENT '是否是热品推荐标',
  `product_status` int(10) NOT NULL COMMENT '产品状态',
  `hsb_status` int(11) NOT NULL DEFAULT 0 COMMENT '徽商产品状态 1-已发标 2-已投标 4-已放款 9-已撤标',
  `extra_rate` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '加息\n',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '产品描述\n',
  `descriptions` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '借款人附加信息',
  `sale_begin_time` datetime(0) NOT NULL COMMENT '开始销售时间',
  `sale_end_time` datetime(0) NOT NULL COMMENT '销售截止时间',
  `payment_begin_time` date DEFAULT NULL COMMENT '回款开始时间',
  `payment_end_time` date DEFAULT NULL COMMENT '回款结束时间\n',
  `full_time` datetime(0) DEFAULT NULL COMMENT '满标时间',
  `full_type` int(11) NOT NULL DEFAULT 0 COMMENT '满标方式 0.投满 1.拉满',
  `borrower_mobile` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '借款人手机号',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间\n',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间\n',
  `flay_manual_loan` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '是否是手动还款：0 不是 1 是',
  `bill_number` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '票据号码',
  `bank_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '承兑银行',
  `bill_end_time` datetime(0) DEFAULT NULL COMMENT '票据到期日',
  `create_admin_id` int(11) NOT NULL DEFAULT 0 COMMENT '创建者管理员id',
  `review_admin_id` int(11) DEFAULT 0 COMMENT '审核人员的id',
  `review_time` datetime(0) DEFAULT NULL COMMENT '审核时间',
  `borrower_uid` int(11) NOT NULL DEFAULT 0 COMMENT '借款人id,对应借款人信息表',
  `actual_borrower_uid` int(11) DEFAULT 0 COMMENT '实际借款人id,对应借款人信息表',
  `old_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '产品募集总额历史值',
  PRIMARY KEY (`product_id`) USING BTREE,
  INDEX `product_type_idx`(`product_type`) USING BTREE,
  INDEX `product_status_idx`(`product_status`) USING BTREE,
  INDEX `term_limit_type_fk`(`term_limit_type`) USING BTREE,
  CONSTRAINT `product_master_ibfk_1` FOREIGN KEY (`product_status`) REFERENCES `product_status_master` (`product_status`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `product_master_ibfk_2` FOREIGN KEY (`product_type`) REFERENCES `product_type_master` (`product_type`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `product_master_ibfk_3` FOREIGN KEY (`term_limit_type`) REFERENCES `term_limit_type_master` (`term_limit_type`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品主表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for product_source_master
-- ----------------------------
DROP TABLE IF EXISTS `product_source_master`;
CREATE TABLE `product_source_master`  (
  `product_source` int(11) NOT NULL DEFAULT 0 COMMENT '产品来源',
  `description` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
  `product_table` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '对应产品表',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) NOT NULL COMMENT '更新时间',
  `product_name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '产品名称',
  `limit_invest_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '产品名称',
  `increase_amount` decimal(15, 4) NOT NULL DEFAULT 0.0000 COMMENT '产品名称',
  PRIMARY KEY (`product_source`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品来源表(固收/基金)' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for product_status_master
-- ----------------------------
DROP TABLE IF EXISTS `product_status_master`;
CREATE TABLE `product_status_master`  (
  `product_status` int(10) NOT NULL DEFAULT 0 COMMENT '产品进度标示\\n',
  `description` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述\n',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间\n',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`product_status`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '产品投资进度' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for set_home
-- ----------------------------
DROP TABLE IF EXISTS `set_home`;
CREATE TABLE `set_home`  (
  `set_id` int(11) NOT NULL AUTO_INCREMENT,
  `set_type` tinyint(4) NOT NULL DEFAULT 0 COMMENT '类型',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `link_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '跳转url',
  `img_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '图片链接地址',
  `ordern` int(11) NOT NULL DEFAULT 0 COMMENT '排序 正序显示',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '上线状态 0未上线 1已上线 -1已下线',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`set_id`) USING BTREE,
  INDEX `set_type`(`set_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '首页配置表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for trade_log_type_master
-- ----------------------------
DROP TABLE IF EXISTS `trade_log_type_master`;
CREATE TABLE `trade_log_type_master`  (
  `trade_type` int(10) UNSIGNED NOT NULL DEFAULT 0 COMMENT '交易类型标识',
  `order_table` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '交易对应的日志表名',
  `description` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`trade_type`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '交易记录类型主表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for u_login_log
-- ----------------------------
DROP TABLE IF EXISTS `u_login_log`;
CREATE TABLE `u_login_log`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键',
  `uid` int(11) NOT NULL COMMENT '用户ID',
  `apikey` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT 'apikey 唯一',
  `login_time` datetime(0) DEFAULT NULL COMMENT '上线时间',
  `logout_time` datetime(0) DEFAULT NULL COMMENT '退出时间',
  `state` tinyint(4) NOT NULL DEFAULT 0 COMMENT '在线状态 1：在线 -1：已下线',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 64 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '员工用户登入日志' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for u_user_master
-- ----------------------------
DROP TABLE IF EXISTS `u_user_master`;
CREATE TABLE `u_user_master`  (
  `uid` int(11) NOT NULL DEFAULT 0 COMMENT 'uid',
  `mobile` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '电话',
  `flag_auth` int(11) NOT NULL DEFAULT 0 COMMENT '是否身份认证',
  `password_flag` int(11) NOT NULL DEFAULT 0 COMMENT '密码设置 0：未设置 1：已经设置',
  `name` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '姓名',
  `id_card` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '身份认证',
  `auth_switch_status` int(11) NOT NULL DEFAULT 0 COMMENT '注册时身份验证开关状态, 标记是否经过身份验证',
  `wx_open_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '微信openid',
  `wx_flag_bind` int(11) NOT NULL DEFAULT 0 COMMENT '是否绑定微信',
  `wx_last_bind_time` datetime(0) DEFAULT NULL COMMENT '绑定微信的时间',
  `wx_last_unbind_time` datetime(0) DEFAULT NULL COMMENT '解绑微信的时间',
  `user_type` int(11) NOT NULL DEFAULT 0 COMMENT '用户类型 0：个人用户 1：企业用户',
  `borrower_uid` int(11) NOT NULL DEFAULT 0 COMMENT '企业id u_borrower_master 的id',
  `suma_register_flag` int(11) NOT NULL DEFAULT 0 COMMENT '是否开通存管账户',
  `suma_user_id_identity` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '存管账户第三方用户标示',
  `suma_user_id` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '用户丰付id',
  `hsb_acct_no` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '徽商电子帐号',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '状态',
  `description` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  `card_type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '证件类型 1：身份证；2：港澳通行证；3：台湾通行证；4：护照；5：军官证；6：士兵证；',
  PRIMARY KEY (`uid`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '用户信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user_master
-- ----------------------------
DROP TABLE IF EXISTS `user_master`;
CREATE TABLE `user_master`  (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '手机号',
  `email` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '邮箱',
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '登入密码',
  `nickname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL COMMENT '昵称',
  `avatar` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '头像',
  `sex` tinyint(4) DEFAULT 0 COMMENT '1男  2女',
  `birthday` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '生日',
  `height` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '身高',
  `weight` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '体重',
  `company_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '公司',
  `job` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '职位',
  `wx_open_id` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '微信openid',
  `wx_union_id` varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '微信unionid',
  `wx_flag_bind` int(11) NOT NULL DEFAULT 0 COMMENT '是否绑定微信',
  `wx_bind_time` datetime(0) DEFAULT NULL COMMENT '绑定微信的时间',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '状态 1正常 2注销',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `login_time` datetime(0) NOT NULL COMMENT '最后登录时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  `invite_code` varchar(32) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '扩展字段 邀请码',
  `share_user_id` int(10) NOT NULL DEFAULT 0 COMMENT '分享用户ID',
  `share_buy_state` tinyint(3) NOT NULL DEFAULT 0 COMMENT '分享购买状态：0未购买，2已购买',
  `source` tinyint(4) DEFAULT 1 COMMENT '来源 1：微信',
  PRIMARY KEY (`uid`) USING BTREE,
  INDEX `mobile`(`mobile`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户主表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for web_infomation_master
-- ----------------------------
DROP TABLE IF EXISTS `web_infomation_master`;
CREATE TABLE `web_infomation_master`  (
  `web_infomation_id` int(11) NOT NULL AUTO_INCREMENT,
  `web_infomation_type` int(11) NOT NULL DEFAULT 0 COMMENT '文章类型',
  `title` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '标题',
  `outline` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '概要',
  `keywords` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '关键字',
  `flag_out_site` int(11) NOT NULL DEFAULT 0 COMMENT '是否是外部文章',
  `out_site_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '外部文章url',
  `static_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '静态链接地址',
  `thumb_img_url` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '缩略图url',
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '文章内容',
  `flag_recommend` int(11) NOT NULL DEFAULT 0 COMMENT '是否是推荐文章 1为推荐',
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '上线状态 0未上线 1已上线 -1已下线',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`web_infomation_id`) USING BTREE,
  INDEX `web_infomation_type`(`web_infomation_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章主表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for web_infomation_type_master
-- ----------------------------
DROP TABLE IF EXISTS `web_infomation_type_master`;
CREATE TABLE `web_infomation_type_master`  (
  `web_infomation_type` int(11) NOT NULL DEFAULT 0 COMMENT '文章类别',
  `description` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '描述',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`web_infomation_type`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '文章类型表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for web_news_master
-- ----------------------------
DROP TABLE IF EXISTS `web_news_master`;
CREATE TABLE `web_news_master`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '描述、正文',
  `add_admin_id` int(11) NOT NULL COMMENT '添加的新闻的管理员id',
  `last_edit_admin_id` int(11) DEFAULT NULL COMMENT '最后一个修改人的id',
  `web_news_status` int(11) NOT NULL COMMENT '新闻状态 外键对应web_news_status_master',
  `apply_time` datetime(0) DEFAULT NULL COMMENT '发布时间',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `web_news_status_idx`(`web_news_status`) USING BTREE,
  CONSTRAINT `web_news_master_ibfk_1` FOREIGN KEY (`web_news_status`) REFERENCES `web_news_status_master` (`web_news_status`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '网站新闻' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for web_news_status_master
-- ----------------------------
DROP TABLE IF EXISTS `web_news_status_master`;
CREATE TABLE `web_news_status_master`  (
  `web_news_status` int(11) NOT NULL DEFAULT 0 COMMENT '网站新闻状态标识',
  `description` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
  `create_time` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  `udpate_time` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`web_news_status`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '网站新闻状态主表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for web_notice_master
-- ----------------------------
DROP TABLE IF EXISTS `web_notice_master`;
CREATE TABLE `web_notice_master`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '标题',
  `description` text CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT '描述、正文',
  `add_admin_id` int(11) NOT NULL COMMENT '添加的新闻的管理员id',
  `web_notice_status` int(11) NOT NULL COMMENT '公告状态 外键对应web_news_notice_master',
  `last_edit_admin_id` int(11) DEFAULT NULL COMMENT '最后一个修改人的id',
  `end_time` datetime(0) DEFAULT NULL COMMENT '有效期结束时间',
  `apply_time` datetime(0) DEFAULT NULL COMMENT '发布时间',
  `create_time` datetime(0) NOT NULL COMMENT '创建时间',
  `update_time` datetime(0) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `web_notice_status_idx`(`web_notice_status`) USING BTREE,
  CONSTRAINT `web_notice_master_ibfk_1` FOREIGN KEY (`web_notice_status`) REFERENCES `web_notice_status_master` (`web_notice_status`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '网站公告' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for web_notice_status_master
-- ----------------------------
DROP TABLE IF EXISTS `web_notice_status_master`;
CREATE TABLE `web_notice_status_master`  (
  `web_notice_status` int(11) NOT NULL DEFAULT 0 COMMENT '网站公告状态标识',
  `description` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '描述',
  `create_time` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '创建时间',
  `update_time` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`web_notice_status`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '网站公告状态主表' ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
