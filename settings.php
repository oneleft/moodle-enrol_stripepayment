<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Stript enrolments plugin settings and presets.
 *
 * @package    enrol_stripepay
 * @copyright  2016 zPivot, Zach Washburn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {

    // --- settings ------------------------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('enrol_stripepay_settings', '', get_string('pluginname_desc', 'enrol_stripepay')));

    $settings->add(new admin_setting_configtext('enrol_stripepay/secretkey', get_string('secretkey', 'enrol_stripepay'),
    get_string('secretkey_desc', 'enrol_stripepay'), '', PARAM_TEXT));
    $settings->add(new admin_setting_configtext('enrol_stripepay/publishablekey', get_string('publishablekey', 'enrol_stripepay'),
    get_string('publishablekey_desc', 'enrol_stripepay'), '', PARAM_TEXT));

    $settings->add(new admin_setting_configcheckbox('enrol_stripepay/mailstudents',
    get_string('mailstudents', 'enrol_stripepay'), '', 0));

    $settings->add(new admin_setting_configcheckbox('enrol_stripepay/mailteachers',
    get_string('mailteachers', 'enrol_stripepay'), '', 0));

    $settings->add(new admin_setting_configcheckbox('enrol_stripepay/mailadmins',
    get_string('mailadmins', 'enrol_stripepay'), '', 0));

    // Note: let's reuse the ext sync constants and strings here, internally it is very similar,
    // it describes what should happen when users are not supposed to be enrolled any more.
    $options = array(
        ENROL_EXT_REMOVED_KEEP           => get_string('extremovedkeep', 'enrol'),
        ENROL_EXT_REMOVED_SUSPENDNOROLES => get_string('extremovedsuspendnoroles', 'enrol'),
        ENROL_EXT_REMOVED_UNENROL        => get_string('extremovedunenrol', 'enrol'),
    );
    $settings->add(new admin_setting_configselect('enrol_stripepay/expiredaction',
    get_string('expiredaction', 'enrol_stripepay'), get_string('expiredaction_help', 'enrol_stripepay'),
    ENROL_EXT_REMOVED_SUSPENDNOROLES, $options));

    // --- enrol instance defaults ----------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('enrol_stripepay_defaults',
        get_string('enrolinstancedefaults', 'admin'), get_string('enrolinstancedefaults_desc', 'admin')));

    $options = array(ENROL_INSTANCE_ENABLED  => get_string('yes'),
                     ENROL_INSTANCE_DISABLED => get_string('no'));
    $settings->add(new admin_setting_configselect('enrol_stripepay/status',
        get_string('status', 'enrol_stripepay'), get_string('status_desc', 'enrol_stripepay'), ENROL_INSTANCE_DISABLED, $options));
		
	$settings->add(new admin_setting_configcheckbox('enrol_stripepay/allow_bitcoin',
    get_string('allow_bitcoin', 'enrol_stripepay'), '', 0));

    $settings->add(new admin_setting_configtext('enrol_stripepay/cost', get_string('cost', 'enrol_stripepay'), '', 0, PARAM_FLOAT, 4));

    $stripecurrencies = enrol_get_plugin('stripepay')->get_currencies();
    $settings->add(new admin_setting_configselect('enrol_stripepay/currency',
    get_string('currency', 'enrol_stripepay'), '', 'USD', $stripecurrencies));

    if (!during_initial_install()) {
        $options = get_default_enrol_roles(context_system::instance());
        $student = get_archetype_roles('student');
        $student = reset($student);
        $settings->add(new admin_setting_configselect('enrol_stripepay/roleid',
            get_string('defaultrole', 'enrol_stripepay'), get_string('defaultrole_desc', 'enrol_stripepay'), $student->id, $options));
    }

    $settings->add(new admin_setting_configduration('enrol_stripepay/enrolperiod',
        get_string('enrolperiod', 'enrol_stripepay'), get_string('enrolperiod_desc', 'enrol_stripepay'), 0));
}
