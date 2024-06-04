<!-- main-content -->
<div class="main-content app-content">
    <!-- container -->
    <div class="main-container container-fluid">
        <!-- breadcrumb -->
        <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <span class="main-content-title tx-primary mg-b-0 mg-b-lg-1">Attendance</span>
            </div>
            <div class="justify-content-center align-items-center d-flex mt-2">
                <ol class="breadcrumb breadcrumb-style3">
                    <li class="breadcrumb-item tx-15"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Attendance</li>
                </ol>
            </div>
        </div>
        <!-- /breadcrumb -->

        <div class="row row-sm">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">View Attendance</h4>
                    </div>

                    <div class="card-body">
                        <div class="calendar-area"> 
                            <?php 
                                $day     = date('D'); 
                                $dateGet = date('d');
                                $month   = date('M');

                                //check the current day
                                if($day != 'Mon') {    
                                    $start_date = date('Y-m-d', strtotime('last Monday'));    
                                } else {
                                    $start_date = date('Y-m-d');   
                                }

                                //always next saturday
                                if($day != 'Sun') {
                                    $end_date = date('Y-m-d', strtotime('next Sunday'));
                                } else {
                                    $end_date = date('Y-m-d');
                                }
                            ?>
                            <div class="status-report">
                                <div class="rep-header">
                                    <h4 class="card-title">
                                        <i class="ti-id-badge"></i> Status Report

                                        <div class="btnChange">
                                            <div class="btn-box">
                                                <a href="<?= base_url(); ?>admin/getNextWeek" class="getDate" data-get="-"><</a>
                                                <a href="<?= base_url(); ?>admin/getNextWeek" class="getDate" data-get="+">></a>
                                            </div>

                                            <div class="date-box">
                                                <span>
                                                <?php 
                                                    $dayFrom = date('D, M d, Y', strtotime($start_date));
                                                    $dayTo   = date('D, M d, Y', strtotime($end_date));  
                                                    
                                                    echo $dayFrom . ' - ' . $dayTo;
                                                ?>
                                                </span>
                                                <i class="ti-calendar"></i> 
                                            </div>
                                        </div>
                                    </h4>

                                    <div class="report-info">
                                        <div class="form-group">
                                            <label>Select Employee</label>
                                            <select name="emp_data_id" class="form-control">
                                                <option value="0">Employees</option>
                                                <?php foreach($dataEmployees as $data): ?>
                                                <option value="<?= $data->id; ?>"><?= $data->username; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="loader-wrapper">
                                    <div class="loader-sub" id="report-load">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="calendar-wrapper">
                                <div class="time-calendar">
                                    <div class="date-header">
                                        <ul>
                                        <?php 
                                            $current_class = '';
                                            
                                            for($i = 0; $i <= 6; $i++) {
                                                $daySet = date('D', strtotime($start_date . ' +'.$i.' days')); 
                                                $date   = date('d', strtotime($start_date . ' +'.$i.' days'));
                                                $month  = date('M', strtotime($start_date . ' +'.$i.' days')); 
                                                
                                                if($date == date('d')) {
                                                    $current_class = ' class="active-date"';
                                                }

                                                echo '<li '.$current_class.'>';
                                                echo '<span>' . $date . '</span>';
                                                echo '<div class="daySet"><span>' . $daySet . '</span>';
                                                echo '<span>' . $month . '</span></div>';
                                                echo '</li>';
                                            }
                                        ?>
                                        </ul>
                                    </div>
                                    <input type="hidden" name="start_date" value="<?= $start_date; ?>" />
                                    <input type="hidden" name="end_date" value="<?= $end_date; ?>" />
                                    <input type="hidden" name="daysToShow" value="<?php echo $date; ?>" />
                                    <input type="hidden" name="datePrevious" value="<?php echo $dateGet; ?>" />

                                    <div class="timeAreaWrapper">
                                        <ul class="timeArea">
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                            <li></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="reportData"></div>

                                <div class="loader-wrapper">
                                    <div class="loader-sub" id="payment-load">
                                        <div class="lds-ellipsis">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="user_id" value="0" />
        <!-- End PAge Content -->
    </div>
</div>