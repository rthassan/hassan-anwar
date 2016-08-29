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
  'ERR_DELETE_RECORD' => 'Der skal angives et postnummer for at slette kundeemnet.',
  'LBL_ACCOUNT_DESCRIPTION' => 'Virksomhedsbeskrivelse',
  'LBL_ACCOUNT_ID' => 'Virksomheds-id',
  'LBL_ACCOUNT_NAME' => 'Virksomhedsnavn:',
  'LBL_ACTIVITIES_COPY' => 'Kopier aktiviteter til',
  'LBL_ACTIVITIES_COPY_HELP' => 'Vælg den/de post(er) for hvilke det ønskes at lave kopier af kundeemnets aktiviteter. Nye opgaver, opkald, møder og noter vil blive oprettet for hver af de valgte poster. E-mails vil blive relateret til de valgte poster.',
  'LBL_ACTIVITIES_MOVE' => 'Flyt aktiviteter til',
  'LBL_ACTIVITIES_MOVE_HELP' => 'Vælg den post hvor kundeemnets aktiviteter skal flyttes til. Opgaver, opkald, møder, noter og e-mails bliver flyttet til den/de valgte post(er).',
  'LBL_ACTIVITIES_SUBPANEL_TITLE' => 'Aktiviteter',
  'LBL_ADDRESS_INFORMATION' => 'Adresseoplysninger',
  'LBL_ADD_BUSINESSCARD' => 'Tilføj visitkort',
  'LBL_ALTERNATE_ADDRESS' => 'Anden adresse:',
  'LBL_ALT_ADDRESS_CITY' => 'Alternativ adresse, by',
  'LBL_ALT_ADDRESS_COUNTRY' => 'Alternativ adresse, land',
  'LBL_ALT_ADDRESS_POSTALCODE' => 'Alternativ adresse, postnummer',
  'LBL_ALT_ADDRESS_STATE' => 'Alternativ adresse, stat',
  'LBL_ALT_ADDRESS_STREET' => 'Alternativ adresse, gade',
  'LBL_ALT_ADDRESS_STREET_2' => 'Alternativ adresse, gade 2:',
  'LBL_ALT_ADDRESS_STREET_3' => 'Alternativ adresse, gade 3:',
  'LBL_ANY_ADDRESS' => 'Adresse:',
  'LBL_ANY_EMAIL' => 'E-mail:',
  'LBL_ANY_PHONE' => 'Telefon:',
  'LBL_ASSIGNED_TO_ID' => 'Tildelt bruger:',
  'LBL_ASSIGNED_TO_NAME' => 'Tildelt til',
  'LBL_ASSISTANT' => 'Assistent',
  'LBL_ASSISTANT_PHONE' => 'Assistents telefon',
  'LBL_BACKTOLEADS' => 'Tilbage til kundeemner',
  'LBL_BIRTHDATE' => 'Fødselsdato:',
  'LBL_BUSINESSCARD' => 'Konverter Kundeemne',
  'LBL_CAMPAIGN' => 'Kampagne:',
  'LBL_CAMPAIGNS' => 'Kampagner',
  'LBL_CAMPAIGNS_SUBPANEL_TITLE' => 'Kampagner',
  'LBL_CAMPAIGN_ID' => 'Kampagne-id',
  'LBL_CAMPAIGN_LEAD' => 'Kampagner',
  'LBL_CAMPAIGN_LIST_SUBPANEL_TITLE' => 'Kampagner',
  'LBL_CITY' => 'By:',
  'LBL_CLICK_TO_RETURN' => 'Retur til portal',
  'LBL_CONTACT' => 'Kundeemne:',
  'LBL_CONTACT_ID' => 'Kontakt-id:',
  'LBL_CONTACT_INFORMATION' => 'Oplysninger om kundeemne',
  'LBL_CONTACT_NAME' => 'Kundeemnets navn:',
  'LBL_CONTACT_OPP_FORM_TITLE' => 'Kundeemne-salgsmulighed:',
  'LBL_CONTACT_ROLE' => 'Rolle:',
  'LBL_CONVERTED' => 'Konverteret',
  'LBL_CONVERTED_ACCOUNT' => 'Konverteret virksomhed:',
  'LBL_CONVERTED_CONTACT' => 'Konverteret kontakt:',
  'LBL_CONVERTED_OPP' => 'Konverteret salgsmulighed:',
  'LBL_CONVERTLEAD' => 'Konverter kundeemne',
  'LBL_CONVERTLEAD_BUTTON_KEY' => 'V',
  'LBL_CONVERTLEAD_ERROR' => 'Kunne ikke konvertere Leadet',
  'LBL_CONVERTLEAD_FILE_WARN' => 'Du har med succes konverteret Leadet {{leadName}}, men der var et problem at uploade vedhæftede filer på en eller flere poster',
  'LBL_CONVERTLEAD_SUCCESS' => 'Du har med succes konverteret Leadet {{leadName}}',
  'LBL_CONVERTLEAD_TITLE' => 'Konverter kundeemne [Alt+V]',
  'LBL_CONVERTLEAD_WARNING' => 'Advarsel: Status på kundeemnet som du er ved at konvertere er "konverteret". Kontakt og/eller virksomheden er muligvis allerede oprettet fra kundeemnet. Hvis du ønsker at fortsætte med konverteringen, tryk Gem. For at gå tilbage til kundeemnet uden at konvertere, tryk Annullere.',
  'LBL_CONVERTLEAD_WARNING_INTO_RECORD' => 'Mulig kontakt:',
  'LBL_CONVERT_ACCESS_DENIED' => 'Du mangler redigering adgang til de moduler, der kræves for at konvertere et lead: {{requiredModulesMissing}}',
  'LBL_CONVERT_ADD_MODULE' => 'Tilføj modul',
  'LBL_CONVERT_ASSOCIATED_MODULE' => 'Tilknyttet {{moduleName}}',
  'LBL_CONVERT_ASSOCIATE_MODULE' => 'Tilknyttet {{moduleName}}',
  'LBL_CONVERT_BACK_TO_DUPLICATES' => 'Tilbage til dubletter',
  'LBL_CONVERT_BUTTON_LABEL' => 'Konverter',
  'LBL_CONVERT_COPY' => 'Kopier data',
  'LBL_CONVERT_CREATE_NEW' => 'Ny {{moduleName}}',
  'LBL_CONVERT_DELETE' => 'Slet',
  'LBL_CONVERT_DUPLICATES_FOUND' => '{{duplikateksemplar}} dubletter fundet',
  'LBL_CONVERT_EDIT' => 'Rediger',
  'LBL_CONVERT_EDIT_LAYOUT' => 'Rediger konverter layout',
  'LBL_CONVERT_FINDING_DUPLICATES' => 'Søger efter dubletter...',
  'LBL_CONVERT_IGNORE_DUPLICATES' => 'Ignorer og skabe ny',
  'LBL_CONVERT_MODULE_ASSOCIATED' => '{{moduleName}} Tilknyttet',
  'LBL_CONVERT_MODULE_ASSOCIATED_NEW_SUCCESS' => 'Du har forbundet {{moduleNameLower}} {{rekord Name}} men det vil ikke blive oprettet indtil du har afsluttet og gemt.',
  'LBL_CONVERT_MODULE_ASSOCIATED_SUCCESS' => 'Du forbandt {{moduleNameLower}} {{recordName}} men det vil ikke være knyttet indtil du er færdig og gemme.',
  'LBL_CONVERT_MODULE_NAME' => 'Modul',
  'LBL_CONVERT_MODULE_NAME_SINGULAR' => 'Modul',
  'LBL_CONVERT_PANEL_OPTIONAL' => '(valgfrit)',
  'LBL_CONVERT_REQUIRED' => 'Obligatorisk',
  'LBL_CONVERT_RESET_PANEL' => 'Nulstille',
  'LBL_CONVERT_SELECT' => 'Tillad valg',
  'LBL_CONVERT_SWITCH_TO_CREATE' => 'Opret ny',
  'LBL_CONVERT_SWITCH_TO_SEARCH' => 'Søg',
  'LBL_COPY_TIP' => 'Hvis markeret, vil felter fra kundeemnet blive kopieret til felter med samme navn i de nyoprettede poster.',
  'LBL_COUNTRY' => 'Land:',
  'LBL_CREATE' => 'Opret',
  'LBL_CREATED' => 'Oprettet af',
  'LBL_CREATED_ACCOUNT' => 'Oprettet en ny virksomhed',
  'LBL_CREATED_CALL' => 'Oprettet et nyt opkald',
  'LBL_CREATED_CONTACT' => 'Oprettet en ny kontakt',
  'LBL_CREATED_ID' => 'Oprettet af id',
  'LBL_CREATED_MEETING' => 'Oprettet et nyt møde',
  'LBL_CREATED_NEW' => 'Opret ny',
  'LBL_CREATED_OPPORTUNITY' => 'Oprettet en ny salgsmulighed',
  'LBL_CREATED_USER' => 'Oprettet bruger',
  'LBL_DEFAULT_SUBPANEL_TITLE' => 'Kundeemner',
  'LBL_DELETE_TIP' => 'Fjern dette modul fra konverter layout.',
  'LBL_DEPARTMENT' => 'Afdeling:',
  'LBL_DESCRIPTION' => 'Beskrivelse:',
  'LBL_DESCRIPTION_INFORMATION' => 'Beskrivelsesoplysninger',
  'LBL_DNB_BAL_PREVIEW' => 'Leads visning',
  'LBL_DNB_BAL_RSLT_CNT' => 'Leads',
  'LBL_DNB_BAL_RSLT_HEADER' => 'D&B: Lead information',
  'LBL_DNB_PRINCIPAL_ID' => 'D&B Principal Id',
  'LBL_DO_NOT_CALL' => 'Ring ikke:',
  'LBL_DUPLICATE' => 'Lignende kundeemner',
  'LBL_EDITLAYOUT' => 'Rediger layout',
  'LBL_EDIT_INLINE' => 'Rediger',
  'LBL_EDIT_TIP' => 'Ændre konverter layout for dette modul.',
  'LBL_EMAIL_ADDRESS' => 'E-mail-adresse:',
  'LBL_EMAIL_OPT_OUT' => 'Fravælg e-mail:',
  'LBL_ENTERDATE' => 'Indtast dato',
  'LBL_EXISTING_ACCOUNT' => 'Brugt en eksisterende virksomhed',
  'LBL_EXISTING_CONTACT' => 'Brugt en eksisterende kontakt',
  'LBL_EXISTING_OPPORTUNITY' => 'Brugt en eksisterende salgsmulighed',
  'LBL_EXPORT_ASSIGNED_USER_ID' => 'Tildelt bruger-id',
  'LBL_EXPORT_ASSIGNED_USER_NAME' => 'Tildelt brugernavn',
  'LBL_EXPORT_CREATED_BY' => 'Oprettet af id',
  'LBL_EXPORT_EMAIL2' => 'Anden e-mail adresse',
  'LBL_EXPORT_MODIFIED_USER_ID' => 'Ændret af id',
  'LBL_EXPORT_PHONE_MOBILE' => 'Mobiltelefon',
  'LBL_FAX_PHONE' => 'Fax:',
  'LBL_FILTER_LEADS_REPORTS' => 'Lead rapporter',
  'LBL_FIRST_NAME' => 'Fornavn:',
  'LBL_FULL_NAME' => 'Fulde navn:',
  'LBL_HELP_CONVERT' => 'Sugar giver dig mulighed for at konvertere {{plural_module_name}} til {{contacts_module}}, {{accounts_module}}, og andre moduler, når {{MODULE_NAME}} opfylder dine kvalifikationskriterier. Gå trinvist gennem de enkelte moduler ved at ændre felter derefter bekræfter den nye posts værdier ved at klikke på hvert associeret knap. Hvis Sugar registrerer en eksisterende post, der matcher din {{MODULE_NAME}}s oplysninger, har du mulighed for at vælge en kopi, og bekræft valget med Associate knappen eller for at klikke på "Ignorer og skabe nye" og fortsætte normalt. Efter bekræftelse hver enkelt påkrævet, og ønskede modul, skal du klikke på Gem og Konverter knappen øverst til at færdiggøre konverteringen.',
  'LBL_HELP_CONVERT_TITLE' => 'Konverter en {{MODULE_NAME}}',
  'LBL_HELP_CREATE' => 'Den {{plural_module_name}} modul består af individuelle udsigter, der kan være interesseret i et produkt eller service din organisation tilbyder. Når {{MODULE_NAME}} er kvalificeret som en salgs {{opportunities_singular_module}}, kan det blive konverteret til en {{contacts_singular_module}}, {{accounts_singular_module}}, {{opportunities_singular_module}} eller anden post. For at oprette en {{MODULE_NAME}}:. 1. Give værdier for felterne som ønsket. - Felter mærket "Required" skal være afsluttet, før du gemmer. - Klik på "Vis mere" for at eksponere yderligere felter, hvis det er nødvendigt. 2.. Klik på "Gem" for at færdiggøre den nye post og vende tilbage til den forrige side. - Vælg "Gem og se" for at åbne den nye {{MODULE_NAME}} på liste visning. - Vælg "Gem og skabe nye" til straks at oprette et nyt {{MODULE_NAME}}.',
  'LBL_HELP_RECORD' => 'Den {{plural_module_name}} modul består af individuelle udsigter, der kan være interesseret i et produkt eller service din organisation tilbyder. - Rediger denne posts felter ved at klikke på et enkelt felt eller på knappen Rediger. - Se eller ændre links til andre poster i underpanelet ved at skifte den nederste venstre rude til "Data View". - Skab og vis brugernes kommentarer og post ændring historie i {{activitystream_singular_module}} ved at skifte det nederste venstre rude til "Activity Stream". - Følg eller favorit denne post med ikonerne til højre for posten navn. - Yderligere handlinger er tilgængelige i dropdown menuen Handlinger til højre for knappen Rediger.',
  'LBL_HELP_RECORDS' => 'Den {{plural_module_name}} modul består af individuelle udsigter, der kan være interesseret i et produkt eller service din organisation giver. Når {{module_name}}  kvalificere som et salg {{opportunities_singular_module}}, {{plural_module_name}} blive konverteret til {{contacts_module}}, {{opportunities_module}} og {{accounts_module}}. Der er forskellige måder, du kan oprette {{plural_module_name}} i Sugar som et eksempel via  {{plural_module_name}}  modul, duplikering, import {{plural_module_name}} osv. Når  {{module_name}} post er oprettet, kan du se og redigere information relateret til {{module_name}}  af {{plural_module_name}}  listevisning.',
  'LBL_HISTORY_SUBPANEL_TITLE' => 'Historik',
  'LBL_HOME_PHONE' => 'Telefon "privat":',
  'LBL_IMPORT_VCARD' => 'Importér vCard',
  'LBL_IMPORT_VCARDTEXT' => 'Opret automatisk et nyt kundeemne ved at importere et vCard fra filsystemet.',
  'LBL_IMPORT_VCARD_SUCCESS' => 'Lead fra vCard blev oprettet med succes',
  'LBL_INVALID_EMAIL' => 'Ugyldig e-mail:',
  'LBL_INVITEE' => 'Direkte rapporter',
  'LBL_LAST_NAME' => 'Efternavn:',
  'LBL_LEAD_SOURCE' => 'Kilde til kundeemne:',
  'LBL_LEAD_SOURCE_DESCRIPTION' => 'Beskrivelse af kilde til kundeemne:',
  'LBL_LIST_ACCEPT_STATUS' => 'Acceptér status',
  'LBL_LIST_ACCOUNT_NAME' => 'Virksomhedsnavn',
  'LBL_LIST_ASSIGNED_TO_NAME' => 'Tildelt bruger',
  'LBL_LIST_CONTACT_NAME' => 'Kundeemnes navn',
  'LBL_LIST_CONTACT_ROLE' => 'Rolle',
  'LBL_LIST_DATE_ENTERED' => 'Oprettet den',
  'LBL_LIST_EMAIL_ADDRESS' => 'E-mail',
  'LBL_LIST_FIRST_NAME' => 'Fornavn',
  'LBL_LIST_FORM_TITLE' => 'Kundeemneliste',
  'LBL_LIST_LAST_NAME' => 'Efternavn',
  'LBL_LIST_LEAD_SOURCE' => 'Kilde til kundeemne',
  'LBL_LIST_LEAD_SOURCE_DESCRIPTION' => 'Beskrivelse af kilde til kundeemne',
  'LBL_LIST_MY_LEADS' => 'Mine kundeemner',
  'LBL_LIST_NAME' => 'Navn',
  'LBL_LIST_PHONE' => 'Telefon "arbejde"',
  'LBL_LIST_REFERED_BY' => 'Henvist af',
  'LBL_LIST_STATUS' => 'Status',
  'LBL_LIST_TITLE' => 'Titel',
  'LBL_LOADING' => 'Indlæser ...',
  'LBL_MESSAGE' => 'Angiv dine oplysninger nedenfor. Oplysninger og/eller en virksomhed oprettes og afventer din godkendelse.',
  'LBL_MKTO_ID' => 'Marketo Lead ID',
  'LBL_MKTO_LEAD_SCORE' => 'Lead Resultat',
  'LBL_MKTO_SYNC' => 'Synkroniser til Marketo®',
  'LBL_MOBILE_PHONE' => 'Mobiltelefon:',
  'LBL_MODIFIED' => 'Ændret af',
  'LBL_MODIFIED_ID' => 'Ændret af id',
  'LBL_MODIFIED_USER' => 'Ændret bruger',
  'LBL_MODULE_NAME' => 'Kundeemner',
  'LBL_MODULE_NAME_SINGULAR' => 'Tilbud produkter',
  'LBL_MODULE_TIP' => 'Modulet til at oprette en ny post i.',
  'LBL_MODULE_TITLE' => 'Kundeemner: Startside',
  'LBL_NAME' => 'Navn:',
  'LBL_NEW_FORM_TITLE' => 'Nyt kundeemne',
  'LBL_NEW_PORTAL_PASSWORD' => 'Ny portaladgangskode:',
  'LBL_NOTES_SUBPANEL_TITLE' => 'Noter',
  'LBL_NOTICE_OLD_LEAD_CONVERT_OVERRIDE' => 'Bemærk: Det viste konverter kundeemne skærmbillede indeholder tilpassede felter. Når du tilpasser konverter kundeemne skærmbilledet i Studio første gang, skal du tilføje tilpassede felter til layoutet, som nødvendigt. De tilpassede felter vil ikke automatisk blive vist i layoutet, som de gjorde tidligere.',
  'LBL_OFFICE_PHONE' => 'Telefon "arbejde":',
  'LBL_OPPORTUNITIES_SUBPANEL_TITLE' => 'Salgsmuligheder',
  'LBL_OPPORTUNITY_AMOUNT' => 'Salgsmulighedsbeløb:',
  'LBL_OPPORTUNITY_ID' => 'Salgsmuligheds-id',
  'LBL_OPPORTUNITY_NAME' => 'Salgsmuligheds navn:',
  'LBL_OPP_NAME' => 'Salgsmuligheds navn:',
  'LBL_OTHER_EMAIL_ADDRESS' => 'Anden e-mail:',
  'LBL_OTHER_PHONE' => 'Anden telefon:',
  'LBL_PHONE' => 'Telefon:',
  'LBL_PHONE_FAX' => 'Telefax',
  'LBL_PHONE_HOME' => 'Hjemmetelefon',
  'LBL_PHONE_MOBILE' => 'Mobiltelefon',
  'LBL_PHONE_OTHER' => 'Anden telefon',
  'LBL_PHONE_WORK' => 'Arbejdstelefon',
  'LBL_PORTAL_ACTIVE' => 'Portal aktiv:',
  'LBL_PORTAL_APP' => 'Portalprogram:',
  'LBL_PORTAL_INFORMATION' => 'Portaloplysninger',
  'LBL_PORTAL_NAME' => 'Portalnavn:',
  'LBL_PORTAL_PASSWORD_ISSET' => 'Portaladgangskode er angivet:',
  'LBL_POSTAL_CODE' => 'Postnummer:',
  'LBL_PRIMARY_ADDRESS' => 'Primær adresse:',
  'LBL_PRIMARY_ADDRESS_CITY' => 'Primær adresse, by',
  'LBL_PRIMARY_ADDRESS_COUNTRY' => 'Primær adresse, land',
  'LBL_PRIMARY_ADDRESS_POSTALCODE' => 'Primær adresse, postnummer',
  'LBL_PRIMARY_ADDRESS_STATE' => 'Primær adresse, stat',
  'LBL_PRIMARY_ADDRESS_STREET' => 'Primær adresse, gade',
  'LBL_PRIMARY_ADDRESS_STREET_2' => 'Primær adresse, gade 2',
  'LBL_PRIMARY_ADDRESS_STREET_3' => 'Primær adresse, gade 3',
  'LBL_PROSPECT_LIST' => 'Liste over potentielle kunder',
  'LBL_RECORD_SAVED_SUCCESS' => 'Du har med succes skabt den {{moduleSingularLower}} {{fulde navn}}.',
  'LBL_REFERED_BY' => 'Henvist af:',
  'LBL_REGISTRATION' => 'Registrering',
  'LBL_REPORTS_FROM' => 'Rapporter fra:',
  'LBL_REPORTS_TO' => 'Rapporterer til:',
  'LBL_REPORTS_TO_ID' => 'Rapporterer til id:',
  'LBL_REQUIRED_TIP' => 'Nødvendige moduler skal oprettes eller vælges før kundeemnet kan konverteres.',
  'LBL_SALUTATION' => 'Tiltaleform',
  'LBL_SAVED' => 'Tak for din registrering. Din virksomhed oprettes, og en person kontakter dig snarest.',
  'LBL_SAVE_CONVERT_BUTTON_LABEL' => 'Gem og konverter',
  'LBL_SEARCH_FORM_TITLE' => 'Søg efter kundeemne',
  'LBL_SELECT' => 'Vælg',
  'LBL_SELECTION_TIP' => 'Moduler med et relateret felt i kontakter kan vælges i stedet for skabt i løbet af konverter kundeemne processen.',
  'LBL_SELECT_CHECKED_BUTTON_LABEL' => 'Vælg kontrollerede kundeemner',
  'LBL_SELECT_CHECKED_BUTTON_TITLE' => 'Vælg kontrollerede kundeemner',
  'LBL_SERVER_IS_CURRENTLY_UNAVAILABLE' => 'Vi beklager, at serveren er ikke tilgængelig i øjeblikket. Prøv igen senere.',
  'LBL_STATE' => 'Stat:',
  'LBL_STATUS' => 'Status:',
  'LBL_STATUS_DESCRIPTION' => 'Statusbeskrivelse:',
  'LBL_STREET' => 'Gade',
  'LBL_TARGET_BUTTON_KEY' => 'T',
  'LBL_TARGET_BUTTON_LABEL' => 'Målrettet',
  'LBL_TARGET_BUTTON_TITLE' => 'Målrettet',
  'LBL_TARGET_OF_CAMPAIGNS' => 'Succesfuld kampagne:',
  'LBL_THANKS_FOR_SUBMITTING_LEAD' => 'Tak for din indsendelse.',
  'LBL_TITLE' => 'Titel:',
  'LBL_UNCONVERTED' => 'Uomdannede',
  'LBL_VCARD' => 'vCard',
  'LBL_VIEW_FORM_TITLE' => 'Kundeemnevisning',
  'LBL_WEBSITE' => 'Websted',
  'LNK_IMPORT_LEADS' => 'Importér kundeemner',
  'LNK_IMPORT_VCARD' => 'Opret fra vCard',
  'LNK_LEAD_LIST' => 'Kundeemner',
  'LNK_LEAD_REPORTS' => 'Kundeemnerapporter',
  'LNK_NEW_ACCOUNT' => 'Opret virksomhed',
  'LNK_NEW_APPOINTMENT' => 'Opret aftale',
  'LNK_NEW_CALL' => 'Registrér opkald',
  'LNK_NEW_CASE' => 'Opret sag',
  'LNK_NEW_CONTACT' => 'Opret kontakt',
  'LNK_NEW_LEAD' => 'Opret kundeemne',
  'LNK_NEW_MEETING' => 'Planlæg møde',
  'LNK_NEW_NOTE' => 'Opret note',
  'LNK_NEW_OPPORTUNITY' => 'Opret salgsmulighed',
  'LNK_NEW_TASK' => 'Opret opgave',
  'LNK_SELECT_ACCOUNTS' => 'Vælg virksomhed',
  'LNK_SELECT_CONTACTS' => 'ELLER Vælg kontakt',
  'NTC_COPY_ALTERNATE_ADDRESS' => 'Kopiér alternativ adresse til primær adresse',
  'NTC_COPY_PRIMARY_ADDRESS' => 'Kopiér primær adresse til alternativ adresse',
  'NTC_DELETE_CONFIRMATION' => 'Er du sikker på, at du vil slette denne post?',
  'NTC_OPPORTUNITY_REQUIRES_ACCOUNT' => 'Oprettelse af en salgsmulighed kræver en virksomhed.\\n Opret en ny virksomhed, eller vælg en eksisterende.',
  'NTC_REMOVE_CONFIRMATION' => 'Er du sikker på, at du vil fjerne dette kundeemne fra denne sag?',
  'NTC_REMOVE_DIRECT_REPORT_CONFIRMATION' => 'Er du sikker på, at du vil fjerne denne post som en direkte rapport?',
  'TPL_BROWSER_SUGAR7_RECORDS_TITLE' => '{{module}} &raquo; {{appId}}',
  'TPL_BROWSER_SUGAR7_RECORD_TITLE' => '{{#if last_name}}{{#if first_name}}{{first_name}} {{/if}}{{last_name}} &raquo; {{/if}}{{module}} &raquo; {{appId}}',
  'db_account_name' => 'LBL_LIST_ACCOUNT_NAME',
  'db_email1' => 'LBL_LIST_EMAIL_ADDRESS',
  'db_email2' => 'LBL_LIST_EMAIL_ADDRESS',
  'db_first_name' => 'LBL_LIST_FIRST_NAME',
  'db_last_name' => 'LBL_LIST_LAST_NAME',
  'db_title' => 'LBL_LIST_TITLE',
);

