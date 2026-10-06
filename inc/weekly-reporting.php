<?php
/**
 * Weekly "New Users (Last 7 Days)" CSV Email Export
 * ---------------------------------------------------
 * Sends a CSV of all users with role = subscriber, registered in the
 * last 7 days, to brettaiello@gmail.com every Monday at 8:00 AM
 * (site timezone).
 *
 * Fields exported: first_name, last_name, email, date registered,
 * country, us-state, city, hospital, training_level
 */

// ---------------------------------------------------------------
// 1. Schedule the weekly cron event on next Monday 8:00 AM
// ---------------------------------------------------------------
add_action( 'wp', 'brett_maybe_schedule_weekly_user_export' );
function brett_maybe_schedule_weekly_user_export() {
	if ( ! wp_next_scheduled( 'brett_weekly_new_user_export' ) ) {

		// Calculate the next Monday 8:00 AM in site time.
		$timezone   = wp_timezone();
		$now        = new DateTime( 'now', $timezone );
		$next_run   = new DateTime( 'next monday 08:00', $timezone );

		// If today IS Monday and it's before 8am, run today instead.
		if ( 'Monday' === $now->format( 'l' ) && $now->format( 'H:i' ) < '08:00' ) {
			$next_run = new DateTime( 'today 08:00', $timezone );
		}

		wp_schedule_event( $next_run->getTimestamp(), 'weekly', 'brett_weekly_new_user_export' );
	}
}

// ---------------------------------------------------------------
// 2. The export + email function
// ---------------------------------------------------------------
add_action( 'brett_weekly_new_user_export', 'brett_run_weekly_new_user_export' );
function brett_run_weekly_new_user_export() {

	// --- Query users: role = subscriber, registered in last 7 days ---
	$args = array(
		'role'       => 'subscriber',
		'date_query' => array(
			array(
				'after'     => '7 days ago',
				'inclusive' => true,
				'column'    => 'user_registered',
			),
		),
		'orderby'    => 'registered',
		'order'      => 'DESC',
	);

	$users = get_users( $args );

	if ( empty( $users ) ) {
		// Still email a heads-up so you know it ran, just with no rows.
		wp_mail(
			array( 'brettaiello@gmail.com', 'Stephanie.Guzowski@bd.com' ),
			'Weekly New User Export - No new users this week',
			'No users with role "subscriber" registered in the last 7 days.'
		);
		return;
	}

	// --- Meta keys to pull, in export column order ---
	$meta_fields = array(
		'country'        => 'Country',
		'us-state'       => 'US State',
		'city'           => 'City',
		'hospital'       => 'Hospital',
		'training_level' => 'Training Level',
	);

	// --- Build CSV in memory ---
	$upload_dir = wp_upload_dir();
	$file_name  = 'new-user-export-' . date( 'Y-m-d' ) . '.csv';
	$file_path  = trailingslashit( $upload_dir['basedir'] ) . $file_name;

	$fh = fopen( $file_path, 'w' );

	// Header row
	$header = array( 'First Name', 'Last Name', 'Email', 'Date Registered' );
	foreach ( $meta_fields as $label ) {
		$header[] = $label;
	}
	fputcsv( $fh, $header );

	// Data rows
	foreach ( $users as $user ) {
		$row = array(
			get_user_meta( $user->ID, 'first_name', true ),
			get_user_meta( $user->ID, 'last_name', true ),
			$user->user_email,
			$user->user_registered,
		);

		foreach ( $meta_fields as $key => $label ) {
			$row[] = get_user_meta( $user->ID, $key, true );
		}

		fputcsv( $fh, $row );
	}

	fclose( $fh );

	// --- Email it ---
	$subject = 'Weekly New User Export - ' . date( 'M j, Y' );
	$body    = sprintf(
		"Attached: %d new subscriber(s) registered in the last 7 days.",
		count( $users )
	);

	wp_mail(
		array( 'brettaiello@gmail.com', 'Stephanie.Guzowski@bd.com' ),
		$subject,
		$body,
		array(),
		array( $file_path )
	);

	// --- Clean up the file after sending ---
	if ( file_exists( $file_path ) ) {
		unlink( $file_path );
	}
}

// ---------------------------------------------------------------
// 3. Cleanup: unschedule if this snippet is ever removed
//    (optional — only fires if you manually call
//    brett_clear_weekly_user_export(), e.g. from a deactivation hook)
// ---------------------------------------------------------------
function brett_clear_weekly_user_export() {
	$timestamp = wp_next_scheduled( 'brett_weekly_new_user_export' );
	if ( $timestamp ) {
		wp_unschedule_event( $timestamp, 'brett_weekly_new_user_export' );
	}
}