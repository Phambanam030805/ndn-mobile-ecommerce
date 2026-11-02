<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * NDN Mobile Admin Badge & UI Helper
 * Centralizes real-time counter metrics for Sidebar and Header Navigation
 */
if ( ! function_exists('admin_sidebar_metrics'))
{
    function admin_sidebar_metrics()
    {
        $CI =& get_instance();
        
        // 1. Pending/New Orders (Orders with status = 0)
        $CI->db->where('status', 0);
        $CI->db->where('trash', 1);
        $pending_orders = $CI->db->count_all_results('orders');

        // Shipping Orders (Orders with status = 1)
        $CI->db->where('status', 1);
        $CI->db->where('trash', 1);
        $shipping_orders = $CI->db->count_all_results('orders');

        // 2. Unread Contact Messages (posts with type = 'contact' AND status = 0 or 1 where status=0 means new unread)
        // Check if status=0 exists in contact, otherwise check trash=1
        $CI->db->where('type', 'contact');
        $CI->db->where('status', 0);
        $CI->db->where('trash', 1);
        $unread_contacts = $CI->db->count_all_results('posts');

        // 3. Pending Reviews (posts with type = 'review' AND status = 0)
        $CI->db->where('type', 'review');
        $CI->db->where('status', 0);
        $CI->db->where('trash', 1);
        $pending_reviews = $CI->db->count_all_results('posts');

        return [
            'pending_orders'  => (int)$pending_orders,
            'shipping_orders' => (int)$shipping_orders,
            'unread_contacts' => (int)$unread_contacts,
            'pending_reviews' => (int)$pending_reviews,
            'total_alerts'    => (int)$pending_orders + (int)$unread_contacts + (int)$pending_reviews
        ];
    }
}
