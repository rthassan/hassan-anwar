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
  'ERR_DELETE_EMPTY' => 'Registreringen er allerede slettet eller ikke-eksisterende',
  'ERR_DELETE_RECORD' => 'Der skal angives et liste nummer for at slette produktet.',
  'LBL_ALERT_TEMPLATES' => 'Beskedskabeloner',
  'LBL_APOSTROPHE_S' => 's',
  'LBL_COMPARE_ANY_TIME_PART2' => 'ændres ikke for',
  'LBL_COMPARE_ANY_TIME_PART3' => 'bestemt tidsrum',
  'LBL_COMPARE_ANY_TIME_TITLE' => 'Felt ændres ikke for et bestemt tidsrum',
  'LBL_COMPARE_CHANGE_PART' => 'ændres',
  'LBL_COMPARE_CHANGE_TITLE' => 'Når et felt i målgruppemodulet ændres',
  'LBL_COMPARE_COUNT_TITLE' => 'Udløser om bestemt antal',
  'LBL_COMPARE_SPECIFIC_PART' => 'ændres til eller fra en bestemt værdi',
  'LBL_COMPARE_SPECIFIC_PART_TIME' => ' ',
  'LBL_COMPARE_SPECIFIC_TITLE' => 'Når et felt i målgruppemodulet ændres til eller fra en bestemt værdi',
  'LBL_COUNT_TRIGGER1' => 'I alt',
  'LBL_COUNT_TRIGGER1_2' => 'sammenlignes med dette beløb',
  'LBL_COUNT_TRIGGER2' => 'filtrer efter relaterede',
  'LBL_COUNT_TRIGGER2_2' => 'kun',
  'LBL_COUNT_TRIGGER3' => 'filter specifikt efter',
  'LBL_COUNT_TRIGGER4' => 'filtrer efter en anden',
  'LBL_EVAL' => 'Udløserevaluering:',
  'LBL_FIELD' => 'felt',
  'LBL_FILTER_FIELD_PART1' => 'Filtrer efter',
  'LBL_FILTER_FIELD_TITLE' => 'Når et felt i målgruppemodulet indeholder en bestemt værdi',
  'LBL_FILTER_FORM_TITLE' => 'Definer en arbejdsgangbetingelse',
  'LBL_FILTER_LIST_STATEMEMT' => 'Filtrer objekter baseret på følgende:',
  'LBL_FILTER_REL_FIELD_PART1' => 'Angiv relaterede',
  'LBL_FILTER_REL_FIELD_TITLE' => 'Når målgruppemodulet ændres, og et felt i et relateret modul indeholder en bestemt værdi',
  'LBL_FUTURE_TRIGGER' => 'Angiv ny',
  'LBL_LIST_EVAL' => 'Eval.:',
  'LBL_LIST_FIELD' => 'Felt:',
  'LBL_LIST_FORM_TITLE' => 'Udløserliste',
  'LBL_LIST_FRAME_PRI' => 'Udløser:',
  'LBL_LIST_FRAME_SEC' => 'Filter:',
  'LBL_LIST_NAME' => 'Beskrivelse:',
  'LBL_LIST_STATEMEMT' => 'Udløs en hændelse baseret på følgende:',
  'LBL_LIST_TYPE' => 'Type:',
  'LBL_LIST_VALUE' => 'Værdi:',
  'LBL_MODULE' => 'modul',
  'LBL_MODULE_NAME' => 'Betingelser',
  'LBL_MODULE_NAME_SINGULAR' => 'Betingelse',
  'LBL_MODULE_SECTION_TITLE' => 'Når disse betingelser er opfyldt',
  'LBL_MODULE_TITLE' => 'Arbejdsgangudløsere: Startside',
  'LBL_MUST_SELECT_VALUE' => 'Du skal vælge en værdi til dette felt',
  'LBL_NAME' => 'Udløsernavn:',
  'LBL_NEW_FILTER_BUTTON_KEY' => 'F',
  'LBL_NEW_FILTER_BUTTON_LABEL' => 'Opret filter',
  'LBL_NEW_FILTER_BUTTON_TITLE' => 'Opret filter [Alt+F]',
  'LBL_NEW_FORM_TITLE' => 'Opret udløser',
  'LBL_NEW_TRIGGER_BUTTON_KEY' => 'T',
  'LBL_NEW_TRIGGER_BUTTON_LABEL' => 'Opret udløser',
  'LBL_NEW_TRIGGER_BUTTON_TITLE' => 'Opret udløser [Alt+T]',
  'LBL_PAST_TRIGGER' => 'Angiv gammel',
  'LBL_RECORD' => 'modulets',
  'LBL_SEARCH_FORM_TITLE' => 'Søg efter arbejdsgangudløser',
  'LBL_SELECT_1ST_FILTER' => 'Du skal vælge et gyldigt 1. filter-felt',
  'LBL_SELECT_2ND_FILTER' => 'Du skal vælge et gyldigt 2. filter-felt',
  'LBL_SELECT_AMOUNT' => 'Du skal vælge beløbet',
  'LBL_SELECT_OPTION' => 'Vælg en indstilling.',
  'LBL_SELECT_TARGET_FIELD' => 'Vælg et målgruppefelt.',
  'LBL_SELECT_TARGET_MOD' => 'Vælg et målgrupperelateret modul.',
  'LBL_SHOW' => 'Vis',
  'LBL_SHOW_PAST' => 'Rediger tidligere værdi:',
  'LBL_SPECIFIC_FIELD' => 's specifikke felt',
  'LBL_SPECIFIC_FIELD_LNK' => 'specifikt felt',
  'LBL_TRIGGER' => 'Hvornår',
  'LBL_TRIGGER_FILTER_TITLE' => 'Udløserfiltre',
  'LBL_TRIGGER_FORM_TITLE' => 'Definer betingelse for udførelse af arbejdsgang',
  'LBL_TRIGGER_RECORD_CHANGE_TITLE' => 'Når målgruppemodulet ændres',
  'LBL_TYPE' => 'Type:',
  'LBL_VALUE' => 'værdi',
  'LBL_WHEN_VALUE1' => 'Når værdien af feltet er',
  'LBL_WHEN_VALUE2' => 'Når værdien af',
  'LNK_NEW_TRIGGER' => 'Opret udløser',
  'LNK_NEW_WORKFLOW' => 'Opret arbejdsgang',
  'LNK_TRIGGER' => 'Arbejdsgangudløsere',
  'LNK_WORKFLOW' => 'Arbejdsgangobjekter',
  'NTC_REMOVE_TRIGGER' => 'Er du sikker på, at du vil fjerne denne udløser?',
  'NTC_REMOVE_TRIGGER_PRIMARY' => 'Fjernelse af en primær trigger vil fjerne alle triggers.',
);

