<?php

/**
 * @author	Chaim Gorbov
 * @since	Version 1.0.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Menu UI
 */
$lang['menu_forms_list']        = 'רשימת דוחות';
$lang['menu_new_form']        = 'דוח חדש';
$lang['menu_charts']        = 'כספים';
$lang['menu_tickets']        = 'משימות';
$lang['menu_contacts']        = 'אנשי קשר';
$lang['menu_hi']        = 'שלום %s';
$lang['menu_update_my_data']        = 'עדכן פרטים שלי';
$lang['menu_logout']        = 'צא ממערכת';

/**
 * Settings UI
 */
$lang['settings']        = 'הגדרות';
$lang['roles']            = 'תפקידים';
$lang['Admin']            = 'מנהל';
$lang['Manager']            = 'אחראי';
$lang['User']            = 'משתמש';
$lang['users']        = 'משתמשים';
$lang['companies']        = 'חברות';
$lang['forms']        = 'דוחות';
$lang['send_req_emails']        = 'תמיד לשלוח למיילים הבאים';
$lang['send_req_emails_details']        = 'נא להשתמש בפסיק בין המאיילים (,)';
$lang['use_smtp']        = 'להשתמש ב-SMTP';
$lang['smtp_host']        = 'שרת SMTP';
$lang['smtp_port']        = 'פורט SMTP';
$lang['username']        = 'שם משתמש';
$lang['password']        = 'סיסמה';
$lang['create_db']        = 'ליצר DB';
$lang['sys_log']        = 'דוחות מערכת';
$lang['explorer']        = 'תיקיות בשרת';
$lang['backup_db']        = 'שמור DB';
$lang['download_db']        = 'הורד DB';
$lang['save']        = 'שמור';
$lang['update']        = 'עדכן';
$lang['edit']        = 'ערוך';
$lang['delete']        = 'מחק';
$lang['upload']        = 'העלה';
$lang['blocked_ip']        = 'IP שחוסמו';
$lang['blocked_ip_details']        = 'שורה חדשה לכל IP';

/**
 * Users UI
 */
$lang['role']        = 'תפקיד';
$lang['view_name']        = 'שם יוצג';
$lang['email']        = 'מייל';
$lang['language']        = 'שפה';
$lang['add_user']        = 'הוסף משתמש';
$lang['edit_details']        = 'ערוך פרטים';
$lang['companies_list']        = 'רשימת חברות';
$lang['default']        = 'שפת מערכת';
$lang['connect'] = 'להתחבר';

/**
 * Companies UI
 */
$lang['company_name']        = 'שם החברה';
$lang['logo']        = 'לוגו';
$lang['edit_company']        = 'ערוך חברה';
$lang['company']        = 'חברה';
$lang['check_feilds']        = 'סמן שדות <b style="color: red;">לכבות</b>';
$lang['form_header']        = 'כותרת של דוח';
$lang['form_extra']        = 'תוספת לדוח';
$lang['form_footer']        = 'כותרת תחתונה של דוח';
$lang['add_company']        = 'הוסף חברה';
$lang += array(
    "start_time_column" => "שעת התחלה",
    "end_time_column" => "שעת סיום",
    "client_num_column" => "מספר לקוח",
    "issue_num_column" => "מספר פניה \ תקלה",
    "issue_kind_column" => "סוג תקלה \ התקנה",
    "client_name_column" => "שם לקוח",
    "place_column" => "כתובת",
    "city_column" => "עיר",
    "manager_column" => "אחראי",
    "contact_name_column" => "איש קשר",
    "activity_text_column" => "תיאור תקלה \ פניה",
    "checking_text_column" => "תוצאות הבדיקה",
    "summary_text_column" => "סיכום",
    "remarks_text_column" => "הערות",
    "recommendations_text_column" => "המלצות",
    "emails" => "מכותבים",
    "files_column" => "קבצים",
    "details_column" => "הערות (CSV) ",
    "new_serial" => "מספר סריאלי - חדש",
    "old_serial" => "מספר סריאלי - ישן",
    "price" => "מחיר"
);

/**
 * Contacts UI
 */
$lang['name']        = 'שם';
$lang['edit_contact']        = 'שנה איש קשר';
$lang['users_list_view']        = 'הצג אצל משתמשים';
$lang['add_contact']        = 'הוסף איש קשר';

/**
 * Tickets UI
 */
$lang['tickets']        = 'משימות';
$lang['dones']        = 'בוצעו';
$lang['reset_filter']        = 'בטל סינון';
$lang['technician']        = 'טכנאי';
$lang['no_filter']        = '-ללא סינון-';
$lang['unresolved']        = 'ללא שיוך';
$lang['status']        = 'סטטוס';
$lang['new']        = 'חדש';
$lang['working']        = 'בטיפול';
$lang['done']        = 'בוצע';
$lang['filter']        = 'סינון';
$lang['warehouse_num']        = 'משימה למחסן';
$lang['upload_tickets']        = 'להעלות קובץ משימות ';
$lang['show_table']        = 'הצג טבלה';
$lang['upload_xlsx']        = 'נא להעלות קובץ XLSX';
$lang['select_column']        = 'נא לבחור תור';
$lang['xlsx_format_error']        = 'פומרט של קובץ לא נכון, נא לבדוק קמות של פריטים בשורה';
$lang['tickets_table']        = 'טבלת משימות';
$lang['add_to_company']        = 'הוסף לחברת';
$lang['add_tickets']        = 'הוסף משימות';
$lang['updated']        = 'עודכן';
$lang['added']        = 'הוסף';
$lang['close_tiket'] = 'סגור משימה';


/**
 * Forms UI
 */
$lang['new_form']        = 'מלוי דוח';
$lang['new_config']        = 'יצירת קונפיגורציה';
$lang['date']        = 'תאריך';
$lang['no_emails']        = 'אין פריטים ברשימת תפוצה של משתמש';
$lang['cant_add_files']        = 'אין אפשרות להוסיף קבצים טרם שמירת דוח.';
$lang['save_sign']        = 'שמור חתימה';
$lang['saved_sign']        = 'חתימת לקוח שמורה:';
$lang['clean_sign']        = 'נקה חתימה';
$lang['client_sign']        = 'חתימת לקוח';
$lang['no_sign']        = 'אין חתימה';
$lang['save_and_send']        = 'שמור ושלח לרשימת תפוצה';
$lang['cant_save']        = 'אין אפשרות לשמור את שינוים';
$lang['sending_email']        = 'שולח מייל, נא להמתין...';
$lang['update_form']        = 'עדכון דוח';
$lang['send_form']        = 'שלח דוח';
$lang['show']        = 'הצג';
$lang['search']        = 'חפש';
$lang['search_placeholder']        = 'מספר תקלה,מספר לקוח,שם לקוח,יוצר';
$lang['day']        = 'יום';
$lang['month']        = 'חודש';
$lang['year']        = 'שנה';
$lang['no_forms']        = 'אין עדיין דוחות';
