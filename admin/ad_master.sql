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

 Date: 02/11/2018 09:27:20
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for ad_master
-- ----------------------------
DROP TABLE IF EXISTS `ad_master`;
CREATE TABLE `ad_master`  (
  `ad_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '广告标题',
  `position_id` int(10) UNSIGNED NOT NULL DEFAULT 1 COMMENT '广告位ID 首页',
  `link_url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '' COMMENT '链接地址',
  `ad_pic` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '默认封面图片',
  `sort` smallint(2) UNSIGNED DEFAULT 0 COMMENT '排序值',
  `on_time` int(11) UNSIGNED DEFAULT 0 COMMENT '上线时间',
  `off_time` int(11) UNSIGNED DEFAULT 0 COMMENT '下线时间',
  `status` tinyint(2) DEFAULT 1 COMMENT '状态：1上线，2下线，-1删除',
  `ad_remark` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT '' COMMENT '备注',
  `create_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '创建时间',
  `update_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`ad_id`) USING BTREE,
  INDEX `position_id`(`position_id`) USING BTREE,
  INDEX `status`(`status`) USING BTREE,
  INDEX `opid`(`ad_remark`) USING BTREE
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
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci COMMENT = '后台用户基础表' ROW_FORMAT = Compact;

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

SET FOREIGN_KEY_CHECKS = 1;
