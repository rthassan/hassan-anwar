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
  'ERR_DELETE_RECORD' => '고객을 삭제하시려면 정확한 자료 고유번호를 입력하셔야합니다.',
  'ERR_EMAIL_INCORRECT' => '새 비밀번호 생성과 전송을 위해서는 유효한 이메일 주소를 입력하십시오',
  'ERR_EMAIL_NOT_SENT_ADMIN' => '시스템이 귀하의 요청을 처리할수 없습니다. 확인해 주십시오',
  'ERR_EMAIL_NO_OPTS' => '수신 이메일을 위한 최적의 설정을 찾지 못했습니다.',
  'ERR_ENTER_CONFIRMATION_PASSWORD' => '비밀번호 확인을 입력하십시오',
  'ERR_ENTER_NEW_PASSWORD' => '새 비밀번호를 입력하십시오',
  'ERR_ENTER_OLD_PASSWORD' => '현재 비밀번호를 입력하십시오',
  'ERR_IE_FAILURE1' => '되돌아가려면 이곳을 클릭하십시오',
  'ERR_IE_FAILURE2' => '이메일 계정 연결에 문제가 있습니다. 설정을 확인하고 다시 시도해 주십시오',
  'ERR_IE_MISSING_REQUIRED' => '수신 이메일설정 필수입력정보가 없습니다. 설정을 확인하고 다시 시도해 주십시오 수신 이메일 설정을 안하려면 그 구역안의 모든 필드를 비우십시오',
  'ERR_INVALID_PASSWORD' => '유효한 사용자명과 비밀번호를 명시해야 합니다',
  'ERR_LAST_ADMIN_1' => '사용자명',
  'ERR_LAST_ADMIN_2' => '관리자에 접속한 마지막 사용자입니다. 최소 한명이상의 사용자는 관리자여야 합니다.',
  'ERR_NO_LOGIN_MOBILE' => '이 어플리케이션에 첫 로그인은 반드시 이동브라우저나',
  'ERR_PASSWORD_CHANGE_FAILED_1' => '사용자 비밀번호 변경 실패',
  'ERR_PASSWORD_CHANGE_FAILED_2' => '실패했습니다. 새 비밀번호가 설정되어야합니다.',
  'ERR_PASSWORD_CHANGE_FAILED_3' => '새 비밀번호가 유효하지 않습니다.',
  'ERR_PASSWORD_INCORRECT_OLD_1' => '사용자의 부정확한 현재 비밀번호',
  'ERR_PASSWORD_INCORRECT_OLD_2' => '비밀버호 정보를 재입력하십시오',
  'ERR_PASSWORD_LINK_EXPIRED' => '귀하의 링크가 만료되었습니다. 새 링크를 만드십시오',
  'ERR_PASSWORD_MISMATCH' => '비밀번호가 일치하지 않습니다.',
  'ERR_PASSWORD_USERNAME_MISSMATCH' => '유효한 사용자명과 이메일 주소를 명시해야 합니다.',
  'ERR_REASS_DIFF_USERS' => '발신 사용자와 다른 수신 사용자를 선택하십시오.',
  'ERR_REASS_SELECT_MODULE' => '돌아가서 최소 하나이상의 모듈을 선택하십시오.',
  'ERR_RECIPIENT_EMAIL' => '수신인 이메일 주소',
  'ERR_REENTER_PASSWORDS' => '새 비밀번호와 확인한 비밀번호가 일치하지 않습니다.',
  'ERR_REPORT_LOOP' => '시스템일 보고 고리를 발견했습니다. 사용자는 본인이나 본인에게 보고하는 매니저에게 보고할수 없습니다.',
  'ERR_RULES_NOT_MET' => '입력한 비밀번호가 요구사항에 맞지 않습니다. 다시 시도해 주십시오',
  'ERR_SERVER_SMTP_EMPTY' => '시스템이 사용자에 이메일을 보낼수 없습니다. 이메일 설정에서 발신 메일 구성을 확인하십시오',
  'ERR_SERVER_STATUS' => '귀하의 서버 상태',
  'ERR_SMTP_URL_SMTP_PORT' => 'SMTP 서버 URL and 포트',
  'ERR_SMTP_USERNAME_SMTP_PASSWORD' => 'SMTP 사용자명과 SMTP 비밀번호',
  'ERR_USER_INFO_NOT_FOUND' => '사용자 정보가 발견되지 않았습니다.',
  'ERR_USER_IS_LOCKED_OUT' => '이 사용자는 Sugar어플리케이션에 들어오지 못하며 기존의 비밀번호를 이용해 접속할수 없습니다.',
  'ERR_USER_NAME_EXISTS_1' => '사용자명',
  'ERR_USER_NAME_EXISTS_2' => '이미 존재합니다. 중복된 사용자명을 허용되지 않습니다. 유일한 사용자명으로 변경하십시오',
  'LBL_ACCOUNT_NAME' => '고객명',
  'LBL_ADDRESS' => '주소',
  'LBL_ADDRESS_CITY' => '도시',
  'LBL_ADDRESS_COUNTRY' => '국가',
  'LBL_ADDRESS_INFORMATION' => '주소정보',
  'LBL_ADDRESS_POSTALCODE' => '우편번호',
  'LBL_ADDRESS_STATE' => '도',
  'LBL_ADDRESS_STREET' => '거리',
  'LBL_ADDRESS_STREET_2' => '거리 주소 2',
  'LBL_ADDRESS_STREET_3' => '거리 주소 3',
  'LBL_ADMIN' => '시스템 관리자',
  'LBL_ADMIN_DESC' => '사용자는 팀보안과 상관없이 관리자 페이지와 모든 기록에 접속할수 있습니다.',
  'LBL_ADMIN_USER' => '시스템 관리자',
  'LBL_ADVANCED' => '고급',
  'LBL_AFFECTED' => '영향을 받음',
  'LBL_ANY_ADDRESS' => '다른 주소:',
  'LBL_ANY_EMAIL' => '다른 이메일:',
  'LBL_ANY_PHONE' => '다른 전화번호:',
  'LBL_APPLY_OPTIMUMS' => '최적의 조적 적용',
  'LBL_ASSIGN_PRIVATE_TEAM' => '(private team on save)',
  'LBL_ASSIGN_TEAM' => '팀에 배정',
  'LBL_ASSIGN_TO_USER' => '사용자에 지정',
  'LBL_AUTHENTICATE_ID' => '인증ID',
  'LBL_BASIC' => '수신 설정',
  'LBL_BUTTON_CREATE' => '새로 만들기',
  'LBL_BUTTON_EDIT' => '편집하기',
  'LBL_CALENDAR_OPTIONS' => '달력 선택항목',
  'LBL_CANCEL' => '취소',
  'LBL_CANNOT_SEND_PASSWORD' => '비밀번호를 보낼수 없습니다.',
  'LBL_CERT' => '증명서 확인',
  'LBL_CERT_DESC' => '메일 서버의 보완 증명서의 확인을 반드시 필요합니다 - 본인 서명시 사용하지 마십시오.',
  'LBL_CHANGE_PASSWORD' => '비밀번호 변경하기',
  'LBL_CHANGE_PASSWORD_TITLE' => '비밀번호:',
  'LBL_CHANGE_SYSTEM_PASSWORD' => '새 비밀번호를 입력하십시오',
  'LBL_CHECKMARK' => '표시확인',
  'LBL_CHOOSE_A_KEY' => '귀하의 달력에 인증되지 않은 발표를 막기위한 키를 선택하십시오',
  'LBL_CHOOSE_EMAIL_PROVIDER' => '이메일 공급자를 선택하십시오.',
  'LBL_CHOOSE_WHICH' => '상위 탐색바에 접속할수 있는 모듈을 선택하십시오. 어떤 모듈이 나타날지 순서를 지정하십시오',
  'LBL_CITY' => '시:',
  'LBL_CLEAR_BUTTON_TITLE' => '비우기',
  'LBL_CONFIRM_PASSWORD' => '비밀번호 확인',
  'LBL_CONFIRM_REGULAR_USER' => '시스템관리자에서 일반 사용자로 유형을 변경했습니다. 이를 저장후 사용자는 더이상 관리자의 특전이 없습니다. 진행하려면 네 버튼을, 기록으로 돌아가려면 취소버튼을 클릭하십시오',
  'LBL_COUNTRY' => '국가:',
  'LBL_CREATED_BY_NAME' => '생성자',
  'LBL_CURRENCY' => '화폐:',
  'LBL_CURRENCY_EXAMPLE' => '화폐진열 예',
  'LBL_CURRENCY_SHOW_PREFERRED' => '선호 통화 보기',
  'LBL_CURRENCY_SHOW_PREFERRED_TEXT' => '목록에서 사용자 선호하는 기본 통화 교환하고 의견을 기록합니다',
  'LBL_CURRENCY_SIG_DIGITS' => '화폐 유효 숫자',
  'LBL_CURRENCY_SIG_DIGITS_DESC' => '화폐의 소수점 숫자 보이기',
  'LBL_CURRENCY_TEXT' => '새 기록 생성시 전시될 화폐를 선택하십시오. 이 화폐는 또한 금액칸과 예비고객 목록보기에도 나타납니다.',
  'LBL_DATE_ENTERED' => '입력 날짜',
  'LBL_DATE_FORMAT' => '날짜 형식',
  'LBL_DATE_FORMAT_TEXT' => '날짜 인지 전시형태를 위한 설정',
  'LBL_DATE_MODIFIED' => '수정일자:',
  'LBL_DECIMAL_SEP' => '소수 기호',
  'LBL_DECIMAL_SEP_TEXT' => '소수점 분리를 위해 사용된 기호',
  'LBL_DEFAULT_PRIMARY_TEAM' => '초기설정 기본 팀',
  'LBL_DEFAULT_SUBPANEL_TITLE' => '사용자',
  'LBL_DEFAULT_TEAM' => '초기설정 팀',
  'LBL_DEFAULT_TEAM_TEXT' => '구성원으로 있는 가능한 팀이 기록의 초기설정으로 나타납니다.',
  'LBL_DELETED' => '삭제 완료',
  'LBL_DELETE_GROUP_CONFIRM' => '이 그룹 사용자를 삭제하시겠습니까? 네를 클릭하면 사용자 기록이 삭제됩니다. 네 클릭후 기록을 지정되었던 그룹 사용자에서 다른 사용자로 재지정할수 있습니다.',
  'LBL_DELETE_PORTAL_CONFIRM' => '이 포탈 API사용자를 삭제하시겠습니까? 사용자 기록을 삭제하려면 네를 클릭하십시오',
  'LBL_DELETE_USER' => '사용자 삭제',
  'LBL_DELETE_USER_CONFIRM' => '사용자 기록이 삭제되었을때 이에 상응하는 직원 기록도 삭제됩니다. 사용자가 삭제된후 작업흐름의 정의나 사용자와 관련된 보고서도 업데이트가 필요할수 있습니다.',
  'LBL_DEPARTMENT' => '부서:',
  'LBL_DESCRIPTION' => '설명:',
  'LBL_DISPLAY_TABS' => '모듈 전시',
  'LBL_DOWNLOADS' => '다운로드',
  'LBL_DST_INSTRUCTIONS' => '일광절약 시간 준수 지정하기',
  'LBL_EAPM_SUBPANEL_TITLE' => '외부 계정',
  'LBL_EDIT' => '편집하기',
  'LBL_EDITLAYOUT' => '지면 배치 편집하기',
  'LBL_EDIT_TABS' => '탐색바를 위한 모듈 선택',
  'LBL_EMAIL' => '이메일 주소:',
  'LBL_EMAILS' => '이메일',
  'LBL_EMAIL_ADDRESS' => '이메일 주소:',
  'LBL_EMAIL_CHARSET' => '발신 문자설정',
  'LBL_EMAIL_EDITOR_OPTION' => '형식 작성하기',
  'LBL_EMAIL_GMAIL_DEFAULTS' => 'Prefill Gmail™ 초기설정',
  'LBL_EMAIL_INBOUND_TITLE' => '수신 이메일 설정',
  'LBL_EMAIL_LINK_TYPE' => '이메일 고객',
  'LBL_EMAIL_LINK_TYPE_HELP' => 'Sugar 메일 고객:Sugar 어플리케이션에서 이메일 고객을 사용해 이메일 전송<br />외부 메일 고객: Microsoft Outlook 같은 Sugar 어플리케이션의 외부고객을 이용해 메일 전송',
  'LBL_EMAIL_NOT_SENT' => '시스템이 귀하의 요청을 진행할수 없습니다. 시스템 관리자에 문의하십시오',
  'LBL_EMAIL_OTHER' => '이메일 2',
  'LBL_EMAIL_OUTBOUND_TITLE' => '발신 이메일 설정',
  'LBL_EMAIL_PROVIDER' => '이메일 공급자',
  'LBL_EMAIL_SHOW_COUNTS' => '이메일 합계 보여주기',
  'LBL_EMAIL_SIGNATURE_ERROR1' => '이 서명은 이름이 필요합니다',
  'LBL_EMAIL_SMTP_SSL' => 'Enable SMTP over SSL?',
  'LBL_EMAIL_TEMPLATE_MISSING' => '사용자에 보내질 비밀번호를 포함한 이메일이 선택되지 않았습니다. 비밀번호 관리자페이지에서 이메일 템플릿을 선택하십시오',
  'LBL_EMPLOYEE_INFORMATION' => '직원 정보',
  'LBL_EMPLOYEE_STATUS' => '직원 상태',
  'LBL_ERROR' => '오류',
  'LBL_EXCHANGE_SMTPPASS' => '비밀번호 교환',
  'LBL_EXCHANGE_SMTPPORT' => '서버 포트 교환',
  'LBL_EXCHANGE_SMTPSERVER' => '서버 교환',
  'LBL_EXCHANGE_SMTPUSER' => '사용자명 교환',
  'LBL_EXPORT_CHARSET' => '기호설정 가져오기/보내기',
  'LBL_EXPORT_CHARSET_DESC' => '지역에서 사용되는 문자설정을 선택하십시오. 이 소유권은 데이타 보내기, csv 보내기와 vCard생성을 위해 사용됩니다.',
  'LBL_EXPORT_CREATED_BY' => '생성자 ID',
  'LBL_EXPORT_DELIMITER' => '경계구호 보내기',
  'LBL_EXPORT_DELIMITER_DESC' => '데이타보내기의 범위지정에 사용될 문자를 지정하십시오',
  'LBL_EXTERNAL_AUTH_ONLY' => '다음을 통해서만 사용자 인증',
  'LBL_EXT_AUTHENTICATE' => '외부 인증',
  'LBL_FAX' => '팩스:',
  'LBL_FAX_PHONE' => '팩스:',
  'LBL_FDOW' => '주의 첫째날',
  'LBL_FDOW_TEXT' => '주, 달, 연도 보기에 진열될 첫째날',
  'LBL_FILTER_USERS_REPORTS' => '사용자 보고서',
  'LBL_FIND_OPTIMUM_KEY' => 'f',
  'LBL_FIND_OPTIMUM_MSG' => '최적조건의 연결 변수를 찾고 있습니다.',
  'LBL_FIND_OPTIMUM_TITLE' => '최적조건의 구성을 찾습니다.',
  'LBL_FIRST_NAME' => '이름:',
  'LBL_FORCE' => '금지력',
  'LBL_FORCE_DESC' => '몇몇의 IMAP/POP3 서버는 특정 스위치를 필요로 합니다. 연결시 금지 스위치를 확인하십시오.(i.e., /notls)',
  'LBL_FORECASTS' => '예상',
  'LBL_FORGOTPASSORD_NOT_ENABLED' => '이것은 현재 사용이 불가합니다 : 관리자에 문의하십시요.',
  'LBL_FOUND_OPTIMUM_MSG' => '최적의 설정을 발견했습니다. 귀하의 메일 계정에 적용하려면 아래 버튼을 누르십시오.',
  'LBL_GENERATE_PASSWORD' => '비밀번호 재설정',
  'LBL_GENERATE_PASSWORD_BUTTON_KEY' => 'G',
  'LBL_GENERATE_PASSWORD_BUTTON_LABEL' => '비밀번호 재설정',
  'LBL_GENERATE_PASSWORD_BUTTON_TITLE' => '비밀번호 재설정',
  'LBL_GMAIL_SMTPPASS' => 'Gmail 비밀번호:',
  'LBL_GMAIL_SMTPUSER' => 'Gmail 이메일 주소:',
  'LBL_GROUP_DESC' => '그룹에 아이템 지정시 사용(예:수신 이메일). 이 유형은 Sugar 웹 인터페이스를 통해 접속할수 없습니다.',
  'LBL_GROUP_USER' => '그룹사용자',
  'LBL_GROUP_USER_STATUS' => '그룹사용자',
  'LBL_HELP' => '도움말',
  'LBL_HIDEOPTIONS' => '선택사항 숨기기',
  'LBL_HIDE_TABS' => '모듈 숨기기',
  'LBL_HOME_PHONE' => '집전화번호',
  'LBL_ICAL_PUB_URL' => 'iCal integration URL',
  'LBL_ICAL_PUB_URL_HELP' => 'iCal.안 Sugar 달력 구독신청을 하려면 이 URL을 이용하십시오',
  'LBL_INBOUND_TITLE' => '계정 정보',
  'LBL_IS_ADMIN' => '관리자',
  'LBL_IS_GROUP' => '그룹',
  'LBL_LANGUAGE' => '언어',
  'LBL_LAST_ADMIN_NOTICE' => '본인을 선택했습니다. 사용자 유형이나 본인 상태를 변경할수 없습니다.',
  'LBL_LAST_NAME' => '성:',
  'LBL_LAST_NAME_SLASH_NAME' => '성/이름',
  'LBL_LAYOUT_OPTIONS' => '지면배치 선택항목',
  'LBL_LDAP' => 'LDAP',
  'LBL_LDAP_AUTHENTICATION' => 'LDAP 인증서',
  'LBL_LDAP_ERROR' => 'LDAP 오류:관리자에 문의하십시오.',
  'LBL_LDAP_EXTENSION_ERROR' => 'LDAP 오류: 확장이 채워지지 않았습니다.',
  'LBL_LIST_ACCEPT_STATUS' => '상태 수락',
  'LBL_LIST_ADMIN' => '관리자',
  'LBL_LIST_DEPARTMENT' => '부서:',
  'LBL_LIST_DESCRIPTION' => '설명:',
  'LBL_LIST_EMAIL' => '이메일',
  'LBL_LIST_FORM_TITLE' => '사용자',
  'LBL_LIST_GROUP' => '그룹',
  'LBL_LIST_LAST_NAME' => '성:',
  'LBL_LIST_MEMBERSHIP' => '멤버쉽',
  'LBL_LIST_NAME' => '이름',
  'LBL_LIST_PASSWORD' => '비밀번호:',
  'LBL_LIST_PRIMARY_PHONE' => '기본 전화번호',
  'LBL_LIST_STATUS' => '상태',
  'LBL_LIST_TITLE' => '제목',
  'LBL_LIST_USER_NAME' => '사용자명',
  'LBL_LOCALE_DEFAULT_NAME_FORMAT' => '이름 전시 형식',
  'LBL_LOCALE_DESC_FIRST' => '처음',
  'LBL_LOCALE_DESC_LAST' => '마지막',
  'LBL_LOCALE_DESC_SALUTATION' => '경칭',
  'LBL_LOCALE_DESC_TITLE' => '직급',
  'LBL_LOCALE_EXAMPLE_NAME_FORMAT' => '예시',
  'LBL_LOCALE_NAME_FORMAT_DESC' => '이름이 어떻게 전시될지 설정',
  'LBL_LOCALE_NAME_FORMAT_DESC_2' => 's-경칭<br />f-이름<br />l-성',
  'LBL_LOGGED_OUT_1' => '로그아웃했습니다. 다시 로그인하려면 클릭하십시오',
  'LBL_LOGGED_OUT_2' => '여기',
  'LBL_LOGGED_OUT_3' => '.',
  'LBL_LOGIN' => '사용자명',
  'LBL_LOGIN_ADMIN_CALL' => '시스템 관리자에 문의하십시오',
  'LBL_LOGIN_ATTEMPTS_OVERRUN' => '로그인 시도 실패횟수 초과',
  'LBL_LOGIN_BUTTON_KEY' => 'L',
  'LBL_LOGIN_BUTTON_LABEL' => '로그인',
  'LBL_LOGIN_BUTTON_TITLE' => '로그인',
  'LBL_LOGIN_FORGOT_PASSWORD' => '비밀번호를 분실했습니까?',
  'LBL_LOGIN_LOGIN_TIME_ALLOWED' => '나중에 다시 로그인을 시도하십시오',
  'LBL_LOGIN_LOGIN_TIME_DAYS' => '날',
  'LBL_LOGIN_LOGIN_TIME_HOURS' => '시',
  'LBL_LOGIN_LOGIN_TIME_MINUTES' => '분',
  'LBL_LOGIN_LOGIN_TIME_SECONDS' => '초',
  'LBL_LOGIN_OPTIONS' => '선택항목',
  'LBL_LOGIN_SUBMIT' => '제출',
  'LBL_LOGIN_WELCOME_TO' => '환영합니다.',
  'LBL_MAILBOX' => '모니터되는 폴더',
  'LBL_MAILBOX_DEFAULT' => '편지함',
  'LBL_MAILBOX_SSL_DESC' => '연결시 SSL 사용합니다. 작동하지 않으면 구성의 "--with-imap-ssl" 를 포함한 PHP 설정을 확인하십시오.',
  'LBL_MAILBOX_TYPE' => '가능한 액션',
  'LBL_MAILMERGE' => '우편 통합',
  'LBL_MAILMERGE_TEXT' => '우편 통합을 작동(구성설정에서 시스템 관리자에 의해 작동되어야 합니다)',
  'LBL_MAIL_FROMADDRESS' => '답장할 주소',
  'LBL_MAIL_FROMNAME' => '답장할 이름',
  'LBL_MAIL_OPTIONS_TITLE' => '이메일 설정',
  'LBL_MAIL_SENDTYPE' => '메일 이전 대행',
  'LBL_MAIL_SMTPAUTH_REQ' => 'SMTP 인증서를 사용하시겠습니까?',
  'LBL_MAIL_SMTPPASS' => 'SMTP 비밀번호',
  'LBL_MAIL_SMTPPORT' => 'SMTP 포트:',
  'LBL_MAIL_SMTPSERVER' => 'SMTP 서버:',
  'LBL_MAIL_SMTPTYPE' => 'SMTP 서버 형식:',
  'LBL_MAIL_SMTPUSER' => 'SMTP 사용자명:',
  'LBL_MAIL_SMTP_SETTINGS' => 'SMTP 서버내역',
  'LBL_MARK_READ' => '서버에 메세지 남기기',
  'LBL_MARK_READ_DESC' => '가져온 메일 서버의 읽은 메세지 표시;삭제하지 마십시오.',
  'LBL_MARK_READ_NO' => '가져온후 삭제한 이메일 표시',
  'LBL_MARK_READ_YES' => '가져온후 서버에 남은 이메일',
  'LBL_MAX_SUBTAB' => '하위 탭의 번호',
  'LBL_MAX_SUBTAB_DESCRIPTION' => '별도 메뉴전에 탭마다 보여지는 하위 탭의 번호',
  'LBL_MAX_TAB' => '최대허용 모듈번호',
  'LBL_MAX_TAB_DESCRIPTION' => '탐색 바에 전시할수 있는 최대허용 모듈번호를 선택하십시오. 모듈의 번호는 전시될 브라우져의 너비에 따라 다릅니다. 전시되지 않는 모듈은 더보기 메뉴에 나타납니다.',
  'LBL_MESSENGER_ID' => 'IM 이름',
  'LBL_MESSENGER_TYPE' => 'IM 유형',
  'LBL_MISSING_DEFAULT_OUTBOUND_SMTP_SETTINGS' => '관리자가 발신계정 초기설정을 형성하지 않아 테스트 이메일을 보낼수 없습니다.',
  'LBL_MOBILE_PHONE' => '휴대전화',
  'LBL_MODIFIED_BY' => '수정자:',
  'LBL_MODIFIED_BY_ID' => '수정자 ID',
  'LBL_MODIFIED_USER_ID' => '수정자 ID',
  'LBL_MODULE_NAME' => '사용자',
  'LBL_MODULE_NAME_SINGULAR' => '사용자',
  'LBL_MODULE_TITLE' => '사용자:홈',
  'LBL_MY_TEAMS' => '나의 팀',
  'LBL_NAME' => '성명:',
  'LBL_NAVIGATION_PARADIGM' => '탐색',
  'LBL_NEW_FORM_TITLE' => '신규 사용자',
  'LBL_NEW_PASSWORD' => '새 비밀번호',
  'LBL_NEW_PASSWORD1' => '비밀번호:',
  'LBL_NEW_PASSWORD2' => '비밀번호 확인',
  'LBL_NEW_USER_BUTTON_KEY' => 'N',
  'LBL_NEW_USER_BUTTON_LABEL' => '신규 사용자',
  'LBL_NEW_USER_BUTTON_TITLE' => '신규 사용자',
  'LBL_NEW_USER_PASSWORD_1' => '비밀번호가 성공적으로 변경되었습니다',
  'LBL_NEW_USER_PASSWORD_2' => '시스템 생성 비밀번호를 포함한 이메일이 사용자에 발송되었습니다.',
  'LBL_NEW_USER_PASSWORD_3' => '비밀번호가 성공적으로 생성되었습니다.',
  'LBL_NORMAL_LOGIN' => '보통보기로 바꾸기',
  'LBL_NOTES' => '노트',
  'LBL_NO_KEY' => '키가 설정되지 않았습니다. 배포를 하시려면 키를 설정해주세요.',
  'LBL_NUMBER_GROUPING_SEP' => '천단위 분리기',
  'LBL_NUMBER_GROUPING_SEP_TEXT' => '천단위 분리위해 사용된 기호',
  'LBL_OAUTH_TOKENS' => '인증 표시',
  'LBL_OAUTH_TOKENS_SUBPANEL_TITLE' => '접속 인증 표시',
  'LBL_OFFICE_PHONE' => '사무실 전화번호',
  'LBL_OK' => '예',
  'LBL_OLD_PASSWORD' => '현재 비밀번호',
  'LBL_ONLY' => 'Only',
  'LBL_ONLY_SINCE' => '마지막 확인 이후만 가져오기',
  'LBL_ONLY_SINCE_DESC' => 'POP3사용시 PHP는 신규/읽지 않은 메세지에 필터사용할수 없습니다. 이 표시는 메일 계정이 마지막으로 등록된 후부터의 메세지의 확인 요청을 허용합니다. 이는 귀하의 메일 계정이 IMAP를 지원하지 않는다면 수행능력을 현저하게 향상시킵니다.',
  'LBL_ONLY_SINCE_NO' => '아니오. 메일 서버의 전체 이메일을 확인하십시오.',
  'LBL_ONLY_SINCE_YES' => '네',
  'LBL_OTHER' => '기타',
  'LBL_OTHER_EMAIL' => '기타 이메일 주소',
  'LBL_OTHER_PHONE' => '다른 전화번호:',
  'LBL_OWN_OPPS' => '영업기회가 없습니다.',
  'LBL_OWN_OPPS_DESC' => '사용자가 영업기회를 지정할지 선택하십시오. 영업활동과 관련되지 않은 매니저 사용자를 위해 이설정을 사용하십시오. 이 설정은 모듈 예측에 사용됩니다',
  'LBL_PASSWORD' => '비밀번호:',
  'LBL_PASSWORD_EXPIRATION_GENERATED' => '새 비밀번호는 시스템에서 생성되었습니다.',
  'LBL_PASSWORD_EXPIRATION_LOGIN' => '귀하의 비밀번호가 만료되었습니다. 새 비밀번호를 입력하십시오',
  'LBL_PASSWORD_EXPIRATION_TIME' => '귀하의 비밀번호가 만료되었습니다. 새 비밀번호를 입력하십시오',
  'LBL_PASSWORD_GENERATED' => '새 비밀전호 생성됨',
  'LBL_PASSWORD_SENT' => '비밀번호 업데이트',
  'LBL_PDF_FONT_NAME_DATA' => '바닥글 글자체',
  'LBL_PDF_FONT_NAME_DATA_TEXT' => '선택된 글자체는 PDF문서의 바닥글과 본문에 적용됩니다.',
  'LBL_PDF_FONT_NAME_MAIN' => '머리글과 본문 글자체',
  'LBL_PDF_FONT_NAME_MAIN_TEXT' => '선택된 글자체는 PDF문서의 머리글과 본문에 적용됩니다.',
  'LBL_PDF_FONT_SIZE_DATA' => '날짜 글짜 크기',
  'LBL_PDF_FONT_SIZE_DATA_TEXT' => '',
  'LBL_PDF_FONT_SIZE_MAIN' => '주 글자크기',
  'LBL_PDF_FONT_SIZE_MAIN_TEXT' => '',
  'LBL_PDF_MARGIN_BOTTOM' => '아래쪽 여백',
  'LBL_PDF_MARGIN_BOTTOM_TEXT' => '',
  'LBL_PDF_MARGIN_FOOTER' => '바닥글 여백',
  'LBL_PDF_MARGIN_FOOTER_TEXT' => '',
  'LBL_PDF_MARGIN_HEADER' => '머리글 여백',
  'LBL_PDF_MARGIN_HEADER_TEXT' => '',
  'LBL_PDF_MARGIN_LEFT' => '왼쪽 여백',
  'LBL_PDF_MARGIN_LEFT_TEXT' => '',
  'LBL_PDF_MARGIN_RIGHT' => '오른쪽 여백',
  'LBL_PDF_MARGIN_RIGHT_TEXT' => '',
  'LBL_PDF_MARGIN_TOP' => '위쪽 여백',
  'LBL_PDF_MARGIN_TOP_TEXT' => '',
  'LBL_PDF_PAGE_FORMAT' => '페이지 형식',
  'LBL_PDF_PAGE_FORMAT_TEXT' => '페이지를 위해 사용되는 형식',
  'LBL_PDF_PAGE_ORIENTATION' => '페이지 오리엔테이션',
  'LBL_PDF_PAGE_ORIENTATION_L' => '가로',
  'LBL_PDF_PAGE_ORIENTATION_P' => '세로',
  'LBL_PDF_PAGE_ORIENTATION_TEXT' => '',
  'LBL_PDF_SETTINGS' => 'PDF 설정',
  'LBL_PHONE' => '전화번호:',
  'LBL_PHONE_FAX' => '팩스전화번호',
  'LBL_PHONE_HOME' => '집 전화번호',
  'LBL_PHONE_MOBILE' => '휴대 전화번호',
  'LBL_PHONE_OTHER' => '다른 전화번호',
  'LBL_PHONE_WORK' => '사무실 전화번호',
  'LBL_PICK_TZ_DESCRIPTION' => '계속하기전 시간대를 확인하십시오. 아래 목록에서 알맞은 시간대를 선택한후 저장하십시오. 시간대는 사용자 설정에서 언제든지 변경할수 있습니다.',
  'LBL_PICK_TZ_WELCOME' => 'Sugar에 오신것을 환영합니다.',
  'LBL_PICTURE_FILE' => '사진',
  'LBL_PORT' => '메일 서버포트',
  'LBL_PORTAL_ONLY' => 'Portal Only',
  'LBL_PORTAL_ONLY_DESC' => '포탈 API를 사용하십시오. 이 유형은 Sugar웹 인터페이스를 통해 로그인할수 없습니다.',
  'LBL_PORTAL_ONLY_USER' => '포탈 API 사용자',
  'LBL_POSTAL_CODE' => '우편번호:',
  'LBL_PRIMARY_ADDRESS' => '기본주소:',
  'LBL_PRIVATE_TEAM_FOR' => '개인 팀',
  'LBL_PROCESSING' => '진행중입니다',
  'LBL_PROMPT_TIMEZONE' => '사용자 바로 마법사',
  'LBL_PROMPT_TIMEZONE_TEXT' => '신규사용자가 첫 로그인때 신규사용자 마법사를 통할수 있도록 선택하십시오',
  'LBL_PROSPECT_LIST' => '잠재고객 목록',
  'LBL_PROVIDE_USERNAME_AND_EMAIL' => '사용자명과 이메일 주소를 입력하십시오',
  'LBL_PSW_MODIFIED' => '마지막 변경된 비밀번호',
  'LBL_PUBLISH_KEY' => '발표키',
  'LBL_QUOTAS' => '견적',
  'LBL_REASS_ASSESSING' => '접속중입니다.',
  'LBL_REASS_BUTTON_CLEAR' => '비우기',
  'LBL_REASS_BUTTON_CONTINUE' => '다음',
  'LBL_REASS_BUTTON_GO_BACK' => '뒤로',
  'LBL_REASS_BUTTON_REASSIGN' => '다시 지정',
  'LBL_REASS_BUTTON_RESTART' => '다시시작',
  'LBL_REASS_BUTTON_RETURN' => '되돌아옴',
  'LBL_REASS_BUTTON_SUBMIT' => '제출',
  'LBL_REASS_CANNOT_PROCESS' => '진행할수 없습니다.',
  'LBL_REASS_CONFIRM_REASSIGN' => '이 사용자의 모든 기록을 재지정하시겠습니까?',
  'LBL_REASS_CONFIRM_REASSIGN_NO' => '아니요',
  'LBL_REASS_CONFIRM_REASSIGN_TITLE' => '재지정',
  'LBL_REASS_CONFIRM_REASSIGN_YES' => '예',
  'LBL_REASS_DESC_PART1' => '특정사용자에서 다른 사용자에 재지정된 기록을 포함하는 모듈을 선택하십시오.<br />각각의 선택된 모듈에서 업데이트 될 기록의 개수를 보려면 다음 버튼을 클릭하십시오.',
  'LBL_REASS_DESC_PART2' => '어떤 모듈이 작업 흐름, 과제 통지 전송 그리고 재지정동안 추적검사를 실행할 모듈을 선택하십시오. 계속해 기록을 재지정하려면 다음 버튼을 클릭하고 다시 시작하려면 재시작 버튼을 클릭하십시오.',
  'LBL_REASS_FAILED' => '실패',
  'LBL_REASS_FAILED_SAVE' => '기록저장이 실패하였습니다.',
  'LBL_REASS_FILTERS' => '필터',
  'LBL_REASS_FROM' => '발신인',
  'LBL_REASS_HAVE_BEEN_UPDATED' => '업데이트 되었습니다.',
  'LBL_REASS_MOD_REASSIGN' => '재지정에 포함되 모듈',
  'LBL_REASS_NONE' => '없음',
  'LBL_REASS_NOTES_ONE' => '작업흐름 실행은 재지정 진행을 현저히 늦춥니다.',
  'LBL_REASS_NOTES_THREE' => '본인의 기록지정은 지정 알림을 작동하지 않습니다.',
  'LBL_REASS_NOTES_TITLE' => '노트',
  'LBL_REASS_NOTES_TWO' => '추적검사를 선택하지 않았어도 기록의 필드에 의한 수정일과 수정인은 자동으로 업데이트됩니다.',
  'LBL_REASS_NOT_PROCESSED' => '진행될수 없습니다.',
  'LBL_REASS_RECORDS_FROM' => '다음에서의 기록',
  'LBL_REASS_SCRIPT_TITLE' => '기록 재배정',
  'LBL_REASS_STEP2_DESC' => '아래 목록의 팀은 수신 사용자팀이 아닌 발신 사용자팀이 사용가능합니다. 발신 사용자팀의 모든 기록은 팀의 가치가 배치되지 않는한 수신 사용자팀에 보이지 않습니다.',
  'LBL_REASS_STEP2_TITLE' => '팀 재지정',
  'LBL_REASS_SUCCESSFUL' => '성공',
  'LBL_REASS_SUCCESS_ASSIGN' => '성공적으로 지정되었습니다.',
  'LBL_REASS_TEAMS_GOOD_MSG' => '수신 사용자은 모든 발신 사용자팀에 접속할수 있습니다. 배치가 필요하지 않으며 5초후 다음페이지로 전송됩니다.',
  'LBL_REASS_TEAM_NO_CHANGE' => '변경 없음',
  'LBL_REASS_TEAM_SET_TO' => '그리고 팀이 다음에 설정되었습니다.',
  'LBL_REASS_TEAM_TO' => '팀 설정',
  'LBL_REASS_THE_FOLLOWING' => '다음',
  'LBL_REASS_TO' => '받는사람',
  'LBL_REASS_UPDATE_COMPLETE' => '업데이트 완료',
  'LBL_REASS_USER_FROM' => '발신 사용자',
  'LBL_REASS_USER_FROM_TEAM' => '발신 사용자팀',
  'LBL_REASS_USER_TO' => '수신 사용자',
  'LBL_REASS_USER_TO_TEAM' => '수신 사용자팀',
  'LBL_REASS_VERBOSE_HELP' => '작업흐름과 연관된 재지정 과제의 세부정보 보기를 위한 사항을 선택하십시오.',
  'LBL_REASS_VERBOSE_OUTPUT' => '자세한 정보출력',
  'LBL_REASS_WILL_BE_UPDATED' => '업데이트됩니다.',
  'LBL_REASS_WORK_NOTIF_AUDIT' => '작업흐름/통지/검사를 포함(현저히 늦어짐)',
  'LBL_RECAPTCHA_FILL_FIELD' => '이미지에 나타나는 문자를 입력하십시오',
  'LBL_RECAPTCHA_IMAGE' => '이미지로 전환',
  'LBL_RECAPTCHA_INSTRUCTION' => '아래에 두 단어를 입력하십시오',
  'LBL_RECAPTCHA_INSTRUCTION_OPPOSITE' => '오른쪽에 두 단어를 입력하십시오',
  'LBL_RECAPTCHA_INVALID_PRIVATE_KEY' => '유효하지 않은 회복한 개인키',
  'LBL_RECAPTCHA_INVALID_REQUEST_COOKIE' => '회복된 스크립트 인증의 조건이 부정확합니다.',
  'LBL_RECAPTCHA_NEW_CAPTCHA' => '또 다른 CAPTCHA 갖기',
  'LBL_RECAPTCHA_SOUND' => '소리로 전환',
  'LBL_RECAPTCHA_UNKNOWN' => '알수없는 오류',
  'LBL_RECEIVE_NOTIFICATIONS' => '과제 통보',
  'LBL_RECEIVE_NOTIFICATIONS_TEXT' => '기록이 귀하에 지정되면 이메일을 통해 통지를 받습니다.',
  'LBL_REGISTER' => '신규 사용자입니까? 등록해 주십시오',
  'LBL_REGULAR_DESC' => '사용자는 모듈과 팀 보안과 역할에 근거한 기록에 접속할수 있습니다.',
  'LBL_REGULAR_USER' => '일반사용자',
  'LBL_REMINDER' => '알림',
  'LBL_REMINDER_EMAIL' => '이메일',
  'LBL_REMINDER_EMAIL_ALL_INVITEES' => '모든 초대자에 이메일 보내기',
  'LBL_REMINDER_POPUP' => '팝업',
  'LBL_REMINDER_TEXT' => '전화상담과 회의를 위한 알림 초기설정을 하십시요. Sugar를 사용하는 모든 초대자에 팝업 알림이 나타납니다. 모든 초대자는 이메일을 통한 통보를 받게됩니다.',
  'LBL_REMOVED_TABS' => '관리자 탭 제거',
  'LBL_REPORTS_TO' => '다음 담당자에 보고:',
  'LBL_REPORTS_TO_ID' => '다음 ID로 보고:',
  'LBL_REPORTS_TO_NAME' => '보고',
  'LBL_REQUEST_SUBMIT' => '귀하의 요청이 제출되었습니다.',
  'LBL_RESET_DASHBOARD' => '계기판 재설정',
  'LBL_RESET_PREFERENCES' => '사용자 선호 재설정',
  'LBL_RESET_PREFERENCES_WARNING' => '귀하의 사용자 선호를 모두 재설정 하시겠습님까? 경고: 이것은 어플리케이션에서 로그아웃시킵니다.',
  'LBL_RESET_PREFERENCES_WARNING_USER' => '이 사용자의 모든 선호를 재설정하시겠습니까?',
  'LBL_RESET_TO_DEFAULT' => '초기설정으로 재설정',
  'LBL_RESOURCE_NAME' => '출처명',
  'LBL_RESOURCE_TYPE' => '유형',
  'LBL_ROLES_SUBPANEL_TITLE' => '역할',
  'LBL_SALUTATION' => '경칭',
  'LBL_SAVED_SEARCH' => '검색저장과 지면 배치',
  'LBL_SEARCH_FORM_TITLE' => '사용자 검색',
  'LBL_SEARCH_URL' => '위치 검색',
  'LBL_SELECT_CHECKED_BUTTON_LABEL' => '확인된 사용자 선택',
  'LBL_SELECT_CHECKED_BUTTON_TITLE' => '확인된 사용자 선택',
  'LBL_SERVER_OPTIONS' => '고급 설정',
  'LBL_SERVER_TYPE' => '메일 서버 통신규약/접속순서',
  'LBL_SERVER_URL' => '메일 서버 주소',
  'LBL_SESSION_EXPIRED' => '세션이 만료되어 로그아웃 되었습니다.',
  'LBL_SETTINGS_URL' => 'URL',
  'LBL_SETTINGS_URL_DESC' => 'Microsoft® Outlook® 과 Sugar Plug-in for Microsoft® Word®.를 위한 Sugar 플러그인의 로그인 설정을 만들때 이 URL을 사용하십시오.',
  'LBL_SHOWOPTIONS' => '선택사항 보이기',
  'LBL_SHOW_ON_EMPLOYEES' => '직원기록 전시',
  'LBL_SIGNATURE' => '서명',
  'LBL_SIGNATURES' => '서명',
  'LBL_SIGNATURE_DEFAULT' => '서명을 사용하시겠습니까?',
  'LBL_SIGNATURE_HTML' => 'HTML 서명',
  'LBL_SIGNATURE_NAME' => '이름',
  'LBL_SIGNATURE_PREPEND' => '답장 위에 서명하기',
  'LBL_SMTP_SERVER_HELP' => '이 SMTP메일 서버는 발신용 메일로 사용될수 있습니다. 메일서버를 사용하려면 이메일 계정의 사용자명과 비밀번호를 입력하십시오',
  'LBL_SSL' => 'SSL 사용',
  'LBL_SSL_DESC' => '만약 귀하의 메일 서버가 보안 소켓을 지원한다면 이 작동은 이메일 가져올때 SSL연결을 강요합니다.',
  'LBL_STATE' => '도:',
  'LBL_STATUS' => '상태',
  'LBL_SUBPANEL_LINKS' => '하위패널 링크',
  'LBL_SUBPANEL_LINKS_DESCRIPTION' => '세부내용보기에서 하위패널의 링크 빨리가기 줄을 진열합니다.',
  'LBL_SUGAR_LOGIN' => 'Sugar사용자여부',
  'LBL_SUPPORTED_THEME_ONLY' => '이 사항을 지원하는 테마만이 영향을 받습니다.',
  'LBL_SWAP_LAST_VIEWED_DESCRIPTION' => '확인됐다면 마지막으로 본 바를 옆에 전시하고 아니면 위로 이동합니다',
  'LBL_SWAP_LAST_VIEWED_POSITION' => '마지막 본것은 옆에',
  'LBL_SWAP_SHORTCUT_DESCRIPTION' => '확인됐다면 빠른길 바를 위에 전시하고 아니면 옆으로 이동합니다,',
  'LBL_SWAP_SHORTCUT_POSITION' => '빠른길은 위에',
  'LBL_SYSTEM_GENERATED_PASSWORD' => '시스템에서 생성된 비밀번호',
  'LBL_SYSTEM_SIG_DIGITS' => '시스템 유효 숫자',
  'LBL_SYSTEM_SIG_DIGITS_DESC' => '소수 자릿수의 수는 보고서에서 통화 및 평균으로 시스템 전반에 걸쳐 소수와 수레를 위해 표시합니다.',
  'LBL_TAB_TITLE_EMAIL' => '이메일 설정',
  'LBL_TAB_TITLE_USER' => '사용자 설정',
  'LBL_TEAMS' => '팀',
  'LBL_TEAM_MEMBERSHIP' => '팀 멤버쉽',
  'LBL_TEAM_SET' => '팀 설정',
  'LBL_TEAM_UPLINE' => '보고하는 멤버',
  'LBL_TEAM_UPLINE_EXPLICIT' => '멤버',
  'LBL_TEST_BUTTON_KEY' => 't',
  'LBL_TEST_BUTTON_TITLE' => '테스트',
  'LBL_TEST_SETTINGS' => '테스트 설정',
  'LBL_TEST_SUCCESSFUL' => '연결이 성공적으로 완료되었습니다.',
  'LBL_THEME' => '테마:',
  'LBL_THEMEPREVIEW' => '미리 보기',
  'LBL_THEME_COLOR' => '색상',
  'LBL_THEME_FONT' => '글자체',
  'LBL_TIMEZONE' => '시간대',
  'LBL_TIMEZONE_DST' => '일광 절약',
  'LBL_TIMEZONE_DST_TEXT' => '일광 절약 준수',
  'LBL_TIMEZONE_TEXT' => '현 시간대 설정',
  'LBL_TIME_FORMAT' => '시간 형식',
  'LBL_TIME_FORMAT_TEXT' => '전시할 시간형식 설정',
  'LBL_TITLE' => '제목',
  'LBL_TLS' => 'TLS 사용하십시오.',
  'LBL_TLS_DESC' => '메일 서버에 연결시 지면배치 보안 운송을 사용하십시오.- 메일 서버가 이 통신 규약을 지원할때만 사용하십시오.',
  'LBL_TOGGLE_ADV' => '고급 선택사항 보이기',
  'LBL_TOO_MANY_CONCURRENT' => '동일 사용자명의 또다른 세션이 시작되어 귀하의 세션이 만료되었습니다.',
  'LBL_UPDATE_FINISH' => '업데이트 완료',
  'LBL_USER' => '사용자',
  'LBL_USER_ACCESS' => '접속',
  'LBL_USER_HASH' => '비밀번호:',
  'LBL_USER_HOLIDAY_SUBPANEL_TITLE' => '사용자 휴일',
  'LBL_USER_INFORMATION' => '사용자 프로필',
  'LBL_USER_LOCALE' => '현지 설정',
  'LBL_USER_NAME' => '사용자명',
  'LBL_USER_NAME_FOR_ROLE' => '사용자/팀/역할',
  'LBL_USER_PREFERENCES' => '사용자 선호',
  'LBL_USER_SETTINGS' => '사용자 설정',
  'LBL_USER_TYPE' => '사용자 종류',
  'LBL_USE_GROUP_TABS' => '모듈메뉴 필터',
  'LBL_USE_REAL_NAMES' => '전체 이름목록 보여주기',
  'LBL_USE_REAL_NAMES_DESC' => '배정 필드의 사용자명 대신 사용자의 전체 이름을 전시합니다.',
  'LBL_WIZARD_BACK_BUTTON' => '뒤로',
  'LBL_WIZARD_FINISH' => '설정을 저장하고 Sugar 사용을 시작하려면 아래 완료 버튼을 클릭하십시오.  Sugar 사용에 대한 더 자세한 내용을 보려면;<br />Sugar University:최종 사용자와 시스템 관리자의 훈련과 자원<br />문서:상품 안내와 발매 노트<br />지식 기반:일반 과제 수행과 Sugar 진행을 위한 SugarCRM 지원의 정보',
  'LBL_WIZARD_FINISH1' => '다음에 무엇을 하시겠습니까?',
  'LBL_WIZARD_FINISH10' => '어플리케이션 필드와 지면배치 생성 및 관리를 위해 작업실을 사용하십시오.',
  'LBL_WIZARD_FINISH11' => 'Sugar University  방문하기',
  'LBL_WIZARD_FINISH12' => '어플리케이선의 시스템 관리자나 사용자로서 시작을 도와주는 훈련물과 강의 찾기',
  'LBL_WIZARD_FINISH14' => '문서화',
  'LBL_WIZARD_FINISH15' => '상품 안내와 발매 노트',
  'LBL_WIZARD_FINISH16' => '지식기반',
  'LBL_WIZARD_FINISH17' => '일반 과제 수행과 Sugar 진행을 위한 SugarCRM 지원으로부터의 정보',
  'LBL_WIZARD_FINISH18' => '포럼',
  'LBL_WIZARD_FINISH19' => '포럼은 상호간이나 SugarCRM 개발자와 관심주제를 논의할수 있는 Sugar 커뮤니티 전용입니다,',
  'LBL_WIZARD_FINISH2' => 'Sugar사용시작하기',
  'LBL_WIZARD_FINISH2DESC' => '어플리케이션 홈페이지로 바로 가기',
  'LBL_WIZARD_FINISH3' => '데이타 가져오기',
  'LBL_WIZARD_FINISH4' => '외부 계정에서 어플리케이션으로 데이타 가져오기',
  'LBL_WIZARD_FINISH5' => '신규 사용자 만들기',
  'LBL_WIZARD_FINISH6' => '어플리케이션에 접속하는 이들을 위한 신규 사용자 계정 만들기',
  'LBL_WIZARD_FINISH7' => '어플리케이션 설정보기 및 관리',
  'LBL_WIZARD_FINISH8' => '초기 어플리케이션 설정을 포함한 고급 설정 관리',
  'LBL_WIZARD_FINISH9' => '어플리케이션 만들기',
  'LBL_WIZARD_FINISH_BUTTON' => '완료',
  'LBL_WIZARD_FINISH_TAB' => '완료',
  'LBL_WIZARD_FINISH_TITLE' => 'Sugar 사용준비가 완료되었습니다!',
  'LBL_WIZARD_LOCALE' => '귀하의 위치',
  'LBL_WIZARD_LOCALE_DESC' => '귀하의 시간대와 Sugar에 데이타, 화폐 그리고 이름이 어떻게 나타나게 할지 명시해주십시오',
  'LBL_WIZARD_NEXT_BUTTON' => '다음',
  'LBL_WIZARD_PERSONALINFO' => '귀하의 정보',
  'LBL_WIZARD_PERSONALINFO_DESC' => '본인정보를 입력하십시오. 입력하신 정보는 다른 Sugar 사용자가 볼수 있습니다. *로 표시된 필드는 필수 항목입니다.',
  'LBL_WIZARD_SKIP_BUTTON' => '생략',
  'LBL_WIZARD_SMTP' => '귀하의 이메일 계정',
  'LBL_WIZARD_SMTP_DESC' => '수신이메일 서버 초기설정을 위한 사용자명과 비밀번호를 입력하십시오.',
  'LBL_WIZARD_TITLE' => '사용자 마법사',
  'LBL_WIZARD_WELCOME' => 'Sugar 사용을 위한 몇몇 기본 설정 형성을 위해 다음 버튼을 클릭하십시오.',
  'LBL_WIZARD_WELCOME_NOSMTP' => 'Sugar 사용을 위한 몇몇 기본 설정 형성을 위해 다음 버튼을 클릭하십시오.',
  'LBL_WIZARD_WELCOME_TAB' => '환영합니다',
  'LBL_WIZARD_WELCOME_TITLE' => 'Sugar에 오신것을 환영합니다.',
  'LBL_WORKSHEETS' => '참고 자료지',
  'LBL_WORK_PHONE' => '사무실 전화번호',
  'LBL_YAHOOMAIL_SMTPPASS' => 'Yahoo! 메일 비밀번호',
  'LBL_YAHOOMAIL_SMTPUSER' => 'Yahoo! 메일 ID:',
  'LBL_YOUR_PUBLISH_URL' => '내 위치 발표',
  'LBL_YOUR_QUERY_URL' => '귀하의 문의 URL',
  'LNK_EDIT_TABS' => '탭 편집',
  'LNK_IMPORT_USERS' => '사용자 가져오기',
  'LNK_NEW_GROUP_USER' => '그룹사용자 새로 만들기',
  'LNK_NEW_PORTAL_USER' => 'Portal API 사용자 만들기',
  'LNK_NEW_USER' => '신규 사용자 말들기',
  'LNK_REASSIGN_RECORDS' => '기록 재 배정',
  'LNK_USER_LIST' => '사용자 보기',
  'NTC_REMOVE_TEAM_MEMBER_CONFIRMATION' => '이 사용자 멥버쉽을 제거하시겠습니까?',
);

