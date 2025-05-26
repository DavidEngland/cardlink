<?php
/*
Plugin Name: Card Link Shortcode for Connections
Description: Outputs a phone, SMS, email, or Facebook Messenger link for a single Connections entry by ID.
Version: 1.4
Author: David E. England, Ph.D.
*/

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * [cardlink] shortcode
 * Usage:
 *   [cardlink id="1" type="phone" format="Call %first%"]
 *   [cardlink id="1" type="sms" format="Text %first%"]
 *   [cardlink id="1" type="email" format="Email %first%"]
 *   [cardlink id="1" type="messenger" format="Message %first% on Messenger"]
 * 
 * Attributes:
 *   id     - Connections entry ID (required)
 *   type   - phone, sms, email, or messenger (default: phone)
 *   format - Output label, supports %first%, %last%, %phone%, %email%, %facebookid%
 */
add_shortcode( 'cardlink', function( $atts ) {
    if ( ! function_exists( 'Connections_Directory' ) ) {
        return '<span>Connections plugin not active.</span>';
    }

    $atts = shortcode_atts( array(
        'id'     => 1,
        'type'   => 'phone', // phone, sms, email, or messenger
        'format' => '',      // e.g. "Call %first%", "Text %first%", "Email %first%", "Message %first% on Messenger"
    ), $atts, 'cardlink' );

    $id     = intval( $atts['id'] );
    $type   = strtolower( trim( $atts['type'] ) );
    $format = trim( $atts['format'] );

    if ( ! $id ) {
        return '<span>No entry ID specified.</span>';
    }

    // Retrieve the entry
    $entry = null;
    $args  = array( 'status' => 'approved', 'limit' => 1, 'id' => $id );
    $results = Connections_Directory()->retrieve->entries( $args );
    if ( ! empty( $results ) ) {
        if ( class_exists( 'cnEntry' ) ) {
            $entry = new cnEntry( $results[0] );
        } else {
            return '<span>Connections Entry class not found.</span>';
        }
    }
    if ( ! $entry ) {
        return '<span>No entry found.</span>';
    }

    // Prepare replacement values
    $first = esc_html( $entry->getFirstName() );
    $last  = esc_html( $entry->getLastName() );

    // Get contact info (RAW, unobfuscated)
    $phone = '';
    $phone_display = '';
    $email = '';
    $facebook_id = '';

    if ( in_array( $type, array( 'phone', 'sms' ), true ) ) {
        $phones = $entry->getPhoneNumbers( array( 'raw' => TRUE ) );
        if ( ! empty( $phones ) && ! empty( $phones[0]->number ) ) {
            $phone = preg_replace( '/[^0-9\+]/', '', $phones[0]->number );
            $phone_display = esc_html( $phones[0]->number );
        }
    }
    if ( $type === 'email' ) {
        $emails = $entry->getEmailAddresses( array( 'raw' => TRUE ) );
        if ( ! empty( $emails ) && ! empty( $emails[0]->address ) ) {
            $email = sanitize_email( $emails[0]->address );
        }
    }
    if ( $type === 'messenger' ) {
        // Try to get Facebook ID from social links
        if ( method_exists( $entry, 'getSocialMedia' ) ) {
            $socials = $entry->getSocialMedia();
            if ( ! empty( $socials ) && is_array( $socials ) ) {
                foreach ( $socials as $social ) {
                    if (
                        isset( $social->type ) &&
                        strtolower( $social->type ) === 'facebook' &&
                        ! empty( $social->id )
                    ) {
                        $facebook_id = $social->id;
                        break;
                    }
                    // Fallback: Try to extract from facebook URL
                    if (
                        isset( $social->type ) &&
                        strtolower( $social->type ) === 'facebook' &&
                        ! empty( $social->url )
                    ) {
                        // Extract username/id from URL
                        if ( preg_match( '~/([^/]+)/?$~', $social->url, $matches ) ) {
                            $facebook_id = $matches[1];
                            break;
                        }
                    }
                }
            }
        }
    }

    // Build output label
    if ( ! $format ) {
        if ( $type === 'email' ) {
            $format = 'Email %first%';
        } elseif ( $type === 'sms' ) {
            $format = 'Text %first%';
        } elseif ( $type === 'messenger' ) {
            $format = 'Message %first% on Messenger';
        } else {
            $format = 'Call %first%';
        }
    }
    $replacements = array(
        '%first%'     => $first,
        '%last%'      => $last,
        '%phone%'     => $phone_display ?: $phone,
        '%email%'     => $email,
        '%facebookid' => $facebook_id,
    );
    $label = strtr( $format, $replacements );
    $label = trim( $label );

    // Output link
    if ( $type === 'phone' && $phone ) {
        return sprintf(
            '<a href="tel:%s">%s</a>',
            esc_attr( $phone ),
            esc_html( $label )
        );
    } elseif ( $type === 'sms' && $phone ) {
        return sprintf(
            '<a href="sms:%s">%s</a>',
            esc_attr( $phone ),
            esc_html( $label )
        );
    } elseif ( $type === 'email' && $email ) {
        return sprintf(
            '<a href="mailto:%s">%s</a>',
            esc_attr( $email ),
            esc_html( $label )
        );
    } elseif ( $type === 'messenger' && $facebook_id ) {
        return sprintf(
            '<a href="https://m.me/%s" target="_blank" rel="noopener">%s</a>',
            esc_attr( $facebook_id ),
            esc_html( $label )
        );
    } else {
        return '<span>Contact info not available.</span>';
    }
});
