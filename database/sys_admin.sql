/*
 Navicat Premium Data Transfer

 Source Server         : sys-admn
 Source Server Type    : MySQL
 Source Server Version : 50723
 Source Host           : localhost:3306
 Source Schema         : sys_admin

 Target Server Type    : MySQL
 Target Server Version : 50723
 File Encoding         : 65001

 Date: 18/06/2019 23:28:31
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for sys_admin_log
-- ----------------------------
DROP TABLE IF EXISTS `sys_admin_log`;
CREATE TABLE `sys_admin_log` (
  `id` bigint(15) unsigned NOT NULL AUTO_INCREMENT COMMENT '只增ID',
  `sys_user_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '后台人员id',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '类型 1日志 2错误 3警告',
  `ip` varchar(64) NOT NULL COMMENT 'IP地址',
  `api_name` varchar(100) NOT NULL DEFAULT '' COMMENT '接口名称',
  `request_method` varchar(100) DEFAULT '' COMMENT '请求方式',
  `request_header` text,
  `request_get` text COMMENT '请求内容',
  `request_post` text,
  `response_content` text COMMENT '返回内容',
  `remark` varchar(500) NOT NULL DEFAULT '' COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL COMMENT '插入时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `api_name` (`api_name`) USING BTREE,
  KEY `sys_user_id` (`sys_user_id`) USING BTREE,
  KEY `create_time` (`create_time`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='运营后台操作日志记录表';

-- ----------------------------
-- Table structure for sys_role
-- ----------------------------
DROP TABLE IF EXISTS `sys_role`;
CREATE TABLE `sys_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '组名称',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '状态  0 禁用，1 启用',
  `description` varchar(255) DEFAULT '' COMMENT '描述',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='组列表';

-- ----------------------------
-- Records of sys_role
-- ----------------------------
BEGIN;
INSERT INTO `sys_role` VALUES (1, 'admin', 1, '超级管理员', 1559107650, 1559107650);
INSERT INTO `sys_role` VALUES (2, '客服1', 1, '测试1', 1559107650, 1560316524);
COMMIT;

-- ----------------------------
-- Table structure for sys_role_rule
-- ----------------------------
DROP TABLE IF EXISTS `sys_role_rule`;
CREATE TABLE `sys_role_rule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) DEFAULT '0',
  `rule_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sys_role_rule
-- ----------------------------
BEGIN;
INSERT INTO `sys_role_rule` VALUES (13, 2, 35);
INSERT INTO `sys_role_rule` VALUES (14, 2, 1);
INSERT INTO `sys_role_rule` VALUES (15, 2, 4);
INSERT INTO `sys_role_rule` VALUES (16, 2, 8);
INSERT INTO `sys_role_rule` VALUES (17, 2, 9);
INSERT INTO `sys_role_rule` VALUES (18, 2, 21);
COMMIT;

-- ----------------------------
-- Table structure for sys_rule
-- ----------------------------
DROP TABLE IF EXISTS `sys_rule`;
CREATE TABLE `sys_rule` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `name` varchar(128) DEFAULT NULL COMMENT '权限点',
  `label` varchar(128) NOT NULL DEFAULT '' COMMENT '标签',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1 启用; 0 禁用',
  `menu` tinyint(2) unsigned NOT NULL DEFAULT '1' COMMENT '1 作为菜单显示; 0 不显示',
  `type` tinyint(2) DEFAULT '0' COMMENT '权限类型 0:h5页面 1:接口权限',
  `level` tinyint(2) DEFAULT '2' COMMENT '权限的限制级别\r\n0:不验证\r\n1:仅需要登录\r\n2.需要赋予权限',
  `condition` varchar(255) DEFAULT '',
  `remark` varchar(255) DEFAULT '' COMMENT '备注',
  `icon` varchar(100) DEFAULT '' COMMENT '菜单的图标',
  `sort` int(6) DEFAULT '0' COMMENT '菜单排序(降序)',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='权限点和菜单列表';

-- ----------------------------
-- Records of sys_rule
-- ----------------------------
BEGIN;
INSERT INTO `sys_rule` VALUES (1, 0, 'system', '系统管理', 1, 1, 0, 2, '', '', 'el-icon-lx-cascades', 0, 1559210186, 1559210186);
INSERT INTO `sys_rule` VALUES (4, 1, 'system/user', '用户管理', 1, 1, 0, 2, '', '1111', NULL, 0, 1559209861, 1560243058);
INSERT INTO `sys_rule` VALUES (5, 1, 'system/role', '角色管理', 1, 1, 0, 2, '', '', NULL, 0, 1559281700, 1560242871);
INSERT INTO `sys_rule` VALUES (6, 1, 'system/rules', '权限管理', 1, 1, 0, 2, '', '', '', 0, 0, 1559281901);
INSERT INTO `sys_rule` VALUES (8, 4, 'api/system/user/lists', '系统用户列表', 1, 0, 1, 2, '', '', '', 0, 0, 1560238116);
INSERT INTO `sys_rule` VALUES (9, 4, 'api/system/user/edit', '系统用户编辑', 1, 0, 1, 2, '', '接口', '', 0, 0, 1560234098);
INSERT INTO `sys_rule` VALUES (10, 1, 'system/sysLog', '后台日志', 1, 1, 0, 2, '', '', NULL, 0, 1560242853, 1560242853);
INSERT INTO `sys_rule` VALUES (21, 4, 'api/system/user/create', '系统用户创建', 1, 0, 1, 2, '', '接口', NULL, 0, 1560245088, 1560245088);
INSERT INTO `sys_rule` VALUES (22, 5, 'api/system/role/lists', '角色列表', 1, 0, 1, 2, '', '', NULL, 0, 1560245174, 1560247410);
INSERT INTO `sys_rule` VALUES (23, 5, 'api/system/role/edit', '编辑角色', 1, 0, 1, 2, '', '', NULL, 0, 1560245329, 1560245329);
INSERT INTO `sys_rule` VALUES (24, 5, 'api/system/role/delete', '删除角色', 1, 0, 1, 2, '', '', NULL, 0, 1560245359, 1560245359);
INSERT INTO `sys_rule` VALUES (25, 5, 'api/system/role/saveRoleRules', '给角色分配权限', 1, 0, 1, 2, '', '', NULL, 0, 1560245408, 1560245408);
INSERT INTO `sys_rule` VALUES (26, 5, 'api/system/role/getRoleRulesTree', '获取角色权限', 1, 0, 1, 2, '', '', NULL, 0, 1560245442, 1560245442);
INSERT INTO `sys_rule` VALUES (27, 6, 'api/system/rule/save', '权限保存', 1, 0, 1, 2, '', '', NULL, 0, 1560245479, 1560245479);
INSERT INTO `sys_rule` VALUES (28, 6, 'api/system/rule/treeLists', '获取权限接口', 1, 0, 1, 2, '', '', NULL, 0, 1560245545, 1560245545);
INSERT INTO `sys_rule` VALUES (29, 6, 'api/system/rule/delete', '删除权限', 1, 0, 1, 2, '', '', NULL, 0, 1560245576, 1560245576);
INSERT INTO `sys_rule` VALUES (30, 6, 'api/system/rule/allRoutes', '获取所有的API路由', 1, 0, 1, 2, '', '', NULL, 0, 1560245625, 1560245625);
INSERT INTO `sys_rule` VALUES (32, 10, 'api/system/log/sysLog', '系统操作日志', 1, 0, 1, 2, '', '', NULL, 0, 1560245770, 1560305119);
INSERT INTO `sys_rule` VALUES (35, 0, 'dashboard', '首页', 1, 1, 0, 1, '', '', 'el-icon-lx-home', 1000000, 1560335081, 1560335351);
COMMIT;

-- ----------------------------
-- Table structure for sys_user
-- ----------------------------
DROP TABLE IF EXISTS `sys_user`;
CREATE TABLE `sys_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '账号状态 -1:刪除 1:正常 2:禁止登陆',
  `username` varchar(128) NOT NULL DEFAULT '' COMMENT '用户名',
  `password` varchar(128) NOT NULL DEFAULT '' COMMENT '密码',
  `realname` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `role_id` int(11) DEFAULT '0' COMMENT '角色',
  `avatar` varchar(200) DEFAULT '' COMMENT '用户头像',
  `email` varchar(100) DEFAULT '' COMMENT '电子邮箱',
  `mobile` varchar(32) DEFAULT '' COMMENT '手机号',
  `token` varchar(64) DEFAULT '' COMMENT '用户的token',
  `token_time` int(11) DEFAULT '0' COMMENT 'Token生成时间',
  `last_login_time` int(11) unsigned DEFAULT '0' COMMENT '最后登录时间',
  `last_ip` varchar(32) NOT NULL DEFAULT '' COMMENT '最后登录IP',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据插入时间',
  `update_time` int(11) DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `username` (`username`) USING BTREE,
  KEY `token` (`token`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC COMMENT='运营后台用户列表';

-- ----------------------------
-- Records of sys_user
-- ----------------------------
BEGIN;
INSERT INTO `sys_user` VALUES (1, 1, 'admin', '$2y$10$SGhQQx6DImABSj7oywR5XO/YIgthvkCtRWNAp3tFL5ntfCARHIR/6', 'SuperAdmin', 1, 'https://www.baidu.com/img/bd_logo1.png', 'yxxxx@qq.com', '15888999991', 'f2a0d377-cd36-45dc-8055-e87a67043212', 1560869664, 1558941483, '127.0.0.1', 1558941483, 1560234058);
INSERT INTO `sys_user` VALUES (2, 1, 'test', '$2y$10$1uqISR6Yu5XZFijUzsOzyOEYYA.18Ii.05LupKeU3ySx7H61Ty8Uu', '测试号1', 1, '', NULL, NULL, '', 0, 1558938534, '127.0.0.1', 1558938534, 1560869027);
INSERT INTO `sys_user` VALUES (4, 1, 'test01', '$2y$10$p80ekmokjjyns0IVLxJU2.u85nKr4sZdJgAuQ/eMIxRsM65quDPgm', '小明01', 2, '', NULL, NULL, 'f849c6ad-10a1-b023-adcd-c8042fb8a85f', 1560871620, 0, '', 1559098789, 1559186402);
INSERT INTO `sys_user` VALUES (5, 1, 'test02', '$2y$10$XjF0Z1s7AQ9LD3BhUdVJHurXkTui4QTpBTsNUtWiS0jyUK8ec/TGS', 'test02', 2, '', NULL, NULL, '', 0, 0, '', 1559098889, 1559186275);
INSERT INTO `sys_user` VALUES (6, 1, 'test03', '$2y$10$701EsorhtSv2uzQNF699LOngjE126vzir3ZwFCuX92kAxLse8Cyn2', 'test03', 2, '', NULL, NULL, '', 0, 0, '', 1559099062, 1559186270);
INSERT INTO `sys_user` VALUES (7, -1, 'test04', '$2y$10$9KNGZRKeoxkR0Cla5ToBBOI3gvAMRuN9Acpc0rzVY2myvKtwl6YCa', 'test04', 2, '', NULL, NULL, '', 0, 0, '', 1559099451, 1560869221);
INSERT INTO `sys_user` VALUES (8, 1, 'test05', '$2y$10$7fvhqFb8lLJ6Ndp/qavvkeytDcGSCqj5O3DhY6M1tY/9Eh6wJ1tUO', '请求', 2, '', NULL, NULL, '', 0, 0, '', 1559193569, 1559193569);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
