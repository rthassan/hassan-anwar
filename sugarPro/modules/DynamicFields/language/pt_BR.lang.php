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
  'COLUMN_DISABLE_NUMBER_FORMAT' => 'Desabilitar Formato',
  'COLUMN_TITLE_AUDIT' => 'Auditoria',
  'COLUMN_TITLE_AUTOINC_NEXT' => 'Próximo Valor de Auto Increment',
  'COLUMN_TITLE_COMMENT_TEXT' => 'Comentário',
  'COLUMN_TITLE_DATA_TYPE' => 'Tipo de Dados',
  'COLUMN_TITLE_DEFAULT_EMAIL' => 'Valor Padrão',
  'COLUMN_TITLE_DEFAULT_VALUE' => 'Valor Padrão',
  'COLUMN_TITLE_DISPLAYED_ITEM_COUNT' => '# Itens apresentados',
  'COLUMN_TITLE_DISPLAY_LABEL' => 'Exibir Rótulo',
  'COLUMN_TITLE_DUPLICATE_MERGE' => 'Fundir Duplicados',
  'COLUMN_TITLE_ENABLE_RANGE_SEARCH' => 'Habilitar Pesquisa com Intervalo',
  'COLUMN_TITLE_EXT1' => 'Campo extra de metadados 1',
  'COLUMN_TITLE_EXT2' => 'Campo extra de metadados 2',
  'COLUMN_TITLE_EXT3' => 'Campo extra de metadados 3',
  'COLUMN_TITLE_FRAME_HEIGHT' => 'Altura do IFrame',
  'COLUMN_TITLE_FTS' => 'Full Text Searchable',
  'COLUMN_TITLE_GLOBAL_SEARCH' => 'Pesquisa Global',
  'COLUMN_TITLE_HELP_TEXT' => 'Texto de Ajuda',
  'COLUMN_TITLE_HTML_CONTENT' => 'HTML',
  'COLUMN_TITLE_IMPORTABLE' => 'Importável',
  'COLUMN_TITLE_LABEL' => 'Rótulo de Sistema',
  'COLUMN_TITLE_LABEL_COLS' => 'Colunas',
  'COLUMN_TITLE_LABEL_ROWS' => 'Linhas',
  'COLUMN_TITLE_LABEL_VALUE' => 'Valor de Rótulo',
  'COLUMN_TITLE_MASS_UPDATE' => 'Atualização em Massa',
  'COLUMN_TITLE_MAX_SIZE' => 'Tamanho Máximo',
  'COLUMN_TITLE_MAX_VALUE' => 'Valor Máximo',
  'COLUMN_TITLE_MIN_VALUE' => 'Valor Mínimo',
  'COLUMN_TITLE_NAME' => 'Nome de Campo',
  'COLUMN_TITLE_PRECISION' => 'Precisão',
  'COLUMN_TITLE_REPORTABLE' => 'Reportável',
  'COLUMN_TITLE_REQUIRED_OPTION' => 'Campo Obrigatório',
  'COLUMN_TITLE_URL' => 'URL padrão',
  'COLUMN_TITLE_VALIDATE_US_FORMAT' => 'Formato E.U.A.',
  'ERR_FIELD_NAME_ALREADY_EXISTS' => 'O campo Nome já existe',
  'ERR_FIELD_NAME_NON_DB_CHARS' => 'O nome do campo deve conter apenas os seguintes caracteres: a-zA-Z_',
  'ERR_NO_MODULE_INCLUDED' => 'Nenhum módulo Incluso, não foi possível salvar',
  'ERR_RESERVED_FIELD_NAME' => 'Palavra Reservada',
  'ERR_SELECT_FIELD_TYPE' => 'Por favor Selecione um Tipo de Campo',
  'LBL_ADDING_COLUMN' => 'Adicionando coluna {0} paraAdding Column {0} to',
  'LBL_ADD_FIELD' => 'Adicionar Campo:',
  'LBL_AUDITED' => 'Auditoria',
  'LBL_BTN_ADD' => 'Adicionar',
  'LBL_BTN_EDIT' => 'Editar',
  'LBL_BTN_EDIT_VISIBILITY' => 'Editar Visibilidade',
  'LBL_CALCULATED' => 'Calculado',
  'LBL_DATA_TYPE' => 'Tipo de Dados',
  'LBL_DEFAULT_VALUE' => 'Valor Padrão',
  'LBL_DEPENDENT' => 'Dependente',
  'LBL_DEPENDENT_CHECKBOX' => 'Dependente',
  'LBL_DEPENDENT_TRIGGER' => 'Trigger:',
  'LBL_DONE' => 'Completo',
  'LBL_DROPPING_COLUMN' => 'Dropping Column {0} from {1} for module',
  'LBL_DROP_DOWN_LIST' => 'Lista Dropdown',
  'LBL_DYNAMIC_VALUES_CHECKBOX' => 'Dependente',
  'LBL_EDIT_VIS' => 'Editar Visibilidade',
  'LBL_ENFORCED' => 'Forçado',
  'LBL_EXE_NON_SIM_MODE' => 'Execute o modo não-simulação',
  'LBL_FIELD_MISSING' => 'campo (s) faltando',
  'LBL_FIX_COLUMN_TYPE' => 'AjustandoColuna Tipo para {0} mudando {1} para',
  'LBL_FORMULA' => 'Fórmula',
  'LBL_GENERATE_URL' => 'Gerar URL',
  'LBL_HAS_PARENT' => 'Has Parent',
  'LBL_HELP' => 'Ajuda',
  'LBL_IMAGE_BORDER' => 'Border',
  'LBL_IMAGE_HEIGHT' => 'Altura',
  'LBL_IMAGE_WIDTH' => 'Largura',
  'LBL_LABEL' => 'Rótulo',
  'LBL_LINK_TARGET' => 'Abrir link com',
  'LBL_MODULE' => 'Módulo',
  'LBL_MODULE_SELECT' => 'Módulo a Editar',
  'LBL_MULTI_SELECT_LIST' => 'Lista Multi Selecção',
  'LBL_PARENT_DROPDOWN' => 'Parent Dropdown',
  'LBL_RADIO_FIELDS' => 'Campos Radio',
  'LBL_REPORTABLE' => 'Reportável',
  'LBL_SCAN_MODULE' => 'Scanning',
  'LBL_SEARCH_FORM_TITLE' => 'Pesquisar',
  'LBL_SIMULATION_MODE' => 'Módulo de simulação - Nenhuma alteracão será feita exceto limpando o Cache',
  'LBL_VISIBLE_IF' => 'Visível Se',
  'LNK_CALL_LIST' => 'Ligações',
  'LNK_EMAIL_LIST' => 'E-mails',
  'LNK_MEETING_LIST' => 'Reuniões',
  'LNK_NEW_CALL' => 'Nova Ligação',
  'LNK_NEW_EMAIL' => 'Arquivar E-mail',
  'LNK_NEW_MEETING' => 'Nova Reunião',
  'LNK_NEW_NOTE' => 'Nova Nota ou Anexo',
  'LNK_NEW_TASK' => 'Nova Tarefa',
  'LNK_NOTE_LIST' => 'Notas ou Anexos',
  'LNK_REPAIR_CUSTOM_FIELD' => 'Reparar Campos Personalizados',
  'LNK_SELECT_CUSTOM_FIELD' => 'Selecionar Campo Personalizado',
  'LNK_TASK_LIST' => 'Tarefas',
  'MSG_DELETE_CONFIRM' => 'Tem a certeza que pretende eliminar este item?',
  'POPUP_EDIT_HEADER_TITLE' => 'Editar Campo Personalizado',
  'POPUP_INSERT_HEADER_TITLE' => 'Adicionar Campo Personalizado',
);

