CREATE TABLE `app_member` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(16) DEFAULT '' COMMENT '//昵称',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '//手机号',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '//密码',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '//创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '//更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='//会员表';

CREATE TABLE `app_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '' COMMENT '//类别名称',
  `category_no` int(11) DEFAULT '0' COMMENT '//类别排序',
  `preview` varchar(100) DEFAULT '' COMMENT '//类别预览图',
  `parent_id` int(11) DEFAULT NULL COMMENT '//父ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '//创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '//更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='//分类表';

CREATE TABLE `app_product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT '' COMMENT '//产品名称',
  `summary` varchar(200) DEFAULT '' COMMENT '//产品概述',
  `price` decimal(10,2) DEFAULT '0.00' COMMENT '//产品价格',
  `preview` varchar(200) DEFAULT '' COMMENT '//预览图',
  `category_id` int(11) DEFAULT '0' COMMENT '//分类ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '//创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '//更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='//产品表';

CREATE TABLE `app_pdt_content` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(20000) DEFAULT '' COMMENT '//产品详情',
  `product_id` int(11) DEFAULT NULL COMMENT '//产品ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '//创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '//更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='//产品详情表';

CREATE TABLE `app_pdt_images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `image_path` varchar(255) DEFAULT '' COMMENT '//图片地址',
  `image_no` int(11) DEFAULT '0' COMMENT '//图片排序',
  `product_id` int(11) DEFAULT NULL COMMENT '//产品ID',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '//创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '//更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='//产品图片表';

CREATE TABLE `app_temp_phone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `phone` varchar(11) DEFAULT '' COMMENT '//临时手机号',
  `code` int(11) DEFAULT NULL COMMENT '//手机验证码',
  `deadline` timestamp NULL DEFAULT NULL COMMENT '//验证码过期时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='//临时手机验证码表';