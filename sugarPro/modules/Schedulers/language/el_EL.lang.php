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
  'ERR_CRON_SYNTAX' => 'Μη έγκυρο Cron σύνταξης',
  'ERR_DELETE_RECORD' => 'Πρέπει να προσδιορίσετε αριθμό εγγραφής για να διαγράψετε το χρονοδιάγραμμα.',
  'LBL_ADV_OPTIONS' => 'Σύνθετες Επιλογές',
  'LBL_ALL' => 'Κάθε Μέρα',
  'LBL_ALWAYS' => 'Πάντα',
  'LBL_AND' => 'και',
  'LBL_ASYNCMASSUPDATE' => 'Εκτέλεση Ασύγχρονων Μαζικών Ενημερώσεων',
  'LBL_AT' => 'στις',
  'LBL_AT_THE' => 'Κατά την',
  'LBL_BASIC_OPTIONS' => 'Βασική Εγκατάσταση',
  'LBL_CATCH_UP' => 'Εκτέλεση Αν Λείπει',
  'LBL_CATCH_UP_WARNING' => 'Απο-ελέγξετε, αν αυτή η εργασία μπορεί να διαρκέσει περισσότερο από ένα λεπτό για να τρέξει.',
  'LBL_CLEANJOBQUEUE' => '<b>Εκκαθάριση Εργασιών Ουράς Αναμονής</b>',
  'LBL_CLEANOLDRECORDLISTS' => 'Εκκαθάριση Λιστών Παλαιών Εγγραφών',
  'LBL_CRONTAB_EXAMPLES' => 'Το παραπάνω χρησιμοποιεί πρότυπο σημείωσης crontab.',
  'LBL_CRONTAB_SERVER_TIME_POST' => '). Παρακαλώ προσδιορίστε αναλόγως το χρονοδιάγραμμα εκτέλεσης εργασιών.',
  'LBL_CRONTAB_SERVER_TIME_PRE' => 'Οι προδιαγραφές του Cron εκτελούνται με βάση την ζώνη ώρας του διακομιστή (',
  'LBL_CRON_INSTRUCTIONS_LINUX' => 'Για Εγκατάσταση Crontab',
  'LBL_CRON_INSTRUCTIONS_WINDOWS' => 'Εγκατάσταση Χρονοπρογραμματιστή Εργασιών των Windows',
  'LBL_CRON_LINUX_DESC' => 'Σημείωση: Προκειμένου να εκτελέσετε τους Χρονοπρογραμματιστές Εργασιών του Sugar, προσθέστε την ακόλουθη γραμμή στο αρχείο crontab:',
  'LBL_CRON_WINDOWS_DESC' => 'Σημείωση: Προκειμένου να εκτελέσετε τους Χρονοπρογραμματιστές Εργασιών του Sugar, δημιουργήστε μία στίβα αρχείου να εκτελεί, χρησιμοποιώντας στα Windows τους Χρονοπρογραμματιστές Εργασιών. Η στίβα φακέλου πρέπει να περιλαμβάνει τις ακόλουθες εντολές:',
  'LBL_DATE_TIME_END' => 'Ημερομηνία και Ώρα Λήξης',
  'LBL_DATE_TIME_START' => 'Ημερομηνία και Ώρα Έναρξης',
  'LBL_DAY_OF_MONTH' => 'ημερομηνία',
  'LBL_DAY_OF_WEEK' => 'ημέρα',
  'LBL_EVERY' => 'Κάθε',
  'LBL_EVERY_DAY' => 'Κάθε Μέρα',
  'LBL_EXECUTE_TIME' => '<b>Χρόνος Εκτέλεσης</b>',
  'LBL_FRI' => 'Παρασκευή',
  'LBL_FROM' => 'Από',
  'LBL_HOUR' => 'ώρες',
  'LBL_HOURS' => 'ώρ.',
  'LBL_HOUR_SING' => 'ώρα',
  'LBL_IN' => 'σε',
  'LBL_INTERVAL' => 'Διάστημα',
  'LBL_JOB' => 'Εργασία',
  'LBL_JOBS_SUBPANEL_TITLE' => '<b>Σύνδεση Εργασίας</b>',
  'LBL_JOB_URL' => 'URL Εργασίας',
  'LBL_LAST_RUN' => 'Τελευταία Επιτυχής Εκτέλεση',
  'LBL_LIST_EXECUTE_TIME' => 'Θα Εκτελέσει Την:',
  'LBL_LIST_JOB_INTERVAL' => 'Διάστημα:',
  'LBL_LIST_LIST_ORDER' => 'Χρονοπρογραμματιστές εργασιών:',
  'LBL_LIST_NAME' => 'Χρονοπρογραμματιστής εργασιών:',
  'LBL_LIST_RANGE' => 'Εύρος Λίστας:',
  'LBL_LIST_REMOVE' => 'Κατάργηση:',
  'LBL_LIST_STATUS' => 'Κατάσταση',
  'LBL_LIST_TITLE' => 'Λίστα Χρονοπρογραμματισμών:',
  'LBL_MINS' => 'λεπ.',
  'LBL_MINUTES' => 'λεπτά',
  'LBL_MIN_MARK' => 'σήμα λεπτού',
  'LBL_MODULE_NAME' => 'Χρονοπρογραμματιστής εργασιών Sugar',
  'LBL_MODULE_NAME_SINGULAR' => 'Χρονοπρογραμματιστής εργασιών Sugar',
  'LBL_MODULE_TITLE' => 'Χρονοπρογραμματιστές εργασιών',
  'LBL_MON' => 'Δευτέρα',
  'LBL_MONTH' => 'μήνα',
  'LBL_MONTHS' => 'μήν.',
  'LBL_NAME' => 'Όνομα Εργασίας',
  'LBL_NEVER' => 'Ποτέ',
  'LBL_NEW_FORM_TITLE' => 'Νέος Χρονοπρογραμματισμός',
  'LBL_NO_PHP_CLI' => 'Αν ο υπολογιστής σας δεν έχει το PHP δυαδικό διαθέσιμο, μπορείτε να χρησιμοποιήσετε το wget ή curl να ξεκινήσει τις εργασίες σας.  <br />for wget: <b>*    *    *    *    *    wget --quiet --non-verbose http://translate.sugarcrm.com/latest/cron.php > /dev/null 2>&1<b><br />for curl:<b> *    *    *    *    *    curl --silent http://translate.sugarcrm.com/latest/cron.php > /dev/null 2>&1</b>',
  'LBL_OFTEN' => 'Όσο το δυνατόν συχνότερα.',
  'LBL_ON_THE' => 'Στις',
  'LBL_OOTB_BOUNCE' => 'Εκτέλεση Διαδικασίας Νυχτερινών Ακάλυπτων Emails Εκστρατείας',
  'LBL_OOTB_CAMPAIGN' => 'Εκτέλεση Νυχτερινών Μαζικών Emails Εκστρατείας',
  'LBL_OOTB_CLEANUP_QUEUE' => 'Εκκαθάριση Εργασιών Ουράς Αναμονής',
  'LBL_OOTB_CREATE_NEXT_TIMEPERIOD' => 'Δημιουργία Μελλοντικών Χρονικών Περιόδων',
  'LBL_OOTB_HEARTBEAT' => 'Sugar Heartbeat',
  'LBL_OOTB_IE' => 'Έλεγχος Εισερχόμενων Ταχυδρομικών Θυρίδων',
  'LBL_OOTB_PROCESS_AUTHOR_JOB' => 'Διεργασία Συγγραφέα Προγραμματισμένης Εργασίας',
  'LBL_OOTB_PRUNE' => 'Περιορισμός Βάσης Δεδομένων την 1η του Μήνα',
  'LBL_OOTB_PRUNE_RECORDLISTS' => 'Κλαδέψτε Λίστες Παλαιών Εγγραφών',
  'LBL_OOTB_REMOVE_DIAGNOSTIC_FILES' => 'Κατάργηση εργαλείων διαγνωστικών αρχείων',
  'LBL_OOTB_REMOVE_PDF_FILES' => 'Κατάργηση προσωρινών PDF αρχείων',
  'LBL_OOTB_REMOVE_TMP_FILES' => 'Κατάργηση προσωρινών αρχείων',
  'LBL_OOTB_REPORTS' => 'Εκτέλεση Αναφοράς Συστήματος Χρονοπρογραμματισμένων Εργασιών',
  'LBL_OOTB_SEND_EMAIL_REMINDERS' => 'Εκτέλεση Υπενθύμισης Email',
  'LBL_OOTB_TRACKER' => 'Περιορισμός Πινάκων Σημείου Εντοπισμού',
  'LBL_OOTB_WORKFLOW' => 'Καθήκοντα Διεργασιών Ροής Εργασίας',
  'LBL_PERENNIAL' => 'διαρκής',
  'LBL_PERFORMFULLFTSINDEX' => '<b>Πλήρης-κείμενο Αναζήτηση Ευρετηρίου Συστήματος</b>',
  'LBL_PMSEENGINECRON' => 'ProcessMaker Μηχανή',
  'LBL_POLLMONITOREDINBOXES' => '<b>Έλεγχος Εισερχόμενων Λογαριασμών Ταχυδρομείου</b>',
  'LBL_POLLMONITOREDINBOXESFORBOUNCEDCAMPAIGNEMAILS' => '<b>Εκτέλεση Διαδικασίας Νυχτερινών Ακάλυπτων Emails Εκστρατείας</b>',
  'LBL_PROCESSQUEUE' => '<b>Εκτέλεση Αναφοράς Χρονοπρογραμματισμένων Εργασιών</b>',
  'LBL_PROCESSWORKFLOW' => '<b>Διαδικασία Ροής Εργασιών</b>',
  'LBL_PRUNEDATABASE' => '<b>Περιορισμός Βάσης Δεδομένων την 1η του Μήνα</b>',
  'LBL_RANGE' => 'στο',
  'LBL_REFRESHJOBS' => '<b>Ανανέωση Εργασιών</b>',
  'LBL_RUNMASSEMAILCAMPAIGN' => '<b>Εκτέλεση Νυχτερινών Μαζικών Emails Εκστρατείας</b>',
  'LBL_SAT' => 'Σάββατο',
  'LBL_SCHEDULER' => 'Χρονοπρογραμματιστής εργασιών:',
  'LBL_SEARCH_FORM_TITLE' => 'Αναζήτηση Χρονοπρογραμματιστή εργασιών',
  'LBL_SENDEMAILREMINDERS' => '<b>Εκτέλεση Αποστολής Email Υπενθυμίσεων</b>',
  'LBL_STATUS' => 'Κατάσταση',
  'LBL_SUGARJOBCREATENEXTTIMEPERIOD' => 'Δημιουργία Μελλοντικών TimePeriods',
  'LBL_SUGARJOBHEARTBEAT' => 'Sugar Heartbeat',
  'LBL_SUN' => 'Κυριακή',
  'LBL_THU' => 'Πέμπτη',
  'LBL_TIME_FROM' => 'Ενεργή Από',
  'LBL_TIME_TO' => 'Ενεργή Σε',
  'LBL_TOGGLE_ADV' => 'Εμφάνιση Σύνθετων Επιλογών',
  'LBL_TOGGLE_BASIC' => 'Εμφάνιση Βασικών Επιλογών',
  'LBL_TRIMTRACKER' => '<b>Περιορισμός Πινάκων Σημείου Εντοπισμού</b>',
  'LBL_TUE' => 'Τρίτη',
  'LBL_UPDATETRACKERSESSIONS' => '<b>Αναπροσαρμογή Πινάκων Χρόνου Συνεδριών Σημείου Εντοπισμού</b>',
  'LBL_UPDATE_TRACKER_SESSIONS' => 'Αναβάθμιση Πίνακα tracker_sessions',
  'LBL_WARN_CURL' => 'Προειδοποίηση:',
  'LBL_WARN_CURL_TITLE' => 'cURL Προειδοποίηση:',
  'LBL_WARN_NO_CURL' => 'Αυτό το σύστημα δεν έχει το cURL βιβλιοθηκών ενεργοποιημένο/συνταγμένο στην ενότητα PHP (--with-curl=/path/to/curl_library). Παρακαλώ επικοινωνήστε με τον διαχειριστή σας, για να επιλύσετε αυτό το ζήτημα. Χωρίς την λειτουργικότητα cURL, οι Χρονοπρογραμματιστές εργασιών δεν μπορούν να περάσουν να εκτελεστούν.',
  'LBL_WED' => 'Τετάρτη',
  'LNK_LIST_SCHEDULED' => 'Χρονοπρογραμματισμένες Εργασίες',
  'LNK_LIST_SCHEDULER' => 'Χρονοπρογραμματιστές εργασιών',
  'LNK_NEW_SCHEDULER' => 'Δημιουργία Χρονοπρογραμματιστών',
  'NTC_DELETE_CONFIRMATION' => 'Είστε βέβαιοι ότι θέλετε να διαγράψετε αυτή την εγγραφή;',
  'NTC_LIST_ORDER' => 'Προσδιορίστε  την σειρά εμφάνισης του χρονοδιαγράμματος που θα εμφανιστεί στην αναδυόμενη λίστα Χρονοπρογραμματιστής Εργασιών.',
  'NTC_STATUS' => 'Προσδιορίστε την κατάσταση στη θέση Ανενεργή για να καταργήσετε το χρονοδιάγραμμα από την αναδυόμενη λίστα Χρονοπρογραμματιστής Εργασιών.',
  'SOCK_GREETING' => 'Αυτή είναι η διεπαφή για τους Χρονοπρογραμματιστές Υπηρεσιών του SugarCRM. [ Διαθέσιμες εντολές δαίμονα: έναρξη|επανεκκίνηση|κλείσιμο|κατάσταση ] Για να εγκαταλείψετε, πληκτρολογήστε "εγκαταλείπω". Για να κλείσει η υπηρεσία πατήστε "κλείσιμο".',
);
