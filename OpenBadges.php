<?php
/**
 * OpenBadges Extension. Based on Mozilla OpenBadges
 *
 * See https://github.com/openbadges/openbadges-specification
 * for specs.
 *
 * @todo Add logging
 *
 * @file
 * @ingroup Extensions
 * @author chococookies, and the rest
 * @license GPL-2.0-or-later
 */

// Ensure that the script cannot be executed outside of MediaWiki.
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is an extension to MediaWiki and cannot be run standalone.' );
}

// Display extension properties on MediaWiki.
$wgExtensionCredits['other'][] = [
	'path' => __FILE__,
	'name' => 'OpenBadges',
	'author' => [
		'chococookies',
		'Don Yu',
		'Stephen Zhou',
		'Lokal_Profil',
		'...'
	],
	'version'  => '0.2.0',
	'url' => 'https://www.mediawiki.org/wiki/OpenBadges',
	'descriptionmsg' => 'ob-desc',
	'license-name' => 'GPL-2.0-or-later'
];

/* Setup */

// Files
$wgAutoloadClasses['SpecialBadgeIssue'] = __DIR__ . '/SpecialBadgeIssue.php';
$wgAutoloadClasses['SpecialBadgeCreate'] = __DIR__ . '/SpecialBadgeCreate.php';
$wgAutoloadClasses['SpecialBadgeView'] = __DIR__ . '/SpecialBadgeView.php';
$wgAutoloadClasses['BadgesPager'] = __DIR__ . '/SpecialBadgeView.php';
$wgAutoloadClasses['ApiOpenBadges'] = __DIR__ . '/ApiOpenBadges.php';
$wgAutoloadClasses['ApiOpenBadgesAssertions'] = __DIR__ . '/ApiOpenBadgesAssertions.php';
$wgAutoloadClasses['ApiOpenBadgesIssue'] = __DIR__ . '/ApiOpenBadgesIssue.php';
$wgMessagesDirs['OpenBadges'] = __DIR__ . '/i18n';
$wgExtensionMessagesFiles['OpenBadgesAlias'] = __DIR__ . '/OpenBadges.i18n.alias.php';

// Map module name to class name
$wgAPIModules['openbadges'] = 'ApiOpenBadgesAssertions';
$wgAPIModules['openbadgesissue'] = 'ApiOpenBadgesIssue';

// Special pages
$wgSpecialPages['BadgeIssue'] = 'SpecialBadgeIssue';
$wgSpecialPages['BadgeCreate'] = 'SpecialBadgeCreate';
$wgSpecialPages['BadgeView'] = 'SpecialBadgeView';

// Permissions
// @todo Add custom create and issue groups
$wgGroupPermissions['sysop']['issuebadge'] = true;
$wgGroupPermissions['sysop']['createbadge'] = true;
$wgGroupPermissions['user']['viewbadge'] = true;
$wgAvailableRights[] = 'createbadge';
$wgAvailableRights[] = 'issuebadge';
$wgAvailableRights[] = 'viewbadge';

// Register hooks
$wgHooks['LoadExtensionSchemaUpdates'][] = 'createTable';
// $wgHooks['BeforePageDisplay'][] = 'efAddOpenBadgesModule';


// Function to hook up our tables
function createTable( DatabaseUpdater $dbU ) {
	$dbU->addExtensionTable( 'openbadges_class',
		__DIR__ . '/OpenBadgesClass.sql' );
	$dbU->addExtensionTable( 'openbadges_assertion',
		__DIR__ . '/OpenBadgesAssertion.sql' );
	return true;
}

/* Configuration */

// Set default thumb width
$wgOpenBadgesThumb = 400;

// Set e-mail requirments for recipients
$wgOpenBadgesRequireEmail = true;
$wgOpenBadgesRequireEmailConfirmation = false;
