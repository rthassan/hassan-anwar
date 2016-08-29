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
  'ERR_FORECAST_AMOUNT' => 'O Registo de Valor é obrigatório, e deverá ser um número.',
  'LBL_AMOUNT' => 'Valor',
  'LBL_BASE_RATE' => 'Taxa Base',
  'LBL_COMMIT_HEADER' => 'Registo da Previsão',
  'LBL_COMMIT_MESSAGE' => 'Pretende registar estes valores?',
  'LBL_COMMIT_NOTE' => 'Introduza os valores que pretende registar para o Período de Tempo seleccionado:',
  'LBL_COMMIT_STAGE' => 'Etapa de Registo',
  'LBL_CREATED_BY' => 'Criado por',
  'LBL_CURRENCY' => 'Moeda',
  'LBL_CURRENCY_ID' => 'ID da Moeda',
  'LBL_CURRENCY_RATE' => 'Taxa da Moeda',
  'LBL_DATE_CLOSED' => 'Data de Fecho Esperada',
  'LBL_DATE_COMMITTED' => 'Data de Registo',
  'LBL_DATE_ENTERED' => 'Data de Introdução',
  'LBL_DATE_MODIFIED' => 'Data de Modificação',
  'LBL_DELETED' => 'Eliminado',
  'LBL_DV_FORECAST_OPPORTUNITY' => 'Oportunidades da Previsão',
  'LBL_DV_FORECAST_PERIOD' => 'Período de Tempo da Previsão',
  'LBL_DV_FORECAST_ROLLUP' => 'Revisão da Previsão',
  'LBL_DV_HEADER' => 'Previsões: Folha de Trabalho',
  'LBL_DV_LAST_COMMIT_AMOUNT' => 'Último Valor de Registo:',
  'LBL_DV_LAST_COMMIT_DATE' => 'Última Data de Registo:',
  'LBL_DV_MY_FORECASTS' => 'As Minhas Previsões',
  'LBL_DV_MY_TEAM' => 'As Previsões da Minha Equipa',
  'LBL_DV_TIMEPERIOD' => 'Período de Tempo:',
  'LBL_DV_TIMEPERIODS' => 'Períodos de Tempo:',
  'LBL_DV_TIMPERIOD_DATES' => 'Intervalo de Datas:',
  'LBL_EDITABLE_INVALID' => 'Valor Inválido para {{field_name}}',
  'LBL_EDITABLE_INVALID_RANGE' => 'O valor tem que estar entre {{min}} e {{max}}',
  'LBL_FC_START_DATE' => 'Data de Início',
  'LBL_FC_USER' => 'Calendarizar Para',
  'LBL_FDR_ADJ_AMOUNT' => 'Valor Ajustado',
  'LBL_FDR_COMMIT' => 'Valor Registado',
  'LBL_FDR_DATE_COMMIT' => 'Data do Registo',
  'LBL_FDR_OPPORTUNITIES' => 'Oportunidades na previsão:',
  'LBL_FDR_USER_NAME' => 'Relatório Directo',
  'LBL_FDR_WEIGH' => 'Valor Ponderado das oportunidades:',
  'LBL_FORECAST' => 'Previsão',
  'LBL_FORECAST_HISTORY' => 'Previsões: Histórico',
  'LBL_FORECAST_HISTORY_TITLE' => 'Histórico',
  'LBL_FORECAST_ID' => 'ID da Previsão',
  'LBL_FORECAST_OPP_COUNT' => 'Contagem do Total de Oportunidades',
  'LBL_FORECAST_OPP_WEIGH' => 'Valor Ponderado',
  'LBL_FORECAST_PIPELINE_OPP_COUNT' => 'Contagem de Oportunidades em Pipeline',
  'LBL_FORECAST_TIME_ID' => 'ID do Período de Tempo',
  'LBL_FORECAST_TYPE' => 'Tipo de Previsão',
  'LBL_FORECAST_USER' => 'Utilizador',
  'LBL_FS_CASCADE' => 'Cascata?',
  'LBL_FS_CREATED_BY' => 'Criado por',
  'LBL_FS_DATE_ENTERED' => 'Data de Introdução',
  'LBL_FS_DATE_MODIFIED' => 'Data da Modificação',
  'LBL_FS_DELETED' => 'Eliminado',
  'LBL_FS_END_DATE' => 'Data de Fim',
  'LBL_FS_FORECAST_FOR' => 'Calendarizar Para:',
  'LBL_FS_FORECAST_START_DATE' => 'Data de Início da Previsão',
  'LBL_FS_MODULE_NAME' => 'Calendarização da Previsão',
  'LBL_FS_START_DATE' => 'Data de Início',
  'LBL_FS_STATUS' => 'Estado',
  'LBL_FS_TIMEPERIOD' => 'Período de Tempo',
  'LBL_FS_TIMEPERIOD_ID' => 'ID do Período de Tempo',
  'LBL_FS_USER_ID' => 'ID do Utilizador',
  'LBL_HISTORY_LOG' => 'Último Registo',
  'LBL_LIST_FORM_TITLE' => 'Previsões Registadas',
  'LBL_LOADING_COMMIT_HISTORY' => 'A carregar a história de registo…',
  'LBL_LV_COMMIT' => 'Valor Registado',
  'LBL_LV_COMMIT_DATE' => 'Data de Registo',
  'LBL_LV_OPPORTUNITIES' => 'Oportunidades',
  'LBL_LV_TIMPERIOD' => 'Período de Tempo',
  'LBL_LV_TIMPERIOD_END_DATE' => 'Data de Fim',
  'LBL_LV_TIMPERIOD_START_DATE' => 'Data de Início',
  'LBL_LV_TYPE' => 'Tipo de Previsão',
  'LBL_LV_WEIGH' => 'Valor Ponderado',
  'LBL_MANGER_SAVED' => 'Gestor Gravado',
  'LBL_MODIFIED_USER_ID' => 'Modificado Por',
  'LBL_MODULE_NAME' => 'Folhas de Trabalho de Gestão de Previsões',
  'LBL_MODULE_NAME_SINGULAR' => 'Folha de Trabalho de Gestão de Previsões',
  'LBL_MODULE_TITLE' => 'Folhas de Trabalho de Gestão de Previsões',
  'LBL_MY_MANAGER_LINE' => '{{full_name}} (eu)',
  'LBL_NO_ACTIVE_TIMEPERIOD' => 'Não existem Período de Tempo activos para a Previsão.',
  'LBL_NO_COMMIT' => 'Sem Registo Prévio',
  'LBL_OW_ACCOUNTNAME' => 'Conta',
  'LBL_OW_DESCRIPTION' => 'Descrição',
  'LBL_OW_MODULE_TITLE' => 'Folha de Trabalho de Oportunidade',
  'LBL_OW_NEXT_STEP' => 'Próximo Passo',
  'LBL_OW_OPPORTUNITIES' => 'Oportunidade',
  'LBL_OW_PROBABILITY' => 'Probabilidade',
  'LBL_OW_REVENUE' => 'Valor',
  'LBL_OW_TYPE' => 'Tipo',
  'LBL_OW_WEIGHTED' => 'Valor Ponderado',
  'LBL_PERCENT' => 'Percentagem concluído',
  'LBL_PRODUCT_ID' => 'ID do Produto',
  'LBL_QC_COMMIT_BUTTON' => 'Registo',
  'LBL_QC_COMMIT_VALUE' => 'Registo de Valores:',
  'LBL_QC_DIRECT_FORECAST' => 'As Minhas Previsões Directas',
  'LBL_QC_HEADER_DELIM' => 'Para',
  'LBL_QC_LAST_COMMIT_VALUE' => 'Último Valor Registo:',
  'LBL_QC_LAST_DATE_COMMITTED' => 'Última Data de Registo:',
  'LBL_QC_OPPORTUNITY_COUNT' => 'Contagem de Oportunidades:',
  'LBL_QC_ROLLUP_FORECAST' => 'As Minhas Previsões de Grupo',
  'LBL_QC_ROLL_COMMIT_VALUE' => 'Valor Registado Cumulativo',
  'LBL_QC_TIME_PERIOD' => 'Período de Tempo',
  'LBL_QC_UPCOMING_FORECASTS' => 'As Minhas Previsões',
  'LBL_QC_WEIGHT_VALUE' => 'Ponderação de Valores:',
  'LBL_QC_WORKSHEET_BUTTON' => 'Folha de Trabalho',
  'LBL_QUOTA' => 'Quota',
  'LBL_QUOTA_ADJUSTED' => 'Quota (Ajustada)',
  'LBL_QUOTA_ID' => 'ID da Quota',
  'LBL_REPORTS_TO_USER_NAME' => 'Reporta a',
  'LBL_RESET_CHECK' => 'Todas as Folhas de Trabalho para o período de tempo seleccionado e utilizador autenticado serão eliminadas. Pretende continuar?',
  'LBL_RESET_WOKSHEET' => 'Reiniciar a Folha de Trabalho',
  'LBL_SALES_STAGE' => 'Etapa',
  'LBL_SAVE_WOKSHEET' => 'Gravar Folha de Trabalho',
  'LBL_SEARCH' => 'Seleccionar',
  'LBL_SEARCH_LABEL' => 'Seleccionar',
  'LBL_SHOW_CHART' => 'Visualizar Gráfico',
  'LBL_SVFS_CASCADE' => 'Relatórios em Cascata?',
  'LBL_SVFS_FORECASTDATE' => 'Calendarizar Data de Início',
  'LBL_SVFS_HEADER' => 'Calendarização da Previsão',
  'LBL_SVFS_STATUS' => 'Estado',
  'LBL_SVFS_USER' => 'Para',
  'LBL_TIMEPERIOD_NAME' => 'Período de Tempo',
  'LBL_USER_NAME' => 'Nome do Utilizador',
  'LBL_VERSION' => 'Versão',
  'LBL_WK_REVISION' => 'Revisão',
  'LBL_WK_VERSION' => 'Versão',
  'LB_FS_KEY' => 'ID',
  'LNK_FORECAST_LIST' => 'Ver Histórico de Previsões',
  'LNK_NEW_OPPORTUNITY' => 'Criar Oportunidade',
  'LNK_NEW_TIMEPERIOD' => 'Criar Período de Tempo',
  'LNK_QUOTA' => 'Ver Quotas',
  'LNK_TIMEPERIOD_LIST' => 'Visualizar Períodos de Tempo',
  'LNK_UPD_FORECAST' => 'Folha de Trabalho de Gestão de Previsões',
);

