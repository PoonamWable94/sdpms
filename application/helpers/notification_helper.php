<?php
if (!function_exists('get_all_notifications')) {
    function get_all_notifications() {
        // Get the CodeIgniter instance
        $CI =& get_instance();
        
        // Load the model
        $CI->load->model('notification/Activity_notification_log_model');
        
        // Fetch the data from the model
        return $CI->Activity_notification_log_model->all_notification();
    }
}