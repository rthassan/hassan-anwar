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
  'ERR_FORECAST_AMOUNT' => 'La Cantidad Realizada es un valor requerido, y debe ser numérico.',
  'LBL_AMOUNT' => 'Cantidad',
  'LBL_BASE_RATE' => 'Mejor Índice',
  'LBL_COMMIT_HEADER' => 'Realización de Previsión',
  'LBL_COMMIT_MESSAGE' => '¿Quiere introducir estas cantidades como realizadas?',
  'LBL_COMMIT_NOTE' => 'Introduzca las cantidades que desee realizar en el Período de Tiempo seleccionado:',
  'LBL_COMMIT_STAGE' => 'Fase de Compromiso',
  'LBL_CREATED_BY' => 'Creado por',
  'LBL_CURRENCY' => 'Moneda',
  'LBL_CURRENCY_ID' => 'ID Moneda',
  'LBL_CURRENCY_RATE' => 'Tipo de Cambio',
  'LBL_DATE_CLOSED' => 'Fecha de Cierre Prevista',
  'LBL_DATE_COMMITTED' => 'Fecha Realización',
  'LBL_DATE_ENTERED' => 'Fecha de Creación',
  'LBL_DATE_MODIFIED' => 'Última Modificación',
  'LBL_DELETED' => 'Eliminada',
  'LBL_DV_FORECAST_OPPORTUNITY' => 'Oportunidades de la Previsión',
  'LBL_DV_FORECAST_PERIOD' => 'Período de Tiempo de la Previsión',
  'LBL_DV_FORECAST_ROLLUP' => 'Previsión Dinámica',
  'LBL_DV_HEADER' => 'Previsiones: Hoja de cálculo',
  'LBL_DV_LAST_COMMIT_AMOUNT' => 'Últimas Cantidades Realizadas:',
  'LBL_DV_LAST_COMMIT_DATE' => 'Última Fecha de Realización:',
  'LBL_DV_MY_FORECASTS' => 'Mis Previsiones',
  'LBL_DV_MY_TEAM' => 'Previsiones de mi Equipo',
  'LBL_DV_TIMEPERIOD' => 'Período de Tiempo:',
  'LBL_DV_TIMEPERIODS' => 'Períodos de Tiempo:',
  'LBL_DV_TIMPERIOD_DATES' => 'Rango de Fechas:',
  'LBL_EDITABLE_INVALID' => 'Valor Incorrecto para {{field_name}}',
  'LBL_EDITABLE_INVALID_RANGE' => 'El valor debe ser entre {{min}} y {{max}}',
  'LBL_FC_START_DATE' => 'Fecha de Inicio',
  'LBL_FC_USER' => 'Planificar Para',
  'LBL_FDR_ADJ_AMOUNT' => 'Cantidad Ajustada',
  'LBL_FDR_COMMIT' => 'Cantidad Realizada',
  'LBL_FDR_DATE_COMMIT' => 'Fecha de Realización',
  'LBL_FDR_OPPORTUNITIES' => 'Oportunidades en Previsión',
  'LBL_FDR_USER_NAME' => 'Informe Directo',
  'LBL_FDR_WEIGH' => 'Total Ponderada de oportunidades:',
  'LBL_FORECAST' => 'Previsión',
  'LBL_FORECAST_HISTORY' => 'Previsiones: Historial',
  'LBL_FORECAST_HISTORY_TITLE' => 'Historial',
  'LBL_FORECAST_ID' => 'ID Previsión',
  'LBL_FORECAST_OPP_COUNT' => 'Total de Oportunidades',
  'LBL_FORECAST_OPP_WEIGH' => 'Cantidad Ponderada',
  'LBL_FORECAST_PIPELINE_OPP_COUNT' => 'Total de Oportunidades en Pipeline',
  'LBL_FORECAST_TIME_ID' => 'ID Período de Tiempo',
  'LBL_FORECAST_TYPE' => 'Tipo de Previsión',
  'LBL_FORECAST_USER' => 'Usuario',
  'LBL_FS_CASCADE' => '¿En cascada?',
  'LBL_FS_CREATED_BY' => 'Creado por',
  'LBL_FS_DATE_ENTERED' => 'Fecha de Creación',
  'LBL_FS_DATE_MODIFIED' => 'Última Modificación',
  'LBL_FS_DELETED' => 'Eliminada',
  'LBL_FS_END_DATE' => 'Fecha Fin',
  'LBL_FS_FORECAST_FOR' => 'Planificar para:',
  'LBL_FS_FORECAST_START_DATE' => 'Fecha de Inicio de la Previsión',
  'LBL_FS_MODULE_NAME' => 'Planificación de la Previsión',
  'LBL_FS_START_DATE' => 'Fecha de Inicio',
  'LBL_FS_STATUS' => 'Estado',
  'LBL_FS_TIMEPERIOD' => 'Período de Tiempo',
  'LBL_FS_TIMEPERIOD_ID' => 'ID Período de Tiempo',
  'LBL_FS_USER_ID' => 'ID Usuario',
  'LBL_HISTORY_LOG' => 'Último Objectivo Alcanzado',
  'LBL_LIST_FORM_TITLE' => 'Previsiones Realizadas',
  'LBL_LOADING_COMMIT_HISTORY' => 'Cargando Historial Realizado...',
  'LBL_LV_COMMIT' => 'Cantidad Realizada',
  'LBL_LV_COMMIT_DATE' => 'Fecha de Realización',
  'LBL_LV_OPPORTUNITIES' => 'Oportunidades',
  'LBL_LV_TIMPERIOD' => 'Período de Tiempo',
  'LBL_LV_TIMPERIOD_END_DATE' => 'Fecha de Fin',
  'LBL_LV_TIMPERIOD_START_DATE' => 'Fecha de Inicio',
  'LBL_LV_TYPE' => 'Tipo de Previsión',
  'LBL_LV_WEIGH' => 'Cantidad Ponderada',
  'LBL_MANGER_SAVED' => 'Mánager Guardado',
  'LBL_MODIFIED_USER_ID' => 'Modificado Por',
  'LBL_MODULE_NAME' => 'Hojas de Trabajo para responsable de Previsión de Ventas',
  'LBL_MODULE_NAME_SINGULAR' => 'Hojas de Trabajo para responsable de Previsión de Ventas',
  'LBL_MODULE_TITLE' => 'Hojas de Trabajo para responsable de Previsión de Ventas',
  'LBL_MY_MANAGER_LINE' => '{{full_name}} (yo)',
  'LBL_NO_ACTIVE_TIMEPERIOD' => 'No hay ningún período de tiempo Activo para realizar una Previsión.',
  'LBL_NO_COMMIT' => 'Ningún Objectivo Alcanzado con anterioridad',
  'LBL_OW_ACCOUNTNAME' => 'Cuenta',
  'LBL_OW_DESCRIPTION' => 'Descripción',
  'LBL_OW_MODULE_TITLE' => 'Hoja de Trabajo para Oportunidades',
  'LBL_OW_NEXT_STEP' => 'Siguiente Paso',
  'LBL_OW_OPPORTUNITIES' => 'Oportunidad',
  'LBL_OW_PROBABILITY' => 'Probabilidad',
  'LBL_OW_REVENUE' => 'Cantidad',
  'LBL_OW_TYPE' => 'Tipo',
  'LBL_OW_WEIGHTED' => 'Cantidad Ponderada',
  'LBL_PERCENT' => 'Porcentaje',
  'LBL_PRODUCT_ID' => 'ID de Producto',
  'LBL_QC_COMMIT_BUTTON' => 'Realizar',
  'LBL_QC_COMMIT_VALUE' => 'Cantidad Realizada:',
  'LBL_QC_DIRECT_FORECAST' => 'Mi Previsión Directa:',
  'LBL_QC_HEADER_DELIM' => 'A',
  'LBL_QC_LAST_COMMIT_VALUE' => 'Última Cantidad Realizada:',
  'LBL_QC_LAST_DATE_COMMITTED' => 'Última Fecha de Realización:',
  'LBL_QC_OPPORTUNITY_COUNT' => 'Total de Oportunidades:',
  'LBL_QC_ROLLUP_FORECAST' => 'Mi Previsión de Grupo:',
  'LBL_QC_ROLL_COMMIT_VALUE' => 'Total Objectivo Alcanzable:',
  'LBL_QC_TIME_PERIOD' => 'Período de Tiempo:',
  'LBL_QC_UPCOMING_FORECASTS' => 'Mis Previsiones',
  'LBL_QC_WEIGHT_VALUE' => 'Cantidad Ponderada:',
  'LBL_QC_WORKSHEET_BUTTON' => 'Hoja de Trabajo',
  'LBL_QUOTA' => 'Cuota',
  'LBL_QUOTA_ADJUSTED' => 'Objectivo (Ajustado)',
  'LBL_QUOTA_ID' => 'ID de Cuota',
  'LBL_REPORTS_TO_USER_NAME' => 'Informa A',
  'LBL_RESET_CHECK' => 'Todos los datos de la hoja de cálculo para el período de tiempo seleccionado y para el usuario que ha iniciado la sesión se eliminarán, ¿desea continuar?',
  'LBL_RESET_WOKSHEET' => 'Restaurar Hoja de cálculo',
  'LBL_SALES_STAGE' => 'Etapa',
  'LBL_SAVE_WOKSHEET' => 'Guardar Hoja de cálculo',
  'LBL_SEARCH' => 'Seleccionar',
  'LBL_SEARCH_LABEL' => 'Seleccionar',
  'LBL_SHOW_CHART' => 'Ver Gráfico',
  'LBL_SVFS_CASCADE' => '¿Aplicar a Informes?',
  'LBL_SVFS_FORECASTDATE' => 'Fecha de Inicio de Planificación',
  'LBL_SVFS_HEADER' => 'Planificación de la Previsión:',
  'LBL_SVFS_STATUS' => 'Estado',
  'LBL_SVFS_USER' => 'Para',
  'LBL_TIMEPERIOD_NAME' => 'Período de Tiempo',
  'LBL_USER_NAME' => 'Nombre de Usuario',
  'LBL_VERSION' => 'Versión',
  'LBL_WK_REVISION' => 'Revisión',
  'LBL_WK_VERSION' => 'Versión',
  'LB_FS_KEY' => 'ID',
  'LNK_FORECAST_LIST' => 'Ver Historial de Previsiones',
  'LNK_NEW_OPPORTUNITY' => 'Crear Oportunidad',
  'LNK_NEW_TIMEPERIOD' => 'Crear Período de Tiempo',
  'LNK_QUOTA' => 'Ver Cuotas',
  'LNK_TIMEPERIOD_LIST' => 'Ver Períodos de Tiempo',
  'LNK_UPD_FORECAST' => 'Hojas de Trabajo para responsable de Previsión de Ventas',
);

