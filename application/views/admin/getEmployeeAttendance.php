<?php
	$active_year = date('Y');
    $active_month = date('m');
    $active_day =  date('d');
    $num_days = date('t', strtotime($active_day . '-' . $active_month . '-' . $active_year));
    $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($active_day . '-' . $active_month . '-' . $active_year)));
    $days = [0 => 'Sun', 1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat'];
    $first_day_of_week = array_search(date('D', strtotime($active_year . '-' . $active_month . '-1')), $days);
                                    
    $html = '';
                                     
	foreach ($days as $day) {
	    $html .= '
	        <div class="day_name">
	            ' . $day . '
	        </div>
	    ';
	}

	for ($i = $first_day_of_week; $i > 0; $i--) {
	    $html .= '
	        <div class="day_num ignore">
	            ' . ($num_days_last_month-$i+1) . '
	        </div>
	    ';
	}

    for($i = 1; $i <= $num_days; $i++) {
        $selected = '';
        if ($i == $active_day) {
            $selected = ' selected';
        }
        $date_today = $active_year . '-' . $active_month . '-' . $i;
        $html .= '<div class="get-status day_num' . $selected . '" data-date="'.$date_today.'">';
        $html .= '<span>' . $i . '</span>';
        $dateCurrent = $active_year . '-' . $active_month . '-' . $i; 
        $html .= '<div class="c-time-box">';
        
        $day = date('D', strtotime($date_today));
        foreach($timeLog as $dataTime):
            if($dataTime->date == $dateCurrent) {
                if($dataTime->time_in == '00:00:00') {
                     $html .= '<label class="badge badge-danger">Abscent</label>';
                } else {
                    $time_in_convert = (date('A', strtotime($dataTime->time_in)) == 'AM') ? 'PM' : 'AM';

                    $time_in = date('h:i:s', strtotime($dataTime->time_in)) . ' ' . $time_in_convert;

                    $html .= '<label class="badge badge-success">Time In : ' . $time_in . '</label>';
                    $html .= '<label class="badge badge-warning">Time Out : ';
                    
                    if($dataTime->time_out == '00:00:00') {
                        $html .= 'N/A';
                    } else { 
                        $time_out_convert = (date('A', strtotime($dataTime->time_out)) == 'AM') ? 'PM' : 'AM';
                        $html .= date('h:i:s', strtotime($dataTime->time_out)) . ' ' . $time_out_convert;
                    }

                    $html .= '</label>';
                }
            }
        endforeach;
        $dateCurrent = '';
        $html .= '</div>';
        $html .= '</div>';
    }

	for ($i = 1; $i <= (42-$num_days-max($first_day_of_week, 0)); $i++) {
	    $html .= '
	        <div class="day_num ignore">
	            ' . $i . '
	        </div>
	    ';
	}

	echo $html;