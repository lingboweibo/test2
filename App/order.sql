CREATE TABLE `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_sn` char(20) NOT NULL COMMENT '序列',
  `is_out` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '订单状态 0未导出 1已导出',
  `consignee` varchar(60) NOT NULL COMMENT '收货人',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `mobile` varchar(60) NOT NULL COMMENT '手机',
  `total_amount` decimal(10,2) unsigned NOT NULL COMMENT '订单总价',
  `add_time` datetime NOT NULL COMMENT '下单时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='订单表';
