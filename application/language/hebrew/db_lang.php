<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$lang['db_invalid_connection_str'] = 'לא ניתן לקבוע את הגדרות מסד הנתונים בהתבסס על מחרוזת החיבור שהגשת.';
$lang['db_unable_to_connect'] = 'לא ניתן להתחבר לשרת מסד הנתונים שלך באמצעות ההגדרות שסופקו.';
$lang['db_unable_to_select'] = 'לא ניתן לבחור את מסד הנתונים שצוין: %s';
$lang['db_unable_to_create'] = 'לא ניתן ליצור את מסד הנתונים שצוין: %s';
$lang['db_invalid_query'] = 'השאילתה ששלחת אינה חוקית.';
$lang['db_must_set_table'] = 'עליך להגדיר את טבלת מסד הנתונים שתשתמש בה עם השאילתה שלך.';
$lang['db_must_use_set'] = 'עליך להשתמש בשיטת "set" כדי לעדכן ערך.';
$lang['db_must_use_index'] = 'עליך לציין אינדקס להתאמה לעדכוני אצווה.';
$lang['db_batch_missing_index'] = 'בשורה אחת או יותר שנשלחו לעדכון אצווה חסר האינדקס שצוין.';
$lang['db_must_use_where'] = 'עדכונים אינם מורשים אלא אם כן הם מכילים סעיף "where".';
$lang['db_del_must_use_where'] = 'מחיקות אינן מורשות אלא אם כן הן מכילות סעיף "where" או "like".';
$lang['db_field_param_missing'] = 'כדי לאחזר שדות נדרש שם הטבלה כפרמטר.';
$lang['db_unsupported_function'] = 'תכונה זו אינה זמינה עבור מסד הנתונים שבו אתה משתמש.';
$lang['db_transaction_failure'] = 'Transaction failure: Rollback performed.';
$lang['db_unable_to_drop'] = 'לא ניתן להוריד את מסד הנתונים שצוין.';
$lang['db_unsupported_feature'] = 'תכונה לא נתמכת של פלטפורמת מסד הנתונים בה אתה משתמש.';
$lang['db_unsupported_compression'] = 'פורמט דחיסת הקבצים שבחרת אינו נתמך על ידי השרת שלך.';
$lang['db_filepath_error'] = 'לא ניתן לכתוב נתונים לנתיב הקובץ שהגשת.';
$lang['db_invalid_cache_path'] = 'נתיב המטמון ששלחת אינו תקף או ניתן לכתיבה.';
$lang['db_table_name_required'] = 'שם טבלה נדרש לפעולה זו.';
$lang['db_column_name_required'] = 'שם עמודה נדרש לפעולה זו.';
$lang['db_column_definition_required'] = 'נדרשת הגדרת עמודה לאותה פעולה.';
$lang['db_unable_to_set_charset'] = 'לא ניתן להגדיר ערכת תווים של חיבור לקוח: %s';
$lang['db_error_heading'] = 'אירעה שגיאת מסד נתונים';
