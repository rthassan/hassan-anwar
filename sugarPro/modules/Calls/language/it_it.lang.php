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
  'ERR_DELETE_RECORD' => 'Per eliminare l´azienda è necessario fornire il numero del record.',
  'LBL_ACCEPT_LINK' => 'Accetta Link',
  'LBL_ACCEPT_STATUS' => 'Accetta Stato',
  'LBL_ACCOUNT_NAME' => 'Azienda',
  'LBL_ACTIVITIES_REPORTS' => 'Report Attività',
  'LBL_ADD_BUTTON' => 'Aggiungi',
  'LBL_ADD_INVITEE' => 'Aggiungi Invitati',
  'LBL_ASSIGNED_TO_ID' => 'Assegnato a:',
  'LBL_ASSIGNED_TO_NAME' => 'Assegnato a:',
  'LBL_BLANK' => '-vuoto-',
  'LBL_CALL' => 'Chiamata:',
  'LBL_CALL_INFORMATION' => 'Informazioni Chiamata',
  'LBL_CANCEL_CREATE_INVITEE' => 'Annulla',
  'LBL_COLON' => ':',
  'LBL_CONFIRM_REMOVE_ALL_RECURRENCES' => 'Sei sicuro di voler cancellare tutti i record ricorrenti?',
  'LBL_CONTACTS_SUBPANEL_TITLE' => 'Contatti',
  'LBL_CONTACT_NAME' => 'Contatto:',
  'LBL_CREATE_AND_ADD' => 'Crea & Aggiungi',
  'LBL_CREATE_CONTACT' => 'Come Contatto',
  'LBL_CREATE_INVITEE' => 'Creare un invitato',
  'LBL_CREATE_LEAD' => 'Come Lead',
  'LBL_CREATE_MODULE' => 'Nuova Chiamata',
  'LBL_DATE' => 'Data Inizio:',
  'LBL_DATE_END' => 'Data Fine',
  'LBL_DATE_END_ERROR' => 'La Data di Fine precede la Data di Inizio',
  'LBL_DATE_TIME' => 'Data e Ora Inizio:',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Chiamate',
  'LBL_DEL' => 'Cancella',
  'LBL_DESCRIPTION' => 'Descrizione:',
  'LBL_DESCRIPTION_INFORMATION' => 'Descrizione',
  'LBL_DIRECTION' => 'Direzione',
  'LBL_DURATION' => 'Durata:',
  'LBL_DURATION_HOURS' => 'Durata Ore:',
  'LBL_DURATION_MINUTES' => 'Durata Minuti:',
  'LBL_EDIT_ALL_RECURRENCES' => 'Modifica Tutte le Ricorrenze',
  'LBL_EMAIL' => 'Email',
  'LBL_EMAIL_REMINDER' => 'Email di promemoria',
  'LBL_EMAIL_REMINDER_SENT' => 'Email di promemoria inviati',
  'LBL_EMAIL_REMINDER_TIME' => 'Data di invio email di promemoria',
  'LBL_EMPTY_SEARCH_RESULT' => 'Nessun risultato trovato. Si prega di creare un invitato.',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'ID Utente Assegnato',
  'LBL_EXPORT_CREATED_BY' => 'Creato da ID',
  'LBL_EXPORT_DATE_START' => 'Data e Ora inizio',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Modificato da ID',
  'LBL_EXPORT_PARENT_TYPE' => 'Collegato al Modulo',
  'LBL_EXPORT_REMINDER_TIME' => 'Promemoria (in minuti)',
  'LBL_FIRST_NAME' => 'Nome',
  'LBL_HELP_CREATE' => 'Il modulo {{plural_module_name}} consiste in {{calls_singular_module}} registrate da utenti della tua organizzazione. Le {{plural_module_name}} possono essere in stato "Pianificata", "Effettuata" o "Non Effettuata". Gli utenti Sugar così come i contatti e i lead possono essere aggiunti come invitati.

Per creare una {{calls_singular_module}}:
1. Fornire i valori desiderati per i campi.
    - I campi segnati come "Obbligatorio" devono essere compilati prima del salvataggio.
    - Cliccare "Mostra più Moduli" per visualizzare ulteriori campi se necessario.
2. Aggiungere invitati alla {{calls_singular_module}}.
    - Clicca "Seleziona un invitato" per aggiungere un utente esistente, contatto e lead alla  {{calls_singular_module}}.
    - Clicca l´icona Più a destra del pulsante "Seleziona un invitato" per inserire l´invitato della {{calls_singular_module}} come nuovo record in Sugar.
3. Cliccare "Salva" per finalizzare il nuovo record e tornare alla pagina precedente..
    - Scegliere "Salva e Visualizza" per aprire la nuova {{calls_singular_module}} nella vista record.
    - Scegliere "Salva e crea nuovo" per creare subito una nuova  {{calls_singular_module}}.',
  'LBL_HELP_RECORD' => 'Il modulo {{plural_module_name}} consiste in un record {{calls_singular_module}} registrato dagli utenti della tua organizzazione. Le {{plural_module_name}} possono essere in stato "Pianificata", "Effettuata" o "Non Effettuata. Utenti Sugar così come {{contacts_module}} e {{leads_module}} possono essere aggiunti come invitati.

- Modifica i campi del record cliccando un campo specifico o il pulsante Modifica.
- Visualizza o modifica relazioni ad altri records nel sottopannello modificando il riquadro in basso a sinistra "Visualizza Dati".
- Inserisci e visualizza i commenti e la cronologia delle modifiche nel modulo Activity Stream modificando il riquadro in basso a sinistra in "Activity Stream".
- Segui o segna come preferito questo record utilizzando le icone sulla destra del nome del record.
- Azioni aggiuntive sono disponibili nel menu a tendina Azioni a destra del pulsante Modica.',
  'LBL_HELP_RECORDS' => 'Il modulo {{plural_module_name}} consiste in chiamate registrate che possono essere in stato "Pianificata", "Effettuata", o "Non Effettuata". Le chiamate pianificate nelle prossime 24 ore hanno la data di inizio evidenziata in blu. Le chiamate scadute hanno la data di inizio evidenziata in rosso.

Dalla vista elenco del modulo {{plural_module_name}}, puoi visualizzare e modificare (tramite in-line editing) le informazioni relative ad una chiamata. Azioni aggiuntive sono disponibili nel menu alla fine di ogni riga di Chiamata. Puoi selezionare "Chiudi" dal menu nella riga di ogni chiamata pianificata per marcarla come completata. 

Gli utenti Sugar, i contatti e leads possono essere aggiunti come invitati nelle chiamate. Le {{plural_module_name}} posso essere create dal modulo {{plural_module_name}}, dal modulo Calendario, tramite importazione, così come dal sottopannello Attività  (per i moduli Legacy) o dalla Dashlet Attività Pianificate (per i moduli Sidecar), in record di moduli relazionati (ad es. Contatti, Aziende, etc.), creando automaticamente una relazione tra i due records.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Note',
  'LBL_HOURS_ABBREV' => 'h',
  'LBL_HOURS_MINUTES' => '(ore/minuti)',
  'LBL_INVITEE' => 'Invitati',
  'LBL_LAST_NAME' => 'Cognome',
  'LBL_LEADS_SUBPANEL_TITLE' => 'Lead',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Assegnato a:',
  'LBL_LIST_CLOSE' => 'Chiudi',
  'LBL_LIST_CONTACT' => 'Contatto',
  'LBL_LIST_DATE' => 'Data Inizio',
  'LBL_LIST_DIRECTION' => 'Direzione',
  'LBL_LIST_DURATION' => 'Durata',
  'LBL_LIST_FORM_TITLE' => 'Elenco Chiamate',
  'LBL_LIST_MY_CALLS' => 'Le mie Chiamate',
  'LBL_LIST_RELATED_TO' => 'Relativo a',
  'LBL_LIST_RELATED_TO_ID' => 'Relativo a ID',
  'LBL_LIST_SUBJECT' => 'Oggetto',
  'LBL_LIST_TIME' => 'Ora Inizio',
  'LBL_LOG_CALL' => 'Nuova Chiamata',
  'LBL_MEMBER_OF' => 'Membro di',
  'LBL_MINSS_ABBREV' => 'm',
  'LBL_MODULE_NAME' => 'Chiamate',
  'LBL_MODULE_NAME_SINGULAR' => 'Chiamata',
  'LBL_MODULE_TITLE' => 'Chiamate: Home',
  'LBL_MY_SCHEDULED_CALLS' => 'Le mie Chiamate Pianificate',
  'LBL_NAME' => 'Nome',
  'LBL_NEW_FORM_TITLE' => 'Nuovo Appuntamento',
  'LBL_NO_ACCESS' => 'Non hai i permessi di creare $module',
  'LBL_OUTLOOK_ID' => 'ID Outlook',
  'LBL_PARENT_ID' => 'ID Padre:',
  'LBL_PHONE' => 'Telefono',
  'LBL_POPUP_REMINDER_TIME' => 'Orario Promemoria Popup',
  'LBL_RECORD_SAVED_ACCESS_DENIED' => 'Hai schedulato {{moduleSingularLower}} per {{formatDate date_start}}, ma non hai i permessi di accesso.',
  'LBL_RECORD_SAVED_SUCCESS' => 'Hai schedulato {{moduleSingularLower}} <a href="#{{buildRoute model=this}}">{{name}}</a> per {{formatDate date_start}}.',
  'LBL_RECURRENCE' => 'Ricorrenza',
  'LBL_RECURRING_LIMIT_ERROR' => 'Questa chiamata ricorrente non può essere schedulata perchè supera il $limite di ricorrenza massima consentita.',
  'LBL_RECURRING_SOURCE' => 'Fonte Ricorrente',
  'LBL_RELATED_RECORD_DEFAULT_NAME' => 'Chiamata con {{{this}}}',
  'LBL_RELATED_TO' => 'Relativo a:',
  'LBL_REMINDER' => 'Promemoria:',
  'LBL_REMINDER_EMAIL' => 'Email',
  'LBL_REMINDER_EMAIL_ALL_INVITEES' => 'Email a tutti gli invitati',
  'LBL_REMINDER_POPUP' => 'Popup',
  'LBL_REMINDER_TIME' => 'Tempo di Avviso',
  'LBL_REMINDER_TITLE' => 'Chiamata:',
  'LBL_REMOVE' => 'Canc',
  'LBL_REMOVE_ALL_RECURRENCES' => 'Cancella Tutte le Ricorrenze',
  'LBL_REPEAT_COUNT' => 'Ripetere Conteggio',
  'LBL_REPEAT_DOW' => 'Ripetere Dow',
  'LBL_REPEAT_END' => 'Fine',
  'LBL_REPEAT_END_AFTER' => 'Dopo',
  'LBL_REPEAT_END_BY' => 'Da',
  'LBL_REPEAT_INTERVAL' => 'Ripetere Intervallo',
  'LBL_REPEAT_OCCURRENCES' => 'ricorrenze',
  'LBL_REPEAT_PARENT_ID' => 'Ripetere ID Parent',
  'LBL_REPEAT_TYPE' => 'Tipo',
  'LBL_REPEAT_UNTIL' => 'Ripetere Fino',
  'LBL_REVENUELINEITEMS' => 'Elementi dell´Opportunità',
  'LBL_SCHEDULING_FORM_TITLE' => 'Gestione degli Invitati',
  'LBL_SEARCH_BUTTON' => 'Cerca',
  'LBL_SEARCH_FORM_TITLE' => 'Cerca Chiamata',
  'LBL_SELECT_FROM_DROPDOWN' => 'Si prega prima di selezionare una voce dalla lista dropdown di Collegato a',
  'LBL_SEND_BUTTON_KEY' => 'I',
  'LBL_SEND_BUTTON_LABEL' => 'Invia Inviti',
  'LBL_SEND_BUTTON_TITLE' => 'Invia Inviti [Alt+I]',
  'LBL_SEND_INVITES' => 'Invia Inviti',
  'LBL_STATUS' => 'Stato:',
  'LBL_SUBJECT' => 'Oggetto:',
  'LBL_SYNCED_RECURRING_MSG' => 'Questa telefonata è stata originata in un altro sistema e sincronizzata in Sugar. Per effettuare delle modifiche, si prega di andare nella telefonata originale all´interno dell´altro sistema. Le modifiche fatte nell´altro sistema potranno essere sincronizzate con questo record di Sugar.',
  'LBL_TIME' => 'Ora Inizio:',
  'LBL_TIME_END' => 'Ora Fine',
  'LBL_USERS_SUBPANEL_TITLE' => 'Utenti',
  'LNK_CALL_LIST' => 'Visualizza Chiamate',
  'LNK_IMPORT_CALLS' => 'Importa Chiamate',
  'LNK_NEW_ACCOUNT' => 'Nuova Azienda',
  'LNK_NEW_APPOINTMENT' => 'Nuovo Appuntamento',
  'LNK_NEW_CALL' => 'Nuova Chiamata',
  'LNK_NEW_MEETING' => 'Nuova Riunione',
  'LNK_NEW_OPPORTUNITY' => 'Nuova Opportunità',
  'LNK_SELECT_ACCOUNT' => 'Seleziona Azienda',
  'NOTICE_DURATION_TIME' => 'La durata deve essere superiore a 0',
  'NTC_REMOVE_INVITEE' => 'Sei sicuro di voler togliere questo invitato dalla chiamata?',
  'TPL_CALL_STATUS_CHANGED' => 'Chiamate impostate come {{status}}.',
);
