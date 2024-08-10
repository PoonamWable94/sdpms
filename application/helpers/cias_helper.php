<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

    /**
    * This function is used to print the content of any data
    */
    function pre($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        exit;
    }

    /**
    * This function used to get the CI instance
    */
    if(!function_exists('get_instance'))
    {
        function get_instance()
        {
            $CI = &get_instance();
        }
    }

    /**
    * This function used to generate the hashed password
    * @param {string} $plainPassword : This is plain text password
    */
    if(!function_exists('getHashedPassword'))
    {
        function getHashedPassword($plainPassword)
        {
            return password_hash($plainPassword, PASSWORD_DEFAULT);
        }
    }

    /**
    * This function used to generate the hashed password
    * @param {string} $plainPassword : This is plain text password
    * @param {string} $hashedPassword : This is hashed password
    */
    if(!function_exists('verifyHashedPassword'))
    {
        function verifyHashedPassword($plainPassword, $hashedPassword)
        {
            return password_verify($plainPassword, $hashedPassword) ? true : false;
        }
    }

    /**
    * This method used to get current browser agent
    */
    if(!function_exists('getBrowserAgent'))
    {
        function getBrowserAgent()
        {
            $CI = get_instance();
            $CI->load->library('user_agent');

            $agent = '';

            if ($CI->agent->is_browser())
            {
                $agent = $CI->agent->browser().' '.$CI->agent->version();
            }
            else if ($CI->agent->is_robot())
            {
                $agent = $CI->agent->robot();
            }
            else if ($CI->agent->is_mobile())
            {
                $agent = $CI->agent->mobile();
            }
            else
            {
                $agent = 'Unidentified User Agent';
            }

            return $agent;
        }
    }

    if(!function_exists('setProtocol'))
    {
        function setProtocol()
        {
            $CI = &get_instance();
                        
            $CI->load->library('email');
            
            // $config['protocol'] = PROTOCOL;
            // $config['mailpath'] = MAIL_PATH;
            // $config['smtp_host'] = SMTP_HOST;
            // $config['smtp_port'] = SMTP_PORT;
            // $config['smtp_user'] = SMTP_USER;
            // $config['smtp_pass'] = SMTP_PASS;
            // $config['charset'] = "utf-8";
            // $config['mailtype'] = "html";
            // $config['newline'] = "\r\n";
            $config['protocol']         = 'smtp';
         $config['smtp_host']        = 'ssl://smtp.gmail.com';
         $config['smtp_port']        = '465';
         $config['smtp_timeout']     = '7';
         $config['smtp_user']        = 'services.konarkglobal@gmail.com';
         $config['smtp_pass']        = 'Techgarner123';
         $config['charset']          = 'utf-8';
         $config['newline']          = "\r\n";
         $config['mailtype']         = 'html'; // or html
         $config['validation']       = TRUE; // bool whether to validate email or not      
            
            $CI->email->initialize($config);
            
            return $CI;
        }
    }

    if(!function_exists('emailConfig'))
    {
        function emailConfig()
        {
            $CI->load->library('email');
            $config['protocol'] = PROTOCOL;
            $config['smtp_host'] = SMTP_HOST;
            $config['smtp_port'] = SMTP_PORT;
            $config['mailpath'] = MAIL_PATH;
            $config['charset'] = 'UTF-8';
            $config['mailtype'] = "html";
            $config['newline'] = "\r\n";
            $config['wordwrap'] = TRUE;
        }
    }

    if(!function_exists('resetPasswordEmail'))
    {
        function resetPasswordEmail($detail)
        {
            $data["data"] = $detail;
            
            $CI = setProtocol();        
            
            $CI->email->from(EMAIL_FROM, FROM_NAME);
            $CI->email->subject("Reset Password");
            $CI->email->message($CI->load->view('pdf/report', $detail, TRUE));
            $CI->email->to($detail["email"]);
            $status = $CI->email->send();
            
            return $status;
        }
    }

    if(!function_exists('reportByEmail'))
    {
        function reportByEmail($detail)
        {

            $data["data"] = $detail;
            //print_r($detail['client_email']);
            //print_r($detail['taskData']->employee_email);
            //print_r($detail['taskData']->senior_email);
            //die;
            
            $CI = setProtocol();

            $url = FCPATH."assets\dompdf\pdf.php";
            include($url);

            $body = $CI->load->view('pdf/report', $detail, TRUE);
            $file_name = $detail['company_name']."_".$detail['reportId'].'_call_report.pdf';

            $pdf = new Pdf();
            $pdf->load_html($body);
            $pdf->setPaper('A4', 'landscape');
            $pdf->render();
            $file = $pdf->output();

            $file_location = FCPATH."uploads\pdf_reports\ ".$file_name;
            file_put_contents($file_location, $file);
        
            $CI->email->from(EMAIL_FROM, FROM_NAME);
            $CI->email->subject("Call Log Report");
            $CI->email->message($detail['emailMessage']);
            $CI->email->attach($file_location, $file_name);
           // $CI->email->to('kajalyadav0610@gmail.com');
            $CI->email->to(array($detail['client_email'],$detail['taskData']->employee_email,$detail['taskData']->senior_email));
           return $CI->email->send();
         //     echo "<pre>";
         // print_r($CI->email->print_debugger());
         // die;
        }
    }
    if(!function_exists('reportByEmail_to_client'))
    {
        function reportByEmail_to_client($detail)
        {

            $data["data"] = $detail;
            //print_r($detail['client_email']);
            //print_r($detail['taskData']->employee_email);
            //print_r($detail['taskData']->senior_email);
            //die;
            
            $CI = setProtocol();

            $url = FCPATH."assets\dompdf\pdf.php";
            include($url);

            $body = $CI->load->view('pdf/report', $detail, TRUE);
            $file_name = $detail['company_name']."_".$detail['reportId'].'_call_report.pdf';

            $pdf = new Pdf();
            $pdf->load_html($body);
            $pdf->setPaper('A4', 'landscape');
            $pdf->render();
            $file = $pdf->output();

            $file_location = FCPATH."uploads\pdf_reports\ ".$file_name;
            file_put_contents($file_location, $file);
        
            $CI->email->from(EMAIL_FROM, FROM_NAME);
            $CI->email->subject("Call Log Report");
            $CI->email->message($detail['emailMessage']);
            $CI->email->attach($file_location, $file_name);
            $CI->email->to($detail['client_email']);
            //$CI->email->to(array($detail['client_email'],$detail['taskData']->employee_email,$detail['taskData']->senior_email));
           return $CI->email->send();
         //     echo "<pre>";
         // print_r($CI->email->print_debugger());
         // die;
        }
    }

    if(!function_exists('setFlashData'))
    {
        function setFlashData($status, $flashMsg)
        {
            $CI = get_instance();
            $CI->session->set_flashdata($status, $flashMsg);
        }
    }

?>