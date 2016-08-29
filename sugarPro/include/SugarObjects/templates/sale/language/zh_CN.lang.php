<?php
if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');


/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */


$mod_strings = array (
  'ERR_DELETE_RECORD' => '要删除销售必须事先指定一个记录号码。',
  'LBL_ACCOUNT_ID' => '客户ID',
  'LBL_ACCOUNT_NAME' => '客户名：',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => '活动',
  'LBL_AMOUNT' => '金额：',
  'LBL_AMOUNT_USDOLLAR' => '美元金额：',
  'LBL_ASSIGNED_TO_ID' => '分配用户编号',
  'LBL_ASSIGNED_TO_NAME' => '用户：',
  'LBL_CAMPAIGN' => '市场活动：',
  'LBL_CLOSED_WON_SALES' => '已成交的销售',
  'LBL_CONTACTS_SUBPANEL_TITLE' => '联系人',
  'LBL_CREATED_ID' => '创建人编号',
  'LBL_CURRENCY' => '货币：',
  'LBL_CURRENCY_ID' => '货币ID',
  'LBL_CURRENCY_NAME' => '货币名称',
  'LBL_CURRENCY_SYMBOL' => '货币符号',
  'LBL_DATE_CLOSED' => '预期结束日期：',
  'LBL_DEFAULT_SUBPANEL_TITLE' => '销售',
  'LBL_DESCRIPTION' => '说明：',
  'LBL_DUPLICATE' => '或为重复销售',
  'LBL_EDIT_BUTTON' => '编辑',
  'LBL_HISTORY_SUBPANEL_TITLE' => '历史记录',
  'LBL_LEADS_SUBPANEL_TITLE' => '潜在客户',
  'LBL_LEAD_SOURCE' => '潜在客户来源：',
  'LBL_LIST_ACCOUNT_NAME' => '客户名',
  'LBL_LIST_AMOUNT' => '数量',
  'LBL_LIST_ASSIGNED_TO_NAME' => '获指派的用户',
  'LBL_LIST_DATE_CLOSED' => '结束',
  'LBL_LIST_FORM_TITLE' => '销售列表',
  'LBL_LIST_SALE_NAME' => '名称',
  'LBL_LIST_SALE_STAGE' => '销售阶段',
  'LBL_MODIFIED_ID' => '修改人ID',
  'LBL_MODIFIED_NAME' => '修改人用户名',
  'LBL_MODULE_NAME' => '销售',
  'LBL_MODULE_TITLE' => '销售：首页',
  'LBL_MY_CLOSED_SALES' => '完成的销售',
  'LBL_NAME' => '销售名称',
  'LBL_NEW_FORM_TITLE' => '创建销售',
  'LBL_NEXT_STEP' => '下一步：',
  'LBL_PROBABILITY' => '可能性(%)：',
  'LBL_PROJECTS_SUBPANEL_TITLE' => '项目',
  'LBL_RAW_AMOUNT' => '原始金额',
  'LBL_REMOVE' => '移除',
  'LBL_SALE' => '销售：',
  'LBL_SALES_STAGE' => '销售阶段：',
  'LBL_SALE_INFORMATION' => '销售信息',
  'LBL_SALE_NAME' => '销售名称：',
  'LBL_SEARCH_FORM_TITLE' => '销售搜索',
  'LBL_TEAM_ID' => '团队ID',
  'LBL_TOP_SALES' => '我的首位待定销售',
  'LBL_TOTAL_SALES' => '销售总额',
  'LBL_TYPE' => '类型：',
  'LBL_VIEW_FORM_TITLE' => '销售视图',
  'LNK_NEW_SALE' => '创建销售',
  'LNK_SALE_LIST' => '销售',
  'MSG_DUPLICATE' => '你要创建的销售记录可能和已有的记录重复。销售记录包含如下相似的名字。<br>单击“保存”继续创建这个新的销售，或者单击“取消”返回模块并不保存本次销售。',
  'NTC_REMOVE_OPP_CONFIRMATION' => '你确定要从本销售中移除此联系人吗？',
  'SALE_REMOVE_PROJECT_CONFIRM' => '你确定要从本项目中移除此项销售吗？',
  'UPDATE' => '销售-货币更新',
  'UPDATE_BUGFOUND_COUNT' => '已发现的缺陷：',
  'UPDATE_BUG_COUNT' => '已发现并尝试修复的缺陷：',
  'UPDATE_COUNT' => '已更新的记录：',
  'UPDATE_CREATE_CURRENCY' => '创建新货币：',
  'UPDATE_DOLLARAMOUNTS' => '更新美元总额',
  'UPDATE_DOLLARAMOUNTS_TXT' => '按当前设置的汇率更新美元销售金额。这个值被用于计算图形和列表视图货币金额。',
  'UPDATE_DONE' => '已完成',
  'UPDATE_FAIL' => '不能更新 -',
  'UPDATE_FIX' => '修复金额',
  'UPDATE_FIX_TXT' => '尝试通过从现有金额创建有效十进制来修复无效金额。任何被修改的金额都备份到amount_backup数据库字段中。如果你运行到这里发现了缺陷，不要在没有从备份中恢复之前返回，因为新的无效数据可能会覆盖备份记录。',
  'UPDATE_INCLUDE_CLOSE' => '包括关闭记录',
  'UPDATE_MERGE' => '合并货币',
  'UPDATE_MERGE_TXT' => '合并多个货币为一个货币。如果对同一货币有多个货币记录，可以将它们合并为一。这将同时合并其他模块的货币记录。',
  'UPDATE_NULL_VALUE' => '金额为空值，请将其设为0 -',
  'UPDATE_RESTORE' => '恢复金额',
  'UPDATE_RESTORE_COUNT' => '记录金额恢复：',
  'UPDATE_RESTORE_TXT' => '从修复时创建的备份中恢复金额值。',
  'UPDATE_VERIFY' => '验证金额',
  'UPDATE_VERIFY_CURAMOUNT' => '当前金额：',
  'UPDATE_VERIFY_FAIL' => '记录验证失败：',
  'UPDATE_VERIFY_FIX' => '运行修复会给',
  'UPDATE_VERIFY_NEWAMOUNT' => '新金额：',
  'UPDATE_VERIFY_NEWCURRENCY' => '新货币：',
  'UPDATE_VERIFY_TXT' => '验证销售金额为有效的十进制数，仅包含数字(0-9)和小数点(.)',
);

